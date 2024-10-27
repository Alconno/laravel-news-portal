<?php
namespace App\Services\HelperServices;
use Illuminate\Support\Facades\Http;

class CountryMapper {
    // Array mapping country names to country codes
    private $countryCodes;

    // Array mapping language names to language codes
    private $languageCodes;

    // Constructor to initialize country and language code arrays
    public function __construct() {
        // Mapping of country names to country codes
        $this->countryCodes = [
            'Argentina' => 'ar',
            'Germany' => 'de',
            'English' => 'en',
            'Spain' => 'es',
            'France' => 'fr',
            'Hebrew' => 'he',
            'Italy' => 'it',
            'Netherlands' => 'nl',
            'Norway' => 'no',
            'Portugal' => 'pt',
            'Russia' => 'ru',
            'Sweden' => 'sv',
            'Ukraine' => 'ua',
            'Algeria' => 'dz',
            'China (Mandarin)' => 'zh',
        ];

        // Mapping of language names to language codes
        $this->languageCodes = [
            'English' => 'en',
            'Spanish' => 'es',
            'French' => 'fr',
            'German' => 'de',
            'Italian' => 'it',
            'Hebrew' => 'he',
            'Dutch' => 'nl',
            'Norwegian' => 'no',
            'Portuguese' => 'pt',
            'Russian' => 'ru',
            'Swedish' => 'sv',
            'Chinese' => 'zh',
        ];
    }

    // Get country name from country code
    public function getCountryName($code) {
        return array_search($code, $this->countryCodes) ?? 'Unknown';
    }

    // Get country code from country name
    public function getCountryCode($name) {
        return $this->countryCodes[$name] ?? 'Unknown';
    }

    // Get language name from language code
    public function getLanguageName($code) {
        return array_search($code, $this->languageCodes) ?? 'Unknown';
    }

    // Get language code from language name
    public function getLanguageCode($name) {
        return $this->languageCodes[$name] ?? 'Unknown';
    }
}