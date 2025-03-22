@extends('auth.layouts.auth_master')

@section('title', 'Register Form')

@section('content')
<section class="form-container-rg d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="login-container bg-white">
        <div class="row">
            <div class="col-lg-5">
                <div class="bg-primary bg-image border-end">
                    <!-- Content here -->
                </div>
            </div>
            <div class="col-12 col-lg-7 py-4 px-5 py-lg-3">
                <div class="text-end d-flex align-items-center fw-semibold">
                    <span>Already have an account?</span>
                    <a href="{{ route('login') }}" class="ms-3 btn btn-sm btn-outline-primary fw-semibold">Login</a>
                </div>


                <form method="POST" action="{{ route('register') }}" class="pt-2">
                    @csrf
                    <!-- Name -->
                    <label class="form-label mt-4 text-primary fw-semibold">Name</label>
                    <input name="name" value="{{ old('name') }}" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="Enter name...">
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror

                    <!-- Email -->
                    <label class="form-label mt-4 text-primary fw-semibold">Email</label>
                    <input name="email" value="{{ old('email') }}" type="text" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Enter email...">
                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror

                    <!-- Gender -->
                    <label class="form-label mt-4 text-primary fw-semibold">Gender</label>
                    <select name="gender" class="form-select form-select-lg @error('gender') is-invalid @enderror">
                        <option value="">Choose gender</option>
                        <option value="male" @if (old('gender') == 'male') selected @endif>Male</option>
                        <option value="female" @if (old('gender') == 'female') selected @endif>Female</option>
                    </select>
                    @error('gender') <span class="invalid-feedback">{{ $message }}</span> @enderror

                    <!-- Password -->
                    <label class="form-label mt-4 text-primary fw-semibold">Password</label>
                    <input name="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Enter password...">
                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror

                    <!-- Confirm Password -->
                    <label class="form-label mt-4 text-primary fw-semibold">Confirm Password</label>
                    <input name="password_confirmation" type="password" class="form-control form-control-lg" placeholder="Enter password again...">

                    <!-- Register Button -->
                    <button type="submit" class="btn btn-lg btn-primary py-2 px-5 mt-4 mb-3">Register</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
