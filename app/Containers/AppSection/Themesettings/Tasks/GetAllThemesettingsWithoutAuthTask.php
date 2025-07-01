<?php

namespace App\Containers\AppSection\Themesettings\Tasks;

use App\Containers\AppSection\Themesettings\Data\Repositories\ThemesettingsRepository;
use App\Ship\Parents\Tasks\Task;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use Apiato\Core\Traits\HashIdTrait;

class GetAllThemesettingsWithoutAuthTask extends Task
{
    use HashIdTrait;
    protected ThemesettingsRepository $repository;

    public function __construct(ThemesettingsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        $returnData['data']=array();
        $theme_setting = Themesettings::where('id',1)->first();
        $getThemesettingsData = Themesettings::first();

        if(!empty($getThemesettingsData)){
            $returnData['data'][0]['object'] = "Themesettings";
            $returnData['data'][0]['id'] = $this->encode($getThemesettingsData->id);
            $returnData['data'][0]['name'] = $getThemesettingsData->name;
            if(empty($getThemesettingsData->logo)){
              $returnData['data'][0]['logo'] = $theme_setting->api_url."public/img/logo.png";
            }else{
              $returnData['data'][0]['logo'] = $theme_setting->api_url.$getThemesettingsData->logo;
            }
            if(empty($getThemesettingsData->favicon)){
              $returnData['data'][0]['favicon'] = $theme_setting->api_url."public/img/logo.png";
            }else{
              $returnData['data'][0]['favicon'] = $theme_setting->api_url.$getThemesettingsData->favicon;
            }
            $returnData['data'][0]['description'] = $getThemesettingsData->description;
            $returnData['data'][0]['mobile'] = $getThemesettingsData->mobile;
            $returnData['data'][0]['email'] = $getThemesettingsData->email;
            $returnData['data'][0]['address'] = $getThemesettingsData->address;
        }
        return $returnData;
    }
}
