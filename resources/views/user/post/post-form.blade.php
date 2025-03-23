<div id="post-form" class="col-md-4 d-none d-md-block border-0 pt-3">
    <form class="card mb-3 shadow rounded p-4" action="{{ route('user#postCreate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="adminId" value="{{ Auth::user()->id }}">
        <input type="hidden" name="approved" value="0"> <!-- Set post as pending -->

        <label for="name" class="form-label fw-semibold">Name</label>
        <input name="name" type="text" class="form-control" readonly disabled value="{{ Auth::user()->name }}">

        <label for="topicId" class="form-label fw-semibold mt-3">Topic</label>
        <select name="topicId" class="form-select @error('topicId') is-invalid @enderror">
            <option value="">Choose topic</option>
            @foreach ($topics as $t)
                <option value="{{ $t->id }}" @if(old('topicId') == $t->id) selected @endif>{{ $t->name }}</option>
            @endforeach
        </select>
        @error('topicId')
            <span class="text-danger d-block">{{ $message }}</span>
        @enderror

        <label for="postImage" class="form-label fw-semibold mt-3">Image</label>
        <input type="file" name="postImage" class="form-control @error('postImage') is-invalid @enderror">
        @error('postImage')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <label for="desc" class="form-label fw-semibold mt-3">Content</label>
        <textarea name="desc" rows="6" class="form-control @error('desc') is-invalid @enderror" placeholder="Enter content here...">{{ old('desc') }}</textarea>
        @error('desc')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="d-flex mt-4 mb-1 justify-content-center">
            <a href="{{ route('post#listPage') }}" class="btn btn-outline-primary" style="width:25%">
                <i class="fa-solid fa-arrow-left me-2"></i>Back
            </a>
            <button type="submit" class="btn btn-primary ms-2" style="width:75%">
                <i class="fa-solid fa-plus me-2"></i>Submit for Approval
            </button>
        </div>

        <div class="text-center mt-3">
            <small class="text-muted">Your post will be reviewed before being published.</small>
        </div>
    </form>
</div>
