<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Photography Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            display: flex; /* Flexbox for sidebar and content */
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        #admin-sidebar {
            width: 250px; /* Sidebar width */
            background-color: #343a40; /* Dark background */
            color: #fff;
            padding: 20px;
            flex-shrink: 0; /* Prevent sidebar from shrinking */
            position: sticky; /* Make it sticky */
            top: 0; /* Stick to the top */
            left: 0;
            height: 100vh; /* Full viewport height */
            overflow-y: auto; /* Enable scrolling for long content */
            display: flex; /* Add flexbox to organize content vertically */
            flex-direction: column; /* Stack children vertically */
        }
        #admin-sidebar .sidebar-heading {
            font-size: 1.5rem;
            margin-bottom: 30px;
            text-align: center;
            color: #fff;
        }
        #admin-sidebar .nav-link {
            color: #ced4da; /* Light gray link color */
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 8px;
            transition: all 0.3s ease; /* Smooth transition for hover effects */
            display: flex;
            align-items: center; /* Align icon and text vertically */
        }
        #admin-sidebar .nav-link:hover {
            background-color: #495057; /* Slightly lighter on hover */
            color: #fff;
        }
        #admin-sidebar .nav-link.active {
            background-color: #0d6efd; /* Bootstrap primary color for active link */
            color: #fff;
            font-weight: bold;
        }
        #admin-sidebar .nav-link i {
            margin-right: 10px; /* Space between icon and text */
            font-size: 1.1rem;
        }
        /* Collapse/Dropdown specific styles */
        #admin-sidebar .nav-item .collapse .collapse-inner {
            background-color: #2b3035; /* Darker background for collapsed items */
            border-radius: 0.25rem;
            margin-top: 5px;
            padding: 10px 0;
        }
        #admin-sidebar .nav-item .collapse .collapse-inner .collapse-item {
            padding: 8px 15px 8px 30px; /* Indent collapsed items */
            color: #ced4da;
            display: block;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        #admin-sidebar .nav-item .collapse .collapse-inner .collapse-item:hover {
            background-color: #495057;
            color: #fff;
        }
        #admin-sidebar .nav-item .collapse .collapse-inner .collapse-item.active {
            font-weight: bold;
            color: #0d6efd; /* Active color for sub-items */
        }
        #admin-sidebar .sidebar-heading.sub-heading {
            font-size: 0.85rem;
            color: #adb5bd;
            padding: 0 15px;
            margin-top: 15px;
            margin-bottom: 5px;
            text-align: left;
        }

        #admin-content {
            flex-grow: 1; /* Main content takes remaining space */
            padding: 20px;
        }
        .navbar-admin {
            background-color: #343a40; /* Top navbar color */
            color: #fff;
            padding: 10px 20px;
            margin-bottom: 20px; /* Space below navbar */
            border-bottom: 1px solid #495057;
            display: flex; /* For alignment of items */
            justify-content: space-between; /* Space out items */
            align-items: center; /* Vertically center items */
        }
        .navbar-admin .navbar-brand {
            color: #fff;
            font-weight: bold;
        }
        .navbar-admin .nav-item .nav-link {
            color: #fff;
        }
        /* New style for the bottom logout section */
        #admin-sidebar .sidebar-bottom {
            margin-top: auto; /* Push the logout section to the bottom */
            padding-top: 20px; /* Add some space above it */
            border-top: 1px solid #495057; /* Optional: A separator line */
        }
        #admin-sidebar .sidebar-bottom .btn-logout {
            width: 100%; /* Full width button */
            background-color: #dc3545; /* Bootstrap red color */
            border-color: #dc3545;
            color: #fff;
            text-align: left; /* Align text to the left */
            padding: 10px 15px;
            display: flex;
            align-items: center;
            justify-content: flex-start; /* Align content to the start */
        }
        #admin-sidebar .sidebar-bottom .btn-logout:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        #admin-sidebar .sidebar-bottom .btn-logout i {
            margin-right: 10px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="admin-sidebar">
        <h3 class="sidebar-heading">Photography Admin</h3>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-list"></i> Categories
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.albums.*') ? 'active' : '' }}" href="#collapseAlbums" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('admin.albums.*') ? 'true' : 'false' }}" aria-controls="collapseAlbums">
                    <i class="fas fa-images"></i> Albums
                </a>
                <div class="collapse {{ Request::routeIs('admin.albums.*') ? 'show' : '' }}" id="collapseAlbums">
                    <ul class="nav flex-column collapse-inner">
                        <h6 class="sidebar-heading sub-heading">Album Options:</h6>
                        <li class="nav-item">
                            <a class="collapse-item nav-link {{ Request::routeIs('admin.albums.index') ? 'active' : '' }}" href="{{ route('admin.albums.index') }}">View All Albums</a>
                        </li>
                        <li class="nav-item">
                            <a class="collapse-item nav-link {{ Request::routeIs('admin.albums.create') ? 'active' : '' }}" href="{{ route('admin.albums.create') }}">Add New Album</a>
                        </li>
                        {{-- ඔබට අවශ්‍ය නම් Manage Album Photos සඳහා වෙනම direct link එකක් මෙහි දැමිය හැක,
                             නමුත් සාමාන්‍යයෙන් Album list එක හරහා යාම තමයි හොඳම පුරුද්ද. --}}
                    </ul>
                </div>
            </li>

            {{-- UPDATED: Bookings Link with Sub-menu for Upload Images --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.bookings.*') || Request::routeIs('admin.booking-images.*') ? 'active' : '' }}" href="#collapseBookings" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('admin.bookings.*') || Request::routeIs('admin.booking-images.*') ? 'true' : 'false' }}" aria-controls="collapseBookings">
                    <i class="fas fa-calendar-check"></i> Bookings
                </a>
                <div class="collapse {{ Request::routeIs('admin.bookings.*') || Request::routeIs('admin.booking-images.*') ? 'show' : '' }}" id="collapseBookings">
                    <ul class="nav flex-column collapse-inner">
                        <h6 class="sidebar-heading sub-heading">Booking Options:</h6>
                        <li class="nav-item">
                            <a class="collapse-item nav-link {{ Request::routeIs('admin.bookings.index') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">View All Bookings</a>
                        </li>
                        <li class="nav-item">
                            <a class="collapse-item nav-link {{ Request::routeIs('admin.bookings.upload-form') ? 'active' : '' }}" href="{{ route('admin.bookings.upload-form') }}">Upload Booking Images</a> {{-- NEW SUB-LINK --}}
                        </li>
                        {{-- ඔබට අවශ්‍ය නම් Manage Booking Images සඳහා වෙනම direct link එකක් මෙහි දැමිය හැක,
                             නමුත් සාමාන්‍යයෙන් Booking list එක හරහා යාම තමයි හොඳම පුරුද්ද. --}}
                    </ul>
                </div>
            </li>

            {{-- NEW: Customers Link --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.customers.*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
                    <i class="fas fa-users"></i> Customers
                </a>
            </li>

            {{-- ඔබට අවශ්‍ය නම් තවත් links මෙතනට එකතු කරන්න --}}
        </ul>

        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div id="admin-content">
        <nav class="navbar-admin">
            <span class="navbar-brand">Admin Panel</span>
            <ul class="navbar-nav d-flex flex-row align-items-center">
                <li class="nav-item me-3">
                    <span class="nav-link">Hello, {{ Auth::user()->name }}</span>
                </li>
            </ul>
        </nav>

        @yield('admin_content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>