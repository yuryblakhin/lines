@extends('layouts.dashboard')

@section('content')
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">ID</div>
                        <div class="datagrid-content">{{ $warehouse->id }}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Active</div>
                        <div class="datagrid-content">
                            <span class="badge ms-auto {{ $warehouse->getBadgeForActiveStatus() }}"></span>
                        </div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Name</div>
                        <div class="datagrid-content">{{ $warehouse->name }}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Code</div>
                        <div class="datagrid-content">{{ $warehouse->code }}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Address</div>
                        <div class="datagrid-content">{{ $warehouse->address }}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Phones</div>
                        <div class="datagrid-content">{{ $warehouse->getPhones() }}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Created At</div>
                        <div class="datagrid-content">{{ $warehouse->created_at }}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Updated At</div>
                        <div class="datagrid-content">{{ $warehouse->updated_at }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
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
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Currency</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td><span class="text-secondary">{{ $product->id }}</span></td>
                            <td><span class="badge ms-auto {{ $product->getBadgeForActiveStatus() }}"></span></td>
                            <td><img class="avatar avatar-xl" src="{{ $product->getImagePath() }}" alt="{{ $product->name }}"></td>
                            <td><a href="{{ route('dashboard.product.show', ['product' => $product->id], false) }}">{{ $product->name }}</a></td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->sku_owner }}</td>
                            <td>{{ $product->pivot->price }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td>{{ $warehouse->currency->code }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('actionButtons')
    <div class="btn-list">
        <a class="btn btn-primary d-none d-sm-inline-block" href="{{ route('dashboard.warehouse.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg> Create
        </a>
    </div>
@endsection
