@extends('admin.layout.master')

@section('title', 'Admin Home')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-12 text-center text-lg-start">
                    <h2 class="title-1">Overview</h2>
                </div>
            </div>

            <!-- Overview Cards -->
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card text-white bg-primary shadow-sm">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-users fa-2x mb-2"></i>
                            <h3 class="fw-bold">{{ $user_count }}</h3>
                            <p class="mb-0">Users</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card text-white bg-danger shadow-sm">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-user-shield fa-2x mb-2"></i>
                            <h3 class="fw-bold">{{ $admin_count }}</h3>
                            <p class="mb-0">Admins</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card text-white bg-success shadow-sm">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-newspaper fa-2x mb-2"></i>
                            <h3 class="fw-bold">{{ $post_count }}</h3>
                            <p class="mb-0">Total Posts</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <h3 class="fw-bold text-primary">Hi, {{ Auth::user()->name }} 👋</h3>
                    <h2>Welcome back!</h2>
                    <p class="text-muted">
                        Our students' blog page is a platform for our team of admins to share insightful and informative posts on a variety of topics, including education, career guidance, and lifestyle. We aim to provide a platform where our students can showcase their creativity, share their thoughts, and engage with the community. Our admins will be posting regularly to keep our readers up-to-date and informed.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('changePw'))
    @section('scriptSource')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('changePw') }}',
                showConfirmButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        </script>
    @endsection
@endif

@endsection
