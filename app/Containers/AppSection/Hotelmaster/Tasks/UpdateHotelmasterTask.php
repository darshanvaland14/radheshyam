<?php

namespace App\Containers\AppSection\Hotelmaster\Tasks;

use App\Containers\AppSection\Hotelmaster\Data\Repositories\HotelmasterRepository;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmasterimages;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class UpdateHotelmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelmasterRepository $repository
    ) {}

    public function run(array $data, $id, $request)
    {
        try {
            $theme_setting = Themesettings::where('id', 1)->first();
            $updateData = Hotelmaster::where('id', $id)->update($data);
            $hotel_master_images = $request['hotelmasterimages'];
            $existingHotelmasterimagesIds = Hotelmasterimages::where('hotel_master_id', $id)->pluck('id')->toArray();

            if (!empty($hotel_master_images)) {
                foreach ($hotel_master_images as $value) {
                    if (isset($value['id'])) {
                        $hotel_master_images_id = $this->decode($value['id']) ?? null;
                    } else {
                        $hotel_master_images_id = null;
                    }
                    $category_name = $value['category_name'] ?? null;
                    $image_url = $value['image_url'] ?? null;

                    // Check if the document ID exists in the database
                    if (in_array($hotel_master_images_id, $existingHotelmasterimagesIds)) {
                        // Check if image_url contains base64 image
                        if (preg_match('/^data:image\/(\w+);base64,(.+)/', $image_url, $matches)) {
                            $imageData = base64_decode($matches[2]);
                            // dd($imageData);

                            if (!file_exists(public_path('hotelimages/'))) {
                                mkdir(public_path('hotelimages/'), 0755, true);
                            }

                            $image_type = "png";
                            $file = uniqid() . '.' . $image_type;
                            $filePath = 'public/hotelimages/' . $file;

                            // Fetch existing document data
                            $existingDocument = Hotelmasterimages::where('id', $hotel_master_images_id)->first();
                            // dd($existingDocument);
                            if ($existingDocument) {
                                if ($existingDocument->image_url != '') {
                                    $oldFilePath = public_path($existingDocument->image_url);
                                    if ($oldFilePath != null) {
                                        // Delete previous image if exists
                                        if (File::exists($oldFilePath)) {
                                            File::delete($oldFilePath);
                                        }
                                    }
                                }
                            }
                            $manager = new ImageManager(Driver::class);
                            $image = $manager->read($imageData);
                            $image_type = "png";
                            $file =  uniqid() . '.' . $image_type;
                            $saveimage = $image->toPng()->save(public_path('hotelimages/' . $file));
                            // dd();
                            // Update existing record
                            $existingDocument->category_name = $category_name;
                            $existingDocument->image_url =  'public/hotelimages/' . $file;
                            $existingDocument->save();
                            // if ($existingDocument->save()) {
                            //   dd($existingDocument);
                            // }
                        } else {
                            $existingDocument = Hotelmasterimages::where('id', $hotel_master_images_id)->first();
                            $existingDocument->category_name = $category_name;
                            $existingDocument->save();
                        }
                    } else {
                        // If hotel_master_images_id not present, create new record
                        $imagefinalurl = '';
                        if (!empty($image_url)) {
                            if (preg_match('/^data:image\/(\w+);base64,(.+)/', $image_url, $matches)) {
                                $imageData = base64_decode($matches[2]);

                                if ($imageData === false) {
                                    die('Base64 decoding failed');
                                }
                                // file_put_contents(public_path('hotelimages/debug_image.png'), $imageData);
                                if (!file_exists(public_path('hotelimages/'))) {
                                    mkdir(public_path('hotelimages/'), 0755, true);
                                }

                                $image_type = 'png'; // Use the extracted image type
                                $file = uniqid() . '.' . $image_type;
                                $filePath = 'public/hotelimages/' . $file;

                                // try {
                                $manager = new ImageManager(Driver::class);
                                $image = $manager->read($imageData);

                                // Save the image
                                $image->toPng()->save(public_path('hotelimages/' . $file));
                                // dd($result, $file);
                                $imagefinalurl = $filePath;
                            }
                        }


                        Hotelmasterimages::create([
                            'hotel_master_id' => $id,
                            'category_name' => $category_name,
                            'image_url' => $imagefinalurl
                        ]);
                    }
                }
            }
            $getData = Hotelmaster::where('id', $id)->first();
            if ($getData !== null) {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['data']['object'] = 'Hotelmasters';
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
                $returnData['data']['address'] =  $getData->address;
                $returnData['data']['city'] =  $getData->city;
                $returnData['data']['state'] =  $getData->state;
                $returnData['data']['country'] =  $getData->country;
                $returnData['data']['zipcode'] =  $getData->zipcode;
                $returnData['data']['email'] =  $getData->email;
                $returnData['data']['website'] =  $getData->website;
                $returnData['data']['assign_to'] =  $this->encode($getData->assign_to);
                $returnData['data']['gst_no'] =  $getData->gst_no;
                $returnData['data']['pan_no'] =  $getData->pan_no;
                $returnData['data']['fssai_no'] =  $getData->fssai_no;
                $returnData['data']['bank_name'] =  $getData->bank_name;
                $returnData['data']['account_no'] =  $getData->account_no;
                $returnData['data']['ifsc_no'] =  $getData->ifsc_no;
                $returnData['data']['hotel_star_rating'] =  $getData->hotel_star_rating;
                $returnData['data']['notes'] =  $getData->notes;
                $returnData['data']['contact_email'] =  $getData->contact_email;
                $returnData['data']['mobile'] =  $getData->mobile;
                $returnData['data']['hotel_facilities'] =  $getData->hotel_facilities;
                $returnData['data']['created_at'] = $getData->created_at;
                $returnData['data']['updated_at'] = $getData->updated_at;
                $returnData['data']['hotelmasterimages'] = array();
                $hotelmasterimages = Hotelmasterimages::where('hotel_master_id', $getData['id'])->get();
                if (!empty($hotelmasterimages)) {
                    for ($doc = 0; $doc < count($hotelmasterimages); $doc++) {
                        $returnData['data']['hotelmasterimages'][$doc]['id'] = $this->encode($hotelmasterimages[$doc]->id);
                        $returnData['data']['hotelmasterimages'][$doc]['hotel_master_id'] = $this->encode($hotelmasterimages[$doc]->hotel_master_id);
                        $returnData['data']['hotelmasterimages'][$doc]['category_name'] = $hotelmasterimages[$doc]->category_name;
                        $returnData['data']['hotelmasterimages'][$doc]['image_url'] = ($hotelmasterimages[$doc]->image_url) ? $theme_setting->api_url . $hotelmasterimages[$doc]->image_url : "";
                    }
                }
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Hotelmasters";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to update the resource. Please try again later.',
                'object' => 'Hotelmasters',
                'data' => [],
            ];
        }
    }
}
