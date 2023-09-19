@extends('layouts.dashboard')

@section('content')
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.product.update', ['product' => $product->id], false) }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="id" class="form-label">{{ __('ID') }}</label>
                        <span id="id" class="form-control disabled">{{ $product->id }}</span>
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
                        <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">

                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">{{ __('Price') }}</label>
                        <input id="price" type="number" min="0" step="0.01" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" required>

                        @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="stock_quantity" class="form-label">{{ __('Stock Quantity') }}</label>
                        <input id="stock_quantity" type="number" min="0" class="form-control @error('stock_quantity') is-invalid @enderror" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>

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
                        <label for="created_at" class="form-label">{{ __('Created At') }}</label>
                        <span id="created_at" class="form-control disabled">{{ $product->created_at }}</span>
                    </div>
                    <div class="mb-3">
                        <label for="created_at" class="form-label">{{ __('Updated At') }}</label>
                        <span id="created_at" class="form-control disabled">{{ $product->updated_at }}</span>
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
