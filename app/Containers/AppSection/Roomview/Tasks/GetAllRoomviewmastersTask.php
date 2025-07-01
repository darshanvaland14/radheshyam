<?php

namespace App\Containers\AppSection\Roomview\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Roomview\Data\Repositories\RoomviewRepository;
use App\Containers\AppSection\Roomview\Models\Roomview;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class GetAllRoomviewmastersTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RoomviewRepository $repository
    ) {
    }

    public function run()
    {
        try{
            $getData = Roomview::orderBy('id', 'desc')->get();
            $returnData = array();
            if (!empty($getData) && count($getData) >= 1) {
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['result'] = true;
                    $returnData['message'] = "Data found";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['name'] =  $getData[$i]->name;
                    $returnData['data'][$i]['icon'] =  $getData[$i]->icon;
                    $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
                    $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;
                }
                    // $returnData['meta']['pagination']['total'] = $getData->total();
                    // $returnData['meta']['pagination']['count'] = $getData->count();
                    // $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                    // $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                    // $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                    // $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                    // $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            } else {
                    $returnData['result'] = false;
                    $returnData['message'] = "No Data Found";
                    $returnData['object'] = "Roomviews";
                    // $returnData['meta']['pagination']['total'] = $getData->total();
                    // $returnData['meta']['pagination']['count'] = $getData->count();
                    // $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                    // $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                    // $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                    // $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                    // $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            }
            return $returnData;
        }catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'Roomviews',
                'data' => [],
            ];
        }
    }
}
