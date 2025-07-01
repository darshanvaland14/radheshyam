<?php

namespace App\Containers\AppSection\Hotelmaster\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Hotelmaster\Data\Repositories\HotelmasterRepository;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class GetAllHotelmastersTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelmasterRepository $repository
    ) {}

    public function run()
    {
        try {
            $getData = Hotelmaster::orderBy('id', 'desc')->get();
            $returnData = array();
            if (!empty($getData) && count($getData) >= 1) {
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['result'] = true;
                    $returnData['message'] = "Data found";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['name'] =  $getData[$i]->name;
                    $returnData['data'][$i]['address'] =  $getData[$i]->address;
                    $returnData['data'][$i]['city'] =  $getData[$i]->city;
                    $returnData['data'][$i]['state'] =  $getData[$i]->state;
                    $returnData['data'][$i]['country'] =  $getData[$i]->country;
                    $returnData['data'][$i]['zipcode'] =  $getData[$i]->zipcode;
                    $returnData['data'][$i]['email'] =  $getData[$i]->email;
                    $returnData['data'][$i]['website'] =  $getData[$i]->website;
                    $returnData['data'][$i]['gst_no'] =  $getData[$i]->gst_no;
                    $returnData['data'][$i]['pan_no'] =  $getData[$i]->pan_no;
                    $returnData['data'][$i]['fssai_no'] =  $getData[$i]->fssai_no;
                    $returnData['data'][$i]['bank_name'] =  $getData[$i]->bank_name;
                    $returnData['data'][$i]['account_no'] =  $getData[$i]->account_no;
                    $returnData['data'][$i]['ifsc_no'] =  $getData[$i]->ifsc_no;
                    $returnData['data'][$i]['hotel_star_rating'] =  $getData[$i]->hotel_star_rating;
                    $returnData['data'][$i]['notes'] =  $getData[$i]->notes;
                    $returnData['data'][$i]['contact_email'] =  $getData[$i]->contact_email;
                    $returnData['data'][$i]['contact_mobile'] =  $getData[$i]->contact_mobile;
                    $returnData['data'][$i]['hotel_facilities'] =  $getData[$i]->hotel_facilities;
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
                $returnData['object'] = "Hotelmasters";
                // $returnData['meta']['pagination']['total'] = $getData->total();
                // $returnData['meta']['pagination']['count'] = $getData->count();
                // $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                // $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                // $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                // $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                // $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'Hotelmasters',
                'data' => [],
            ];
        }
    }
}
