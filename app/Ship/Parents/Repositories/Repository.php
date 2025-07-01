<?php

namespace App\Ship\Parents\Repositories;

use Apiato\Core\Abstracts\Repositories\Repository as AbstractRepository;
use App\Ship\Parents\Absoluteweb\AbsolutewebRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

//abstract class Repository extends AbstractRepository
abstract class Repository extends AbsolutewebRepository
{
    // use CacheableRepository;
    // // Setting the lifetime of the cache to a repository specifically
    // protected $cacheMinutes = 90;
    //
    // protected $cacheOnly = ['all'];
    // //or
    // protected $cacheExcept = ['all'];

    public function boot()
    {
        parent::boot();
    }

}
