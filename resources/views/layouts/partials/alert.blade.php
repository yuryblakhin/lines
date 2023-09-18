@if (session('success'))
    <div>
        <div class="alert alert-success bg-white" role="alert">
            {{ session('success') }}
        </div>
    </div>
@endif

@if (session('warning'))
    <div>
        <div class="alert alert-warning bg-white" role="alert">
            {{ session('warning') }}
        </div>
    </div>
@endif

@if (session('error'))
    <div>
        <div class="alert alert-danger bg-white" role="alert">
            {{ session('error') }}
        </div>
    </div>
@endif

@if (session('info'))
    <div>
        <div class="alert alert-info bg-white" role="alert">
            {{ session('info') }}
        </div>
    </div>
@endif
