<?php

namespace Printful;

use Printful\Structures\CountryItem;
use Printful\Structures\StateItem;
use Printful\Structures\TaxRateItem;

class PrintfulTaxRates
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
     * Get tax rate for given address
     * @param string $countryCode ISO country code
     * @param string $stateCode
     * @param string $city
     * @param string $zipCode
     * @return TaxRateItem
     */
    public function getTaxRate($countryCode, $stateCode, $city, $zipCode)
    {
        $recipient = [
            'country_code' => $countryCode,
            'state_code' => $stateCode,
            'city' => $city,
            'zip' => (string)$zipCode,
        ];

        $requestData = ['recipient' => $recipient];
        $raw = $this->printfulClient->post('tax/rates', $requestData);

        return TaxRateItem::fromArray($raw);
    }

    /**
     * Retrieve country list (with states) that requires sales tax calculation
     * @return CountryItem[]
     */
    public function getTaxCountries()
    {
        $raw = $this->printfulClient->get('tax/countries');
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
