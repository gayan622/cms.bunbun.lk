<div class="grid gap-5">
    <label class="font-bold">
        Category
        <select name="category_id" class="mt-2 w-full rounded-xl border p-4" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $menuItem->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </label>

    <label class="font-bold">
        Item Name
        <input type="text" name="name" value="{{ old('name', $menuItem->name ?? '') }}" class="mt-2 w-full rounded-xl border p-4" required>
    </label>

    <label class="font-bold">
        Description
        <textarea name="description" rows="4" class="mt-2 w-full rounded-xl border p-4">{{ old('description', $menuItem->description ?? '') }}</textarea>
    </label>

    <div class="grid gap-5">
    <label class="font-bold">
        Price
        <input type="number" step="0.01" name="price" value="{{ old('price', $menuItem->price ?? '') }}" class="mt-2 w-full rounded-xl border p-4" required>
    </label>

    <label class="font-bold">
        Stock Quantity
        <input type="number" name="stock" value="{{ old('stock', $menuItem->stock ?? 0) }}" class="mt-2 w-full rounded-xl border p-4" required>
    </label>

    </div>

    <label class="font-bold">
        Badge
        <input type="text" name="badge" value="{{ old('badge', $menuItem->badge ?? '') }}" placeholder="Best Seller / New / Popular" class="mt-2 w-full rounded-xl border p-4">
    </label>

    <label class="font-bold">
        Image
        <input type="file" name="image" class="mt-2 w-full rounded-xl border p-4">
    </label>

    @if(!empty($menuItem?->image))
        <img src="{{ asset('storage/'.$menuItem->image) }}" class="h-24 w-24 rounded-xl object-cover">
    @endif

    <label class="flex items-center gap-3 font-bold">
        <input type="checkbox" name="is_available" value="1" class="h-5 w-5" @checked(old('is_available', $menuItem->is_available ?? true))>
        Available
    </label>

    <label class="flex items-center gap-3 font-bold">
        <input type="checkbox" name="is_featured" value="1" class="h-5 w-5" @checked(old('is_featured', $menuItem->is_featured ?? false))>
        Featured
    </label>
</div>
