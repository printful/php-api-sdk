<?php

namespace Printful;

use Printful\Structures\CountryItem;
use Printful\Structures\StateItem;
use Printful\Structures\TaxRateItem;

class PrintfulCountries
{
    /**
     * @var PrintfulApiClient
     */
    private $printfulClient;

    /**
     * @param PrintfulApiClient $printfulClient
     */
    public function __construct(PrintfulApiClient $printfulClient)
    {
        $this->printfulClient = $printfulClient;
    }

    /**
     * Retrieve country list (with states)
     * @return CountryItem[]
     */
    public function getCountries()
    {
        $raw = $this->printfulClient->get('countries');
        $re = [];

        foreach ($raw as $v) {
            $country = CountryItem::fromArray($v);
            foreach ($v['states'] as $v1) {
                $country->states[] = StateItem::fromArray($v1);
            }
            $re[] = $country;
        }

        return $re;
    }
}
