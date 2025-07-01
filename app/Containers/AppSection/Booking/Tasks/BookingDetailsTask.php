<?php
namespace App\Containers\AppSection\Booking\Tasks;

use App\Containers\AppSection\Booking\Data\Repositories\BookingRepository;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\Bookingroom;
use App\Containers\AppSection\Booking\Models\Roomstatus;
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use Carbon\Carbon;

class BookingDetailsTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($request)
    {
        $booking_id = $this->decode($request->booking_id);
        $booking_no = $request->booking_no;
        $hotel_master_id = $request->hotal_master_id;
    
        $roomsPayload = $request->rooms ?? [];
        
        if (empty($roomsPayload)) {
            return [
                'result' => false,
                'message' => "No Rooms Provided",
                'object' => "Booking Master",
                'data' => []
            ];
        }
    
        // 🔥 Delete all existing room statuses for this booking
        // Roomstatus::where('booking_master_id', $booking_id)->delete();
    
        $data = [];
        $roomGroups = [];

        foreach ($roomsPayload as $room) {
            $room_id = $this->decode($room['room_id']);
            $room_type_id = $this->decode($room['room_type_id']);
        
            // Initialize array if not already set
            if (!isset($roomGroups[$room_type_id])) {
                $roomGroups[$room_type_id] = [];
            }
        
            if (!in_array($room_id, $roomGroups[$room_type_id])) {
                $roomGroups[$room_type_id][] = $room_id;
            }
        }
        foreach ($roomGroups as $room_type_id => $room_ids_array) {
            $room_ids_str = implode(',', $room_ids_array);
            $bookingRoom = Bookingroom::where('booking_master_id', $booking_id)
                ->where('room_type_id', $room_type_id)
                ->first();        
            if ($bookingRoom) { 
                $bookingRoom->room_id = $room_ids_str;
                $bookingRoom->save();
            }
        }
        foreach ($roomsPayload as $room) {
            $room_id = $this->decode($room['room_id']) ?? null;
            $room_no = $room['room_no'];
            $room_type_id = $this->decode($room['room_type_id']) ?? null;
    
            $dates = $room['dates'] ?? [];
            $datesToInsert = array_slice($dates, 0, count($dates) - 1); // Remove last date
    
            // foreach ($datesToInsert as $date) {
            //     $formattedDate = \Carbon\Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
            //     // ✅ Create new room status
            //     Roomstatus::create([
            //         'booking_master_id' => $booking_id,
            //         'booking_no' => $booking_no,
            //         'room_id' => $room_id,
            //         'room_no' => $room_no,
            //         'status' => 'booking',
            //         'status_date' => $formattedDate
            //     ]);
            // }              

            foreach ($datesToInsert as $date) {
                $formattedDate = \Carbon\Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
            
                Roomstatus::updateOrCreate(
                    [
                        'booking_master_id' => $booking_id,
                        'status_date' => $formattedDate,
                        'booking_no' => $booking_no,
                    ],
                    [
                        'room_id' => $room_id,
                        'room_no' => $room_no,
                        'status' => 'booking',
                    ]
                );
            }
            
            // 🔎 Fetch booking room  
            
            $bookingRoom = Bookingroom::where('booking_master_id', $booking_id)
                ->where('booking_no', $booking_no)
                ->where('room_id', 'LIKE', "%$room_id%")
                // ->where('room_id', 'LIKE', "8")

                ->first();
            // return $room_type_id;
            if ($bookingRoom) {
                $roomType = Roomtype::find($bookingRoom->room_type_id);
    
                $data[] = [
                    'room_type_id' => $this->encode($bookingRoom->room_type_id),
                    'room_type' => $roomType->name ?? '',
                    'room_no' => $room_no,
                    'room_id' => $this->encode($room_id),
                    'price' => $bookingRoom->price,
                    'plan' => $bookingRoom->plan,
                    'extra_bed_qty' => $bookingRoom->extra_bed_qty,
                    'extra_bed_price' => $bookingRoom->extra_bed_price,
                    'total_amount' => $bookingRoom->total_amount,
                    'other_charge' => $bookingRoom->other_charge,
                    'other_description' => $bookingRoom->other_description,
                    'check_in' => $bookingRoom->check_in,
                    'check_out' => $bookingRoom->check_out,
                ];
            } else {
                // fallback
                $data[] = [
                    'room_type_id' => null,
                    'room_type' => null,
                    'room_no' => $room_no,
                    'room_id' => $this->encode($room_id),
                    'price' => null,
                    'plan' => null,
                    'extra_bed_qty' => null,
                    'extra_bed_price' => null,
                    'total_amount' => null,
                    'other_charge' => null,
                    'other_description' => null,
                    'check_in' => null,
                    'check_out' => null,
                ];
            }
        }
    
        return [
            'result' => true,
            'message' => "Room-wise Booking Data Processed",
            'object' => "Booking Master",
            'data' => $data
        ];
    }
    
    


    
}
