<body class="bg-gray-100 p-4">
    <div class="bg-white rounded-lg p-6 max-w-lg mx-auto shadow-md">
        <h2 class="text-2xl font-bold text-gray-800">Hello, {{ $user->name }}!</h2>
        <p class="text-gray-600 mt-4">
            Status of your order from {{ $order->created_at->format('d:m:Y') }} no. {{ $order->id }} has changed! The current status is: {{ $order->status }}.
        </p>
    </div>
</body>
