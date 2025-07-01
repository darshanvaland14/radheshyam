<?php

namespace App\Containers\AppSection\FitMaster\Tasks;
// use App\Containers\AppSection\FitMaster\Jobs\ProcessTourPackageMediaJob;

use App\Containers\AppSection\FitMaster\Data\Repositories\FitMasterRepository;
use App\Containers\AppSection\FitMaster\Models\FitMaster;
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

class CreateOrUpdateFitMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected FitMasterRepository $repository
    ) {
    }


    public function run($request)
    {
            // dd($request->no_days);
            $fit_master_id  = $this->decode($request->fit_master_id);
            if($fit_master_id){
                $createData = FitMaster::find($fit_master_id);
                
            }else{
                $createData = new FitMaster();
            }
            $createData->name = $request->name ;
            $createData->no_days = $request->no_days ;
            $createData->tour_sector = $this->decode($request->tour_sector) ??'';
            $createData->tour_category = $this->decode($request->tour_category) ??'';
            $createData->tour_rate = $request->tour_rate;
            $createData->highlight = $request->highlights ;
            $createData->notes = $request->notes ;
            $createData->tour_plan = json_encode($request->tour_plan); 
            $createData->budget = json_encode($request->budget);
            
            
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
            return [
                'result' => true,
                'message' => $fit_master_id ? 'Tour Packages Updated Successfully.' : 'Tour Packages Created Successfully.',
                'object' => 'FitMasters',
               
            ];
       
    }


    

}