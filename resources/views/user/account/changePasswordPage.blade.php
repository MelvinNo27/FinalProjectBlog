@extends('user.layout.master')

@section('content')
<div class="container-fluid">
    <div class="col-lg-6 offset-lg-3 mt-5">
        <div class="card shadow-lg rounded">
            <div class="card-body">
                <div class="card-title text-center">
                    <h3 class="fw-bold text-primary">Change Account Password</h3>
                </div>
                <hr>
                <form action="{{ route('user#changePassword') }}" method="POST" novalidate="novalidate">
                    @csrf
                    <!-- Old Password -->
                    <div class="form-group mb-3">
                        <label for="oldPassword" class="form-label fw-semibold">Old Password</label>
                        <input id="oldPassword" name="oldPassword" type="password" class="form-control @if(session('changePasswordFail')) is-invalid @endif @error('oldPassword') is-invalid @enderror" placeholder="Enter Old Password">
                        @error('oldPassword')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        @if(session('changePasswordFail'))
                            <span class="invalid-feedback">{{ session('changePasswordFail') }}</span>
                        @endif
                    </div>

                    <!-- New Password -->
                    <div class="form-group mb-3">
                        <label for="newPassword" class="form-label fw-semibold">New Password</label>
                        <input id="newPassword" name="newPassword" type="password" class="form-control @error('newPassword') is-invalid @enderror" placeholder="Enter New Password">
                        @error('newPassword')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group mb-3">
                        <label for="confirmPassword" class="form-label fw-semibold">Confirm Password</label>
                        <input id="confirmPassword" name="confirmPassword" type="password" class="form-control @error('confirmPassword') is-invalid @enderror" placeholder="Enter Confirm Password">
                        @error('confirmPassword')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary w-50">
                            <i class="fa-solid fa-key me-2"></i> Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
