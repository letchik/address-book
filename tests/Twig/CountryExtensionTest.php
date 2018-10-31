<?php
/**
 * Created by PhpStorm.
 * User: letchik
 * Date: 30/10/18
 * Time: 00:20
 */

namespace AppBundle\Tests\Twig;


use AppBundle\Twig\CountryExtension;
use PHPUnit\Framework\TestCase;

class CountryExtensionTest extends TestCase
{
    public function countryMappingWithLocale()
    {
        return [
            ['DE', 'en_US', 'Germany'],
            ['US', 'de_DE', 'Vereinigte Staaten'],
            ['TH', 'ru_RU', 'Таиланд'],
        ];
    }

    /**
     * @dataProvider countryMappingWithLocale
     */
    public function testGetCountryCode($code, $locale, $expected)
    {
        $extension = new CountryExtension();
        $this->assertEquals($expected, $extension->getCountryByCode($code, $locale)); ;
    }

    public function countryMappingWithoutLocale()
    {
        return [
            ['DE', 'Germany'],
            ['US', 'United States'],
            ['TH', 'Thailand'],
        ];
    }
    /**
     * @dataProvider countryMappingWithoutLocale
     */
    public function testGetCountryCodeWithoutLocale($code, $expected)
    {
        $extension = new CountryExtension();
        $this->assertEquals($expected, $extension->getCountryByCode($code)); ;
    }

    public function testFilterOptions()
    {
        $extension = new CountryExtension();
        $filters = $extension->getFilters();
        $this->assertCount(1, $filters);
        /**
         * @var \Twig_SimpleFilter $filter
         */
        $filter = array_pop($filters);
        $this->assertInstanceOf(\Twig_SimpleFilter::class, $filter);
        $this->assertTrue(is_callable($filter->getCallable()));
        $this->assertEquals('country', $filter->getName());
    }
}
