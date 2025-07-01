<?php

namespace App\Containers\AppSection\TourPlacesMaster\Tasks;

use App\Containers\AppSection\TourPlacesMaster\Data\Repositories\TourPlacesMasterRepository;
use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMaster;
use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMasterChild;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateTourPlacesMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourPlacesMasterRepository $repository
    ) {
    }

   
    public function run($request)
    {
        $tour_place_id = $this->decode($request->tour_place_id);

        if ($tour_place_id) {
            $createData = TourPlacesMaster::find($tour_place_id);
            TourPlacesMasterChild::where('tour_places_master_id', $tour_place_id)->delete();
        } else {
            $exists = TourPlacesMaster::where('name', $request->name)->first();
            if ($exists) {
                return [
                    'result' => false,
                    'message' => 'Error: Tour Place already exists.',
                    'object' => 'TourPlacesMasters',
                    'data' => [],
                ];
            }
            $createData = new TourPlacesMaster();
        }

        $createData->tour_category = $request->tour_category;
        $createData->name = $request->name;
        $createData->city = $request->city;
        $createData->country = $request->country;
        $createData->state = $request->state;
        $createData->description = $request->description;
        $createData->save();

        if ($request->image_type) {
            foreach ($request->image_type as $key => $value) {
                $createDataChild = new TourPlacesMasterChild();
                $createDataChild->tour_places_master_id = $createData->id;
                $createDataChild->category_name = $value['category_name'];
                $document_url = $value["image_url"];

                if (!empty($document_url)) {
                    if (Str::startsWith($document_url, 'data:image') || Str::startsWith($document_url, 'data:application')) {
                        $folderPath = 'public/tourplaces/';
                        $savePath = public_path('tourplaces/');

                        if (!file_exists($savePath)) {
                            mkdir($savePath, 0755, true);
                        }

                        list($meta, $base64Data) = explode(';', $document_url);
                        $mimeType = str_replace('data:', '', $meta);
                        list(, $base64Data) = explode(',', $base64Data);
                        $fileData = base64_decode($base64Data);

                        $mimeToExt = [
                            'application/pdf' => 'pdf',
                            'image/png' => 'png',
                            'image/jpeg' => 'jpg',
                            'image/gif' => 'gif',
                            'text/plain' => 'txt',
                            'application/msword' => 'doc',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                            'application/vnd.ms-excel' => 'xls',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
                            'application/zip' => 'zip',
                            'application/x-rar-compressed' => 'rar',
                        ];

                        $extension = $mimeToExt[$mimeType] ?? 'bin';
                        $fileName = uniqid() . '.' . $extension;
                        $filePath = $folderPath . $fileName;

                        file_put_contents($savePath . $fileName, $fileData);

                        $createDataChild->image_url = $filePath;
                    
                    } else {
                        $parsedUrl = parse_url($document_url);
                        if (isset($parsedUrl['path'])) {
                            $path = ltrim($parsedUrl['path'], '/');

                            if (Str::contains($path, 'public/tourplaces/')) {
                                // Extract only the relative path after 'public/'
                                $relativePath = Str::after($path, 'public/');
                                $createDataChild->image_url = 'public/' . $relativePath;
                            } else {
                                $createDataChild->image_url = $document_url; // External link
                            }
                        } else {
                            $createDataChild->image_url = $document_url;
                        }
                    }
                }

                $createDataChild->save();
            }
        }

        return [
            'result' => true,
            'message' => $tour_place_id ? 'Tour Places Updated Successfully.' : 'Tour Places Created Successfully.',
            'object' => 'TourPlacesMasters',
            // 'data' => $createData,
        ];
    }

}
