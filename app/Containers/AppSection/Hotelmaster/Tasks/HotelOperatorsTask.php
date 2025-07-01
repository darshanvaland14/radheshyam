<?php

namespace App\Containers\AppSection\Hotelmaster\Tasks;

use App\Containers\AppSection\Hotelmaster\Data\Repositories\HotelmasterRepository;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Role\Models\Role;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;

class HotelOperatorsTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelmasterRepository $repository
    ) {}

    public function run()
    {
        try {
            $role = Role::where('name', 'Hotel Operator')->whereNull('deleted_at')->first();
            $getData = Tenantuser::where('role_id', $role->id)->get();
            $returnData = array();
            if (!empty($getData) && count($getData) >= 1) {
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['result'] = true;
                    $returnData['message'] = "Data found";
                    $returnData['data'][$i]['label'] =  $getData[$i]->first_name . ' ' . $getData[$i]->last_name;
                    $returnData['data'][$i]['value'] = $this->encode($getData[$i]->id);
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
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'Hotelmasters',
                'data' => [],
            ];
        }
    }
}
