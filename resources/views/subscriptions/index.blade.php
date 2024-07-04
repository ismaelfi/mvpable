<x-app-layout>
    <div class="breadcrumbs text-sm">
    <ul>
        <li><a href="{{route('dashboard')}}">{{ __('Dashboard') }}</a></li>
        <li><a>{{ __('Subscription Plans') }}</a></li>
    </ul>
    </div>

    <div class="py-12">
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($plans as $plan)
                    <div class="card bg-base-100 w-full shadow-xl">
                        <div class="card-body">
                            <h3 id="tier-{{ $plan->id }}" class="card-title text-2xl font-bold text-indigo-400">{{ $plan->name }}</h3>
                            <p class="text-5xl font-bold tracking-tight text-gray-900">${{ $plan->price }}<span class="text-base text-gray-700">/month</span></p>
                            <p class="mt-4 text-base leading-7 text-gray-800">{{ $plan->description }}</p>
                            @if (is_array($plan->features) && count($plan->features) > 0)
                                <ul class="mt-4 space-y-3 text-sm leading-6 text-gray-700">
                                    @foreach ($plan->features as $feature)
                                        @if (isset($feature['feature_name']))
                                            <li class="flex gap-x-3">
                                                <svg class="h-6 w-5 flex-none text-indigo-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $feature['feature_name'] }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                            <div class="card-actions justify-end mt-6">
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
