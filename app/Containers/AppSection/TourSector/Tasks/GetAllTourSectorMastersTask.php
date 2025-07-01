<?php

namespace App\Containers\AppSection\TourSector\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourSector\Data\Repositories\TourSectorRepository;
use App\Containers\AppSection\TourSector\Models\TourSector;
use App\Containers\AppSection\TourPackagesMaster\Models\TourPackagesMaster;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Themesettings\Models\Themesettings;

class GetAllTourSectorMastersTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourSectorRepository $repository
    ) {
    }

    public function run()
    {
        try{
            $getData = TourSector::orderBy('id', 'desc')->get();
            $theme_setting = Themesettings::where('id', 1)->first();
            // return $theme_setting->api_url;

            $Data = []; // initialize a clean array

            foreach ($getData as $value) {
                $tour_packages = TourPackagesMaster::where('tour_sector', $value['id'])->count();

                // if ($tour_packages > 0) {
                    $tour_packages_images = TourPackagesMaster::where('tour_sector', $value['id'])->first();

                    $Data[] = [
                        'tour_sector_id' => $this->encode($value['id']),
                        'name'           => $value['name'],
                        'thumbnailImage' => $tour_packages_images 
                            ? $theme_setting->api_url . $tour_packages_images->thumbnailImage 
                            : '',
                        'tour_packages'  => $tour_packages,
                    ];
                // }
            }


            $returnData = [
                'result' => true,
                'message' => 'Data found',
                'object' => 'TourSector',
                'data' => $Data
                ];
            return $returnData;
        }catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'TourSectors',
                'data' => [],
            ];
        }
    }
}
