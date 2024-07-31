<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product card') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex justify-center">
                    <!-- Product Details and Images Container -->
                    <div class="w-4/5 flex">
                        <!-- Product Details - Left Side -->
                        <div class="w-1/2 pr-8">
                            <!-- Name -->
                            <div>
                                <x-input-label class="p-1" for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="$product->name" readonly />
                            </div>

                            <!-- Description -->
                            <div class="mt-4">
                                <x-input-label for="description" :value="__('Description')" />
                                <x-text-input id="description" class="block mt-1 w-full" type="text"
                                    name="description" :value="$product->description" readonly />
                            </div>

                            <!-- Amount -->
                            <div class="mt-4">
                                <x-input-label for="amount" :value="__('Amount')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount"
                                    :value="$product->amount" readonly />
                            </div>

                            <!-- Price -->
                            <div class="mt-4">
                                <x-input-label for="price" :value="__('Price')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="text" name="price"
                                    :value="$product->price" readonly />
                            </div>

                            {{-- Category --}}
                            <div class="mt-4">
                                <x-input-label for="category" :value="__('Category')" />
                                <input id="category" class="block mt-1 w-full" type="text" name="price"
                                    @if ($product->category !== null) value="{{ $product->category->name }}" 
                                @else
                                value="Brak" @endif
                                    readonly />
                            </div>
                        </div>

                        <!-- Product Images - Right Side -->
                        <div class="w-1/2">
                            <!-- Main Image -->
                            <div class="mt-4">
                                <x-input-label for="image_main" :value="__('Main Image')" />
                                <img src="{{ asset('storage/' . $product->image_path_main) }}" alt="Main Image"
                                    class="block mt-1 w-full" />
                            </div>

                            <!-- Additional Images -->
                            <div class="mt-4">
                                <x-input-label :value="__('Additional Images')" />
                                {{-- @foreach ($product->additionalImages as $image)
                                    <img src="{{ asset($image->path) }}" alt="Additional Image"
                                        class="block mt-1 w-full" />
                                @endforeach --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
