<?php

namespace App\Containers\AppSection\TourPackagesMaster\Tasks;
// use App\Containers\AppSection\TourPackagesMaster\Jobs\ProcessTourPackageMediaJob;

use App\Containers\AppSection\TourPackagesMaster\Data\Repositories\TourPackagesMasterRepository;
use App\Containers\AppSection\TourPackagesMaster\Models\TourPackagesMaster;
use App\Containers\AppSection\TourPackagesMaster\Models\TourScheduleMaster;
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

class CreateTourPackagesMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourPackagesMasterRepository $repository
    ) {
    }


    public function run($request)
    {
            // dd($request->no_days);
            // return $request->all();
            $tour_package_id  = $this->decode($request->tour_package_id);
            if($tour_package_id){
                $createData = TourPackagesMaster::find($tour_package_id);
                TourScheduleMaster::where('tour_packages_master_id', $tour_package_id)->delete();
            }else{
                $createData = new TourPackagesMaster();
            }
            $createData->name = $request->name ;
            $createData->no_days = $request->no_days ;
            $createData->tour_sector = $this->decode($request->tour_sector) ??'';
            $createData->tour_category = $this->decode($request->tour_category) ??'';
            $createData->highlight = $request->highlights ;
            $createData->notes = $request->notes;
            $createData->trendingtour = $request->trendingTour;
            $createData->tour_plan = json_encode($request->tour_plan) ; 
            $createData->child_rate = $request->child_rate ;
            $createData->per_person_rate = $request->per_person_rate ;
            
            
            if ($request->thumbnailImage) {
                $document_url = $request->thumbnailImage;
                if (!empty($document_url)) {
                    if (Str::startsWith($document_url, 'data:image') || Str::startsWith($document_url, 'data:application')) {
                        $folderPath = 'public/TourPackages/';
                        $savePath = public_path('TourPackages/');

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

                        $createData->thumbnailImage = $filePath;
                    
                    } else {
                        $parsedUrl = parse_url($document_url);
                        if (isset($parsedUrl['path'])) {
                            $path = ltrim($parsedUrl['path'], '/');

                            if (Str::contains($path, 'public/TourPackages/')) {
                                // Extract only the relative path after 'public/'
                                $relativePath = Str::after($path, 'public/');
                                $createData->thumbnailImage = 'public/' . $relativePath;
                            } else {
                                $createData->thumbnailImage = $document_url; // External link
                            }
                        } else {
                            $createData->thumbnailImage = $document_url;
                        }
                    }
                }
            }

            // Handle video file
            if ($request->video) {
                $videoData = $request->video;
                if (!empty($videoData)) {
                    if (Str::startsWith($videoData, 'data:video')) {
                        $folderPath = 'public/TourPackages/Videos/';
                        $savePath = public_path('TourPackages/Videos/');

                        if (!file_exists($savePath)) {
                            mkdir($savePath, 0755, true);
                        }

                        list($meta, $base64Data) = explode(';', $videoData);
                        $mimeType = str_replace('data:', '', $meta);
                        list(, $base64Data) = explode(',', $base64Data);

                        $maxBase64Size = 10 * 1024 * 1024 * 4 / 3; // 10MB in base64 characters
                        if (strlen($base64Data) > $maxBase64Size) {
                            return [
                                'message' => 'Video size must not exceed 10MB.',
                                'result' => false,
                            ];
                        }

           

                        $fileData = base64_decode($base64Data);

                        $mimeToExt = [
                            'video/mp4' => 'mp4',
                            'video/avi' => 'avi',
                            'video/mov' => 'mov',
                            'video/webm' => 'webm',
                            'video/mpeg' => 'mpeg',
                        ];

                        $extension = $mimeToExt[$mimeType] ?? 'mp4';
                        $fileName = uniqid() . '.' . $extension;
                        $filePath = $folderPath . $fileName;

                        file_put_contents($savePath . $fileName, $fileData);
                        $createData->video = $filePath;

                    } else {
                        // If it's already a URL or path
                        $parsedUrl = parse_url($videoData);
                        if (isset($parsedUrl['path'])) {
                            $path = ltrim($parsedUrl['path'], '/');

                            if (Str::contains($path, 'public/TourPackages/Videos/')) {
                                $relativePath = Str::after($path, 'public/');
                                $createData->video = 'public/' . $relativePath;
                            } else {
                                $createData->video = $videoData;
                            }
                        } else {
                            $createData->video = $videoData;
                        }
                    }
                }
            }

            $createData->save();
 

            if($request->tour_schedule){
                foreach($request->tour_schedule as $key => $value){
                    $tour_schedule = new  TourScheduleMaster();
                    $tour_schedule->tour_packages_master_id = $createData->id;
                    $tour_schedule->start_date = $value['start_date'] ?? '';
                    $tour_schedule->end_date = $value['end_date'] ?? '';
                    $tour_schedule->sheets = $value['sheets'] ??'';
                    $tour_schedule->bus_layout = $value['bus_layout'] ?? '';
                    $tour_schedule->child_rate = $value['child_rate'] ?? '';
                    $tour_schedule->per_person_rate = $value['per_person_rate'] ?? '';
                    $tour_schedule->save();
                    
                }
            }


            return [
                'result' => true,
                'message' => $tour_package_id ? 'Tour Packages Updated Successfully.' : 'Tour Packages Created Successfully.',
                'object' => 'TourPackagesMasters',
               
            ];
       
    }


    

}
