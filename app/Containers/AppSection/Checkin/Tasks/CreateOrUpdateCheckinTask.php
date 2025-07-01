<?php

namespace App\Containers\AppSection\Checkin\Tasks;

use App\Containers\AppSection\Checkin\Data\Repositories\CheckinRepository;
use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Checkin\Models\CheckinGuestDetails;
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
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Checkin\Tasks\GenerateCheckinMasterByCheckinIdTask;

class CreateOrUpdateCheckinTask extends ParentTask
{
    use HashIdTrait;

 

    public function run($request)
    {

        $userId = auth()->user()->id;
        $returnData = [];
        $theme_setting = Themesettings::where('id', 1)->first();

        // ✅ Validate document data
        if (empty($request->documentdata) || !is_array($request->documentdata) || count($request->documentdata) == 0) {
            return [
                'result' => false,
                'message' => 'Please upload at least one document.',
            ];
        }


        // check for guest infromation is availble or not
        foreach($request->rooms as $guest_data) {
            $check_room_availbiliy = Roomstatus::where('room_no', $guest_data['room_no'])
                ->where('status', 'checkin')
                ->first();
            if($check_room_availbiliy) {
                return [
                    'result' => false,
                    'message' => 'Room No '. $guest_data['room_no'] .' is already checked in.',
                ];
            }

            foreach($guest_data['guest_data'] as $room){
                if (empty($room['guest_name']) || empty($room['guest_mobile']) || empty($room['guest_email']) || empty($room['guest_gender']) || empty($room['guest_age'])) {
                    return [
                        'result' => false,
                        'message' => 'Missing Guest Details for Room No '. $guest_data['room_no'] .'.',
                    ];
                }
            }
        }

        // return "1";
        $hasValidDocument = false;
        foreach ($request->documentdata as $doc) {
            if (!empty($doc['document_name']) && !empty($doc['document_url'])) {
                $hasValidDocument = true;
                break;
            }
        }

        if (!$hasValidDocument) {
            return [
                'result' => false,
                'message' => 'Document name and document file are required.',
            ];
        }
        $userData = [
            'created_by' => $userId,
            'updated_by' => $userId,
            'booking_no' => $request->booking_no ?? null,
            'booking_master_id' => isset($request->booking_master_id) ? $this->decode($request->booking_master_id) : null,
            'hotel_master_id' => $this->decode($request->hotel_master_id),
        ];

        $checkinNo = app(GenerateCheckinMasterByCheckinIdTask::class)->run();

        foreach ($request->rooms as $room) {
            $roomId = $this->decode($room['room_id']);

            $checkInDateTime = Carbon::parse($room['check_in'])->setTime(10, 0, 0);
            $checkOutDateTime = Carbon::parse($room['check_out'])->setTime(9, 0, 0);

            $roomData = array_merge($userData, [
                'checkin_no' => $checkinNo,
                'room_id' => $roomId ?? null,
                'room_allocation' => $room['room_no'] ?? null,
                'room_type_id' => $this->decode($room['room_type_id']),
                'room_type' => $room['room_type'],
                'plan' => $room['plan'],
                'price' => $room['price'],
                'extra_bed_qty' => $room['extra_bed_qty'],
                'extra_bed_price' => $room['extra_bed_price'],
                "other_charge" => $room['other_charge'],
                "total_amount" => $room['total_amount'],
                'date' => $checkInDateTime->format("Y-m-d"),
                'time' => Carbon::now()->format('H:i:s'),
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name, 
                'last_name' => $request->last_name,
                'address_line_1' => $request->address_line_1, 
                'address_line_2' => $request->address_line_2, 
                'city' => $request->city,
                'country' => $request->country,
                'zipcode' => $request->zipcode,
                'adults' => $request->adults,
                'children' => $request->childrens,
                'state' => $request->state,
                'nationality' => $request->nationality,
                'passport_no' => $request->passport_no,
                'arrival_date_in_india' => $request->arrival_date_in_india,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'birth_date' => Carbon::parse($request->birth_date)->format("Y-m-d"),
                'anniversary_date' => Carbon::parse($request->anniversary_date)->format("Y-m-d"),
                'checkout_date' => $checkOutDateTime->format("Y-m-d"),
                // 'female' => $request->female,
                // 'male'=> $request->male,
                'booking_form' => $this->decode($request->booking_from) ?? '',
                'advance_amount' => $request->advance_amount,
                'payment_type' => $request->payment_type,
                'booking_date' => Carbon::parse($request->booking_date)->format("Y-m-d"),
                'arrived_from' => $request->arrived_from,
                'depart_to' => $request->depart_to,
                'purpose_of_visit' => $request->purpose_of_visit,
                'notes' => $request->notes,
            ]);

            $checkin = Checkin::create($roomData);

            $stayEndDate = $checkOutDateTime->copy()->lt($checkOutDateTime->copy()->setTime(9, 0, 0))
                ? $checkOutDateTime->copy()->subDay()
                : $checkOutDateTime->copy();

            $statusDate = $checkInDateTime->copy();
            while ($statusDate->lte($stayEndDate)) {
                Roomstatus::updateOrCreate(
                    [
                        "status_date" => $statusDate->format('Y-m-d'),
                        "room_id" => $roomId,
                        "room_no" => $room['room_no'],
                    ],
                    [
                        "checkin_no" => $checkinNo,
                        "status" => 'checkin',
                    ]
                );
                $statusDate->addDay();
            }

            // ✅ Handle document uploads
            $document_data = $request->documentdata;
            if (!empty($document_data)) {
                foreach ($document_data as $key => $value) {
                    $document_name = $value['document_name'];
                    $document_url = $value['document_url'];

                    if (!empty($document_url)) {
                        $folderPath = 'public/identityproof/';
                        if (!file_exists(public_path('identityproof/'))) {
                            mkdir(public_path('identityproof/'), 0755, true);
                        }

                        list($type, $base64Data) = explode(';', $document_url);
                        $mimeType = str_replace('data:', '', $type);
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

                        file_put_contents(public_path('identityproof/' . $fileName), $fileData);

                        if (isset($checkin) && isset($checkin->id)) {
                            $docdata['check_in'] = $checkin->id;
                        } else {
                            throw new \Exception("Check-in data is not properly set.");
                        }

                        $docdata['document_name'] = $document_name;
                        $docdata['document_url'] = $filePath; 
                        CheckIdentityType::create($docdata);
                    }
                }
            }

            foreach($room['guest_data'] as $rooms){
                $guest_details = new CheckinGuestDetails();
                $guest_details->checkin_no = $checkinNo;
                $guest_details->room_no = $room['room_no'];
                $guest_details->checkin_date = $checkInDateTime->format("Y-m-d");
                $guest_details->checkout_date = $checkOutDateTime->format("Y-m-d");
                $guest_details->guest_name = $rooms['guest_name'];
                $guest_details->guest_mobile = $rooms['guest_mobile'];
                $guest_details->guest_email = $rooms['guest_email'];
                $guest_details->guest_gender = $rooms['guest_gender'];
                $guest_details->guest_age = $rooms['guest_age'];
                $guest_details->save();
            }

            $returnData['data'][] = [
                'id' => $this->encode($checkin->id),
                'checkin_no' => $checkinNo,
                'room_id' => $this->encode($checkin->room_id),
                'room_no' => $checkin->room_no,
                'booking_master_id' => $checkin->booking_master_id ? $this->encode($checkin->booking_master_id) : '',
            ];
        }

        $returnData['result'] = true;
        $returnData['message'] = "Check-In Created Successfully";
        $returnData['object'] = "Checkin Master";

        return $returnData;
    }

}
