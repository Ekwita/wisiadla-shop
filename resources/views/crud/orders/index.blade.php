<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Orders List
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @foreach ($orders as $order)
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-600 text-gray-200">
                            <tr>
                                <th class="px-6 py-4 whitespace-nowrap">
                                    Order #
                                </th>
                                <th class="px-6 py-4 whitespace-nowrap">
                                    Buyer
                                </th>
                                <th class="px-6 py-4 whitespace-nowrap">
                                    Status
                                </th>
                                <th class="px-6 py-4 whitespace-nowrap">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('orders.status.update', ['order' => $order]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" id="status">
                                            @foreach ($order->statusChange() as $status)
                                                <option value="{{ $status }}"
                                                    @if ($status == $order->status) selected @endif>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit"
                                            class="bg-gray-800 hover:bg-gray-400 text-white font-bold py-2 px-4 rounded ml-2">
                                            Update Status
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Add any additional actions here -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Display order items -->
                    <table class="w-full mt-4 divide-y divide-gray-200">
                        <thead class="bg-gray-200 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Picture
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total price
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ asset('storage/' . $item->product->image_path_main) }}"
                                            alt="{{ $item->product->name }}" class="h-10 w-10">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->total_price }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-right pr-6 py-4">Total:</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->total_price }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            </div>
            <div class="p-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
