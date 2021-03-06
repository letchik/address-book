<?php

namespace AppBundle\Twig;

use Symfony\Component\Intl\Intl;


class CountryExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('country', [$this, 'getCountryByCode']),
        ];
    }

    public function getCountryByCode($countryCode, $locale = "en")
    {
        return Intl::getRegionBundle()->getCountryName($countryCode, $locale);
    }

    public function getName()
    {
        return 'country_extension';
    }
}
