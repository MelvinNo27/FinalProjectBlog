@extends('user.layout.master')

@section('content')
<div class="container-fluid">
    <div class="col-lg-6 offset-lg-3 mt-4">
        <div class="card shadow-lg rounded">
            <div class="card-body">
                <div class="card-title text-center">
                    <h3 class="fw-bold text-primary">Update Information</h3>
                </div>
                <hr>

                <form action="{{ route('user#updateAccount') }}" method="post" novalidate="novalidate" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">

                    <div class="form-group mt-3">
                        <div class="row">
                            <!-- Profile Image Section -->
                            <div class="col-lg-6">
                                <div style="width: auto; height: 300px; overflow: hidden; border-radius: 50%; margin: 0 auto;">
                                    @if (Auth::user()->image)
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" style="object-fit:cover;object-position:center;" class="w-100 h-100 img-thumbnail card-img-top" alt="" />
                                    @else
                                        <img class="w-100 h-100 img-thumbnail" style="object-fit: cover; object-position:center;" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" />
                                    @endif
                                </div>
                                <input type="file" name="image" class="form-control mt-3 @error('image') is-invalid @enderror">
                                @error('image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Form Fields Section -->
                            <div class="col-lg-6">
                                <!-- Name -->
                                <div class="row mb-3">
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="name" class="fs-4"><i class="fa-solid fa-user me-2"></i></label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" placeholder="Enter Name">
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="row mb-3">
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="role" class="fs-4"><i class="fa-solid fa-shield-halved me-2"></i></label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="role" class="form-control" value="{{ old('role', Auth::user()->role) }}" readonly>
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="row mb-3">
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="gender" class="fs-4"><i class="fa-solid fa-venus-mars me-2"></i></label>
                                    </div>
                                    <div class="col-9">
                                        <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                            <option value="">Choose Gender</option>
                                            <option value="male" @if(Auth::user()->gender == 'male') selected @endif>Male</option>
                                            <option value="female" @if(Auth::user()->gender == 'female') selected @endif>Female</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="row mb-3">
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="email" class="fs-4"><i class="fa-solid fa-envelope me-2"></i></label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" placeholder="Enter Email">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="row py-3">
                                    <div class="col-6">
                                        <a href="{{ route('user#informationPage') }}" class="btn btn-outline-secondary w-100">
                                            <i class="fa-solid fa-arrow-left me-2"></i>Back
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa-solid fa-arrow-up-from-bracket me-2"></i> Update
                                        </button>
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
@endsection
