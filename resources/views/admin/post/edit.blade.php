@extends('admin.layout.master')

@section('title', 'Edit Post')

@section('content')

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-6 offset-md-3 bg-white p-4 shadow-sm rounded">
                <h3 class="text-center text-primary fw-bold mb-3">Edit Post</h3>
                <hr>

                <form action="{{ route('post#edit', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Admin Name (Read-Only) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" class="form-control" readonly disabled value="{{ $post->admin_name }}">
                        <input type="hidden" name="adminId" value="{{ $post->admin_id }}">
                    </div>

                    <!-- Topic Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Topic</label>
                        <select name="topicId" class="form-select @error('topicId') is-invalid @enderror">
                            <option value="">Choose topic</option>
                            @foreach ($topic as $t)
                                <option value="{{ $t->id }}" @if(old('topicId', $post->topic_id) == $t->id) selected @endif>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('topicId')
                        <span class="text-danger d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Image</label>
                        <input type="file" name="postImage" class="form-control">
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Content</label>
                        <textarea name="desc" rows="4" class="form-control @error('desc') is-invalid @enderror"
                                  placeholder="Enter post content...">{{ old('desc', $post->desc) }}</textarea>
                        @error('desc')
                        <span class="text-danger d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('post#listPage') }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-arrow-left me-2"></i>Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-upload me-2"></i>Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->

@endsection
