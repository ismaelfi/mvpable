<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($subscribed)
                        <p>You are currently subscribed to the {{ $plan }} plan.</p>
                        <a href="{{ route('billing-portal') }}" class="btn btn-primary">Manage Subscription</a>
                    @else
                        <p>You are not currently subscribed to any plan.</p>
                        <a href="{{ route('subscribe') }}" class="btn btn-primary">Subscribe Now</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
