<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Create Sales Data') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Input your sales data") }}
        </p>
    </header>

    <form method="post" action="{{ route('sales.store') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')
        <div>
            <x-input-label for="transaction_date" :value="__('Transaction date')" />
            <x-text-input id="transaction_date" name="transaction_date" type="date" class="mt-1 block w-full" required autofocus autocomplete="transaction_date" />
            <x-input-error class="mt-2" :messages="$errors->get('transaction_date')" />
        </div>

        <div>
            <x-input-label for="type" :value="__('Type')" />
            <div class="mt-1 block w-full">
                <select class="mt-1 block w-full" id="type" name="type" required autofocus>
                    <option value="goods">Barang</option>        
                    <option value="services">Jasa</option>        
                </select>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('type')" />
        </div>

        <div>
            <x-input-label for="nominal" :value="__('Nominal')" />
            <x-text-input id="nominal" name="nominal" type="number" class="mt-1 block w-full" required autofocus autocomplete="nominal" />
            <x-input-error class="mt-2" :messages="$errors->get('nominal')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'data-created')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Sales data is created.') }}</p>
            @endif
        </div>
    </form>
</section>