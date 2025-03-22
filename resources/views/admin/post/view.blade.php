@extends('admin.layout.master')

@section('title', 'Post Detail')

@section('content')

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow rounded border-0">

                    <!-- Post Topic -->
                    <h5 class="card-title fw-bold text-primary border-start border-4 border-dark ps-3 mt-3 ms-3">
                        {{ $topic_name }}
                    </h5>

                    <!-- Post Author Info -->
                    <div class="d-flex align-items-center ms-3 mt-2">
                        <div class="rounded-circle overflow-hidden border" style="width: 55px; height: 55px;">
                            @if ($post->profile_image)
                                <img src="{{ asset('storage/'.$post->profile_image) }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ $post->admin_name }}" class="w-100 h-100" style="object-fit: cover;">
                            @endif
                        </div>
                        <div class="ms-2">
                            <span class="fw-semibold fs-6">{{ $post->admin_name }}</span><br>
                            <span class="text-muted fs-6">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <!-- Post Image -->
                    <div class="p-3 text-center">
                        @if ($post->image)
                            <img src="{{ asset('storage/'.$post->image) }}" class="img-fluid rounded border border-dark">
                        @else
                            <img src="{{ asset('images/alert gif/postimg.jpg') }}" class="img-fluid rounded border border-dark">
                        @endif
                    </div>

                    <!-- Post Content -->
                    <div class="card-body">
                        <p class="card-text" style="white-space: pre-wrap;">{{ Str::words($post->desc, 20, '...') }}</p>
                        <hr>

                        <!-- Bookmark & Back Button -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fs-5 text-primary" style="cursor: pointer;">
                                <i class="fa-solid fa-bookmark"></i>
                                <span>{{ $post->save_count }}</span>
                            </div>
                            <a href="{{ route('post#listPage') }}" class="btn btn-primary">
                                <i class="fa-solid fa-arrow-left me-2"></i>Back
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->

@endsection
