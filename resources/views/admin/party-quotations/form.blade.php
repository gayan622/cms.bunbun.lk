<div class="grid gap-5">
    <label class="font-bold">
        Customer Name
        <input type="text" name="name" value="{{ old('name', $partyQuotation->name ?? '') }}"
            class="mt-2 w-full rounded-xl border p-4" required>
    </label>

    <label class="font-bold">
        Phone
        <input type="text" name="phone" value="{{ old('phone', $partyQuotation->phone ?? '') }}"
            class="mt-2 w-full rounded-xl border p-4" required>
    </label>

    <label class="font-bold">
        Email
        <input type="email" name="email" value="{{ old('email', $partyQuotation->email ?? '') }}"
            class="mt-2 w-full rounded-xl border p-4">
    </label>

    <label class="font-bold">
        Event Type
        <select name="event_type" class="mt-2 w-full rounded-xl border p-4" required>
            <option value="office_party" @selected(old('event_type', $partyQuotation->event_type ?? '') === 'office_party')>
                Office Party
            </option>

            <option value="birthday_party" @selected(old('event_type', $partyQuotation->event_type ?? '') === 'birthday_party')>
                Birthday Party
            </option>

            <option value="other" @selected(old('event_type', $partyQuotation->event_type ?? '') === 'other')>
                Other
            </option>
        </select>
    </label>

    <label class="font-bold">
        Guest Count
        <input type="number" name="guest_count" value="{{ old('guest_count', $partyQuotation->guest_count ?? '') }}"
            class="mt-2 w-full rounded-xl border p-4" required>
    </label>

    <label class="font-bold">
        Event Date
        <input type="date" name="event_date"
            value="{{ old('event_date', isset($partyQuotation) && $partyQuotation?->event_date ? $partyQuotation->event_date->format('Y-m-d') : '') }}"
            class="mt-2 w-full rounded-xl border p-4" required>
    </label>

    <label class="font-bold">
        Status
        <select name="status" class="mt-2 w-full rounded-xl border p-4">
            @foreach (['new', 'contacted', 'quoted', 'confirmed', 'cancelled'] as $status)
                <option value="{{ $status }}" @selected(old('status', $partyQuotation->status ?? 'new') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </label>

    <label class="font-bold">
        Message
        <textarea name="message" rows="5" class="mt-2 w-full rounded-xl border p-4">{{ old('message', $partyQuotation->message ?? '') }}</textarea>
    </label>

    <label class="font-bold">
        Booking Status
        <select name="booking_status" class="mt-2 w-full rounded-xl border p-4" required>
            @foreach (['pending', 'confirmed', 'rejected', 'completed'] as $status)
                <option value="{{ $status }}" @selected(old('booking_status', $partyQuotation->booking_status ?? '') === $status)>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
            @endforeach
        </select>
    </label>

    <label class="font-bold">
        Payment Status
        <select name="payment_status" class="mt-2 w-full rounded-xl border p-4" required>
            @foreach (['pending', 'advance_paid', 'partial_paid', 'paid'] as $status)
                <option value="{{ $status }}" @selected(old('payment_status', $partyQuotation->payment_status ?? '') === $status)>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
            @endforeach
        </select>
    </label>
</div>
