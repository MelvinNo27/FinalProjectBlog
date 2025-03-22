@extends('admin.layout.master')

@section('title', 'Feedback Messages')

@section('content')

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">

                <!-- SEARCH BAR -->
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3">
                    <form action="{{ route('admin#feedbackPage') }}" method="get" class="w-100">
                        <div class="input-group shadow-sm">
                            <button type="submit" class="input-group-text btn">
                                <i class="fa-regular fa-magnifying-glass fw-semibold text-primary"></i>
                            </button>
                            <input name="searchKey" value="{{ request('searchKey') }}" type="text"
                                   class="form-control" placeholder="Search name">
                        </div>
                    </form>
                </div>

                <!-- FEEDBACK COUNT & DELETE ALL (Now Below Search Bar) -->
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-3">
                    <button type="button" class="btn btn-lg bg-white shadow-sm">
                        <i class="fa-solid fa-envelope me-2 text-primary fw-bold"></i>
                        <span class="badge p-2 text-bg-primary">{{ $message->total() }}</span>
                    </button>

                    <button class="btn btn-lg btn-danger shadow-sm delete-message-all">
                        <i class="fa-solid fa-trash me-2"></i> Delete All
                    </button>
                </div>

                <!-- MESSAGE TABLE -->
                @if ($message->count() > 0)
                <div class="table-responsive mt-3">
                    <table class="table table-hover table-striped text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                        @foreach ($message as $m)
                        <tr id="message-{{ $m->id }}">
                            <td class="align-middle">{{ $m->id }}</td>
                            <td class="align-middle">{{ $m->name }}</td>
                            <td class="align-middle">{{ $m->email }}</td>
                            <td class="align-middle">{{ $m->subject }}</td>
                            <td class="align-middle">{{ Str::words($m->message, 5, '...') }}</td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- View Message -->
                                    <a href="{{ route('admin#feedbackView', $m->id) }}" class="btn btn-sm btn-light shadow-sm">
                                        <i class="fa-solid fa-eye text-primary"></i>
                                    </a>

                                    <!-- Delete Message -->
                                    <button class="btn btn-sm btn-danger shadow-sm delete-message"
                                            data-id="{{ $m->id }}">
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
                <h3 class="text-secondary text-center mt-4">
                    There's no message to show!
                    <i class="fa-solid fa-face-frown-open ms-2"></i>
                </h3>
                @endif

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $message->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->

@endsection

@section('scriptSource')

<script>
    // Delete Single Message with Instant UI Update
    $('.delete-message').click(function() {
        let button = $(this);
        let message_id = button.data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This message will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: '/admin/feedback/delete',
                    data: { message_id: message_id },
                    success: function() {
                        Swal.fire('Deleted!', 'Message has been removed.', 'success');
                        $('#message-' + message_id).fadeOut(500, function() { $(this).remove(); });
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

    // Delete All Messages with Instant UI Update
    $('.delete-message-all').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "All messages will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete all!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: '/admin/feedback/delete/all',
                    success: function() {
                        Swal.fire('Deleted!', 'All messages have been removed.', 'success');
                        $('tbody').fadeOut(500, function() { $(this).empty(); });
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
