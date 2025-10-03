@props(['messages'])

@if ($messages)
    @foreach ((array) $messages as $message)
        <div {{ $attributes->merge(['class' => 'mt-2 text-sm text-red-600']) }}>
            {{ $message }}
        </div>
    @endforeach
@endif
