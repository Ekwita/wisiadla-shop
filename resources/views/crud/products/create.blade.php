<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="px-8 py-6">
                    @csrf

                    <!-- Name -->
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <x-text-input id="description" class="block mt-1 w-full" type="text" name="description"
                            :value="old('description')" required />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Amount -->
                    <div class="mt-4">
                        <x-input-label for="amount" :value="__('Amount')" />
                        <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount"
                            :value="old('amount')" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <!-- Price -->
                    <div class="mt-4">
                        <x-input-label for="price" :value="__('Price')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price"
                            :value="old('price')" required step="0.01" min="0"/>
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div class="mt-4">
                        <x-input-label for="category" :value="__('Category')" />
                        <select name="category_id" id="category">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            <option value="" selected>Brak</option>
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <!-- Main Image -->
                    <div class="mt-4">
                        <x-input-label for="image_main" :value="__('Main Image')" />
                        <input type="file" name="image_main" id="image_main" class="block mt-1 w-full" required />
                        <x-input-error :messages="$errors->get('image_main')" class="mt-2" />
                    </div>

                    <!-- Additional Images -->
                    <div class="mt-4">
                        <x-input-label :value="__('Additional Images')" />
                        <input type="file" name="image_1" id="image_1" class="block mt-1 w-full" />
                        <input type="file" name="image_2" id="image_2" class="block mt-1 w-full" />
                        <input type="file" name="image_3" id="image_3" class="block mt-1 w-full" />
                        <input type="file" name="image_4" id="image_4" class="block mt-1 w-full" />
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 flex justify-start">
                        <x-primary-button class="mr-4">
                            Submit
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
