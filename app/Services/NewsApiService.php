<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use App\Services\HelperServices\CountryMapper;

class NewsApiService
{
    /**
     * Get news articles from the News API.
     *
     * @param string $endpoint The API endpoint (e.g., 'everything', 'top-headlines').
     * @param array $options Additional options for the API request.
     * @return array The JSON response from the API.
     * @throws \Exception If an error occurs during the API request.
     */
    public static function getNewsArticles($endpoint, $options = [])
    {
        // Transfor country/language into a code for api to read (ex. Argentina => ar, Germany => de, German => de)
        $countryMapper = new CountryMapper();
        if(isset($options['Country'])) // Convert country name to code
            $options['Country'] = $countryMapper->getCountryCode($options['Country']);

        if(isset($options['Language'])) // Convert language name to code
            $options['Language'] = $countryMapper->getLanguageCode($options['Language']);
        
        // Rename 'Keywords' to 'q'
        if (isset($options['Keywords'])) { 
            $options['q'] = $options['Keywords'];
            unset($options['Keywords']);
        }

        // Default API key for authentication
        $defaultOptions = ['apiKey' => 'f022e9e669464bb7b1ab7b4f444fe98c'];

        // Merge default options with user-provided options
        $options = array_merge($defaultOptions, $options);

        // Build the API request URL with the provided endpoint and options
        $url = 'https://newsapi.org/v2/' . $endpoint . '?' . http_build_query($options);

        try {
            // Make the API request using Laravel's HTTP client
            $response = Http::get($url);
            // Check if the response has an error code
            if ($response->failed()) {
                // Extract error information from the response JSON
                $errorData = $response->json();

                // Throw an exception with error details
                throw new \Exception("News API Error: {$errorData['code']} - {$errorData['message']}");
            }

            // Return the JSON response from the API
            return $response->json();
        } catch (\Exception $exception) {
            // Catch any exceptions that might occur during the API request
            throw new \Exception("Failed to fetch news articles: {$exception->getMessage()}", $exception->getCode());
        }
    }
}