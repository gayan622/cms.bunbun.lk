<div class="space-y-6">

    {{-- Layout --}}
    <div>
        <label class="mb-2 block font-semibold">
            Layout
        </label>

        <select
            name="layout"
            class="w-full rounded-xl border p-3"
            required>

            <option value="default">Default</option>
            <option value="split">Split</option>
            <option value="fullscreen">Fullscreen</option>
            <option value="centered">Centered</option>

        </select>
    </div>

    {{-- Badge --}}
    <div>
        <label class="mb-2 block font-semibold">
            Badge
        </label>

        <input
            type="text"
            name="badge"
            value="{{ old('badge', $hero->badge ?? '') }}"
            class="w-full rounded-xl border p-3">
    </div>

    {{-- Title --}}
    <div>
        <label class="mb-2 block font-semibold">
            Title
        </label>

        <input
            type="text"
            name="title"
            value="{{ old('title', $hero->title ?? '') }}"
            class="w-full rounded-xl border p-3"
            required>
    </div>

    {{-- Subtitle --}}
    <div>
        <label class="mb-2 block font-semibold">
            Subtitle
        </label>

        <input
            type="text"
            name="subtitle"
            value="{{ old('subtitle', $hero->subtitle ?? '') }}"
            class="w-full rounded-xl border p-3">
    </div>

    {{-- Description --}}
    <div>
        <label class="mb-2 block font-semibold">
            Description
        </label>

        <textarea
            name="description"
            rows="5"
            class="w-full rounded-xl border p-3">{{ old('description', $hero->description ?? '') }}</textarea>
    </div>

    {{-- Primary Button --}}
    <div>
        <label class="mb-2 block font-semibold">
            Primary Button Text
        </label>

        <input
            type="text"
            name="primary_button_text"
            value="{{ old('primary_button_text', $hero->primary_button_text ?? '') }}"
            class="w-full rounded-xl border p-3">
    </div>

    {{-- Secondary Button --}}
    <div>
        <label class="mb-2 block font-semibold">
            Secondary Button Text
        </label>

        <input
            type="text"
            name="secondary_button_text"
            value="{{ old('secondary_button_text', $hero->secondary_button_text ?? '') }}"
            class="w-full rounded-xl border p-3">
    </div>

    {{-- Image --}}
    <div>
        <label class="mb-2 block font-semibold">
            Hero Image
        </label>

        <input
            type="file"
            name="image"
            accept="image/*"
            class="w-full rounded-xl border p-3">

        @if(isset($hero) && $hero?->image)
            <img
                src="{{ asset('storage/'.$hero->image) }}"
                class="mt-4 h-40 rounded-xl object-cover">
        @endif
    </div>

    {{-- Active --}}
    <div>
        <label class="flex items-center gap-2">
            <input
                type="checkbox"
                name="is_active"
                value="1"
                {{ old('is_active', $hero->is_active ?? true) ? 'checked' : '' }}>

            <span>Active Hero</span>
        </label>
    </div>

</div>
