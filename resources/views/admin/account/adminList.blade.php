@extends('admin.layout.master')

@section('title', 'Admin Account List')

@section('content')

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">

                <!-- SEARCH BAR -->
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3">
                    <form action="{{ route('admin#adminAccountList') }}" method="get" class="w-100">
                        <div class="input-group shadow-sm">
                            <button type="submit" class="input-group-text btn">
                                <i class="fa-regular fa-magnifying-glass fw-semibold text-primary"></i>
                            </button>
                            <input name="searchKey" value="{{ request('searchKey') }}" type="text"
                                   class="form-control" placeholder="Search admin">
                        </div>
                    </form>
                </div>

                <!-- ADMIN COUNT (Now Below Search Bar) -->
                <div class="mt-3">
                    <button type="button" class="btn btn-lg bg-white shadow-sm">
                        <i class="fa-solid fa-user-shield me-2 text-primary fw-bold"></i>
                        <span class="badge p-2 text-bg-primary">{{ count($accounts) }}</span>
                    </button>
                </div>

                <!-- ADMIN TABLE -->
                @if (count($accounts) > 0)
                <div class="table-responsive mt-3">
                    <table class="table table-hover table-striped text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                        @foreach ($accounts as $account)
                        <tr id="admin-{{ $account->id }}">
                            <td>
                                <div class="mx-auto" style="width: 60px; height: 60px; overflow: hidden;">
                                    @if ($account->image)
                                        <img src="{{ asset('storage/'.$account->image) }}"
                                             class="w-100 h-100 img-thumbnail rounded-circle" alt="" />
                                    @else
                                        <img class="w-100 h-100 img-thumbnail rounded-circle"
                                             src="https://ui-avatars.com/api/?name={{ $account->name }}" />
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle">{{ $account->name }}</td>
                            <td class="align-middle">{{ $account->email }}</td>
                            <td class="align-middle">{{ $account->gender }}</td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-center gap-2">
                                    @if ($account->id != Auth::user()->id)
                                        <!-- Demote Admin -->
                                        <button class="btn btn-sm btn-warning shadow-sm demote-admin"
                                                data-id="{{ $account->id }}">
                                            <i class="fa-solid fa-user-minus"></i>
                                        </button>

                                        <!-- Delete Admin -->
                                        <button class="btn btn-sm btn-danger shadow-sm delete-admin"
                                                data-id="{{ $account->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    @else
                                        <button type="button" class="btn btn-sm bg-secondary text-white shadow-sm">
                                            <i class="fa-solid fa-user-shield"></i>
                                            <span class="badge text-bg-light">Me</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @else
                <h3 class="text-secondary text-center mt-4">
                    There's no admin account to show!
                    <i class="fa-solid fa-face-frown-open ms-2"></i>
                </h3>
                @endif

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $accounts->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->

@endsection

@section('scriptSource')
<script>
    // Delete Admin Account - Instant UI Update
    $('.delete-admin').click(function() {
        let button = $(this);
        let admin_id = button.data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This admin and all their posts will be deleted forever!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: '/admin/account/delete/' + admin_id,
                    success: function() {
                        Swal.fire(
                            'Deleted!',
                            'Admin account has been removed.',
                            'success'
                        );
                        $('#admin-' + admin_id).fadeOut(500, function() { $(this).remove(); });
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

    // Demote Admin to User - No Refresh Needed
    $('.demote-admin').click(function() {
        let button = $(this);
        let admin_id = button.data('id');

        Swal.fire({
            title: 'Demote Admin?',
            text: "Are you sure you want to remove admin privileges from this user?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, demote!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: '/admin/account/change/userRole/' + admin_id,
                    success: function(response) {
                        Swal.fire(
                            'Success!',
                            'Admin has been demoted to a regular user.',
                            'success'
                        );

                        // Update UI Without Refreshing
                        let parentRow = button.closest('tr');
                        button.remove(); // Remove demotion button
                        parentRow.find('.role-badge').text('User'); // Update the role text
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
