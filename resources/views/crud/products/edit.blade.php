<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit product') }}
        </h2>
    </x-slot>
    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$product->name" required
                autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="$product->description"
                required />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Amount -->
        <div class="mt-4">
            <x-input-label for="amount" :value="__('Amount')" />
            <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" :value="$product->amount"
                required />
            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
        </div>

        <!-- Price -->
        <div class="mt-4">
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="$product->price"
                required step="0.01" min="0" />
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>

        <!-- Category -->
        <div class="mt-4">
            <x-input-label for="category" :value="__('Category')" />
            <select name="category_id" id="category">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if ($product->category_id == $category->id) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
                <option value="" @if ($product->category_id == null) selected @endif>Brak</option>
            </select>
            <x-input-error :messages="$errors->get('category')" class="mt-2" />
        </div>

        <!-- Main image -->
        <div class="mt-4">
            <x-input-label for="image_main" :value="__('Main image')" />
            <input type="file" name="image_main" id="image_main" class="block mt-1 w-full" />
            <x-input-error :messages="$errors->get('image_main')" class="mt-2" />
        </div>

        <!-- Additional images -->
        <div class="mt-4">
            <x-input-label :value="__('Additional images')" />
            <input type="file" name="image_1" id="image_1" class="block mt-1 w-full" />
            <input type="file" name="image_2" id="image_2" class="block mt-1 w-full" />
            <input type="file" name="image_3" id="image_3" class="block mt-1 w-full" />
            <input type="file" name="image_4" id="image_4" class="block mt-1 w-full" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                Submit
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
