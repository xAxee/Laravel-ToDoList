@if (session()->has('message'))
    <!-- Alerts -->
    <div class="alert alert-{{ session('alert') ?? 'success' }} alert-dismissible fade show">
        <strong>Sukces!</strong> {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if ($errors->any())
    <!-- Errors -->
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Bład!</strong> {{ $error }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endforeach
@endif
