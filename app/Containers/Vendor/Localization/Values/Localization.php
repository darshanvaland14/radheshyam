<?php

namespace App\Containers\Vendor\Localization\Values;

use App\Ship\Parents\Values\Value;
use Locale;

class Localization extends Value
{
    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected string $resourceKey = 'localizations';
    private $language = null;
    private array $regions = [];

    public function __construct($language, array $regions = [])
    {
        $this->language = $language;

        foreach ($regions as $region) {
            $this->regions[] = new Region($region);
        }
    }

    public function getDefaultName(): string
    {
        return Locale::getDisplayLanguage($this->language, config('app.locale'));
    }

    public function getLocaleName(): string
    {
        return Locale::getDisplayLanguage($this->language, $this->language);
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getRegions(): array
    {
        return $this->regions;
    }
}
