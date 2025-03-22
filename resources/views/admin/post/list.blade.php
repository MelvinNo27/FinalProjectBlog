@extends('admin.layout.master')

@section('title', 'Post List')

@section('content')

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">

                <!-- SEARCH BAR -->
                <div class="mb-3">
                    <form action="{{ route('post#listPage') }}" method="get">
                        <div class="input-group shadow-sm">
                            <button type="submit" class="input-group-text btn">
                                <i class="fa-regular fa-magnifying-glass fw-semibold text-primary"></i>
                            </button>
                            <input name="searchKey" value="{{ request('searchKey') }}" type="text"
                                   class="form-control" placeholder="Search for post name">
                        </div>
                    </form>
                </div>

                <!-- FILTER, CREATE, COUNT (Now below Search Bar) -->
<div class="d-flex flex-wrap justify-content-start align-items-center gap-3 mb-3">

    <!-- Filter Dropdown -->
    <div class="dropdown">
        <button class="btn btn-lg bg-white text-primary dropdown-toggle shadow-sm"
                type="button" data-bs-toggle="dropdown">
            <i class="fa-solid fa-arrow-up-z-a me-2 text-primary"></i> Filter
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('post#listPage') }}">Newest First</a></li>
            <li><a class="dropdown-item" href="{{ route('post#filterAsc') }}">Oldest First</a></li>
            <li><a class="dropdown-item" href="{{ route('post#mostSaved') }}">Most Saved</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('post#filterApproved') }}">Approved</a></li>
            <li><a class="dropdown-item" href="{{ route('post#filterPending') }}">Pending</a></li>
        </ul>
    </div>

    <!-- Post Count -->
    <button type="button" class="btn btn-lg bg-white shadow-sm">
        <i class="fa-solid fa-newspaper me-2 text-primary fw-bold"></i>
        <span class="badge p-2 text-bg-primary">{{ $post->total() }}</span>
    </button>

    <!-- Create Button -->
    <a href="{{ route('post#createPage') }}" class="btn btn-lg bg-white text-primary shadow-sm">
        <i class="fa-solid fa-plus me-2"></i> Create
    </a>

</div>


                <!-- POST TABLE -->
                @if ($post->count())
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-primary fw-bold text-center">ID</th>
                                <th class="text-primary fw-bold text-center">Name</th>
                                <th class="text-primary fw-bold text-center">Topic</th>
                                <th class="text-primary fw-bold text-center">Date</th>
                                <th class="text-primary fw-bold text-center">Saved</th>
                                <th class="text-primary fw-bold text-center">Content</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($post as $p)
                            <tr id="post-{{ $p->id }}" class="{{ $p->approved ? '' : 'bg-warning text-dark' }}">
                                <td class="fw-semibold text-center">{{ $p->id }}</td>
                                <td class="fw-semibold text-center">{{ $p->admin_name }}</td>
                                <td class="fw-semibold text-center">{{ $p->topic_name }}</td>
                                <td class="fw-semibold text-center">{{ $p->created_at->format('F j, Y') }}</td>
                                <td class="fw-semibold text-center">
                                    <i class="fa-solid fa-bookmark me-2"></i>{{ $p->save_count }}
                                </td>
                                <td class="fw-semibold text-center">
                                    @if ($p->approved)
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="fw-semibold text-center">
                                    <div class="d-flex justify-content-center justify-content-md-end gap-2">
                                        <a href="{{ route('post#view', $p->id) }}" class="btn btn-sm bg-white text-primary shadow-sm">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('post#editPage', $p->id) }}" class="btn btn-sm bg-white text-primary shadow-sm">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <!-- Approve Button with Confirmation -->
                                        @if (!$p->approved)
                                        <button class="btn btn-sm btn-success shadow-sm btn-approve" data-id="{{ $p->id }}">
                                            <i class="fa-solid fa-check"></i> Approve
                                        </button>
                                        @endif

                                        <!-- Delete Button -->
                                        <button class="btn btn-sm btn-danger shadow-sm btn-delete" data-id="{{ $p->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>


                    </table>
                </div>

                @else
                <h3 class="text-primary text-center mt-4">
                    There's no post to show! <i class="fa-solid fa-face-frown-open ms-2"></i>
                </h3>
                @endif

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $post->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->

<!-- DELETE CONFIRMATION -->
@section('scriptSource')
<script>
    // Delete Post with Instant UI Update
    $('.btn-delete').click(function() {
        let button = $(this);
        let post_id = button.data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This post will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: '/admin/post/delete',
                    data: { post_id: post_id },
                    success: function() {
                        Swal.fire('Deleted!', 'Post has been removed.', 'success')
                        .then(() => $('#post-' + post_id).fadeOut(500, function() { $(this).remove(); }));
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

      // ✅ Approve Post with Confirmation
      $('.btn-approve').click(function() {
    let button = $(this);
    let post_id = button.data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to approve this post?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: '/admin/post/approve/' + post_id,
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    Swal.fire('Approved!', 'The post has been approved.', 'success')
                    .then(() => location.reload()); // Refresh the page
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire('Error!', 'Something went wrong. Check the console.', 'error');
                }
            });
        }
    });
});
</script>


@endsection

@if (session('createMessage'))
    @section('scriptSource')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('createMessage') }}',
                showConfirmButton: true,
            }).then(() => location.reload());
        </script>
    @endsection
@endif

@if (session('editMessage'))
    @section('scriptSource')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('editMessage') }}',
                showConfirmButton: true,
            }).then(() => location.reload());
        </script>
    @endsection
@endif

@endsection
