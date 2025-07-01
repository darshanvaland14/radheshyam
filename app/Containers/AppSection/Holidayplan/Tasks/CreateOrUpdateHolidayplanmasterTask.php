<?php

namespace App\Containers\AppSection\Holidayplan\Tasks;

use App\Containers\AppSection\Holidayplan\Data\Repositories\HolidayplanRepository;
use App\Containers\AppSection\Holidayplan\Models\Holidayplan;
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
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;

class CreateOrUpdateHolidayplanmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HolidayplanRepository $repository
    ) {}

    public function run($request)
    {
        try {
            $user_id = $this->decode($request->user_id);
            $hotel_master_id = $this->decode($request->hotel_master_id);
            $hotelflag = Hotelmaster::find($hotel_master_id);
            $flag = false;
            if ($hotelflag) {
                if ($request->rooms != null) {
                    if (count($request->rooms) >= 1) {
                        foreach ($request->rooms as $roomData) {
                            $room_id = $this->decode($roomData['id']);
                            $actroomData = Hotelroom::where('id', $room_id)->first();
                            if ($actroomData != null) {
                                $condition = array();
                                $newData = array();
                                $holidayplan = $roomData['holiday_plan'];
                                $condition['hotel_master_id'] = $hotel_master_id;
                                $condition['room_id'] = $room_id;
                                $newData['holiday_start_date'] = $holidayplan['holiday_start_date'];
                                $newData['holiday_end_date'] = $holidayplan['holiday_end_date'];
                                $newData['fair_increase_decrease'] = $holidayplan['fair_increase_decrease'];
                                $newData['fair_per'] = $holidayplan['fair_per'];
                                $newData['updated_by'] = $user_id;
                                $existingRecord = Holidayplan::where($condition)
                                    ->where('holiday_start_date', '<=', $holidayplan['holiday_end_date'])
                                    ->where('holiday_end_date', '>=', $holidayplan['holiday_start_date'])
                                    ->first();
                                if ($existingRecord) {
                                    $createData = $existingRecord->update($newData);
                                    $flag = true;
                                } else {
                                    $newData['created_by'] = $user_id;
                                    $createData = Holidayplan::create(array_merge($condition, $newData));
                                    $flag = true;
                                }
                                if ($flag !== true) {
                                    $returnData['result'] = false;
                                    $returnData['message'] = "Record Not Created/Updated";
                                    $returnData['object'] = "Holidayplan Master";
                                    return $returnData;
                                }
                            } else {
                                $returnData['result'] = false;
                                $returnData['message'] = "Room Not Found";
                                $returnData['object'] = "Holidayplan Master";
                            }
                        }
                        $getData = Holidayplan::where('hotel_master_id', $hotel_master_id)
                            ->where('room_id', $room_id)->first();
                        if ($getData !== null) {
                            $returnData['result'] = true;
                            $returnData['message'] = "Holiday plan Updated Successfully";
                            $returnData['object'] = "Holidayplan Master";
                            $returnData['data']['id'] = $this->encode($getData->id);
                            $returnData['data']['holiday_start_date'] = $getData->holiday_start_date;
                            $returnData['data']['holiday_end_date'] = $getData->holiday_end_date;
                            $returnData['data']['fair_increase_decrease'] = $getData->fair_increase_decrease;
                            $returnData['data']['fair_per'] = $getData->fair_per;
                            $returnData['data']['created_by'] = $this->encode($getData->created_by);
                            $returnData['data']['updated_by'] = $this->encode($getData->updated_by);
                            $returnData['data']['created_at'] = $getData->created_at;
                            $returnData['data']['updated_at'] = $getData->updated_at;
                        }
                    }
                } else {
                    $returnData['result'] = false;
                    $returnData['message'] = "Rooms Not Found";
                    $returnData['object'] = "Holidayplan Master";
                }
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "Hotel Id is Invalid";
                $returnData['object'] = "Holidayplan Master";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to create the resource. Please try again later.',
                'object' => 'Holidayplans',
                'data' => [],
            ];
        }
    }
}
