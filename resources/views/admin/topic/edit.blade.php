@extends('admin.layout.master')

@section('title', 'Edit Topic')

@section('content')

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-6 offset-md-3 bg-white p-4 shadow-sm rounded">
                <h3 class="text-center text-primary fw-bold mb-3">Edit Topic</h3>
                <hr>

                <form action="{{ route('topic#edit', $topic->id) }}" method="POST">
                    @csrf

                    <!-- Topic Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Topic Name</label>
                        <input type="text" name="name" value="{{ old('name', $topic->name) }}"
                               class="form-control form-control-lg @error('name') is-invalid @enderror"
                               placeholder="Enter topic name...">
                        @error('name')
                        <span class="text-danger d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('topic#listPage') }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-arrow-left me-2"></i>Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-arrow-up-from-bracket me-2"></i>Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->

@endsection
