<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mihi Photography</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    @stack('styles')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/Red and Black Modern Photography Logo.png') }}" alt="logo">
            </a>
        </div>
        <div class="navbar-center">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('album') }}">Album</a></li>
                <li><a href="{{ route('booking.index') }}">Booking</a></li>
                <li><a href="{{ route('aboutpage') }}">About</a></li>
                <li><a href="{{ route('contact.show') }}">Contact</a></li>
            </ul>
        </div>
        <div class="navbar-right">
            <div class="search-container">
                <input type="text" placeholder="Search..." class="search-input">
                <button type="submit" class="search-button">Search</button>
            </div>

            <ul class="navbar-nav" style="flex-direction: row; align-items: center; gap: 10px;">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="button" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="button" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="button">Logout</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>

    <div class="content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 20px auto; max-width: 800px;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 20px auto; max-width: 800px;">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="footer">
        <div class="footer-content">
            <h3>MIHI PHOTOGRAPHY</h3>
            <p class="footer-tagline">We're here to assist you with your inquiries.</p>
            <div class="footer-contact-info">
                <span class="phone-number">📞 0719567512</span>
                <span class="address">📍 258/1 , Kottawa , Sri Lanka</span>
            </div>
            <hr class="footer-divider">
            <p class="footer-copyright">&copy; {{ date('Y') }} Mihi Photography. All Rights Reserved.</p>
            <p class="footer-website-by">A Website by Inside Space</p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });
            }, 3000);

            setTimeout(function() {
                $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });
            }, 5000);
        });
    </script>
    @stack('scripts')
</body>
</html>