@extends('user.layout.master')

@section('content')

<div class="container mt-5">
    <div class="row">

<!-- 📌 Sidebar Section (Fixed Left, Dark Mode Compatible) -->
<div class="sidebar col-lg-2 d-none d-lg-block pt-5"
    style="position: fixed; left: 10px; width: 250px; height: 88vh; background-color: white;
           box-shadow: 2px 0 0px rgba(0, 0, 0, 0.1); padding: 20px;">


           <!-- 📢 Announcements -->
           <h6 class="fw-bold text-primary"><i class="bi bi-megaphone-fill me-1"></i> Announcements</h6>
           <marquee direction="up" scrollamount="2" style="height: 60px; font-size: 12px;">
               <p>📣 New coding workshop this Friday!</p>
           </marquee>



            <!-- 📌 Topics List -->
            <h6 class="fw-bold text-primary"><i class="bi bi-tags-fill me-1"></i> Topics</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item border-0">
                    <a class="text-dark text-decoration-none" href="{{route('user#home')}}">📌 All Posts</a>
                </li>
                @foreach ($topics as $topic)
                    <li class="list-group-item border-0">
                        <a class="text-dark text-decoration-none" href="{{route('user#topicFilter', $topic->id)}}">📝 {{$topic->name}}</a>
                    </li>
                @endforeach
            </ul>

   <!-- 📂 Quick Links -->
   <h6 class="fw-bold text-primary mt-3"><i class="bi bi-link-45deg me-1"></i> Resources</h6>
   <ul class="list-unstyled">
       <li><a href="https://www.w3schools.com" target="_blank" class="text-dark">📘 W3Schools</a></li>
       <li><a href="https://www.geeksforgeeks.org" target="_blank" class="text-dark">💡 GeeksforGeeks</a></li>
       <li><a href="https://stackoverflow.com" target="_blank" class="text-dark">👨‍💻 StackOverflow</a></li>
   </ul>

            <!-- 📊 Poll Section -->
            <h6 class="fw-bold text-primary mt-3"><i class="bi bi-bar-chart me-1"></i> Vote on Tech Trends</h6>
            <form action="{{ route('user#votePoll') }}" method="POST">
                @csrf
                <p class="small">What’s the hottest tech right now?</p>
                <input type="radio" name="poll" value="AI"> 🤖 AI & Machine Learning <br>
                <input type="radio" name="poll" value="Web3"> 🌐 Web3 & Blockchain <br>
                <input type="radio" name="poll" value="Cyber"> 🔒 Cybersecurity <br>
                <button type="submit" class="btn btn-sm btn-primary mt-2">Vote</button>
            </form>

        </div>
</div>


        <!-- 📌 Centered Posts Section -->
        <div class="col-lg-8 offset-lg-3 d-flex flex-column align-items-center pt-5" style="min-height: 92vh; overflow-y: auto;" id="post-container">
            @if ($posts->count() > 0)
                @foreach ($posts as $post)
                    @if ($post->approved == 1)
                        <div class="card shadow rounded border-0 mb-4" style="width: 70%;">
                            <h5 class="card-title mt-3 fw-bold ms-3">
                                <span class="me-2 text-primary border-start border-4 border-dark ps-1">
                                    {{$post->topic_name}}
                                </span>
                            </h5>
                            <div class="d-flex align-items-center ms-3 mt-1">
                                <div style="width: 55px; height: 55px; overflow: hidden;">
                                    @if ($post->profile_image)
                                        <img src="{{asset('storage/'.$post->profile_image)}}" class="w-100 h-100 rounded-circle card-img-top" />
                                    @else
                                        <img class="w-100 h-100 rounded-circle" src="https://ui-avatars.com/api/?name={{$post->admin_name}}"/>
                                    @endif
                                </div>
                                <div class="ms-2">
                                    <span style="font-size: 18px;" class="fw-semibold">{{$post->admin_name}}</span>
                                    <br>
                                    <span style="font-size: 12px;">{{$post->created_at->diffForHumans()}}</span>
                                </div>
                            </div>
                            <div class="img-container my-3 mx-4 border rounded border-dark border-3">
                                @if ($post->image)
                                    <img src="{{asset('storage/'.$post->image)}}" class="image card-img-top" />
                                @else
                                    <img src="{{asset('images/alert gif/postimg.jpg')}}" class="card-img-top img-thumbnail" />
                                @endif
                            </div>
                            <div class="card-body">
                                <p class="card-text" style="white-space: pre-wrap">{{Str::words($post->desc,20,"....")}}</p>
                                <hr />
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{route('user#view',$post->id)}}" class="btn btn-primary">
                                        <i class="fa-solid fa-eye me-2"></i>See More
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <!-- Centered No Post Message -->
                <div class="d-flex justify-content-center align-items-center" style="height: 100%; text-align: center;">
                    <h4 class="text-primary">No post to show.</h4>
                </div>
            @endif

         <!-- ✅ Custom Pagination (Removes "Showing X to X of X results") -->
<div class="mt-2 text-center">
    {{ $posts->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-4') }}
</div>

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
