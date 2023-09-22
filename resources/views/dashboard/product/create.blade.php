@extends('layouts.dashboard')

@section('content')
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.product.store', [], false) }}" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

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
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description') }}</textarea>

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">{{ __('Image') }}</label>
                        <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*" required>

                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">{{ __('Images') }}</label>

                        <div id="images-container">
                            <div class="input-group image-field">
                                <input type="file" class="form-control @error('images.*') is-invalid @enderror" name="images[]" accept="image/*" multiple>
                            </div>
                        </div>

                        <button type="button" id="add-image-button" class="btn btn-secondary mt-2">Add Image</button>

                        @error('images.*')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">{{ __('Price') }}</label>
                        <input id="price" type="number" min="0" step="0.01" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required>

                        @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="stock_quantity" class="form-label">{{ __('Stock Quantity') }}</label>
                        <input id="stock_quantity" type="number" min="0" class="form-control @error('stock_quantity') is-invalid @enderror" name="stock_quantity" value="{{ old('stock_quantity') }}" required>

                        @error('stock_quantity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="categories" class="form-label">{{ __('Categories') }}</label>
                        <select id="categories" class="form-control @error('categories') is-invalid @enderror" name="categories[]" multiple required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        @error('categories')
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
            const addImageButton = document.getElementById('add-image-button');
            const imagesContainer = document.getElementById('images-container');
            const maxImages = 10;

            let imageIndex = 2;

            addImageButton.addEventListener('click', function() {
                if (imageIndex >= maxImages) {
                    return;
                }

                const imageField = document.createElement('div');
                imageField.className = 'input-group image-field mt-2';

                const input = document.createElement('input');
                input.type = 'file';
                input.className = 'form-control';
                input.name = 'images[]';
                input.accept = 'image/*';
                input.multiple = true;

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-outline-danger remove-image-button';
                removeButton.textContent = 'Remove';

                imageField.appendChild(input);
                imageField.appendChild(removeButton);
                imagesContainer.appendChild(imageField);

                imageIndex++;
            });

            imagesContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-image-button')) {
                    const imageField = event.target.closest('.image-field');
                    imageField.remove();
                    imageIndex--;
                }
            });
        });
    </script>
@endsection
