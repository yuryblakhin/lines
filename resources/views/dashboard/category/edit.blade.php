@extends('layouts.dashboard')

@section('content')
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.category.update', ['category' => $category->id], false) }}" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="id" class="form-label">{{ __('ID') }}</label>
                        <span id="id" class="form-control disabled">{{ $category->id }}</span>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $category->name) }}" required autocomplete="name">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">{{ __('Code') }}</label>
                        <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $category->code) }}" required autocomplete="code">

                        @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description', $category->description) }}</textarea>

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="parent_id" class="form-label">{{ __('Parent Category') }}</label>
                        <select id="parent_id" class="form-control @error('parent_id') is-invalid @enderror" name="parent_id">
                            <option value="">—</option> <!-- Опция для отсутствия родительской категории -->
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $category->parent_id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        @error('parent_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="created_at" class="form-label">{{ __('Created At') }}</label>
                        <span id="created_at" class="form-control disabled">{{ $category->created_at }}</span>
                    </div>
                    <div class="mb-3">
                        <label for="created_at" class="form-label">{{ __('Updated At') }}</label>
                        <span id="created_at" class="form-control disabled">{{ $category->updated_at }}</span>
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
