@extends('user.layout.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- 📌 Sidebar Section (Fixed Left, Dark Mode Compatible) -->
        <div class="sidebar col-lg-2 d-none d-lg-block pt-5"
            style="position: fixed; left: 10px; width: 250px; height: 88vh; background-color: white;
                   box-shadow: 2px 0 0px rgba(0, 0, 0, 0.1); padding: 20px;">

            <!-- 📢 Announcements -->
            <div class="mb-4">
                <h6 class="fw-bold text-primary"><i class="bi bi-megaphone-fill me-1"></i> Announcements</h6>
                <marquee direction="up" scrollamount="2" style="height: 60px; font-size: 12px;">
                    <p>📣 New coding workshop this Friday!</p>
                </marquee>
            </div>
            <hr style="border-top: 2px solid #6f42c1; margin-bottom: 20px;">

<!-- 📌 Topics List (Filtered for Saved Topics) -->
<div class="mb-4">
    <h6 class="fw-bold text-primary"><i class="bi bi-tags-fill me-1"></i> Topics</h6>
    <ul class="list-group">
        <li class="list-group-item border-0 {{ request('topic_id') ? '' : 'active bg-primary text-white' }}">
            <a class="text-decoration-none {{ request('topic_id') ? 'text-dark' : 'text-white fw-bold' }}"
                href="{{ route('saved#list') }}">
                📌 All Saved Posts
            </a>
        </li>
        @foreach ($topics as $topic)
            <li class="list-group-item border-0 {{ request('topic_id') == $topic->id ? 'active bg-primary text-white' : '' }}">
                <a class="text-decoration-none {{ request('topic_id') == $topic->id ? 'text-white fw-bold' : 'text-dark' }}"
                    href="{{ route('saved#list', ['topic_id' => $topic->id]) }}">
                    📝 {{ $topic->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>



            <hr style="border-top: 2px solid #6f42c1; margin-bottom: 20px;">

            <!-- 📂 Quick Links -->
            <div class="mb-4">
                <h6 class="fw-bold text-primary"><i class="bi bi-link-45deg me-1"></i> Resources</h6>
                <ul class="list-unstyled">
                    <li><a href="https://www.w3schools.com" target="_blank" class="text-dark">📘 W3Schools</a></li>
                    <li><a href="https://www.geeksforgeeks.org" target="_blank" class="text-dark">💡 GeeksforGeeks</a></li>
                    <li><a href="https://stackoverflow.com" target="_blank" class="text-dark">👨‍💻 StackOverflow</a></li>
                </ul>
            </div>
            <hr style="border-top: 2px solid #6f42c1; margin-bottom: 20px;">
        </div>

        <!-- 📌 Saved Posts Section -->
        <div class="col-lg-6 offset-lg-4 bg-card pt-4"
            style="height: 91vh; overflow-y: scroll; background-color: #f8f9fa; border-radius: 10px; padding: 20px;">
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
                            <div style="width: 55px; height: 55px; overflow: hidden; border-radius: 50%;">
                                @if ($post->profile_image)
                                    <img src="{{asset('storage/'.$post->profile_image)}}" style="object-fit:cover;object-position:center;" class="w-100 h-100 rounded-circle card-img-top" alt="" />
                                @else
                                    <img class="w-100 h-100 rounded-circle" style="object-fit: cover; object-position:center;" src="https://ui-avatars.com/api/?name={{$post->admin_name}}"/>
                                @endif
                            </div>
                            <div class="d-flex">
                                <div class="ms-2">
                                    <span style="font-size: 18px;" class="fw-semibold">{{$post->admin_name}}
                                        @if ($post->role == 'admin')
                                        <i class="bi bi-patch-check-fill " style="color: #1DA1F2;font-size:14px;"></i>
                                        @endif
                                    </span>
                                    <br>
                                    <span style="font-size: 12px;">{{$post->created_at->diffForHumans()}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="img-container my-3 mx-4 border rounded border-dark border-3">
                            @if ($post->image)
                                <img src="{{asset('storage/'.$post->image)}}" class="image card-img-top" />
                            @else
                                <img src="{{asset('images/alert gif/postimg.jpg')}}" class="card-img-top img-thumbnail" alt="" />
                            @endif
                        </div>
                        <div class="card-body">
                            <p class="card-text" style="white-space: pre-wrap">{{Str::words($post->desc,20,"....")}}</p>
                            <hr />
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="btn btn-unsave">
                                        <i class="fa-regular fa-solid text-primary fa-bookmark fs-3"></i>
                                    </div>
                                    <span class="text-primary">saved</span>
                                </div>
                                <a href="{{route('user#view',$post->id)}}" class="btn btn-primary">
                                    <i class="fa-solid fa-eye me-2"></i>see more
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="d-flex justify-content-center align-items-center" style="height: 100%; text-align: center;">
                <h4 class="text-center text-primary">No post saved yet.</h4>
            </div>
            @endif
            <div class="mt-2 d-flex justify-content-center">
                {{$posts->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
</div>
@endsection


@section('scriptSource')
<script>
    $(document).ready(function() {
        // Auto detect link
        $(".card-text").each(function() {
            const linkRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
            const modifiedHTML = $(this).html().replace(linkRegex, '<a target="_blank" href="$1">$1</a>');
            $(this).html(modifiedHTML);
        });

        $('.btn-unsave').click(function(){
            $parentNode = $(this).parents('.card-box');
            $parentNode.find('.fa-bookmark').addClass('fa-solid');
            $post_id = $parentNode.find('.post_id').val();
            Swal.fire({
                title: 'Are you sure bro?',
                text: "You want to unsave this Blog?",
                showCancelButton: true,
                imageUrl: '{{asset('images/alert gif/mad.gif')}}',
                imageWidth: 300,
                imageHeight: 300,
                imageAlt: 'Custom image',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'get',
                        url: '/user/saved/unsave',
                        data: {'post_id': $post_id},
                        dataType: 'json',
                        success: function() {
                            Swal.fire(
                                'Unsaved!',
                                'Blog Unsaved',
                                'success'
                            ).then(function(){
                                location.reload();
                            })
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
