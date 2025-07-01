<?php

namespace App\Containers\AppSection\Checkin\Actions;

use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Checkin\Tasks\NewCreateOrUpdateCheckinTask;
use App\Containers\AppSection\Checkin\UI\API\Requests\newcreateOrUpdateCheckinRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\Booking;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use App\Containers\AppSection\Checkin\Models\CheckIdentityType;

class newcreateOrUpdateCheckinAction extends ParentAction
{
    use HashIdTrait;
    // public function run(CreateOrUpdateCheckinRequest $request)
    // {
    //     $bookingId = $this->decode($request->booking_master_id);
    //     $booking = Booking::where('id', $bookingId)->first();
    //     if (!$booking) {
    //         $returnbookingData['result'] = false;
    //         $returnbookingData['message'] = "Booking Id is Invalid";
    //         $returnbookingData['object'] = "Check In Master";
    //         return $returnbookingData;
    //     }
    //     if (!empty($request->identity_proof)) {
    //         // return "hiii";
    //         $base64String = $request->identity_proof;
    //         $folderPath = 'public/identityproof/';
    //         if (!file_exists(public_path('identityproof'))) {
    //             mkdir(public_path('identityproof'), 0755, true);
    //         }

    //         // Extract MIME type and Base64 content
    //         list($type, $data) = explode(';', $base64String);
    //         list(, $data) = explode(',', $data);

    //         // Decode Base64
    //         $fileData = base64_decode($data);
    //         if (!$fileData) {
    //             return ['error' => 'Invalid Base64 data'];
    //         }

    //         // Generate unique filename
    //         $fileName = uniqid() . '.';

    //         if ($type == "data:application/pdf") {
    //             $fileName .= "pdf";
    //             $filePath = $folderPath . $fileName;
    //             file_put_contents($filePath, $fileData);
    //         } else {
    //             // Handle image uploads (PNG by default)
    //             $manager = new ImageManager(Driver::class);
    //             $image = $manager->read($base64String);
    //             $fileName .= "png";
    //             $filePath = $folderPath . $fileName;
    //             $image->toPng()->save($filePath);
    //         }
    //     } else {
    //         $filePath = '';
    //     }
    //     $data = [
    //         'date' => $request->date,
    //         'time' => $request->time,
    //         'name' => $request->name,
    //         'address' => $request->address,
    //         'nationality' => $request->nationality,
    //         'passport_no' => $request->passport_no,
    //         'arrival_date_in_india' => $request->arrival_date_in_india,
    //         'mobile' => $request->mobile,
    //         'email' => $request->email,
    //         'birth_date' => $request->birth_date,
    //         'anniversary_date' => $request->anniversary_date,
    //         'checkout_date' => $request->checkout_date,
    //         'male' => $request->male,
    //         'female' => $request->female,
    //         'children' => $request->children,
    //         'arrived_from' => $request->arrived_from,
    //         'depart_to' => $request->depart_to,
    //         'purpose_of_visit' => $request->purpose_of_visit,
    //         'room_allocation' => $request->room_allocation,
    //         'identity_proof' => $filePath,
    //     ];
    //     return $data;
    //     return app(CreateOrUpdateCheckinTask::class)->run($data, $request);
    // }

    public function run(newcreateOrUpdateCheckinRequest $request)
    {
        // return "hhii";;
        // return $request->booking_master_id;
        // $bookingId = $this->decode($request->booking_master_id);
        // $booking = Booking::where('id', $bookingId)->first();

        // if (!$booking) {
        //     return [
        //         'result' => false,
        //         'message' => "Booking Id is Invalid",
        //         'object' => "Check In Master"
        //     ];
        // }

        // if (!empty($request->identity_proof)) {
        //     $base64String = $request->identity_proof;
        //     $folderPath = public_path('identityproof/');

        //     // Ensure directory exists
        //     if (!is_dir($folderPath)) {
        //         mkdir($folderPath, 0755, true);
        //     }

        //     // Extract MIME type and Base64 content
        //     list($type, $data) = explode(';', $base64String);
        //     list(, $data) = explode(',', $data);

        //     // Decode Base64
        //     $fileData = base64_decode($data);
        //     if (!$fileData) {
        //         return ['error' => 'Invalid Base64 data'];
        //     }

        //     // Generate unique filename
        //     $fileName = uniqid();

        //     if ($type == "data:application/pdf") {
        //         $fileName .= ".pdf";
        //         $filePath = $folderPath . $fileName;
        //         file_put_contents($filePath, $fileData);
        //     } else {
        //         // Handle image uploads
        //         $fileName .= ".png";
        //         $filePath = $folderPath . $fileName;

        //         $manager = new ImageManager(new Driver());
        //         $image = $manager->read($base64String);
        //         $image->toPng()->save($filePath);
        //     }
        // } else {
        //     $filePath = '';
        // }
        // $allocatedRoom = implode(',', array_map([$this, 'decode'], $request->room_allocation));
        $data = [
            // 'date' => $request->date,
            'time' => $request->time ?? '',
            'name' => $request->name ?? '',
            'address' => $request->address ?? '',
            'nationality' => $request->nationality ?? '',
            'passport_no' => $request->passport_no ?? '',
            'arrival_date_in_india' => $request->arrival_date_in_india ?? '',
            'mobile' => $request->mobile ?? '', 
            'email' => $request->email ?? '',
            'birth_date' => $request->birth_date ?? '',
            'anniversary_date' => $request->anniversary_date ?? '',
            // 'checkout_date' => $request->checkout_date,
            'male' => $request->male ?? '',
            'female' => $request->female ?? '',
            'children' => $request->children ?? '',
            'arrived_from' => $request->arrived_from ?? '',
            'depart_to' => $request->depart_to ?? '',
            'purpose_of_visit' => $request->purpose_of_visit ?? '',
        ];
     
        return app(NewCreateOrUpdateCheckinTask::class)->run($request);
    }
}
