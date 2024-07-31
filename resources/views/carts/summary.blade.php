<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Order Summary
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold mb-4">Order Summary</h1>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold mb-2">Customer Information:</h2>
                    <div>
                        {{ $user->name }} <br>
                        Street: {{ $address->street }} <br>
                        City: {{ $address->city }} <br>
                        State: {{ $address->state }} <br>
                        Postal Code: {{ $address->postal_code }} <br>
                        Country: {{ $address->country }} <br>
                    </div>
                </div>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold mb-2">Cart Contents:</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $totalPrice = 0;
                                @endphp
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->product->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->product->price }}</td>
                                    </tr>
                                    @php
                                        $totalPrice += $item->quantity * $item->product->price;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold" colspan="2">Total Price:</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold"> XYZ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <form action="{{ route('order.create') }}" method="post">
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Confirm Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
