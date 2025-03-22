<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin Dashboard">
    <meta name="author" content="Your Name">
    <meta name="keywords" content="Admin, Dashboard, CMS">

    <!-- Title Page -->
    <title>@yield('title')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome & Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Styles -->
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Sidebar */
        .menu-sidebar {
            width: 250px;
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid #ddd;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            overflow-y: auto;
            z-index: 1050;
        }

        .menu-sidebar .nav-link {
            color: #333;
            padding: 10px;
            display: flex;
            align-items: center;
        }

        .menu-sidebar .nav-link i {
            margin-right: 10px;
        }

        /* Mobile Sidebar */
        @media (max-width: 991px) {
            .menu-sidebar {
                left: -250px;
                transition: all 0.3s ease-in-out;
            }

            .menu-sidebar.active {
                left: 0;
            }

            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                visibility: hidden;
                opacity: 0;
                transition: opacity 0.3s ease-in-out;
            }

            .mobile-overlay.active {
                visibility: visible;
                opacity: 1;
            }
        }

        /* Page Content */
        .page-container {
            margin-left: 250px;
            padding: 20px;
        }

        @media (max-width: 991px) {
            .page-container {
                margin-left: 0;
            }
        }

        /* Profile Section */
        .profile-section {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .profile-section .profile-info {
            text-align: center;
        }

        .profile-section img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center;
        }

        .profile-section .profile-name {
            font-weight: 600;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <!-- Mobile Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm d-lg-none">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" id="mobile-menu-btn">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand mx-auto" href="#">
                <img src="{{ asset('images/logo.png') }}" width="130px" alt="Logo">
            </a>
        </div>
    </nav>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay"></div>

    <!-- Sidebar -->
    <aside class="menu-sidebar">
        <div class="logo text-center">
            <a href="#">
                <img src="{{ asset('images/logo_dark.png') }}" width="150px" alt="Logo">
            </a>
        </div>
        <nav class="navbar-sidebar mt-4">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin#home') }}" class="nav-link"><i class="fa-solid fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('topic#listPage') }}" class="nav-link"><i class="fa-solid fa-table-list"></i> Topics</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('post#listPage') }}" class="nav-link"><i class="fa-solid fa-newspaper"></i> Posts</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin#adminAccountList') }}" class="nav-link"><i class="fa-solid fa-user-shield"></i> Admins</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin#userAccountList') }}" class="nav-link"><i class="fa-solid fa-user"></i> Users</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin#feedbackPage') }}" class="nav-link"><i class="fa-solid fa-envelope"></i> Feedbacks</a>
                </li>

                <!-- Profile Section -->
                <li class="profile-section">
                    <div class="profile-info">
                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}" alt="Profile">
                        <div class="profile-name">{{ Auth::user()->name }}</div>
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    </div>
                    <ul class="nav flex-column mt-2">
                        <li class="nav-item">
                            <a href="{{ route('admin#informationPage') }}" class="nav-link"><i class="fa-solid fa-user-secret"></i> Account</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin#changePasswordPage') }}" class="nav-link"><i class="fa-solid fa-key"></i> Change Password</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="post" class="px-3 mt-2">
                                @csrf
                                <button class="btn btn-danger w-100">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Page Content -->
    <div class="page-container">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Mobile Sidebar Toggle -->
    <script>
        $(document).ready(function () {
            $('#mobile-menu-btn').click(function () {
                $('.menu-sidebar, .mobile-overlay').toggleClass('active');
            });

            $('.mobile-overlay').click(function () {
                $('.menu-sidebar, .mobile-overlay').removeClass('active');
            });
        });
    </script>

    @yield('scriptSource')

</body>
</html>
