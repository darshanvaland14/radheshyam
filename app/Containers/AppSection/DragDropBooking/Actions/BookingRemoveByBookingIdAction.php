<?php

namespace App\Containers\AppSection\DragDropBooking\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\DragDropBooking\Models\DragDropBooking;
use App\Containers\AppSection\DragDropBooking\Tasks\BookingRemoveByBookingIdTask;
use App\Containers\AppSection\DragDropBooking\UI\API\Requests\BookingRemoveByBookingIdRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class BookingRemoveByBookingIdAction extends ParentAction
{
    public function run(BookingRemoveByBookingIdRequest $request)
    {   
       return app(BookingRemoveByBookingIdTask::class)->run($request->id);
    }
}
