<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cookies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-emerald-400 text-white p-4 my-5">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-rose-400 text-white p-4 my-5">{{ session('error') }}</div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('buy-cookie') }}">
                        @csrf
                        <div class="grid grid-rows-3 gap-4 items-center" x-data="{ quantity: 1, price: 1 }">
                            <div class="">
                                <h4 for="">Cookie Price: ${{ $cookie_price }}</h4>
                            </div>
                            <div>
                                <label for="">Quanity: </label>
                                <input type="number" name="quantity" x-model="quantity" x-bind:min="1" @input="calculateTotal">
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                            <div>
                                <p>Total Amount: $<span x-text="quantity * price"></span></p>
                            </div>
                            <div>
                                <button class="p-2.5 bg-blue-500 text-white rounded-none hover:bg-blue-600 focus:outline-none focus:ring-2.5 focus:ring-blue-500 focus:ring-opacity-50">Buy</button>
                            </div>
                        </div>
                    </form> 
                    
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function calculateTotal() {
        return {
            quantity: 1,
            price: 1,
            calculateTotal() {
                return this.quantity * this.price;
            }
        };
    }
</script>