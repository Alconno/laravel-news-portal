<!DOCTYPE html>
@if (Route::has('login'))
    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
        @auth
            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            @endif
        @endauth
    </div>
@endif 
@vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])

            
<div class="relative sm:flex sm:justify-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    <div class="w-1/5 bg-gray-900 p-6" id="search-panel">
        <label for="endpointDropdown" class="block font-medium text-sm text-gray-700 mb-2 text-white">
            {{ __('Select Endpoint:') }}
        </label>
        <select id="endpointDropdown" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300 transition duration-150 ease-in-out bg-gray-800 text-white">
            <option value="everything">Everything</option>
            <option value="topheadlines">Top Headlines</option>
            <option value="sources">Sources</option>
        </select>

        <div id="paramDropdownsContainer" class="mt-4"></div>
    </div>

    <div class="flex-1 p-6">
        <form id="searchForm" action="/" method="POST">
            @csrf
            <button id="searchButton" class="p-2 border border-gray-300 rounded-md bg-gray-800 text-white" type="button" onclick="toggleSearchPanel()">Settings</button>
            <button id="searchButton" class="p-2 border border-gray-300 rounded-md bg-gray-800 text-white" type="submit">Search</button>
    
        </form>
    



        @extends('layouts.layout')

        @section('title')
        <title>Forge task</title>
        @endsection

        
        @section('content')
         <div class="mt-16">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 lg:gap-8">
                @auth
                    @if (auth()->user()->role === 'Admin')
                        <a href="/admin/view_users" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">View Users</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    View, search, edit, update, delete all users on the website (Admin only)
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>
                    @endif
                @endauth
            </div>
        </div>
        </div>
    </div>
</div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#searchForm').submit(function (event) {
            // Prevent the default form submission
            event.preventDefault();

            // Collect form data
            var formData = {};
            $('#paramDropdownsContainer :input').each(function () {
                formData[this.id] = $(this).val();
            });

            // Add additional form data if needed
            formData['endpoint'] = $('#endpointDropdown').val();

            // Perform an AJAX request
            $.ajax({
                type: 'POST', // or 'GET' depending on your route definition
                url: '/',
                data: {
                    _token: '{{ csrf_token() }}',
                    data: formData,
                },
                success: function (response) {
                    //console.log(response); // Log the entire response
                    
                    if (Array.isArray(response) && response.length > 0) {
                        // Take the first 100 articles
                        var articles = response.slice(0, 100);
                        var articlesHtml = articles.map(function (article) {
                            return `
                                <a href="/${article.title}" id="article-container" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500" style="background-image: url('${article.urlToImage}'); background-size: cover; background-position: center; border: 8px solid black; position: relative;">
                                    <div>
                                        <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full invisible opacity-0"></div>
                                        <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full invisible opacity-0"></div>
                                        <div class="title-container">
                                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">${article.title}</h2>
                                            <h2 class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">${article.description}</h2>
                                        </div>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                                    </svg>
                                </a>
                            `;
                        }).join('');

                        


                        // Update the articles container with the new HTML content
                        document.querySelector('.grid-cols-1').innerHTML = articlesHtml;

                        // Log a message to confirm that the update is happening
                        console.log('Articles updated successfully');
                    } else {
                        console.error('Error: Response is not an array or is empty');
                    }
                },
                error: function (error) {
                    // Handle errors
                    console.error(error);
                }
            });
        });
        
        function generateDropdowns(endpoint) {
            $('#paramDropdownsContainer').empty();


            // set lang, country, fav category, fav articles
            // pick 
            var params = [];
            switch (endpoint) {
                case 'everything':
                    params = [
                        { name: 'Keywords', type: 'textarea', description: 'Keywords or phrases to search for in the article title and body. Advanced search is supported here: Surround phrases with quotes (") for an exact match...' },
                        { name: 'Sources', type: 'text', description: 'A comma-separated string of identifiers (maximum 20) for the news sources or blogs you want headlines from...' },
                        { name: 'From', type: 'date', description: 'Option to set the start date for the search...' },
                        { name: 'To', type: 'date', description: 'Option to set the end date for the search...' },
                        { name: 'Language', type: 'select', options: ['Arabic', 'German', 'English', 'Spanish', 'French', 'Hebrew', 'Italian', 'Dutch', 'Norwegian', 'Portuguese', 'Russian', 'Swedish', 'Undefined', 'Chinese'], description: 'Select the language of the news sources...' },
                        { name: 'Sort by', type: 'select', options: ['relevancy', 'popularity'], description: '' },
                    ];
                break;
                // Add cases for other endpoints as needed
                case 'topheadlines':
                    params = [
                        { name: 'Keywords', type: 'textarea', description: 'Keywords or phrases to search for in the article title and body...' },
                        { name: 'Sources', type: 'text', description: 'A comma-separated string of identifiers (maximum 20) for the news sources or blogs you want headlines from...' },
                        // Add other parameters as needed
                    ];
                    break;
                case 'sources':
                    params = [
                        { name: 'Category', type: 'text', description: 'The category of the news sources...' },
                        { name: 'Language', type: 'select', options: ['Arabic', 'German', 'English', 'Spanish', 'French', 'Hebrew', 'Italian', 'Dutch', 'Norwegian', 'Portuguese', 'Russian', 'Swedish', 'Undefined', 'Chinese'], description: 'Select the language of the news sources...' },
                        // Add other parameters as needed
                    ];
                    break;
            }

        params.forEach(function (param) {
            var inputHtml = '';
            if (param.type === 'textarea') {
                inputHtml = `<textarea class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300 transition duration-150 ease-in-out bg-gray-800 text-white" id="${param.name}"></textarea>`;
            } else if (param.type === 'date') {
                inputHtml = `<input type="date" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300 transition duration-150 ease-in-out bg-gray-800 text-white" id="${param.name}">`;
            } else if (param.type === 'number') {
                inputHtml = `<input type="number" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300 transition duration-150 ease-in-out bg-gray-800 text-white" id="${param.name}">`;
            } else if (param.type === 'select') {
                inputHtml = `<select class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300 transition duration-150 ease-in-out bg-gray-800 text-white" id="${param.name}">
                                <option value="" selected disabled>Select ${param.name}</option>
                                ${param.options.map(option => `<option value="${option}">${option}</option>`).join('')}
                            </select>`;
            } else {
                inputHtml = `<input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300 transition duration-150 ease-in-out bg-gray-800 text-white" id="${param.name}">`;
            }

            var dropdownHtml = `<div class="mt-4">
                                <label for="${param.name}" class="block font-medium text-sm text-white">${param.name}</label>
                                ${inputHtml}
                                <p class="mt-2 text-gray-500 text-sm">${param.description}</p>
                            </div>`;
            $('#paramDropdownsContainer').append(dropdownHtml);
        });
        }

        $('#endpointDropdown').change(function () {
            var selectedEndpoint = $(this).val();
            generateDropdowns(selectedEndpoint);
        });

        generateDropdowns($('#endpointDropdown').val());
    });


    function toggleSearchPanel() {
        var searchPanel = document.getElementById('search-panel');
        var searchButton = document.getElementById('searchButton');

        if (searchPanel.style.visibility === 'hidden' || searchPanel.style.visibility === '') {
            searchPanel.style.visibility = 'visible';
            searchPanel.style.position = 'relative';
            searchButton.classList.add('glow-effect');
        } else {
            searchPanel.style.visibility = 'hidden';
            searchPanel.style.position = 'absolute';
            searchButton.classList.remove('glow-effect');
        }
    }

</script>

<style>
#article-container{
    box-shadow: 0 0 15px #544cc2;
    transition: box-shadow 0.3s ease;
}

.title-container {
    background-color: rgba(0, 0, 0, 0.7); 
    padding-top: -15px; 
    padding-left: 5px;
    padding-right: 5px;
    border-radius: 8px;
    transition: opacity 0.4s ease;  /* Add transition for a smoother effect */
}

.title-container {
    position:relative;
    bottom: 0;
    left: 0;
}

#search-panel{
    visibility: hidden;
    position:absolute;
}

#searchButton:active{
    background-color: #2c5282;
}

.glow-effect {
    border: 2px solid #3498db;
    box-shadow: 0 0 15px #3498db;
    transition: box-shadow 0.3s ease;
}

</style>