<?php

namespace App\Containers\AppSection\DragDropBooking\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\DragDropBooking\Actions\DragBookingConfirmAction;
use App\Containers\AppSection\DragDropBooking\Actions\BookingRemoveByBookingIdAction;

use App\Containers\AppSection\DragDropBooking\UI\API\Requests\DragBookingConfirmRequest;
use App\Containers\AppSection\DragDropBooking\UI\API\Requests\BookingRemoveByBookingIdRequest;


use App\Containers\AppSection\DragDropBooking\Entities\DragDropBooking;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function DragBookingConfirm(DragBookingConfirmRequest $request)
    {
        $DragDropBookingmaster = app(DragBookingConfirmAction::class)->run($request);
        return $DragDropBookingmaster;
    }

    public function BookingRemoveByBookingId(BookingRemoveByBookingIdRequest $request)
    {
        $DragDropBookingmaster = app(BookingRemoveByBookingIdAction::class)->run($request);
        return $DragDropBookingmaster;
    }

    
}
