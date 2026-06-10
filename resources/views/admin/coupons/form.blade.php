<div class="grid gap-5">
    <label class="font-bold">
        Coupon Code
        <input type="text" name="code" value="{{ old('code', $coupon->code ?? '') }}" class="mt-2 w-full rounded-xl border p-4 uppercase" required>
        @error('code') <p class="mt-1 text-red-600">{{ $message }}</p> @enderror
    </label>

    <label class="font-bold">
        Discount Type
        <select name="type" class="mt-2 w-full rounded-xl border p-4" required>
            <option value="fixed" @selected(old('type', $coupon->type ?? '') === 'fixed')>Fixed Amount</option>
            <option value="percent" @selected(old('type', $coupon->type ?? '') === 'percent')>Percentage</option>
        </select>
    </label>

    <label class="font-bold">
        Value
        <input type="number" step="0.01" name="value" value="{{ old('value', $coupon->value ?? '') }}" class="mt-2 w-full rounded-xl border p-4" required>
    </label>

    <label class="font-bold">
        Minimum Spend
        <input type="number" step="0.01" name="minimum_spend" value="{{ old('minimum_spend', $coupon->minimum_spend ?? 0) }}" class="mt-2 w-full rounded-xl border p-4">
    </label>

    <label class="font-bold">
        Usage Limit
        <input type="number" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}" class="mt-2 w-full rounded-xl border p-4">
    </label>

    <label class="font-bold">
        Expiry Date
        <input type="date" name="expires_at" value="{{ old('expires_at', isset($coupon) && $coupon?->expires_at ? $coupon->expires_at->format('Y-m-d') : '') }}" class="mt-2 w-full rounded-xl border p-4">
    </label>

    <label class="flex items-center gap-3 font-bold">
        <input type="checkbox" name="is_active" value="1" class="h-5 w-5" @checked(old('is_active', $coupon->is_active ?? true))>
        Active
    </label>
</div>
