@extends('admin.layout.master')

@section('title', 'Change Password')

@section('content')

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-6 offset-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h3 class="fw-bold">Change Account Password</h3>
                            </div>
                            <hr>

                            <form action="{{ route('admin#changePassword') }}" method="post">
                                @csrf

                                <!-- Old Password -->
                                <div class="mb-3">
                                    <label class="fw-semibold"><i class="fa-solid fa-lock me-2"></i> Old Password</label>
                                    <input type="password" name="oldPassword" class="form-control @if(session('changePasswordFail')) is-invalid @endif @error('oldPassword') is-invalid @enderror" placeholder="Enter Old Password">
                                    @error('oldPassword') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    @if(session('changePasswordFail')) <span class="invalid-feedback">{{ session('changePasswordFail') }}</span> @endif
                                </div>

                                <!-- New Password -->
                                <div class="mb-3">
                                    <label class="fw-semibold"><i class="fa-solid fa-key me-2"></i> New Password</label>
                                    <input type="password" name="newPassword" class="form-control @error('newPassword') is-invalid @enderror" placeholder="Enter New Password">
                                    @error('newPassword') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <label class="fw-semibold"><i class="fa-solid fa-lock me-2"></i> Confirm Password</label>
                                    <input type="password" name="confirmPassword" class="form-control @error('confirmPassword') is-invalid @enderror" placeholder="Confirm New Password">
                                    @error('confirmPassword') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <!-- Change Password Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-key me-2"></i> Change Password
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
