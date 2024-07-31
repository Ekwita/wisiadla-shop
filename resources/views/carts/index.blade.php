<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Cart') }}
        </h2>
    </x-slot>
    <div class="py-12 flex flex-col items-end"> <!-- Kontener dla tabeli i dodatkowej sekcji -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-full flex justify-between">
            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg w-4/5">
                @if (session('status') === 'cart-deleted')
                    <div class="p-4 bg-red-200 dark:bg-red-600">
                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ __('Product deleted from cart') }}</p>
                    </div>
                @endif
                @if (session('status') === 'maxQuantityChange')
                    <div class="p-4 bg-red-200 dark:bg-red-600">
                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ __('Product quantity has change') }}</p>
                    </div>
                @endif
                @if (session('status') === 'productUnavailable')
                    <div class="p-4 bg-red-200 dark:bg-red-600">
                        <p class="text-sm text-gray-800 dark:text-gray-200">
                            {{ __('Some of your products are no longer available') }}</p>
                    </div>
                @endif
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" id="select-all" class="mr-2" onchange="toggleCheckboxes()">Cały
                                koszyk
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($carts as $index => $cart)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><input type="checkbox" class="cart-checkbox">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cart->product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap"><img
                                        src="{{ asset('storage/' . $cart->product->image_path_main) }}" alt=""
                                        class="h-10 w-10">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <button class="px-2 py-1 bg-gray-200 text-gray-700 rounded-l-md"
                                            wire:click="decreaseQuantity({{ $cart->id }})">
                                            -
                                        </button>
                                        <span class="px-4">{{ $cart->quantity }}</span>
                                        <button class="px-2 py-1 bg-gray-200 text-gray-700 rounded-r-md"
                                            wire:click="increaseQuantity({{ $cart->id }})">
                                            +
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap price">
                                    {{ $cart->quantity * $cart->product->price }}
                                    PLN</td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('cart.delete', $cart->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 ml-2">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="ml-4 w-1/5">
                <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-lg mb-4">
                    <p id="total-price" class="text-xl font-semibold text-right">Total value: ...</p>
                </div>
                <!-- Przycisk Checkout -->

                <a href="{{ route('order.confirm') }}">
                    <button class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg mb-2 w-full">
                        Checkout
                    </button>
                </a>
               

                <!-- Przycisk Continue Shopping -->
                <a href="{{ route('shop.index') }}"><button
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg w-full">
                        Continue Shopping
                    </button></a>
            </div>
        </div>
    </div>

    <script>
        function toggleCheckboxes() {
            var checkboxes = document.querySelectorAll('.cart-checkbox');
            var selectAllCheckbox = document.getElementById('select-all');
            var totalPriceElement = document.getElementById('total-price');
            var totalPrice = 0;

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });

            if (selectAllCheckbox.checked) {
                var checkedCheckboxes = document.querySelectorAll('.cart-checkbox:checked');
                checkedCheckboxes.forEach(function(checkbox) {
                    var row = checkbox.closest('tr');
                    var price = parseFloat(row.querySelector('.price').innerText);
                    totalPrice += price;
                });
            }

            totalPriceElement.innerText = 'Total value: ' + totalPrice.toFixed(2) + ' PLN';
        }

        document.addEventListener('DOMContentLoaded', function() {
            var selectAllCheckbox = document.getElementById('select-all');
            selectAllCheckbox.addEventListener('change', toggleCheckboxes);

            var checkboxes = document.querySelectorAll('.cart-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var totalPriceElement = document.getElementById('total-price');
                    var totalPrice = 0;

                    var checkedCheckboxes = document.querySelectorAll('.cart-checkbox:checked');
                    checkedCheckboxes.forEach(function(checkbox) {
                        var row = checkbox.closest('tr');
                        var price = parseFloat(row.querySelector('.price').innerText);
                        totalPrice += price;
                    });

                    totalPriceElement.innerText = 'Total value: ' + totalPrice.toFixed(2) + ' PLN';
                });
            });
        });
    </script>


</x-app-layout>
