<x-app-layout>
    <div class="text-sm breadcrumbs">
    <ul>
        <li><a href="{{route('dashboard')}}">{{ __('Dashboard') }}</a></li>
        <li><a>{{ __('Subscription Plans') }}</a></li>
    </ul>
    </div>

    <div class="py-12">
        <div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($plans as $plan)
                    <div class="w-full shadow-xl card bg-base-100">
                        <div class="card-body">
                            <h3 id="tier-{{ $plan->id }}" class="text-2xl font-bold card-title text-base-content">{{ $plan->name }}</h3>
                            <p class="text-5xl font-bold tracking-tight text-base-content">${{ $plan->price }}<span class="text-base">/month</span></p>
                            <p class="mt-4 text-base leading-7 text-base-content">{{ $plan->description }}</p>
                            @if (is_array($plan->features) && count($plan->features) > 0)
                                <ul class="mt-4 space-y-3 text-sm leading-6 text-base-content">
                                    @foreach ($plan->features as $feature)
                                        @if (isset($feature['feature_name']))
                                            <li class="flex gap-x-3">
                                                <svg class="flex-none w-5 h-6 text-primary" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $feature['feature_name'] }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                            <div class="justify-end mt-6 card-actions">
                                <form action="{{ route('checkout') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="plan" value="{{ $plan->id }}">
                                    <button type="submit" class="btn btn-primary">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
