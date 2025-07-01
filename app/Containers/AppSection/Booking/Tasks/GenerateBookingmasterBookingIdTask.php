<?php

namespace App\Containers\AppSection\Booking\Tasks;

use App\Containers\AppSection\Booking\Data\Repositories\BookingRepository;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Apiato\Core\Traits\HashIdTrait;
use Carbon\Carbon;

class GenerateBookingmasterBookingIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run()
    {
        $datePart = Carbon::now()->format('Ymd'); // e.g., 20250101
        $randomPart = str_pad(random_int(1, 999), 3, '0', STR_PAD_LEFT); // Random 3-digit number
        return 'RS' . $datePart . '-CUST' . $randomPart; // e.g., B20250101-CUST001
    }
}
