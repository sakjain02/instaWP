<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-emerald-400 text-white p-4 my-5">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-rose-400 text-white p-4 my-5">{{ session('error') }}</div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('add-money') }}">
                        @csrf
                        <label for="">Amount</label>
                        <div class="flex items-center">
                            <x-text-input id="amount" class="flex-grow p-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-none" type="text" name="amount" :value="old('amount')" required autofocus></x-text-input>
                            <button class="p-2.5 bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-none">Add</button>
                        </div>
                        <small class="text-gray-400">Minimum $3 and Maximum $100 can be added to the wallet at a time.</small>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </form> 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>