<?php

namespace App\Containers\AppSection\Laundry\Tasks;

use App\Containers\AppSection\Laundry\Data\Repositories\LaundryRepository;
use App\Containers\AppSection\Laundry\Models\LaundryMaster;
use App\Containers\AppSection\Laundry\Models\LaundryOrder;

use App\Containers\AppSection\Laundry\Models\LaundryOrderChild;
use App\Containers\AppSection\Laundry\Models\LaundryMasterChild;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class DeleteLaundryOrderMasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected LaundryRepository $repository
    ) {
    }

    
    // for single laundry
    public function run($id)
    {
       
        $master = LaundryOrder::find($this->decode($id))->delete();
        LaundryOrderChild::where('laundry_order_id', $this->decode($id))->delete();
        return [
            'result' => true,
            'message' => 'Laundry Item deleted successfully',
            'object' => 'Laundry Master',
        ];
       
    }
}
