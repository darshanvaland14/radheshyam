<?php

namespace App\Containers\AppSection\TourWebDashboard\Tasks;

use App\Containers\AppSection\TourWebDashboard\Data\Repositories\TourWebDashboardRepository;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebBlogChild;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebBlogMaster;
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

class CreateORUpdateTourWebBlogTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourWebDashboardRepository $repository
    ) {
    }

    public function run($request)
    {
        try {
            
            $tour_web_blog_master_id = $this->decode($request->tour_web_blog_master_id);
            // return $tour_web_blog_master_id;
            if($tour_web_blog_master_id){
                $createData = TourWebBlogMaster::find($tour_web_blog_master_id);
                TourWebBlogChild::where('web_blog_master_id' ,$tour_web_blog_master_id)->delete();
            }else{
                $createData = new TourWebBlogMaster;
            }
            $createData->blog_title = $request->blog_title;
            $createData->blog_short_discreption = $request->blog_short_discreption;
            $createData->blog_type = $request->blog_type;
            
            // blog thumbnail images
            if ($request->blog_thumbnail) {
                $document_url = $request->blog_thumbnail;
                if (!empty($document_url)) {
                    if (Str::startsWith($document_url, 'data:image') || Str::startsWith($document_url, 'data:application')) {
                        $folderPath = 'public/WebBlog/';
                        $savePath = public_path('WebBlog/');

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

                        $createData->blog_thumbnail = $filePath;
                    
                    } else {
                        $parsedUrl = parse_url($document_url);
                        if (isset($parsedUrl['path'])) {
                            $path = ltrim($parsedUrl['path'], '/');

                            if (Str::contains($path, 'public/WebBlog/')) {
                                // Extract only the relative path after 'public/'
                                $relativePath = Str::after($path, 'public/');
                                $createData->blog_thumbnail = 'public/' . $relativePath;
                            } else {
                                $createData->blog_thumbnail = $document_url; // External link
                            }
                        } else {
                            $createData->blog_thumbnail = $document_url;
                        }
                    }
                }
            }


            // for images
            if ($request->blog_image) {
                $document_url = $request->blog_image;
                if (!empty($document_url)) {
                    if (Str::startsWith($document_url, 'data:image') || Str::startsWith($document_url, 'data:application')) {
                        $folderPath = 'public/WebBlog/';
                        $savePath = public_path('WebBlog/');

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

                        $createData->blog_image = $filePath;
                    
                    } else {
                        $parsedUrl = parse_url($document_url);
                        if (isset($parsedUrl['path'])) {
                            $path = ltrim($parsedUrl['path'], '/');

                            if (Str::contains($path, 'public/WebBlog/')) {
                                // Extract only the relative path after 'public/'
                                $relativePath = Str::after($path, 'public/');
                                $createData->blog_image = 'public/' . $relativePath;
                            } else {
                                $createData->blog_image = $document_url; // External link
                            }
                        } else {
                            $createData->blog_image = $document_url;
                        }
                    }
                }
            }

            $createData->save();

            if($request->blog_details){
                foreach($request->blog_details  as $blog){
                    $new_data = new TourWebBlogChild();
                    $new_data->web_blog_master_id = $createData->id;
                    $new_data->discreption = $blog['discreption'];
                    $new_data->type = $blog['type'];

                    if($blog['type'] == 'image'){
                         $document_url = $blog['image'];
                            if (!empty($document_url)) {
                                if (Str::startsWith($document_url, 'data:image') || Str::startsWith($document_url, 'data:application')) {
                                    $folderPath = 'public/WebBlog/';
                                    $savePath = public_path('WebBlog/');

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

                                    $new_data->image = $filePath;
                                
                                } else {
                                    $parsedUrl = parse_url($document_url);
                                    if (isset($parsedUrl['path'])) {
                                        $path = ltrim($parsedUrl['path'], '/');

                                        if (Str::contains($path, 'public/WebBlog/')) {
                                            // Extract only the relative path after 'public/'
                                            $relativePath = Str::after($path, 'public/');
                                            $new_data->image = 'public/' . $relativePath;
                                        } else {
                                            $new_data->image = $document_url; // External link
                                        }
                                    } else {
                                        $new_data->image = $document_url;
                                    }
                                }
                            }
                    }else{
                        $videoData = $blog['video'];
                        if (!empty($videoData)) {
                            if (Str::startsWith($videoData, 'data:video')) {
                                $folderPath = 'public/WebBlog/Videos/';
                                $savePath = public_path('WebBlog/Videos/');

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
                                $new_data->video = $filePath;

                            } else {
                                // If it's already a URL or path
                                $parsedUrl = parse_url($videoData);
                                if (isset($parsedUrl['path'])) {
                                    $path = ltrim($parsedUrl['path'], '/');

                                    if (Str::contains($path, 'public/WebBlog/Videos/')) {
                                        $relativePath = Str::after($path, 'public/');
                                        $new_data->video = 'public/' . $relativePath;
                                    } else {
                                        $new_data->video = $videoData;
                                    }
                                } else {
                                    $new_data->video = $videoData;
                                }
                            }
                        }
                    }
                    $new_data->save();
                }   
            }


            return [
                'result' => true,
                'message' => $tour_web_blog_master_id ? 'Tour Web Blog Updated Successfully.' : 'Tour Web Blog Created Successfully.',
                'object' => 'WebBlogMasters',
               
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
