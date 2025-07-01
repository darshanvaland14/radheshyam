<?php

namespace App\Containers\AppSection\Checkin\Tasks;

use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Laundry\Models\LaundryOrder;
use App\Containers\AppSection\Laundry\Models\LaundryOrderChild;
use App\Containers\AppSection\Laundry\Models\LaundryMaster;
use App\Containers\AppSection\Restaurant\Models\KotBill;
use App\Containers\AppSection\Restaurant\Models\KotDetails;
use App\Containers\AppSection\Restaurant\Models\KotMaster;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMasterChild;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Apiato\Core\Traits\HashIdTrait;
use DateTime;
use DateInterval;
use DatePeriod;
use Carbon\Carbon;
class FindCheckinByIdTask extends ParentTask
{
    use HashIdTrait;
    

    public function run($id)
    {
            $theme_setting = Themesettings::where('id', 1)->first();
            $checkinData = Checkin::where('id', $id)->first();

            if ($checkinData) {
                $returnData['result'] = true;
                $returnData['message'] = "Check In Found Successfully";
                $returnData['object'] = "Checkin Master";

                $total_amount = Checkin::where('checkin_no', $checkinData->checkin_no)->sum('total_amount');
                
                $returnData['data'] = [
                    'id' => $this->encode($checkinData->id),
                    'booking_master_id' => $this->encode($checkinData->booking_master_id),
                    'room_type_id' => $this->encode($checkinData->room_type_id),
                    'booking_no' => $checkinData->booking_no,
                    'checkin_no' => $checkinData->checkin_no,
                    'date' => $checkinData->date,
                    'time' => $checkinData->time,
                    'name' => $checkinData->first_name . '' . $checkinData->middle_name . ''. $checkinData->last_name,
                    'address' => $checkinData->address_line_1,
                    'nationality' => $checkinData->nationality,
                    'passport_no' => $checkinData->passport_no,
                    'arrival_date_in_india' => $checkinData->arrival_date_in_india,
                    'mobile' => $checkinData->mobile,
                    'email' => $checkinData->email,
                    'birth_date' => $checkinData->birth_date,
                    'anniversary_date' => $checkinData->anniversary_date,
                    'checkout_date' => $checkinData->checkout_date,
                    'female' => $checkinData->female,
                    'children' => $checkinData->children,
                    'arrived_from' => $checkinData->arrived_from,
                    'depart_to' => $checkinData->depart_to,
                    'purpose_of_visit' => $checkinData->purpose_of_visit,
                    'room_allocation' => $checkinData->room_allocation,
                    'identity_proof' => $checkinData->identity_proof ? $theme_setting->api_url . $checkinData->identity_proof : "",
                    'total_amount' => $total_amount,
                    'advance_amount' => $checkinData->advance_amount,
                    'pending_amount' => $total_amount - $checkinData->advance_amount,
                    'final_total_amount' => $total_amount,
                    'created_by' => $this->encode($checkinData->created_by),
                    'updated_by' => $this->encode($checkinData->updated_by),
                ];

                
                $laundryData = LaundryOrder::where('checkin_no', $checkinData->checkin_no)->pluck('id')->toArray();
                // return $laundryData;
                if (!empty($laundryData)) {
                    foreach ($laundryData as $laundryKey => $item) {
                        $laundryChildData = LaundryOrderChild::where('laundry_order_id', $item)
                            ->where('status', 'Delivered')
                            ->get();

                        foreach ($laundryChildData as $childKey => $value) {
                            $item = LaundryMaster::where('id', $value->item)->first();
                            $returnData['data']['laundry'][] = [
                                'id' => $this->encode($value->id),
                                'laundry_order_id' => $this->encode($value->laundry_order_id),
                                'item' => $this->encode($value->item),
                                'item_name' => $item ? $item->name : '',
                                'quantity' => $value->quantity,
                                'price' => $value->price,
                                'total_price' => $value->total_price,
                                'status' => $value->status,
                                'delivery_date' => $value->delivery_date,
                                'delivery_time' => $value->delivery_time,
                            ];
                        }
                    }
                }


                

                // Room + Hall KOT Details
                $room_ids = Checkin::where('checkin_no', $checkinData->checkin_no)
                    ->pluck('room_id')
                    ->filter()
                    ->toArray();

                // $hall_ids = Checkin::where('checkin_no', $checkinData->checkin_no)
                //     ->pluck('hall_id')
                //     ->filter()
                //     ->toArray();

                // $service_ids = array_merge($room_ids, $hall_ids);

                $check_in = $checkinData->date;
                $check_out = $checkinData->checkout_date;

                $start = DateTime::createFromFormat('Y-m-d', $check_in);
                $end = DateTime::createFromFormat('Y-m-d', $check_out);
                $end->modify('+1 day');

                $interval = new DateInterval('P1D');
                $dateRange = new DatePeriod($start, $interval, $end);

                $dates = [];
                foreach ($dateRange as $date) {
                    $dates[] = $date->format('Y-m-d');
                }

                // $kot_master_ids = KotMaster::where('type', 'Room Service')
                //     ->whereIn('table_no_room_no', $room_ids)
                //     ->whereIn('date', $dates)
                //     ->where('status', 'Settled')
                //     ->pluck('id')
                //     ->toArray();

                $kot_master_data = KotMaster::where('type', 'Room Service')
                    ->whereIn('table_no_room_no', $room_ids)
                    ->whereIn('date', $dates)
                    ->where('status', 'Settled')
                    ->select('id', 'date' , 'restaurant_master_id')
                    ->get()
                    ->toArray();

                $kot_master_ids = [];
                $kot_master_dates = [];  

                foreach ($kot_master_data as $key => $value) {
                    $kot_master_ids[] = $value['id'];
                    $kot_master_dates[$value['id']] = $value['date']; 
                    $restaurant_name[$value['id']] = Restaurant::find($value['restaurant_master_id']);
                }

                if (!empty($kot_master_ids)) {
                    $kotDetails = KotDetails::whereIn('kot_master_id', $kot_master_ids)->get();

                    foreach ($kotDetails as $key => $value) {
                        
                        $item = RestaurantMenuMasterChild::where('id', $value->item)->first();
                        
                        $kot_date = isset($kot_master_dates[$value->kot_master_id]) ? $kot_master_dates[$value->kot_master_id] : '';
                        $kot_restaurant_name = isset($restaurant_name[$value->kot_master_id]) ? $restaurant_name[$value->kot_master_id] : '';
        
                        $returnData['data']['kot_child'][$key] = [
                            'id' => $this->encode($value->id),
                            'kot_master_id' => $this->encode($value->kot_master_id),
                            'item' => $this->encode($value->item),
                            'item_name' => $item ? $item->menu_name : '',
                            'restaurant_name' => $kot_restaurant_name ? $kot_restaurant_name->name : '',
                            'quantity' => $value->quantity,
                            'rate' => $value->rate,
                            'gst_tax' => $value->gst_tax,
                            'hsn_code' => $value->hsn_code,
                            'sp_instruction' => $value->sp_instruction,
                            "total_with_gst" => $value->rate * $value->quantity * ($value->gst_tax / 100) + $value->rate,
                            'kot_no' => $value->no,
                            'date' => $kot_date,  // Use the date from KotMastre
                        ];
                    }
                


                    $kot_bills = KotBill::whereIn('kot_master_id', $kot_master_ids)->get();
                    foreach ($kot_bills as $kot_bill) {
                        $kot_restaurant_name = isset($restaurant_name[$kot_bill->kot_master_id]) ? $restaurant_name[$kot_bill->kot_master_id] : '';
                        $returnData['data']['kot_bill'][] = [
                            'id' => $this->encode($kot_bill->id),
                            'kot_master_id' => $this->encode($kot_bill->kot_master_id),
                            'restaurant_name' => $kot_restaurant_name ? $kot_restaurant_name->name : '',
                            'bill_no' => $kot_bill->bill_no,
                            'customer_gst_no' => $kot_bill->customer_gst_no,
                            'date' => $kot_bill->date,
                            'groce' => $kot_bill->groce,
                            'discount_type' => $kot_bill->discount_type,
                            'discount' => $kot_bill->discount,
                            'payment_with' => $kot_bill->payment_with,
                            'total_discount' => $kot_bill->total_discount,
                            'tax' => $kot_bill->tax,
                            'net_amount' => number_format( $kot_bill->net_amount, 2, '.', '' ),
                            'room_no' => $this->encode($kot_bill->room_no),
                            'payment_mode' => $kot_bill->payment_mode,
                            'utr_no' => $kot_bill->utr_no,
                            'recive_amount' => $kot_bill->recive_amount,
                            'returnble_amount' => $kot_bill->returnble_amount,
                        ];
                    }
                }

                return $returnData;
            } else {
                return [
                    'result' => false,
                    'message' => "No Data Found",
                    'object' => "Checkin Master",
                    'data' => [],
                ];
            }
        // } catch (\Exception $e) {
        //     return [
        //         'result' => false,
        //         'message' => 'Error: Failed to find the resource. Please try again later.',
        //         'object' => 'Checkin Master',
        //         'data' => [],
        //     ];
        // }
    }
}
