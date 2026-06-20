<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Candidate Analysis') }}
            </h2>
            <a href="{{ route('offers.show', $offer) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Back to Offer') }}
            </a>
        </div>
    </x-slot>

    <meta http-equiv="refresh" content="5">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="animate-pulse">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Analysis in progress…') }}</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Candidate:') }} {{ $candidate->name }}</p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Job Offer:') }} {{ $offer->title }}</p>
                        <p class="mt-4 text-xs text-gray-400 dark:text-gray-500">{{ __('This page will refresh automatically every 5 seconds.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
