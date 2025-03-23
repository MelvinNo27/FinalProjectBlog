@extends('user.layout.master')

@section('content')

<div class="container">
    <div class="row justify-content-center pt-3">

        <!-- Floating Create Post Button -->
        @include('user.post.create-button')

        <!-- Post Form -->
        @include('user.post.post-form', ['topics' => $topics, 'token' => $token])

        <!-- User Posts -->
        @include('user.post.user-posts', ['posts' => $posts])

    </div>
</div>

<!-- Alert Messages -->
@if (session('message'))
    @include('user.post.success-alert', ['message' => session('message')])
@endif

@if (session('error'))
    @include('user.post.error-alert', ['error' => session('error')])
@endif

@endsection

@section('scriptSource')
    @include('user.post.scripts')
@endsection
