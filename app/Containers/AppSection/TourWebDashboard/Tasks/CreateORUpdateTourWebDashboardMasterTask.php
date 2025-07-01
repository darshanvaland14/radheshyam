<?php

namespace App\Containers\AppSection\TourWebDashboard\Tasks;

use App\Containers\AppSection\TourWebDashboard\Data\Repositories\TourWebDashboardRepository;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
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

class CreateORUpdateTourWebDashboardMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourWebDashboardRepository $repository
    ) {
    }

    public function run($request)
    {
        try {
            $tour_web_dashboard_id = $this->decode($request->tour_web_dashboard_id);
            // return $tour_web_dashboard_id;
            if($tour_web_dashboard_id){
                $createData = TourWebDashboard::find($tour_web_dashboard_id);
            }else{
                $createData = new TourWebDashboard;
            }
            $createData->label = $request->label;
            $createData->description = $request->description;
            
            if ($request->image) {
                $document_url = $request->image;
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

                        $createData->image = $filePath;
                    
                    } else {
                        $parsedUrl = parse_url($document_url);
                        if (isset($parsedUrl['path'])) {
                            $path = ltrim($parsedUrl['path'], '/');

                            if (Str::contains($path, 'public/TourPackages/')) {
                                // Extract only the relative path after 'public/'
                                $relativePath = Str::after($path, 'public/');
                                $createData->image = 'public/' . $relativePath;
                            } else {
                                $createData->image = $document_url; // External link
                            }
                        } else {
                            $createData->image = $document_url;
                        }
                    }
                }
            }

            $createData->save();
            return [
                'result' => true,
                'message' => $tour_web_dashboard_id ? 'Tour Web Dashboard Updated Successfully.' : 'Tour Web Dashboard Created Successfully.',
                'object' => 'TourPackagesMasters',
               
            ];
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to create the resource. Please try again later.',
                'object' => 'TourWebDashboards',
                'data' => [],
            ];
        }
    }
}
