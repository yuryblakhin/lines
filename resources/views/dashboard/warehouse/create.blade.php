@extends('layouts.dashboard')

@section('content')
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.warehouse.store', [], false) }}" novalidate>
                    @csrf

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" id="active" class="form-check-input @error('active') is-invalid @enderror" name="active" {{ old('active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Active</label>
                        </div>

                        @error('active')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">{{ __('Code') }}</label>
                        <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="code">

                        @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="currency_id" class="form-label">{{ __('Currency') }}</label>
                        <select id="currency_id" class="form-select @error('currency_id') is-invalid @enderror" name="currency_id" required>
                            @foreach ($currencies as $item)
                                <option value="{{ $item->id }}" {{ old('currency_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} ({{ $item->code }})
                                </option>
                            @endforeach
                        </select>

                        @error('currency_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">{{ __('Address') }}</label>
                        <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" required>{{ old('address') }}</textarea>

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phones" class="form-label">{{ __('Phones') }}</label>
                        <div id="phone-inputs-container">
                            @if (is_array(old('phones')))
                                @foreach (old('phones') as $index => $phone)
                                    <div class="input-group phone-field">
                                        <input type="text" class="form-control @error('phones.*') is-invalid @enderror" name="phones[]" value="{{ $phone }}" required>
                                        @if ($index > 0)
                                            <button class="btn btn-outline-danger remove-phone-button">Remove</button>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group phone-field">
                                    <input type="text" class="form-control @error('phones.*') is-invalid @enderror" name="phones[]" required>
                                </div>
                            @endif
                        </div>

                        <button type="button" id="add-phone-button" class="btn btn-secondary mt-2">Add Phone</button>

                        @error('phones.*')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addPhoneButton = document.getElementById('add-phone-button');
            const phoneInputsContainer = document.getElementById('phone-inputs-container');
            const maxPhones = 10;

            let phoneIndex = 1;

            addPhoneButton.addEventListener('click', function() {
                if (phoneIndex >= maxPhones) {
                    return;
                }

                const phoneField = document.createElement('div');
                phoneField.className = 'input-group phone-field mt-2';

                const input = document.createElement('input');
                input.type = 'text';
                input.className = 'form-control';
                input.name = 'phones[]';
                input.required = true;

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-outline-danger remove-phone-button';
                removeButton.textContent = 'Remove';

                phoneField.appendChild(input);
                phoneField.appendChild(removeButton);
                phoneInputsContainer.appendChild(phoneField);

                phoneIndex++;
            });

            phoneInputsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-phone-button')) {
                    const phoneField = event.target.closest('.phone-field');
                    phoneField.remove();
                    phoneIndex--;
                }
            });
        });
    </script>
@endsection
