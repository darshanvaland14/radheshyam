<?php

namespace App\Containers\AppSection\Booking\Tasks;

use App\Containers\AppSection\Booking\Data\Repositories\BookingRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\Bookingroom;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Booking\Models\BookingFrom;

class DeleteBookingFromTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($id)
    {
        
        $data = BookingFrom::find($id);
        $data->delete();
        $returnData = [
            'result' => true,
            'message' => 'Data Deleted successfully',
            'object' => 'Bookings',
            'data' => [],
        ];
        return $returnData;
    }
}
