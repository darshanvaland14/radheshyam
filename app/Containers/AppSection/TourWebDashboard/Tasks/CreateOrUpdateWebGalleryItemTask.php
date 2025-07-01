<?php

namespace App\Containers\AppSection\TourWebDashboard\Tasks;

use App\Containers\AppSection\TourWebDashboard\Data\Repositories\TourWebDashboardRepository;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebGalleryItem;
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

class CreateOrUpdateWebGalleryItemTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourWebDashboardRepository $repository
    ) {
    }

    public function run($request)
    {
        try {
            
            $gallery_item_id = $this->decode($request->gallery_item_id);
            // return $gallery_item_id;
            if($gallery_item_id){
                $createData = TourWebGalleryItem::find($gallery_item_id);
            }else{
                $createData = new TourWebGalleryItem;
            }
            $createData->category = $request->category;
            $createData->location = $request->location;
            $createData->title = $request->title;
            
            if ($request->src) {
                $document_url = $request->src;
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
                'message' => $gallery_item_id ? 'Tour Web Gallery Updated Successfully.' : 'Tour Web Gallery Created Successfully.',
                'object' => 'TourWebGalleryItem',
               
            ];
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to create the resource. Please try again later.',
                'object' => 'TourWebGalleryItem',
                'data' => [],
            ];
        }
    }
}
