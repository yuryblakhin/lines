@extends('layouts.dashboard')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th class="w-1">ID</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phones</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if ($warehouses->isEmpty())
                        <tr>
                            <td colspan="8">No warehouses found</td>
                        </tr>
                    @else
                        @foreach ($warehouses as $warehouse)
                            <tr>
                                <td><span class="text-secondary">{{ $warehouse->id }}</span></td>
                                <td>{{ $warehouse->code }}</td>
                                <td>{{ $warehouse->name }}</td>
                                <td>{{ $warehouse->address }}</td>
                                <td>{{ $warehouse->getPhones() }}</td>
                                <td>{{ $warehouse->created_at }}</td>
                                <td>{{ $warehouse->updated_at }}</td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('dashboard.warehouse.edit', ['warehouse' => $warehouse->id], false) }}">Edit</a>
                                        <form action="{{ route('dashboard.warehouse.destroy', ['warehouse' => $warehouse->id], false) }}" method="POST">
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
            {{ $warehouses->links() }}
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

