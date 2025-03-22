@extends('admin.layout.master')

@section('title','Update Information')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card shadow-sm bg-light">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h3 class="title-2 fw-bold">Update Information</h3>
                            </div>
                            <hr>

                            <form action="{{route('admin#updateAccount', Auth::user()->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4 align-items-center">

                                    <!-- Profile Image Upload -->
                                    <div class="col-md-4 text-center">
                                        <div class="rounded-circle overflow-hidden border border-secondary shadow-sm mx-auto" style="width: 150px; height: 150px;">
                                            @if (Auth::user()->image)
                                                <img src="{{ asset('storage/' . Auth::user()->image) }}" class="w-100 h-100" style="object-fit: cover; object-position: center;" alt="Profile">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="w-100 h-100" style="object-fit: cover; object-position: center;" alt="Profile">
                                            @endif
                                        </div>
                                        <input type="file" name="image" class="form-control mt-3">
                                    </div>

                                    <!-- User Details -->
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="fw-semibold"><i class="fa-solid fa-user me-2"></i>Name</label>
                                            <input type="text" name="name" class="form-control bg-white @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}" placeholder="Enter Name">
                                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="fw-semibold"><i class="fa-solid fa-shield-halved me-2"></i>Role</label>
                                            <input type="text" name="role" class="form-control bg-light border-0" value="{{ Auth::user()->role }}" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="fw-semibold"><i class="fa-solid fa-venus-mars me-2"></i>Gender</label>
                                            <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                                <option value="">Choose Gender</option>
                                                <option value="male" @if(Auth::user()->gender == 'male') selected @endif>Male</option>
                                                <option value="female" @if(Auth::user()->gender == 'female') selected @endif>Female</option>
                                            </select>
                                            @error('gender') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="fw-semibold"><i class="fa-solid fa-envelope me-2"></i>Email</label>
                                            <input type="text" name="email" class="form-control bg-white @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" placeholder="Enter Email">
                                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-flex justify-content-between mt-4">
                                            <a href="{{ route('admin#informationPage') }}" class="btn btn-outline-secondary w-45">
                                                <i class="fa-solid fa-arrow-left me-2"></i>Back
                                            </a>
                                            <button type="submit" class="btn btn-primary w-45">
                                                <i class="fa-solid fa-arrow-up-from-bracket me-2"></i>Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END MAIN CONTENT-->

@endsection
