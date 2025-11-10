<!DOCTYPE html>
<!-- MODIFIED: Added h-100 class -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- MODIFIED: Dynamic Title -->
        <title>@yield('title', 'Shop Zone - #No1 Shopping site')</title>

        <!-- 1. Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <!-- NEW: Bootstrap Icons for footer -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
        <!-- 2. Import Rubik Font from Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    
        <!-- 3. MODIFIED: Added styles for sticky footer & new footer -->
        <style>
            html {
                height: 100%;
            }
            body {
                font-family: 'Rubik', sans-serif;
                background-color: #f8f9fa; /* Light gray background for Bootstrap */
                /* Added for sticky footer */
                display: flex;
                flex-direction: column;
                min-height: 100vh; 
            }
            /* Added for sticky footer */
            #app {
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }
            /* Added for sticky footer */
            main {
                flex-grow: 1;
            }
            .card-img-top {
                aspect-ratio: 1 / 1; /* Makes images square */
                object-fit: cover; /* Prevents images from stretching */
            }
            .card-img-placeholder {
                aspect-ratio: 1 / 1;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #e9ecef;
                color: #6c757d;
            }

            /* NEW: Footer Styles */
            .footer-heading {
                color: #198754; /* CHANGED: Was #ffc107 (yellow), now green */
                font-weight: 600;
            }
            .footer-links li {
                margin-bottom: 0.5rem;
            }
            .footer-links a {
                color: rgba(255, 255, 255, 0.7);
                text-decoration: none;
                transition: color 0.2s ease-in-out;
            }
            .footer-links a:hover {
                color: #ffffff;
                text-decoration: none;
            }
            .social-icon {
                font-size: 1.5rem;
                color: rgba(255, 255, 255, 0.7);
                transition: color 0.2s ease-in-out;
            }
            .social-icon:hover {
                color: #ffffff;
            }
        </style>

        <!-- We keep your Vite scripts in case you use them elsewhere -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <!-- MODIFIED: Added classes for sticky footer -->
    <body class="d-flex flex-column">
        <!-- MODIFIED: Added classes for sticky footer -->
        <div id="app">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm">
                    <!-- Swapped Tailwind 'max-w-7xl' for Bootstrap 'container' -->
                    <div class="container py-3">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-4">
                <!-- This is where your @section('content') from 'index.blade.php' will go -->
                @yield('content')
            </main>
        </div>

        <!-- NEW FOOTER (User Requested Style) -->
        <footer class="bg-dark text-white pt-5 pb-4 mt-auto">
            <div class="container">
                <div class="row">

                    <!-- Column 1: About -->
                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                        <h5 class="footer-heading mb-3">About Shop zone</h5>
                        <p class="text-white-50">Your one-stop shop for everything. We are dedicated to providing the best products with the best service.</p>
                        <div class_ ="mt-4">
                            <a href="#" class="social-icon me-3"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="social-icon me-3"><i class="bi bi-github"></i></a>
                            <a href="#" class="social-icon"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>

                    <!-- Column 2: Quick Links -->
                    <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                        <h5 class="footer-heading mb-3">Quick Links</h5>
                        <ul class="list-unstyled footer-links">
                            <li><a href="{{ route('products.index') }}">Products</a></li>
                            <li><a href="{{ route('logout') }}">Log Out</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Column 3: Categories -->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="footer-heading mb-3">Categories</h5>
                        <!-- You can make this dynamic later if you want -->
                        <ul class="list-unstyled footer-links">
                            <li><a href="#">Electronics</a></li>
                            <li><a href="#">Fashion</a></li>
                            <li><a href="#">Home & Garden</a></li>
                            <li><a href="#">Vehicles</a></li>
                        </ul>
                    </div>

                    <!-- Column 4: Legal -->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="footer-heading mb-3">Legal</h5>
                        <ul class="list-unstyled footer-links">
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Service</a></li>
                        </ul>
                    </div>

                </div>
                
                <hr class="my-4" style="background-color: rgba(255,255,255,0.1);">

                <!-- Copyright -->
                <div class="text-center">
                    <p class="text-white-50 mb-0">&copy; {{ date('Y') }} Shop zone. All Rights Reserved.</p>
                </div>
            </div>
        </footer>
        <!-- END NEW FOOTER -->

        <!-- 4. Bootstrap JS (at the end of the body) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

