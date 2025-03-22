@extends('admin.layout.master')

@section('title','Account Information')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h3 class="title-2 fw-bold">Personal Information</h3>
                            </div>
                            <hr>

                            <div class="row g-4 align-items-center">
                                <!-- Profile Image -->
                                <div class="col-md-4 text-center">
                                    <div class="rounded-circle overflow-hidden border border-secondary shadow-sm mx-auto" style="width: 150px; height: 150px;">
                                        @if (Auth::user()->image)
                                            <img src="{{ asset('storage/' . Auth::user()->image) }}" class="w-100 h-100" style="object-fit: cover; object-position: center;" alt="Profile">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="w-100 h-100" style="object-fit: cover; object-position: center;" alt="Profile">
                                        @endif
                                    </div>
                                </div>

                                <!-- User Details -->
                                <div class="col-md-8">
                                    <form>
                                        @csrf
                                        <div class="mb-3">
                                            <label class="fw-semibold"><i class="fa-solid fa-user me-2"></i>Name</label>
                                            <input type="text" class="form-control bg-light border-0" value="{{ Auth::user()->name }}" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="fw-semibold"><i class="fa-solid fa-shield-halved me-2"></i>Role</label>
                                            <input type="text" class="form-control bg-light border-0" value="{{ Auth::user()->role }}" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="fw-semibold"><i class="fa-solid fa-venus-mars me-2"></i>Gender</label>
                                            <input type="text" class="form-control bg-light border-0" value="{{ Auth::user()->gender }}" readonly>
                                        </div>

                                        <div class="mb-4">
                                            <label class="fw-semibold"><i class="fa-solid fa-envelope me-2"></i>Email</label>
                                            <input type="text" class="form-control bg-light border-0" value="{{ Auth::user()->email }}" readonly>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('admin#home') }}" class="btn btn-outline-secondary w-45">
                                                <i class="fa-solid fa-arrow-left me-2"></i>Back
                                            </a>
                                            <a href="{{ route('admin#updateAccountPage') }}" class="btn btn-primary w-45">
                                                <i class="fa-solid fa-pen-to-square me-2"></i>Edit
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END MAIN CONTENT-->

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
