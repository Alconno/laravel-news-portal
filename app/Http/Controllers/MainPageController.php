<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NewsApiService;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UserFavoritesUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Models\User;

class MainPageController extends Controller
{
    public function index(){
        return view('main-page');
    }

    public function handleRequest(Request $request)
    {
        // Access the 'data' key from the input
        $data = $request->input('data');

        // Remove null values from the 'data' array
        $filteredData = array_filter($data, function ($value) {
            return $value !== null;
        });

        error_log('API Response Data: ' . json_encode($filteredData, JSON_PRETTY_PRINT));

        try {
            $options = array_diff_key($filteredData, ['endpoint' => true]);
            $response = NewsApiService::getNewsArticles($filteredData['endpoint'], $options);
    
            // Return only the articles data
            return $response['articles'];
    
        } catch (\Exception $exception) {
            // Handle exceptions (log, display an error, etc.)
            error_log($exception);   
        }
    }
}
