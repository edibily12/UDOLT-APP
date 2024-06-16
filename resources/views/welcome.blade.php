<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="icon" type="icon" href="assets/images/favicon.png" />
    <title>{{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Styles -->
    @livewireStyles
</head>

<body>
@use('\Illuminate\Support\Facades\Storage')
<header class="bg-gray-dark sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center py-4">
        <!-- Left section: Logo -->
        <div class="flex items-center">
            <img src="{{ Storage::url('files/images/logo.png') }}" alt="Logo" class="h-14 w-auto mr-4">
        </div>

        <!-- Hamburger menu (for mobile) -->
        <div class="flex md:hidden">
            <button id="hamburger" class="text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>

        <!-- Center section: Menu -->
        <nav class="hidden md:flex md:flex-grow justify-center">
            <ul class="flex justify-center space-x-4 text-white">
                <li><a href="#home" class="hover:text-secondary font-bold">Home</a></li>
                <li><a href="#aboutus" class="hover:text-secondary font-bold">About us</a></li>
                <li><a href="#reviews" class="hover:text-secondary font-bold">Reviews</a></li>
                <li><a href="#contact" class="hover:text-secondary font-bold">Contact</a></li>
            </ul>
        </nav>

        <!-- Right section: Buttons (for desktop) -->
        <div class="hidden lg:flex items-center space-x-4">
            <a href="{{ route('login') }}" class="bg-secondary hover:bg-primary text-white font-semibold px-4 py-2 rounded inline-block">Log In</a>
            <a href="{{ route('register') }}" class="bg-primary hover:bg-secondary text-white font-semibold px-4 py-2 rounded inline-block">Sign Up</a>
        </div>
    </div>
</header>
<!-- Mobile menu -->
<nav id="mobile-menu-placeholder" class="mobile-menu hidden flex flex-col items-center space-y-8 md:hidden">
    <ul>
        <li><a href="#home" class="hover:text-secondary font-bold">Home</a></li>
        <li><a href="#aboutus" class="hover:text-secondary font-bold">About us</a></li>
        <li><a href="#reviews" class="hover:text-secondary font-bold">Reviews</a></li>
        <li><a href="#contact" class="hover:text-secondary font-bold">Contact</a></li>
    </ul>
    <div class="flex flex-col mt-6 space-y-2 items-center">
        <a href="{{ route('login') }}" class="bg-secondary hover:bg-primary text-white font-semibold px-4 py-2 rounded inline-block flex items-center justify-center min-w-[110px]">Log In</a>
        <a href="{{ route('register') }}" class="bg-primary hover:bg-secondary text-white font-semibold px-4 py-2 rounded inline-block flex items-center justify-center min-w-[110px]">Sign Up</a>
    </div>
</nav>

<section id="home" class="bg-white py-16">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between">
        <!-- Left column: Description and buttons -->
        <div class="md:w-1/2 text-center md:text-left mb-8 md:mb-0">
            <h2 class="text-5xl font-bold mb-4">Welcome To <span class="text-primary">UDOLT</span> App</h2>
            <p class="my-7">
                Welcome to UDOLT – your campus transportation solution! We’re excited to enhance mobility within Dodoma University. With our app, intelligent route planning, and reliable services, traveling the campus is effortless. Sit back and enjoy the ride with UDOLT. Welcome aboard!
            </p>
            <div class="space-x-2">
                <a href="{{ route('login') }}" class="bg-secondary hover:bg-primary text-white font-semibold px-4 py-2 rounded inline-block">Log In</a>
                <a href="{{ route('register') }}" class="bg-primary hover:bg-secondary text-white font-semibold px-4 py-2 rounded inline-block">Sign Up</a>
            </div>
        </div>

        <!-- Right column: Responsive image -->
        <div class="md:w-1/2">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide flex flex-col space-y-4">
                        <img src="{{ Storage::url('files/images/bike/bike1.jpg') }}" alt="Image" class="w-full md:mx-auto md:max-w-md" />
                        <h3 class="text-lg font-medium text-gray-700 text-primary">
                        </h3>
                    </div>

                    <div class="swiper-slide flex flex-col space-y-4">
                        <img src="{{ Storage::url('files/images/bike/bike2.jpg') }}" alt="Image" class="w-full md:mx-auto md:max-w-md" />
                        <h3 class="text-lg font-medium text-gray-700 text-primary">
                        </h3>
                    </div>
                    <div class="swiper-slide flex flex-col space-y-4">
                        <img src="{{ Storage::url('files/images/bike/bike3.jpg') }}" alt="Image" class="w-full  md:mx-auto md:max-w-md" />
                        <h3 class="text-lg font-medium text-gray-700 text-primary">
                        </h3>
                    </div>
                </div>
                {{--                 <div class="swiper-button-prev"></div> --}}
                {{--                 <div class="swiper-button-next"></div> --}}
            </div>
        </div>
    </div>
</section>

<section id="aboutus" class="py-16 bg-gray-dark">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between">
        <!-- Left column: Image -->
        <div class="md:w-1/2 mb-8 md:mb-0">
            <img src="{{ Storage::url('files/images/2.png') }}" alt="Image" class="w-full md:mx-auto md:max-w-md" />
        </div>

        <!-- Right column: Title, description list, and button -->
        <div class="md:w-1/2">
            <h2 class="text-5xl font-bold mb-4 text-white">How We <span class="text-primary">Work</span></h2>
            <p class="my-5 text-white">
            </p>
            <ol class="mb-10 list-outside">
                <li class="flex items-center mb-4">
                    <strong class="bg-primary text-white rounded-full w-8 h-8 text-lg font-semibold flex items-center justify-center mr-3">1</strong>
                    <span class="text-white">
                        As UDOLT, we employ cutting-edge technology and intelligent algorithms to optimize campus transportation routes, ensuring timely and efficient travel for users.
                    </span>
                </li>
                <li class="flex items-center mb-4">
                    <strong class="bg-primary text-white rounded-full w-8 h-8 text-lg font-semibold flex items-center justify-center mr-3">2</strong>
                    <span class="text-white">
                         Our dedicated team monitors and evaluates system performance to maintain high standards of reliability and user satisfaction.
                    </span>
                </li>
                <li class="flex items-center mb-4">
                    <strong class="bg-primary text-white rounded-full w-8 h-8 text-lg font-semibold flex items-center justify-center mr-3">3</strong>
                    <span class="text-white">
                         With seamless booking and payment processes, eco-friendly options, and personalized experiences, UDOLT revolutionizes campus mobility, making every journey a smooth and enjoyable one.
                    </span>
                </li>
            </ol>
            <a href="{{ route('login') }}">
                <button class="bg-secondary hover:bg-primary text-white font-semibold px-4 py-2 rounded">Get Started</button>
            </a>
        </div>

    </div>
</section>

<section id="reviews" class="bg-white py-16 px-4">
    <div class="container mx-auto max-w-screen-xl px-4 testimonials">
        <div class="text-center mb-12 lg:mb-20">
            <h2 class="text-5xl font-bold mb-4 text-white">What Our Clients Say</h2>
            <p class="text-lg text-primary font-semibold">
                Discover the experiences of our satisfied clients
            </p>
        </div>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @php $messages =\App\Models\Message::orderByDesc('id')->limit(10)->get(); @endphp
                @foreach($messages as $message)
                    <div class="swiper-slide flex flex-col space-y-4">
                        <img class="w-20 h-20 rounded-full mx-auto object-cover" src="{{ Storage::url('files/images/logo.png') }}" alt="User Image">
                        <h3 class="text-lg font-medium text-gray-700 text-primary">{{ $message->name }}</h3>
                        <h6 class="text-base text-gray-500 max-w-[800px] text-white">
                            {{ $message->message }}
                        </h6>
                    </div>
                @endforeach

            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>

<section id="contact" class="bg-cover bg-no-repeat bg-center relative py-16 px-2">
    <div
            class="grid md:grid-cols-2 gap-16 items-center relative overflow-hidden p-10 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-3xl max-w-6xl mx-auto bg-white text-[#333] my-6 before:absolute before:right-0 before:w-[300px] before:bg-blue-400 before:h-full max-md:before:hidden">
        <div>
            <h2 class="text-5xl font-bold text-primary">Get In Touch</h2>
            <p class="text-gray-dark mt-5">
                Have a specific inquiry or looking to explore new opportunities? Our
                experienced team is ready to engage with you.
            </p>
            <!-- contact form -->
            <livewire:forms.contact-form />
            <ul class="mt-4 flex justify-center lg:space-x-6 max-lg:flex-col max-lg:items-center max-lg:space-y-2 ">
                <li class="flex items-center hover:text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill='currentColor'
                         viewBox="0 0 479.058 479.058">
                        <path
                                d="M434.146 59.882H44.912C20.146 59.882 0 80.028 0 104.794v269.47c0 24.766 20.146 44.912 44.912 44.912h389.234c24.766 0 44.912-20.146 44.912-44.912v-269.47c0-24.766-20.146-44.912-44.912-44.912zm0 29.941c2.034 0 3.969.422 5.738 1.159L239.529 264.631 39.173 90.982a14.902 14.902 0 0 1 5.738-1.159zm0 299.411H44.912c-8.26 0-14.971-6.71-14.971-14.971V122.615l199.778 173.141c2.822 2.441 6.316 3.655 9.81 3.655s6.988-1.213 9.81-3.655l199.778-173.141v251.649c-.001 8.26-6.711 14.97-14.971 14.97z"
                                data-original="#006BFD" />
                    </svg>
                    <a href="javascript:void(0)" class="text-current text-sm ml-3">
                        <strong>info@udolt.com</strong>
                    </a>
                </li>
                <li class="flex items-center text-current hover:text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill='currentColor'
                         viewBox="0 0 482.6 482.6">
                        <path
                                d="M98.339 320.8c47.6 56.9 104.9 101.7 170.3 133.4 24.9 11.8 58.2 25.8 95.3 28.2 2.3.1 4.5.2 6.8.2 24.9 0 44.9-8.6 61.2-26.3.1-.1.3-.3.4-.5 5.8-7 12.4-13.3 19.3-20 4.7-4.5 9.5-9.2 14.1-14 21.3-22.2 21.3-50.4-.2-71.9l-60.1-60.1c-10.2-10.6-22.4-16.2-35.2-16.2-12.8 0-25.1 5.6-35.6 16.1l-35.8 35.8c-3.3-1.9-6.7-3.6-9.9-5.2-4-2-7.7-3.9-11-6-32.6-20.7-62.2-47.7-90.5-82.4-14.3-18.1-23.9-33.3-30.6-48.8 9.4-8.5 18.2-17.4 26.7-26.1 3-3.1 6.1-6.2 9.2-9.3 10.8-10.8 16.6-23.3 16.6-36s-5.7-25.2-16.6-36l-29.8-29.8c-3.5-3.5-6.8-6.9-10.2-10.4-6.6-6.8-13.5-13.8-20.3-20.1-10.3-10.1-22.4-15.4-35.2-15.4-12.7 0-24.9 5.3-35.6 15.5l-37.4 37.4c-13.6 13.6-21.3 30.1-22.9 49.2-1.9 23.9 2.5 49.3 13.9 80 17.5 47.5 43.9 91.6 83.1 138.7zm-72.6-216.6c1.2-13.3 6.3-24.4 15.9-34l37.2-37.2c5.8-5.6 12.2-8.5 18.4-8.5 6.1 0 12.3 2.9 18 8.7 6.7 6.2 13 12.7 19.8 19.6 3.4 3.5 6.9 7 10.4 10.6l29.8 29.8c6.2 6.2 9.4 12.5 9.4 18.7s-3.2 12.5-9.4 18.7c-3.1 3.1-6.2 6.3-9.3 9.4-9.3 9.4-18 18.3-27.6 26.8l-.5.5c-8.3 8.3-7 16.2-5 22.2.1.3.2.5.3.8 7.7 18.5 18.4 36.1 35.1 57.1 30 37 61.6 65.7 96.4 87.8 4.3 2.8 8.9 5 13.2 7.2 4 2 7.7 3.9 11 6 .4.2.7.4 1.1.6 3.3 1.7 6.5 2.5 9.7 2.5 8 0 13.2-5.1 14.9-6.8l37.4-37.4c5.8-5.8 12.1-8.9 18.3-8.9 7.6 0 13.8 4.7 17.7 8.9l60.3 60.2c12 12 11.9 25-.3 37.7-4.2 4.5-8.6 8.8-13.3 13.3-7 6.8-14.3 13.8-20.9 21.7-11.5 12.4-25.2 18.2-42.9 18.2-1.7 0-3.5-.1-5.2-.2-32.8-2.1-63.3-14.9-86.2-25.8-62.2-30.1-116.8-72.8-162.1-127-37.3-44.9-62.4-86.7-79-131.5-10.3-27.5-14.2-49.6-12.6-69.7z"
                                data-original="#006BFD"></path>
                    </svg>
                    <a href="javascript:void(0)" class="text-current text-sm ml-3">
                        <strong>0764 175 337</strong>
                    </a>
                </li>
            </ul>
        </div>
        <div class="z-10 relative h-full max-md:min-h-[350px]">
            <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD94Nn1uj4OJxhpy7UPW6vFp-xAPj9TqR0&q=CIVE"
                    class="left-0 top-0 h-full w-full rounded-t-lg lg:rounded-tr-none lg:rounded-bl-lg" frameborder="0"
                    allowfullscreen></iframe>
        </div>
    </div>
</section>

<footer class="bg-gray-dark text-white py-16">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- First column: About Us -->
        <div class="text-center md:text-left">
            <h3 class="text-lg font-bold mb-4">About Us</h3>
            <ul class="space-y-2">
                <li>
                    <a href="#aboutus" class="hover:text-secondary font-bold">About Our Company</a>
                </li>
                <li>
                    <a href="#reviews" class="hover:text-secondary font-bold">Reviews</a>
                </li>
            </ul>
        </div>

        <!-- Second column: Services -->
        <div class="text-center md:text-left">
            <h3 class="text-lg font-bold mb-4">Services</h3>
            <ul class="space-y-2">
                <li>
                    <a href="#home" class="hover:text-secondary font-bold">Transportation</a>
                </li>
            </ul>
        </div>

        <!-- Third column: Contact Us -->
        <div class="text-center md:text-left">
            <h3 class="text-lg font-bold mb-4">Contact Us</h3>
            <ul class="space-y-2">
                <li><a href="#contact" class="hover:text-secondary font-bold">Contact Information</a></li>
            </ul>
        </div>

        <!-- Fourth column: Logo -->
        <div class="flex flex-col items-center md:items-center">
            <!-- Logo -->
            <img src="{{ Storage::url('files/images/logo.png') }}" alt="Logo" class="h-14 w-auto mb-4">
            <p>Developed & Maintained by <a href="https://www.udom.ac.tz/" class="text-primary hover:text-secondary font-bold">UDOM-Students</a>
        </div>
    </div>
</footer>
@livewireScripts

@stack('scripts')
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>