<?php

namespace App\Containers\AppSection\Laundry\Tasks;

use App\Containers\AppSection\Laundry\Data\Repositories\LaundryRepository;
use App\Containers\AppSection\Laundry\Models\LaundryMaster;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\AppSection\Laundry\Models\LaundryOrder;
use App\Containers\AppSection\Laundry\Models\LaundryOrderChild;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class UpdateLaundryStatusByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected LaundryRepository $repository
    ) {
    }

    public function run($id)
    {
       
            // return $this->decode($id);
            $childs = LaundryOrderChild::find($this->decode($id));
            // return $childs;
            $childs->status = 'Delivered';
            $childs->save();
            return [
                'result' => true,
                'message' => 'Delivered items successfully.', 
            ];
    }
}
