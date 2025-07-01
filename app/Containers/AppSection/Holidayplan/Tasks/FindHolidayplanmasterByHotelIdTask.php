<?php

namespace App\Containers\AppSection\Holidayplan\Tasks;

use App\Containers\AppSection\Holidayplan\Data\Repositories\HolidayplanRepository;
use App\Containers\AppSection\Holidayplan\Models\Holidayplan;
use App\Ship\Exceptions\NotFoundException;
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
use App\Containers\AppSection\Roomtype\Models\Roomtype;

class FindHolidayplanmasterByHotelIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HolidayplanRepository $repository
    ) {}

    public function run($id, $request)
    {
        try {
            $year = $request->input('year');
            $month = $request->input('month');
            $hotelData = Hotelmaster::where('id', $id)->first();
            if ($hotelData !== null) {
                $roomData = Hotelroom::where('hotel_master_id', $hotelData->id)->get();
                if (!empty($roomData)) {
                    if (count($roomData) >= 1) {
                        $returnData['result'] = true;
                        $returnData['message'] = "Data found";
                        $returnData['data']['object'] = "Holidayplans";
                        $returnData['data']['hotel_master_id'] = $this->encode($hotelData->id);
                        for ($i = 0; $i < count($roomData); $i++) {
                            $room = [];
                            $holidayplanData = [];
                            $room['id'] = $this->encode($roomData[$i]->id);
                            $room['room_number'] = $roomData[$i]->room_number;
                            $room['room_type_id'] = $this->encode($roomData[$i]->room_type_id);
                            $roomType = Roomtype::where('id', $roomData[$i]->room_type_id)->first();
                            if (!empty($roomType)) {
                                $room['room_type_name'] = $roomType->name;
                            } else {
                                $room['room_type_name'] = '';
                            }
                            $room['room_size_in_sqft'] = $roomData[$i]->room_size_in_sqft;
                            $room['occupancy'] = $roomData[$i]->occupancy;
                            $room['room_view'] = $roomData[$i]->room_view;
                            $room['room_amenities'] = $roomData[$i]->room_amenities;
                            $room['created_at'] = $roomData[$i]->created_at;
                            $room['updated_at'] = $roomData[$i]->updated_at;
                            $holidayplanQuery = Holidayplan::where('hotel_master_id', $hotelData->id)
                                ->where('room_id', $roomData[$i]->id);
                            if ($year) {
                                $holidayplanQuery->where(function ($query) use ($year) {
                                    $query->whereYear('holiday_start_date', $year)
                                        ->orWhereYear('holiday_end_date', $year);
                                });
                            }
                            if ($month) {
                                $holidayplanQuery->where(function ($query) use ($month) {
                                    $query->whereMonth('holiday_start_date', '<=', $month)
                                        ->whereMonth('holiday_end_date', '>=', $month);
                                });
                            }
                            $holidayplanData = $holidayplanQuery->get();
                            // dd($holidayplanData);
                            // die;
                            if (!empty($holidayplanData)) {
                                if (count($holidayplanData) >= 1) {
                                    $room['holiday_plan_flag'] = true;
                                    for ($i = 0; $i < count($holidayplanData); $i++) {
                                        $holidayplan = [];
                                        $holidayplan['id'] = $this->encode($holidayplanData[$i]->id);
                                        $holidayplan['holiday_start_date'] = $holidayplanData[$i]->holiday_start_date;
                                        $holidayplan['holiday_end_date'] = $holidayplanData[$i]->holiday_end_date;
                                        $holidayplan['fair_increase_decrease'] = $holidayplanData[$i]->fair_increase_decrease;
                                        $holidayplan['fair_per'] = $holidayplanData[$i]->fair_per;
                                        $holidayplan['created_by'] = $this->encode($holidayplanData[$i]->created_by);
                                        $holidayplan['updated_by'] = $this->encode($holidayplanData[$i]->updated_by);
                                        $holidayplan['created_at'] = $holidayplanData[$i]->created_at;
                                        $holidayplan['updated_at'] = $holidayplanData[$i]->updated_at;
                                        $room['holiday_plans'][] = $holidayplan;
                                    }
                                    // dd($room);
                                } else {
                                    $room['holiday_plan_flag'] = false;
                                }
                            } else {
                                $room['holiday_plan_flag'] = false;
                            }
                            $returnData['data']['rooms'][] = $room;
                        }
                    } else {
                        $returnData['result'] = false;
                        $returnData['message'] = " Rooms Not Available";
                        $returnData['object'] = "Holidayplan";
                    }
                } else {
                    $returnData['result'] = false;
                    $returnData['message'] = " Rooms Not Found";
                    $returnData['object'] = "Holidayplan";
                }
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "Hotel Not Found";
                $returnData['object'] = "Holidayplan";
            }
            // dd($returnData);
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'Holidayplans',
                'data' => [],
            ];
        }
    }
}
