@extends('user.layout.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar for Topic Filter (visible only on large screens) -->
        <div class="col-lg-4 d-none d-lg-block pt-5" style="height: 88vh;">
            <div class="mx-auto border-2" style="width: 250px;">
                <div class="dropdown">
                    <button class="btn btn-white border border-primary border-2 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Topics to choose
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('user#home')}}">All</a></li>
                        @foreach ($topics as $topic)
                        <li><a class="dropdown-item" href="{{route('user#topicFilter',$topic->id)}}">{{$topic->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
<!-- Posts Section -->
<div class="col-lg-7 pt-5    bg-card" style="height: 92vh; overflow-y: scroll;" id="post-container">
    @if (count($posts) != 0)
        @foreach ($posts as $post)
        <div class="card-box d-flex justify-content-center mb-4">
            <div class="card shadow rounded border-0" style="width: 35rem">
                <h5 class="card-title mt-3 fw-bold ms-3">
                    <span class="me-2 text-primary border-start border-4 border-dark ps-1">
                        {{$post->topic_name}}
                        <input class="post_id" type="hidden" value="{{$post->id}}">
                    </span>
                </h5>
                <div class="d-flex align-items-center ms-3 mt-1">
                    <div style="width: 55px; height: 55px; overflow: hidden;">
                        @if ($post->profile_image)
                            <img src="{{asset('storage/'.$post->profile_image)}}" style="object-fit:cover;object-position:center;" class="w-100 h-100 rounded-circle card-img-top" alt="" />
                        @else
                            <img class="w-100 h-100 rounded-circle" style="object-fit: cover; object-position:center;" src="https://ui-avatars.com/api/?name={{$post->admin_name}}"/>
                        @endif
                    </div>
                    <div class="ms-2">
                        <span style="font-size: 18px;" class="fw-semibold">{{$post->admin_name}}
                            @if ($post->role == 'admin')
                            <i class="bi bi-patch-check-fill" style="color: #1DA1F2;font-size:14px;"></i>
                            @endif
                        </span>
                        <br>
                        <span style="font-size: 12px;" class="">{{$post->created_at->diffForHumans()}}</span>
                    </div>
                </div>
                <div class="img-container my-3 mx-4 border rounded border-dark border-3">
                    @if ($post->image)
                        <img src="{{asset('storage/'.$post->image)}}" class="image card-img-top" />
                        <div class="buttons">
                            <button class="btn btn-primary btn-view"><i class="fa-solid fa-mountain-sun me-2"></i>View</button>
                            <a href="{{asset('storage/'.$post->image)}}" download class="btn btn-primary btn-download"><i class="fa-solid fa-download"></i></a>
                        </div>
                    @else
                        <img src="{{asset('images/alert gif/postimg.jpg')}}" class="card-img-top img-thumbnail" alt="" />
                    @endif
                </div>
                <div class="card-body">
                    <p class="card-text" style="white-space: pre-wrap">{{Str::words($post->desc,20,"....")}}</p>
                    <hr />
                    <div class="d-flex justify-content-between align-items-center">
                        @if (Auth::check())
                            <div class="btn btn-save">
                                <i class="fa-regular @if ($saveStatus[$post->id] == true) fa-solid @endif text-primary fa-bookmark fs-3"></i>
                            </div>
                        @endif
                        <a href="{{route('user#view',$post->id)}}" class="btn btn-primary @if (!(Auth::check())) ms-auto @endif">
                            <i class="fa-solid fa-eye me-2"></i>See More
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
    <!-- Centered No Post Message -->
    <div class="d-flex justify-content-center align-items-center" style="height: 100%; text-align: center;">
        <h4 class="text-primary">No post to show.</h4>
    </div>
    @endif
    <div class="mt-2">
        {{$posts->appends(request()->query())->links()}}
    </div>
</div>
</div>
@endsection

@if (session('feedbackSent'))
    @section('scriptSource')
        <script>
            Swal.fire({
                imageUrl: '{{asset('images/alert gif/happy.gif')}}',
                imageWidth: 300,
                imageHeight: 300,
                imageAlt: 'Custom image',
                title: '{{ session('feedbackSent') }}',
                showConfirmButton: true,
            })
        </script>
    @endsection
@endif

@if (session('info'))
    @section('scriptSource')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                text: '{{ session('info') }}',
                showConfirmButton: true,
            })
        </script>
    @endsection
@endif

@section('scriptSource')
<script>
    $(document).ready(function() {
        // Auto detect and linkify URLs in the post description
        $(".card-text").each(function() {
            const linkRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
            const modifiedHTML = $(this).html().replace(linkRegex, '<a target="_blank" href="$1">$1</a>');
            $(this).html(modifiedHTML);
        });

        // Save post functionality
        $('.btn-save').click(function(){
            const $parentNode = $(this).parents('.card-box');
            const $post_id = $parentNode.find('.post_id').val();

            $.ajax({
                type : 'get',
                url : '/user/home/save',
                data : {'post_id' : $post_id},
                dataType : 'json',
                success : function(response) {
                    Swal.fire({
                        title: 'Bro!',
                        text: 'Post has been saved!',
                        imageUrl: '{{asset('images/alert gif/already saved.gif')}}',
                        imageWidth: 300,
                        imageHeight: 300,
                        imageAlt: 'Custom image',
                        confirmButtonText : 'Ok',
                    })
                },
                error: function(response) {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'There was an issue saving the post. Please try again.',
                        imageUrl: '{{asset('images/alert gif/mad.gif')}}',
                        imageWidth: 300,
                        imageHeight: 300,
                        imageAlt: 'Custom image',
                        confirmButtonText : 'Retry',
                    })
                }
            });
        });

        // Infinite scroll
        var page = 1;
        function loadMorePosts() {
            $.ajax({
                url: '{{ route('user#home') }}' + '?page=' + page + '&searchKey={{ request('searchKey') }}',
                type: 'GET',
                success: function(response) {
                    if (response) {
                        $('#post-container').append(response);
                        page++;
                    }
                }
            });
        }

        var container = $('#post-container');
        container.scroll(function() {
            var scrollPosition = container.scrollTop();
            var containerHeight = container[0].scrollHeight;
            var visibleHeight = container.outerHeight();

            if (scrollPosition + visibleHeight >= containerHeight) {
                loadMorePosts();
            }
        });
    });
</script>

<script>
    // Alert user once per 24 hours about new features
    var lastAlertTimestamp = localStorage.getItem('lastAlertTimestamp');
    var currentTimestamp = new Date().getTime();

    if (!lastAlertTimestamp || currentTimestamp - lastAlertTimestamp >= 24 * 60 * 60 * 1000) {
        Swal.fire({
            icon: 'info',
            title: 'New Update!',
            text: 'You can now see home page posts and view details, and you can search via the search box or topic filter. Some features require login.',
            confirmButtonText: 'OK'
        });
        localStorage.setItem('lastAlertTimestamp', currentTimestamp);
    }
</script>

@endsection
