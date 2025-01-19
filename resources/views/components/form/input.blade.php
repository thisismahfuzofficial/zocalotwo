@props([
    'label' => '',
    'value' => old($name),
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'options' => [],
    'id' => '',
    'checked' => false,
    'exclude' => '',
    'show_empty_options' => false,
    'className' => '',
])

@php
    $classes = 'form-control';
    if (in_array($type, ['checkbox', 'radio'])) {
        $classes .= '-input';
    }
    if (in_array($type, ['select'])) {
        $classes = 'form-select form-select-lg';
    }

    $classes .= ' ' . $className;
@endphp

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    @if ($type === 'textarea')
        <textarea class="{{ $classes }} @error($name) is-invalid @enderror" id="{{ $id }}"
            name="{{ $name }}" placeholder="{{ $placeholder }}" {{ $attributes }}>{!! $value !!}</textarea>
    @elseif ($type === 'select')
        <select style="font-size: 12px"
            class="{{ $classes }} @error($name) is-invalid @enderror"id="{{ $id }}"
            name="{{ $name }}" {{ $attributes }}>
            @if ($show_empty_options)
                <option value=""> Choose {{ $label }} </option>
            @endif
            @foreach ($options as $optionValue => $optionLabel)
                @if ($exclude != $optionValue)
                    <option value="{{ $optionValue }}" @if ($value == $optionValue) selected @endif>
                        {{ $optionLabel }} </option>
                @endif
            @endforeach
        </select>
    @else
        <input type="{{ $type }}" class="{{ $classes }}  @error($name) is-invalid @enderror"
            id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
            placeholder="{{ $placeholder }}" {{ $attributes }} @if ($checked) checked @endif step="any">
    @endif
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
