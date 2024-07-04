<div>
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>{{ __('Dashboard') }}</a></li>
        </ul>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    @if($subscribed)
                        <p class="my-4">You are currently subscribed to the {{ $plan }} plan.</p>
                        <a href="{{ route('billing-portal') }}" class="btn btn-primary">Manage Subscription</a>
                    @else
                        <p class="my-4">You are not currently subscribed to any plan.</p>
                        <a href="{{ route('subscribe') }}" class="btn btn-primary">Subscribe Now</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
