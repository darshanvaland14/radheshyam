<?php

namespace App\Containers\AppSection\Tenantuser\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Tenantuser\Data\Repositories\TenantuserRepository;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdocument;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class UpdateTenantusersTask extends Task
{
    use HashIdTrait;
    protected TenantuserRepository $repository;

    public function __construct(TenantuserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, $data, $InputData)
    {
        $theme_setting = Themesettings::where('id', 1)->first();
        try {
            $image_api_url = Themesettings::where('id', 1)->first();
            $data['mobile'] = (string) $data['mobile'];
            $update = Tenantuser::where('id', $id)->update($data);
            // Set Document
            $document_data = $InputData->getDocumentdata();
            $existingDocumentIds = Tenantuserdocument::where('user_id', $id)->pluck('document_id')->toArray();

            if (!empty($document_data)) {
                foreach ($document_data as $value) {
                    $document_id = $value['document_id'] ?? null;
                    $document_name = $value['document_name'] ?? null;
                    $document_url = $value['document_url'] ?? null;

                    // Check if the document ID exists in the database
                    if (in_array($document_id, $existingDocumentIds)) {
                        // Check if document_url contains base64 image
                        if (preg_match('/^data:image\/(png|jpg|jpeg);base64,/', $document_url)) {
                            $imageData = substr($document_url, strpos($document_url, ',') + 1);
                            $imageData = base64_decode($imageData);

                            if (!file_exists(public_path('profileimages/'))) {
                                mkdir(public_path('profileimages/'), 0755, true);
                            }

                            $image_type = "png";
                            $file = uniqid() . '.' . $image_type;
                            $filePath = 'public/profileimages/' . $file;

                            // Fetch existing document data
                            $existingDocument = Tenantuserdocument::where('document_id', $document_id)->first();

                            if ($existingDocument && !empty($existingDocument->document_url)) {
                                $oldFilePath = public_path($existingDocument->document_url);

                                // Delete previous image if exists
                                if (File::exists($oldFilePath)) {
                                    File::delete($oldFilePath);
                                }
                            }

                            // Save new image
                            $manager = new ImageManager(Driver::class);
                            $image = $manager->read($imageData);
                            $image->toPng()->save(public_path($filePath));

                            // Update existing record
                            Tenantuserdocument::where('document_id', $document_id)
                                ->update(['document_url' => $filePath]);
                        }
                        continue; // Skip if it's not base64
                    } else {
                        // If document_id not present, create new record
                        $documentfinalurl = '';

                        if (!empty($document_url)) {
                            $manager = new ImageManager(Driver::class);
                            $image = $manager->read($document_url);

                            if (!file_exists(public_path('profileimages/'))) {
                                mkdir(public_path('profileimages/'), 0755, true);
                            }

                            $image_type = "png";
                            $file = uniqid() . '.' . $image_type;
                            $filePath = 'public/profileimages/' . $file;
                            $image->toPng()->save(public_path($filePath));

                            $documentfinalurl = $filePath;
                        }

                        Tenantuserdocument::create([
                            'user_id' => $id,
                            'document_id' => $document_id,
                            'document_name' => $document_name,
                            'document_url' => $documentfinalurl
                        ]);
                    }
                }
            }
            // $document_data = $InputData->getDocumentdata();
            // if (!empty($document_data)) {
            //     foreach ($document_data as $key => $value) {
            //         // Fetch fields data
            //         if (isset($value['document_id'])) {
            //         }
            //         $document_name = $value['document_name'];
            //         $document_url = $value['document_url'];
            //         if ($document_url != null) {
            //             $manager = new ImageManager(Driver::class);
            //             $image = $manager->read($document_url);
            //             if (!file_exists(public_path('profileimages/'))) {
            //                 mkdir(public_path('profileimages/'), 0755, true);
            //             }
            //             $image_type = "png";
            //             $folderPath = 'public/profileimages/';
            //             $file =  uniqid() . '.' . $image_type;
            //             $saveimage = $image->toPng()->save(public_path('profileimages/' . $file));
            //             $documentfinalurl  =  $folderPath . $file;
            //         } else {
            //             $documentfinalurl = '';
            //         }

            //         $docdata['user_id'] = $create->id;
            //         $docdata['document_name'] = $document_name;
            //         $docdata['document_url'] = $documentfinalurl;
            //         $createdetail = Tenantuserdocument::create($docdata);
            //     }
            // }
            $getData = Tenantuser::where('id', $id)->first();
            $returnData = array();
            if (!empty($getData)) {
                $returnData['message'] = "Data Updated";
                $returnData['data']['object'] = "pro_tenantusers";
                $returnData['data']['id'] = $this->encode($getData['id']);
                $returnData['data']['role_id'] = $this->encode($getData['role_id']);
                $returnData['data']['first_name'] = $getData['first_name'];
                $returnData['data']['middle_name'] = $getData['middle_name'];
                $returnData['data']['last_name'] = $getData['last_name'];
                $returnData['data']['profile_image'] = ($getData['profile_image']) ? $theme_setting->api_url . $getData['profile_image'] : "";
                $returnData['data']['dob'] = $getData['dob'];
                $returnData['data']['gender'] = $getData['gender'];
                $returnData['data']['email'] = $getData['email'];
                $returnData['data']['mobile'] = $getData['mobile'];
                $returnData['data']['address'] = $getData['address'];
                $returnData['data']['country'] = $getData['country'];
                $returnData['data']['state'] = $getData['state'];
                $returnData['data']['city'] = $getData['city'];
                $returnData['data']['zipcode'] = $getData['zipcode'];
                $returnData['data']['status'] = $getData['status'];
                $returnData['data']['userdocdata'] = array();
                $docData = Tenantuserdocument::where('user_id', $getData['id'])->get();
                if (!empty($docData)) {
                    for ($doc = 0; $doc < count($docData); $doc++) {
                        $returnData['data']['userdocdata'][$doc]['id'] = $this->encode($docData[$doc]->id);
                        $returnData['data']['userdocdata'][$doc]['user_id'] = $this->encode($docData[$doc]->user_id);
                        $returnData['data']['userdocdata'][$doc]['document_name'] = $docData[$doc]->document_name;
                        $returnData['data']['userdocdata'][$doc]['document_url'] = ($docData[$doc]->document_url) ? $theme_setting->api_url . $docData[$doc]->document_url : "";
                    }
                }
            } else {
                $returnData['message'] = "Data Not Found";
                $returnData['object'] = "pro_tenantusers";
            }
            return $returnData;
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
