<body class="bg-gray-100 p-4">
    <div class="bg-white rounded-lg p-6 max-w-lg mx-auto shadow-md">
        <h2 class="text-2xl font-bold text-gray-800">Hello, {{ $user->name }}!</h2>
        <p class="text-gray-600 mt-4">Thank you for ordering these items!</p>
        <table class="w-full mt-6 border-collapse">
            <thead>
                <tr>
                    <th class="text-left border-b-2 pb-2 text-gray-700">Product</th>
                    <th class="text-left border-b-2 pb-2 text-gray-700">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td class="py-2 border-b border-gray-200">{{ $item->product->name }}</td>
                        <td class="py-2 border-b border-gray-200">{{ $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
