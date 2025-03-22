@extends('admin.layout.master')

@section('title', 'Create New Post')

@section('content')

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-6 offset-md-3 bg-white p-4 shadow-sm rounded">
                <h3 class="text-center text-primary fw-bold mb-3">Create New Post</h3>

                <form action="{{ route('post#create') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="adminId" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="approved" value="{{ Auth::user()->role === 'admin' ? 1 : 0 }}"> <!-- ✅ Auto-approve for admins -->

                    <!-- Admin Name (Read-Only) -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Name</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly disabled>
                    </div>

                    <!-- Topic Selection -->
                    <div class="mb-3">
                        <label for="topicId" class="form-label fw-semibold">Topic</label>
                        <select name="topicId" class="form-select @error('topicId') is-invalid @enderror">
                            <option value="">Choose topic</option>
                            @foreach ($topic as $t)
                                <option value="{{ $t->id }}" @if(old('topicId') == $t->id) selected @endif>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('topicId')
                        <span class="text-danger d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Upload Image -->
                    <div class="mb-3">
                        <label for="postImage" class="form-label fw-semibold">Image</label>
                        <input type="file" name="postImage" class="form-control">
                    </div>

                    <!-- Post Description -->
                    <div class="mb-3">
                        <label for="desc" class="form-label fw-semibold">Content</label>
                        <textarea name="desc" rows="4" class="form-control @error('desc') is-invalid @enderror"
                                  placeholder="Enter content messages here...">{{ old('desc') }}</textarea>
                        @error('desc')
                        <span class="text-danger mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('post#listPage') }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-arrow-left me-2"></i>Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i>Create
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->

@endsection
