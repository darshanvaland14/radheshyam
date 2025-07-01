<?php

namespace App\Containers\AppSection\Checkin\Tasks;

use App\Containers\AppSection\Checkin\Data\Repositories\CheckinRepository;
use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Apiato\Core\Traits\HashIdTrait;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use App\Containers\AppSection\Checkin\Models\CheckIdentityType;
use Carbon\Carbon;
use App\Containers\AppSection\Booking\Models\Roomstatus;
use App\Containers\AppSection\Booking\Models\Bookingroom;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Checkin\Tasks\GenerateCheckinMasterByCheckinIdTask;

class NewCreateOrUpdateCheckinTask extends ParentTask
{
     use HashIdTrait;
    public function run($request)
    {
        $userId = auth()->user()->id;
        $returnData = [];
        $theme_setting = Themesettings::where('id', 1)->first();
        $rooms_id = [];
        $checkinNo = app(GenerateCheckinMasterByCheckinIdTask::class)->run();

        foreach ($request->rooms as $room) {
            $hotelMasterId = $this->decode($request->hotel_master_id ?? null);
            $bookingMasterId = $this->decode($request->booking_master_id ?? null);
            $roomId = $this->decode($room['room_id'] ?? null);
            $roomTypeId = $this->decode($room['room_type_id'] ?? null);
            $customer_info = Booking::where('id', $bookingMasterId)->first();
            $userData = [
                'time' => $request->time,
                'name' => $request->name,
                'address' => $request->address,
                'nationality' => $request->nationality,
                'passport_no' => $request->passport_no,
                'arrival_date_in_india' => $request->arrival_date_in_india,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'created_by' => $userId,
                'updated_by' => $userId,
                'hotel_master_id' => $hotelMasterId,
                'booking_master_id' => $bookingMasterId,
                'booking_no' => $request->booking_number ?? null,
                'room_allocation' => $room['room_no'] ?? null,
                'room_id' => $roomId,
                'room_type_id' => $roomTypeId,
                'room_type' => $room['room_type'],
                'checkin_no' => $checkinNo,
                // 'name' => $customer_info->first_name . ' ' . $customer_info->last_name . ' ' .$customer_info->middle_name ?? '',
                // 'address' =>  $customer_info->address_line_1 ?? '',
                // 'nationality' => '',
                // 'passport_no' => '',
                'birth_date' => Carbon::parse($request->birth_date)->format("Y-m-d"),
                'anniversary_date' => Carbon::parse($request->anniversary_date)->format("Y-m-d"),
                'female' => $request->female,
                'male'=> $request->male,
                'children' => $request->children,
                'arrived_from' => '',
                'depart_to' => '',
                'purpose_of_visit' => '',

            ];

            $rooms_id[] = $roomId;

            // Ensure correct date format
            $dates = $room['dates'] ?? [];
            if (!empty($dates)) {
                $userData['date'] = Carbon::parse(reset($dates));  // First date
                $userData['checkout_date'] = Carbon::parse(end($dates));  // Last date
            }

            // Generate range of dates for room status
            $checkinDate = clone $userData['date'];
            $checkoutDate = $userData['checkout_date'];

            $dates = [];
            while ($checkinDate->lte($checkoutDate)) {
                $dates[] = $checkinDate->format('Y-m-d');
                $checkinDate->addDay();
            }

            foreach ($dates as $value) {
                // Only update if both booking_master_id and booking_number are available
                if (!empty($bookingMasterId) && !empty($request->booking_number)) {
                    Roomstatus::updateOrCreate(
                        [
                            "booking_master_id" => $bookingMasterId,
                            "booking_no" => $request->booking_number,
                            "status_date" => $value, // Add this to ensure date-based uniqueness
                        ],
                        [
                            "room_id" => $roomId,
                            "room_no" => $room['room_no'],
                            "checkin_no" => $checkinNo,
                            "status" => 'checkin',
                        ]
                    );
                }
            }
            


            // Create a single Checkin entry
            $data = Checkin::create($userData);
        }
        $lastCheckin = $data; // Store last created Checkin object

        $document_data = $request['documentdata'] ?? [];
        if (!empty($document_data)) {
            foreach ($document_data as $key => $value) {
                $document_name = $value['document_name'];
                $document_url = $value['document_url'];

                $folderPath = 'public/identityproof/';
                if (!file_exists(public_path('identityproof/'))) {
                    mkdir(public_path('identityproof/'), 0755, true);
                }

                // Extract MIME type and Base64 content
                list($type, $data) = explode(';', $document_url);
                list(, $data) = explode(',', $data);

                // Decode Base64
                $fileData = base64_decode($data);

                // Get file extension from MIME type
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

                $extension = $mimeToExt[$type] ?? 'bin'; // Default to 'bin' for unknown types

                // Generate unique filename
                $fileName = uniqid() . '.' . $extension;
                $filePath = $folderPath . $fileName;

                // Save the file
                file_put_contents(public_path('identityproof/' . $fileName), $fileData);

                if (isset($lastCheckin) && is_object($lastCheckin)) {
                    $docdata['check_in'] = $lastCheckin->id;
                } else {
                    throw new \Exception("Check-in data is not properly set.");
                }

                $docdata['document_name'] = $document_name;
                $docdata['document_url'] = $filePath;
                CheckIdentityType::create($docdata);
            }
        }


        // Ensure booking_master_id is an array before using whereIn()
        $bookingMasterIds = $this->decode($request->booking_master_id);
        $bookingMasterIds = is_array($bookingMasterIds) ? $bookingMasterIds : [$bookingMasterIds];

        Bookingroom::whereIn('booking_master_id', $bookingMasterIds)->update([
            "room_id" => implode(',', $rooms_id),
        ]);

        return [
            'result' => true,
            'message' => 'Checkin created successfully',
        ];
    }
}
