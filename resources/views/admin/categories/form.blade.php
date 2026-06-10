<div class="grid gap-5">

<div>
<label>Name</label>

<input
type="text"
name="name"
value="{{ old('name',$category->name ?? '') }}"
class="w-full border rounded-xl p-4">
</div>

<div>
<label>Parent Category</label>

<select
name="parent_id"
class="w-full border rounded-xl p-4">

<option value="">
None
</option>

@foreach($parents as $parent)

<option
value="{{ $parent->id }}"
@selected(old('parent_id',$category->parent_id ?? '') == $parent->id)>
{{ $parent->name }}
</option>

@endforeach

</select>

</div>

<div>
<label>Description</label>

<textarea
name="description"
class="w-full border rounded-xl p-4">{{ old('description',$category->description ?? '') }}</textarea>
</div>

<div>
<label>Icon</label>

<input
type="text"
name="icon"
value="{{ old('icon',$category->icon ?? '') }}"
class="w-full border rounded-xl p-4">
</div>

<div>
<label>Image</label>

<input
type="file"
name="image"
class="w-full border rounded-xl p-4">
</div>

<div>
<label>Sort Order</label>

<input
type="number"
name="sort_order"
value="{{ old('sort_order',$category->sort_order ?? 0) }}"
class="w-full border rounded-xl p-4">
</div>

<label class="flex gap-2 items-center">
<input
type="checkbox"
name="is_active"
value="1"
@checked(old('is_active',$category->is_active ?? true))>

Active
</label>

</div>
