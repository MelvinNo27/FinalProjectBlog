@extends('admin.layout.master')

@section('title', 'Topic List')

@section('content')

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">

                <!-- SEARCH BAR -->
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <form action="{{ route('topic#listPage') }}" method="get" class="w-100">
                        <div class="input-group shadow-sm">
                            <button type="submit" class="input-group-text btn">
                                <i class="fa-regular fa-magnifying-glass fw-semibold text-primary"></i>
                            </button>
                            <input name="searchKey" value="{{ request('searchKey') }}" type="text"
                                   class="form-control" placeholder="Search for topic name">
                        </div>
                    </form>
                </div>

                <!-- FILTER, CREATE, COUNT (Now below Search Bar) -->
                <div class="d-flex flex-wrap gap-3 mt-3 justify-content-start">

                    <!-- Filter Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-lg bg-white text-primary dropdown-toggle shadow-sm"
                                type="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-arrow-up-z-a me-2 text-primary"></i> Filter
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('topic#listPage') }}">Newest First</a></li>
                            <li><a class="dropdown-item" href="{{ route('topic#filterAsc') }}">Oldest First</a></li>
                        </ul>
                    </div>

                    <!-- Topic Count -->
                    <button type="button" class="btn btn-lg bg-white shadow-sm">
                        <i class="fa-solid fa-table-list me-2 text-primary fw-bold"></i>
                        <span class="badge p-2 text-bg-primary">{{ $topic->total() }}</span>
                    </button>

                    <!-- Create Button -->
                    <a href="{{ route('topic#createPage') }}" class="btn btn-lg bg-white text-primary shadow-sm">
                        <i class="fa-solid fa-plus me-2"></i> Create
                    </a>

                </div>

                <!-- TOPIC TABLE -->
                @if ($topic->count())
                <div class="table-responsive mt-3">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-primary fw-bold text-center">ID</th>
                                <th class="text-primary fw-bold text-center">Name</th>
                                <th class="text-primary fw-bold text-center">Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($topic as $t)
                            <tr>
                                <td class="fw-semibold text-center">{{ $t->id }}</td>
                                <td class="fw-semibold text-center">{{ $t->name }}</td>
                                <td class="fw-semibold text-center">{{ $t->created_at->format('F j, Y') }}</td>
                                <td class="fw-semibold text-center">
                                    <div class="d-flex justify-content-center justify-content-md-end gap-2">
                                        <a href="{{ route('topic#editPage', $t->id) }}" class="btn btn-sm bg-white text-primary shadow-sm">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger btn-delete shadow-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" class="topic-id" value="{{ $t->id }}">
                                </td>
                            </tr>
                            <tr class="spacer"></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @else
                <h3 class="text-primary text-center mt-4">
                    There's no topic to show! <i class="fa-solid fa-face-frown-open ms-2"></i>
                </h3>
                @endif

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $topic->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->

<!-- DELETE CONFIRMATION -->
@section('scriptSource')
<script>
    $('.btn-delete').click(function() {
        let topicRow = $(this).closest('tr');
        let topicID = topicRow.find('.topic-id').val();

        Swal.fire({
            title: 'Are you sure?',
            text: "This topic will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: '/admin/topic/delete',
                    data: { topic_id: topicID },
                    dataType: 'json',
                    success: function() {
                        Swal.fire('Deleted!', 'Topic has been removed.', 'success')
                        .then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
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
