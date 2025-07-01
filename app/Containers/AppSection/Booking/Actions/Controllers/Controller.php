<?php

namespace App\Containers\AppSection\Booking\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Booking\Actions\CreateBookingmasterAction;
use App\Containers\AppSection\Booking\Actions\BookingConfirmationAction;
use App\Containers\AppSection\Booking\Actions\BookingNewConfirmationAction;

use App\Containers\AppSection\Booking\Actions\DeleteBookingmasterAction;
use App\Containers\AppSection\Booking\Actions\FindBookingmasterByIdAction;
use App\Containers\AppSection\Booking\Actions\FindBookingmasterByHotelIdAction;
use App\Containers\AppSection\Booking\Actions\RoomStatusMonthlyAction;
use App\Containers\AppSection\Booking\Actions\RoomStatusMonthlyNewAction;
use App\Containers\AppSection\Booking\Actions\RoomsByRoomTypeForBookAction;
use App\Containers\AppSection\Booking\Actions\FindBookingmasterByHotelIdWithFilterAction;
use App\Containers\AppSection\Booking\Actions\GetAllBookingmastersAction;
use App\Containers\AppSection\Booking\Actions\GetAllBookingmasterswithpaginationAction;
use App\Containers\AppSection\Booking\Actions\UpdateBookingmasterAction;
use App\Containers\AppSection\Booking\UI\API\Requests\CreateBookingmasterRequest;
use App\Containers\AppSection\Booking\UI\API\Requests\BookingNewConfirmationRequest;
use App\Containers\AppSection\Booking\UI\API\Requests\DeleteBookingmasterRequest;
use App\Containers\AppSection\Booking\UI\API\Requests\FindBookingmasterByIdRequest;
use App\Containers\AppSection\Booking\UI\API\Requests\FindBookingmasterByHotelIdRequest;
use App\Containers\AppSection\Booking\UI\API\Requests\RoomStatusMonthlyRequest;
use App\Containers\AppSection\Booking\UI\API\Requests\RoomStatusMonthlyNewRequest;
use App\Containers\AppSection\Booking\UI\API\Requests\RoomsByRoomTypeForBookRequest;
use App\Containers\AppSection\Booking\UI\API\Requests\FindBookingmasterByHotelIdWithFilterRequest;
use App\Containers\AppSection\Booking\UI\API\Requests\GetAllBookingmastersRequest;
use App\Containers\AppSection\Booking\UI\API\Requests\UpdateBookingmasterRequest;
use App\Containers\AppSection\Booking\UI\API\Transformers\BookingTransformer;

use App\Containers\AppSection\Booking\Entities\Booking;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createBookingmaster(CreateBookingmasterRequest $request)
    {
        $Bookingmaster = app(CreateBookingmasterAction::class)->run($request);
        return $Bookingmaster;
    }
    public function bookingConfirmation(BookingConfirmationRequest $request)
    {
        $Bookingmaster = app(BookingConfirmationAction::class)->run($request);
        return $Bookingmaster;
    }

    
    public function bookingNewConfirmation(BookingNewConfirmationRequest $request)
    {
        $Bookingmaster = app(BookingNewConfirmationAction::class)->run($request);
        return $Bookingmaster;
    }

    public function findBookingmasterById(FindBookingmasterByIdRequest $request)
    {
        $Bookingmaster = app(FindBookingmasterByIdAction::class)->run($request);
        return $Bookingmaster;
    }
    public function findBookingmasterByHotelId(FindBookingmasterByHotelIdRequest $request)
    {
        $Bookingmaster = app(FindBookingmasterByHotelIdAction::class)->run($request);
        return $Bookingmaster;
    }
    public function roomStatusMonthly(RoomStatusMonthlyRequest $request)
    {
        $Bookingmaster = app(RoomStatusMonthlyAction::class)->run($request);
        return $Bookingmaster;
    }

    public function roomStatusMonthlyNewNishit(RoomStatusMonthlyNewNishitRequest $request)
    {
        $Bookingmaster = app(RoomStatusMonthlyNewAction::class)->run($request);
        return $Bookingmaster;
    } 
    public function roomStatusMonthlyNew(RoomStatusMonthlyNewRequest $request)
    {
        $Bookingmaster = app(RoomStatusMonthlyNewAction::class)->run($request);
        return $Bookingmaster;
    }
    public function roomsByRoomtypeForBook(RoomsByRoomTypeForBookRequest $request)
    {
        $Bookingmaster = app(RoomsByRoomTypeForBookAction::class)->run($request);
        return $Bookingmaster;
    }

    public function findBookingmasterByHotelIdWithFilter(FindBookingmasterByHotelIdWithFilterRequest $request)
    {
        $Bookingmaster = app(FindBookingmasterByHotelIdWithFilterAction::class)->run($request);
        return $Bookingmaster;
    }

    public function getAllBookingmasters(GetAllBookingmastersRequest $request)
    {
        $Bookingmasters = app(GetAllBookingmastersAction::class)->run($request);
        return $Bookingmasters;
    }

    public function getAllBookingmasterswithpagination(GetAllBookingmastersRequest $request)
    {
        $Bookingmasters = app(GetAllBookingmasterswithpaginationAction::class)->run($request);
        return $Bookingmasters;
    }

    public function updateBookingmaster(UpdateBookingmasterRequest $request)
    {
        $Bookingmaster = app(UpdateBookingmasterAction::class)->run($request);
        return $Bookingmaster;
    }



    public function deleteBookingmaster(DeleteBookingmasterRequest $request)
    {
        $Bookingmaster = app(DeleteBookingmasterAction::class)->run($request);
        return $Bookingmaster;
    }
}
