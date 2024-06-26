<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subscription Plans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach ($plans as $plan)
                        <div class="mb-4">
                            <h3 class="text-xl font-bold">{{ $plan->name }}</h3>
                            <p>{{ $plan->description }}</p>
                            <p>Price: ${{ number_format($plan->price / 100, 2) }}</p>
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan" value="{{ $plan->id }}">
                                <button type="submit" class="btn btn-primary">Subscribe</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
