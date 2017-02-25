<?php

use Printful\PrintfulTaxRates;
use Printful\Structures\CountryItem;
use Printful\Structures\TaxRateItem;
use Printful\Tests\TestCase;

class TaxRatesTest extends TestCase
{
    /**
     * @param array $recipient
     * @param bool $isTaxRequired - Expected result
     * @dataProvider addressDataProvider
     */
    public function testTaxRatesCalculation(array $recipient, $isTaxRequired)
    {
        $rates = new PrintfulTaxRates($this->api);
        $countryCode = $recipient['country_code'];
        $stateCode = $recipient['state_code'];
        $city = $recipient['city'];
        $zipCode = $recipient['zip'];

        $taxRate = $rates->getTaxRate($countryCode, $stateCode, $city, $zipCode);
        self::assertInstanceOf(TaxRateItem::class, $taxRate);
        self::assertEquals($isTaxRequired, $taxRate->required);
    }

    public function testTaxableCountriesListRetrieved()
    {
        $rates = new PrintfulTaxRates($this->api);

        $taxableCountriesList = $rates->getTaxCountries();
        self::assertInstanceOf(CountryItem::class, reset($taxableCountriesList));
    }

    /**
     * Valid address data
     * First two addresses require tax calculation
     * @return array
     */
    public function addressDataProvider()
    {
        return [
            [
                [
                    'country_code' => 'US',
                    'state_code' => 'CA',
                    'city' => 'California',
                    'zip' => '91311',
                ],
                true,
            ],
            [
                [
                    'country_code' => 'US',
                    'state_code' => 'NC',
                    'city' => 'Charlotte',
                    'zip' => '28273',
                ],
                true,
            ],
            [
                [
                    'country_code' => 'CA',
                    'state_code' => 'ON',
                    'city' => 'Ottawa',
                    'zip' => 'K1A 0G9',
                ],
                false,
            ],
        ];
    }
}
