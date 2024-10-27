<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('News-Article Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's favorite news category and view all your favorited articles.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="favorite_category" :value="__('Favorite Category')" />
            <select id="favorite_category" name="favorite_category" class="mt-1 block w-full" required autofocus style="background-color: #181c24; color: #fff;">
                <option value="business" @if(old('favorite_category', $user->favorite_category) == 'business') selected @endif>Business</option>
                <option value="entertainment" @if(old('favorite_category', $user->favorite_category) == 'entertainment') selected @endif>Entertainment</option>
                <option value="general" @if(old('favorite_category', $user->favorite_category) == 'general') selected @endif>General</option>
                <option value="health" @if(old('favorite_category', $user->favorite_category) == 'health') selected @endif>Health</option>
                <option value="science" @if(old('favorite_category', $user->favorite_category) == 'science') selected @endif>Science</option>
                <option value="sports" @if(old('favorite_category', $user->favorite_category) == 'sports') selected @endif>Sports</option>
                <option value="technology" @if(old('favorite_category', $user->favorite_category) == 'technology') selected @endif>Technology</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('favorite_category')" />
        </div>



        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
