<?php

namespace App\Containers\AppSection\Checkin\UI\API\Controllers;

use App\Containers\AppSection\Checkin\Actions\CreateOrUpdateCheckinAction;
use App\Containers\AppSection\Checkin\Actions\FindCheckinByBookingIdAction;
use App\Containers\AppSection\Checkin\Actions\FindCheckinByIdAction;
use App\Containers\AppSection\Checkin\Actions\GetAllCheckinsAction;
use App\Containers\AppSection\Checkin\Actions\newcreateOrUpdateCheckinAction;
use App\Containers\AppSection\Checkin\Actions\getCityCountryStateAction;
use App\Containers\AppSection\Checkin\Actions\GetAllCheckinsWithPaginationAction;
use App\Containers\AppSection\Checkin\Actions\FindCheckinByIdForBillPrintAction;
use App\Containers\AppSection\Checkin\Actions\ExtendCheckinAction;
use App\Containers\AppSection\Checkin\Actions\ExtendCheckinDailyAutomaticAction;


use App\Containers\AppSection\Checkin\UI\API\Requests\FindCheckinByIdForBillPrintRequest;
use App\Containers\AppSection\Checkin\UI\API\Requests\ExtendCheckinDailyAutomaticRequest;
use App\Containers\AppSection\Checkin\UI\API\Requests\CreateOrUpdateCheckinRequest;
use App\Containers\AppSection\Checkin\UI\API\Requests\getCityCountryStateRequest;

use App\Containers\AppSection\Checkin\UI\API\Requests\FindCheckinByBookingIdRequest;
use App\Containers\AppSection\Checkin\UI\API\Requests\FindCheckinByIdRequest;
use App\Containers\AppSection\Checkin\UI\API\Requests\GetAllCheckinsRequest;
use App\Containers\AppSection\Checkin\UI\API\Requests\GetAllCheckinsWithPaginationRequest;
use App\Containers\AppSection\Checkin\UI\API\Requests\newcreateOrUpdateCheckinRequest;

use App\Ship\Parents\Controllers\ApiController;

class Controller extends ApiController 
{
    public function createOrUpdateCheckin(CreateOrUpdateCheckinRequest $request)
    {
        $Checkin = app(CreateOrUpdateCheckinAction::class)->run($request);
        return $Checkin;
    }
    public function findCheckinsByBookingId(FindCheckinByBookingIdRequest $request)
    {
        $Checkin = app(FindCheckinByBookingIdAction::class)->run($request);
        return $Checkin;
    }
    public function findCheckinsById(FindCheckinByIdRequest $request)
    {
        $Checkin = app(FindCheckinByIdAction::class)->run($request);
        return $Checkin;
    }
    public function getAllCheckins(GetAllCheckinsRequest $request)
    {
        $Checkin = app(GetAllCheckinsAction::class)->run($request);
        return $Checkin;
    }
    public function getAllCheckinsWithPagination(GetAllCheckinsWithPaginationRequest $request)
    {
        $Checkin = app(GetAllCheckinsWithPaginationAction::class)->run($request);
        return $Checkin;
    }

    public function newcreateOrUpdateCheckin(newcreateOrUpdateCheckinRequest $request){
        // return "hhh";
        $Checkin = app(newcreateOrUpdateCheckinAction::class)->run($request);
        return $Checkin;
    }

    public function getCityCountryState(getCityCountryStateRequest $request){
        // return "hiii";
        $Checkin = app(getCityCountryStateAction::class)->run($request);
        return $Checkin;
    }

    public function FindCheckinByIdForBillPrint(FindCheckinByIdForBillPrintRequest $request)
    {
        $Checkin = app(FindCheckinByIdForBillPrintAction::class)->run($request);
        return $Checkin;
    }

    public function ExtendCheckin(CreateOrUpdateCheckinRequest $request)
    {
        $Checkin = app(ExtendCheckinAction::class)->run($request);
        return $Checkin;
    }

    public function ExtendCheckinDailyAutomatic(ExtendCheckinDailyAutomaticRequest $request)
    {
        $Checkin = app(ExtendCheckinDailyAutomaticAction::class)->run($request);
        return $Checkin;
    }
}

