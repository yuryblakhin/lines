@extends('layouts.dashboard')

@section('content')
    <div class="col-md-6">
        <div class="card">
            <div id="productCarusel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if ($product->image_path)
                        <div class="carousel-item active">
                            <img src="{{ $product->getImagePath() }}" class="d-block w-100" alt="{{ $product->name }}">
                        </div>
                    @endif
                    @if ($product->images->count() > 0)
                        @foreach ($product->images as $image)
                            <div class="carousel-item">
                                <img src="{{ $image->getImagePath() }}" class="d-block w-100" alt="Additional Image">
                            </div>
                        @endforeach
                    @endif
                </div>
                @if ($product->image_path || $product->images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarusel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarusel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">ID</div>
                        <div class="datagrid-content">{{ $product->id }}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Active</div>
                        <div class="datagrid-content">
                            <span class="badge ms-auto {{ $product->getBadgeForActiveStatus() }}"></span>
                        </div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Name</div>
                        <div class="datagrid-content">{{ $product->name }}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Code</div>
                        <div class="datagrid-content">{{ $product->code }}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Description</div>
                        <div class="datagrid-content">{{ $product->description }}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Categories</div>
                        <div class="datagrid-content">
                            {{ $product->getCategoryNames() }}
                        </div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Created At</div>
                        <div class="datagrid-content">{{ $product->created_at }}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Updated At</div>
                        <div class="datagrid-content">{{ $product->updated_at }}</div>
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
                        <th class="w-1">&nbsp;</th>
                        <th>Warehouse</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($warehouses as $warehouse)
                        <tr>
                            <td><span class="badge ms-auto {{ $warehouse->getBadgeForActiveStatus() }}"></span></td>
                            <td>{{ $warehouse->name }}</td>
                            @php
                                $pivot = $warehouse->products->find($product) ? $warehouse->products->find($product)->pivot : null;
                            @endphp
                            <form class="mb-0" method="POST" action="{{ route('api.product.warehouse.update', ['product' => $product->id, 'warehouse' => $warehouse->id], false) }}">
                                @csrf
                                @method('PUT')

                                <td>
                                    <input type="number" class="form-control form-control-sm" name="price" value="{{ $pivot ? $pivot->price : '' }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" name="quantity" value="{{ $pivot ? $pivot->quantity : '' }}">
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsectionё
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            for (let i = 0; i < forms.length; i++) {
                forms[i].addEventListener('submit', function(event) {
                    event.preventDefault();

                    let formData = new FormData(this);
                    let confirmation = confirm('Are you sure you want to update?');

                    if (!confirmation) {
                        return;
                    }

                    const _this = this;
                    const xhr = new XMLHttpRequest();

                    xhr.open('POST', this.action, true);

                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            console.log('Changes saved successfully.');
                        } else {
                            console.error('An error occurred while saving changes.');
                        }
                    };

                    xhr.onerror = function () {
                        console.error('Error occurred while deleting image.');
                    };

                    xhr.send(formData);
                });
            }
        });
    </script>
@endsection
@section('actionButtons')
    <div class="btn-list">
        <a class="btn btn-primary d-none d-sm-inline-block" href="{{ route('dashboard.product.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg> Create
        </a>
    </div>
@endsection
