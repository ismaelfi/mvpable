@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-primary-content']) }}>
    {{ $value ?? $slot }}
</label>
