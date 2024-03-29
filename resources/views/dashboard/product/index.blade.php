@extends('layouts.dashboard')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th class="w-1">ID</th>
                            <th>&nbsp;</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>SKU owner</th>
                            <th>Categories</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

                    @if ($products->isEmpty())
                        <tr>
                            <td colspan="10">No products found</td>
                        </tr>
                    @else
                        @foreach ($products as $product)
                            <tr>
                                <td><span class="text-secondary">{{ $product->id }}</span></td>
                                <td><span class="badge ms-auto {{ $product->getBadgeForActiveStatus() }}"></span></td>
                                <td><img class="avatar avatar-xl" src="{{ $product->getImagePath() }}" alt="{{ $product->name }}"></td>
                                <td><a href="{{ route('dashboard.product.show', ['product' => $product->id], false) }}">{{ $product->name }}</a></td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->sku_owner }}</td>
                                <td>{{ $product->getCategoryNames() }}</td>
                                <td>{{ $product->created_at }}</td>
                                <td>{{ $product->updated_at }}</td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('dashboard.product.edit', ['product' => $product->id], false) }}">Edit</a>
                                        <form action="{{ route('dashboard.product.destroy', ['product' => $product->id], false) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            {{ $products->links() }}
        </div>
    </div>
@endsection
@section('actionButtons')
    <div class="btn-list">
        @if ($xmlFilePath)
            <a class="btn btn-success" href="{{ $xmlFilePath }}" download>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                    <line x1="10" y1="12" x2="14" y2="12"></line>
                    <line x1="12" y1="10" x2="12" y2="14"></line>
                </svg> Download XML
            </a>
        @endif
        <a class="btn btn-primary d-none d-sm-inline-block" href="{{ route('dashboard.product.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg> Create
        </a>
    </div>
@endsection

