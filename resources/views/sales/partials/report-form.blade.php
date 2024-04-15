<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Download Report Sales Data') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Download report sales data from all users") }}
        </p>
    </header>

    <form method="post" action="{{ route('sales.report') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')
        <div>
            <x-input-label for="start_date" :value="__('Start date')" />
            <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" required autofocus autocomplete="start_date" />
            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
        </div>

        <div>
            <x-input-label for="end_date" :value="__('End date')" />
            <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" required autofocus autocomplete="end_date" />
            <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Download xlxs') }}</x-primary-button>

            @if (session('status-download') === 'data-downloaded')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Download was successfully, please check your download folder') }}</p>
            @endif
        </div>
    </form>
</section>