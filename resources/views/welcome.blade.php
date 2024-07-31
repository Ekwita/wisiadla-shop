<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wisiadła.pl</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Styles -->
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</head>

<body id ="app" class="font-sans antialiased bg-gray-50">
    <header class="bg-gray-300 py-2 mb-6 rounded-lg">
        <div class="container mx-auto flex justify-between">
            <div>
                <form action="{{ route('shop.search') }}" method="GET" class="flex">
                    <input type="text" name="query" placeholder="Search..."
                        class="border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200 px-3 py-1">
                    <button type="submit" class="bg-gray-600 text-white px-4 py-1 ml-2 rounded">Search</button>
                </form>
            </div>
            <div>
                <a href="{{ route('cart.index') }}" class=""><img
                        src="{{ asset('build/assets/images/cart-icon.png') }}" alt="" class="h-6 w-auto"></a>
            </div>
            @if (Route::has('login'))
                <nav>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-link">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    @if (session('status') === 'added')
        <div class="container mx-auto py-2 bg-green-200 dark:bg-green-600">
            <p class="text-sm text-green-800 dark:text-green-200">{{ __('Product added to cart.') }}</p>
            <div class="flex justify-between mt-2">
                <a href="{{ route('cart.index') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded">Go to cart</a>
            </div>
        </div>
    @endif
    @if (session('status') === 'quantity_error')
        <div class="container mx-auto py-2 bg-red-200 dark:bg-red-600">
            <p class="text-sm text-green-800 dark:text-green-200">
                {{ __('The number of products added to the cart exceeds the stock.') }}</p>
        </div>
    @endif

    <div class="container mx-auto flex mb-16"> <!-- Add margin-bottom to prevent footer overlap -->

        <!-- Category Menu -->
        <div class="w-1/4 bg-white p-6 rounded-lg mr-6">
            <h2 class="text-lg font-semibold mb-4">Categories</h2>
            <ul>
                @foreach ($categories as $category)
                    <li>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2">
                            <span>{{ $category->name }}</span>
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- Products -->
        <div class="w-3/4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $product)
                @if ($product->amount > 0)
                    <div class="bg-white rounded-lg p-6">
                        <a href="{{ route('products.show', $product->id) }}">
                            <div class="product-image">
                                <img src="{{ asset('storage/' . $product->image_path_main) }}" alt="Product Image">
                            </div>
                        </a>
                        <div class="product-details mt-4">
                            <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                            <p class="text-gray-700 mt-2">{{ $product->description }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-500">Price:</span>
                                    <span class="text-lg font-semibold ml-1">{{ $product->price }} PLN</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-500">Remain:</span>
                                    <span class="text-lg font-semibold ml-1">{{ $product->amount }} szt.</span>
                                </div>
                            </div>
                            <div class="mt-4"> <!-- Add margin-top to space out the form -->
                                <form action="{{ route('cart.store', ['product' => $product->id]) }}" method="POST">
                                    @csrf
                                    <input type="number" name="quantity" value="1" min="1"
                                        max="{{ $product->amount }}"
                                        class="border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                                    <button
                                        class="bg-orange-500 text-white px-4 py-2 rounded transition duration-300 ease-in-out hover:bg-orange-600">Add
                                        to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-lg p-6 filter grayscale">
                        <a href="{{ route('products.show', $product->id) }}">
                            <div class="product-image">
                                <img src="{{ asset('storage/' . $product->image_path_main) }}" alt="Product Image">
                            </div>
                        </a>
                        <div class="product-details mt-4">
                            <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                            <p class="text-gray-700 mt-2">{{ $product->description }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-500">Price:</span>
                                    <span class="text-lg font-semibold ml-1">{{ $product->price }} PLN</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-500">Remain:</span>
                                    <span class="text-lg font-semibold ml-1">{{ $product->amount }} szt.</span>
                                </div>
                            </div>
                            <div class="text-red-500 text-sm mt-2">
                                This product is currently unavailable.
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <footer class="relative bottom-0 w-full bg-gray-300 py-4"> <!-- Change fixed to relative -->
        <div class="container mx-auto flex justify-between items-center">
            <div>&copy; 2024 Wisiadła.pl. All rights reserved.</div>
            <div class="flex space-x-4 items-center">
                <a href="https://www.instagram.com/wisiadla/" class="text-gray-700 hover:text-gray-900">
                    <img src="{{ asset('build/assets/images/Instagram_simple_icon.svg.png') }}" alt="I"
                        class="h-6 w-auto">
                </a>
                <a href="https://www.facebook.com/wisiadla/" class="text-gray-700 hover:text-gray-900">
                    <img src="{{ asset('build/assets/images/facebook_Icon.png') }}" alt="fb"
                        class="h-6 w-auto">
                </a>
                <a href="/contact" class="text-gray-700 hover:text-gray-900">Contact</a>
                <a href="/terms" class="text-gray-700 hover:text-gray-900">Terms</a>
            </div>
        </div>
    </footer>
</body>

</html>
