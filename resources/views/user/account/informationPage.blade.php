@extends('user.layout.master')

@section('content')
<div class="container-fluid">
    <div class="col-lg-6 offset-lg-3 mt-5">
        <div class="card shadow-lg rounded">
            <div class="card-body">
                <div class="card-title text-center">
                    <h3 class="fw-bold text-primary">Personal Information</h3>
                </div>
                <hr>

                <!-- Form to Show Personal Information -->
                <form action="" method="post" novalidate="novalidate">
                    @csrf
                    <div class="form-group mt-3">
                        <div class="row">
                            <!-- Profile Image -->
                            <div class="col-lg-6">
                                <div style="width: 250px; height: 250px; overflow: hidden; border-radius: 50%; margin: 0 auto;">
                                    @if (Auth::user()->image)
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" class="w-100 h-100 img-thumbnail" alt="Profile Image" />
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="w-100 h-100 img-thumbnail" alt="Default Avatar" />
                                    @endif
                                </div>
                            </div>

                            <!-- User Info Fields -->
                            <div class="col-lg-6">
                                <!-- Name -->
                                <div class="row mb-3">
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="name" class="fs-4"><i class="fa-solid fa-user me-2"></i></label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" readonly disabled />
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="row mb-3">
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="role" class="fs-4"><i class="fa-solid fa-shield-halved me-2"></i></label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="role" class="form-control" value="{{ Auth::user()->role }}" readonly disabled />
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="row mb-3">
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="gender" class="fs-4"><i class="fa-solid fa-venus-mars me-2"></i></label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="gender" class="form-control" value="{{ Auth::user()->gender }}" readonly disabled />
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="row mb-3">
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="email" class="fs-4"><i class="fa-solid fa-envelope me-2"></i></label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly disabled />
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="row py-3">
                                    <div class="col-6">
                                        <a href="{{ route('user#home') }}" class="btn btn-outline-secondary w-100">
                                            <i class="fa-solid fa-arrow-left me-2"></i> Back
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('user#updateAccountPage') }}" class="btn btn-primary w-100">
                                            <i class="fa-solid fa-pen-to-square me-2"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if (session('updateAlert'))
    @section('scriptSource')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('updateAlert') }}',
                showConfirmButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        </script>
    @endsection
@endif

@endsection
