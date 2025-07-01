<?php

namespace App\Containers\Vendor\Localization\Values;

use App\Ship\Parents\Values\Value;
use Locale;

class Region extends Value
{
    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected string $resourceKey = 'regions';
    private $region = null;

    public function __construct($region)
    {
        $this->region = $region;
    }

    public function getDefaultName(): string
    {
        return Locale::getDisplayRegion($this->region, config('app.locale'));
    }

    public function getLocaleName(): string
    {
        return Locale::getDisplayRegion($this->region, $this->region);
    }

    public function getRegion()
    {
        return $this->region;
    }
}
