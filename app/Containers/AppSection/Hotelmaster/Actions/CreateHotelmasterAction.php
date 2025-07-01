<?php

namespace App\Containers\AppSection\Hotelmaster\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Hotelmaster\Tasks\CreateHotelmasterTask;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\CreateHotelmasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateHotelmasterAction extends ParentAction
{
    use HashIdTrait;
    public function run(CreateHotelmasterRequest $request)
    {
        $returnData = array();
        $returnHotelmasterData = array();
        $check_Hotelmaster = Hotelmaster::where('name', $request->name)->exists();

        if ($check_Hotelmaster == true || $check_Hotelmaster == 1) {
            $returnHotelmasterData['result'] = false;
            $returnHotelmasterData['message'] = "Entered Hotelmaster Name already exists, Enter different data";
            return $returnHotelmasterData;
        }
        $assign_to = $this->decode($request->assign_to);

        $data = $request->sanitizeInput([
            "name" => $request->name,
            "address" => $request->address,
            "city" => $request->city,
            "state" => $request->state,
            "country" => $request->country,
            "zipcode" => $request->zipcode,
            "email" => $request->email,
            "website" => $request->website,
            "gst_no" => $request->gst_no,
            "pan_no" => $request->pan_no,
            "fssai_no" => $request->fssai_no,
            "bank_name" => $request->bank_name,
            "account_no" => $request->account_no,
            "ifsc_no" => $request->ifsc_no,
            "hotel_star_rating" => $request->hotel_star_rating,
            "notes" => $request->notes,
            "hotel_facilities" => $request->hotel_facilities,
            "contact_email" => $request->contact_email,
            "mobile" => $request->mobile,
        ]);
        $data['assign_to'] = $assign_to;

        return app(CreateHotelmasterTask::class)->run($data, $request);
    }
}
