@extends('layouts.dashboard')

@section('content')
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.product.update', ['product' => $product->id], false) }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox"  id="active" class="form-check-input @error('active') is-invalid @enderror" name="active" {{ old('active', $product->active) ? 'checked' : '' }}>
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
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" required autocomplete="name">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">{{ __('Code') }}</label>
                        <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $product->code) }}" required autocomplete="code">

                        @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description', $product->description) }}</textarea>

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">{{ __('Image') }}</label>
                        @if ($product->image_path)
                            <div class="mb-3">
                                <img src="{{ $product->getImagePath() }}" alt="{{ $product->name }}" class="img-thumbnail mb-3">
                            </div>
                        @endif
                        <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">

                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">{{ __('Additional Images') }}</label>
                        @if ($product->images->count() > 0)
                            <div class="row">
                                @foreach ($product->images as $image)
                                    <div class="col-md-4 mb-3">
                                        <img src="{{ $image->getImagePath() }}" alt="Additional Image" class="img-thumbnail">
                                        <button type="button" class="btn btn-danger mt-2 deleteImageBtn" data-destroy-url="{{ route('api.product.image.destroy', ['product' => $product->id, 'image' => $image->id], false) }}">{{ __('Delete Image') }}</button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
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
                        <label for="categories" class="form-label">{{ __('Categories') }}</label>
                        <select id="categories" class="form-control @error('categories') is-invalid @enderror" name="categories[]" multiple required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $category->name }}</option>
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
                            {{ __('Update') }}
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

            let imageIndex = {{ $product->images->count() + 1 }};

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

            const deleteImageBtns = document.getElementsByClassName('deleteImageBtn');
            for (let i = 0; i < deleteImageBtns.length; i++) {
                deleteImageBtns[i].addEventListener('click', function () {
                    let destroyUrl = this.getAttribute('data-destroy-url');
                    let confirmation = confirm("Are you sure you want to delete this image?");

                    if (!confirmation) {
                        return;
                    }

                    const _this = this;
                    const xhr = new XMLHttpRequest();

                    xhr.open('DELETE', destroyUrl);

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            // Изображение успешно удалено
                            const imageElement = _this.previousElementSibling;
                            const imageContainer = imageElement.parentNode;
                            imageContainer.parentNode.removeChild(imageContainer);
                            imageIndex--;

                            console.log('Image deleted successfully.');
                        } else {
                            console.error('Failed to delete image.');
                        }
                    };

                    xhr.onerror = function () {
                        console.error('Error occurred while deleting image.');
                    };

                    xhr.send();
                });
            }
        });
    </script>
@endsection
