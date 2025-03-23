<div id="user-posts" class="col-md-6 py-3 overflow-auto flex-column bg-card" style="height:92vh;">
    @if (count($posts) != 0)
        @foreach ($posts as $post)
            <div class="card-box d-flex justify-content-center mb-4">
                <div class="card shadow rounded border-0" style="width: 35rem">
                    <div class="text-center p-2 {{ $post->approved ? 'bg-success text-white' : 'bg-warning text-dark' }} fw-bold">
                        <i class="fa-solid {{ $post->approved ? 'fa-check-circle' : 'fa-hourglass-half' }} me-2"></i>
                        {{ $post->approved ? 'Approved' : 'Pending Approval' }}
                    </div>
                    <h5 class="card-title d-flex justify-content-between align-items-center mt-3 fw-bold ms-3">
                        <span class="me-2 text-primary border-start border-4 border-dark ps-1">
                            {{ $post->topic_name }}
                        </span>
                    </h5>

                    <div class="img-container pt-3 px-4">
                        @if ($post->image)
                            <img src="{{asset('storage/'.$post->image)}}" class="card-img-top img-thumbnail border border-dark" alt="Post Image" />
                        @else
                            <img src="{{asset('images/alert gif/postimg.jpg')}}" class="card-img-top img-thumbnail border border-dark" alt="Default Image" />
                        @endif
                    </div>

                    <div class="card-body">
                        <p class="card-text">{{ Str::words($post->desc, 20, '....') }}</p>
                        <hr />
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{asset('storage/'.$post->image)}}" target="_blank" download="{{$post->image}}" class="btn btn-outline-primary">Download</a>
                            <a href="{{route('user#view', $post->id)}}" class="btn btn-primary">
                                <i class="fa-solid fa-eye me-2"></i>See More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <h4 class="text-primary text-center mt-4">No post to show.</h4>
    @endif
</div>
