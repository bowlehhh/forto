@php
    $skillBag = $errors->getBag($errorBag ?? 'skillForm');
@endphp

<div class="field">
    <label for="skill_title">Judul Skill</label>
    <input
        id="skill_title"
        name="title"
        type="text"
        value="{{ old('title', $skill?->title ?? '') }}"
        required
    >
    @if ($skillBag->has('title'))
        <span class="error-text">{{ $skillBag->first('title') }}</span>
    @endif
</div>

<div class="field">
    <label for="skill_items">Item Skill</label>
    <textarea id="skill_items" name="items">{{ old('items', $skill?->items ?? '') }}</textarea>
    <small>Pisahkan dengan enter atau koma. Contoh: Laravel, Responsive UI, MySQL</small>
    @if ($skillBag->has('items'))
        <span class="error-text">{{ $skillBag->first('items') }}</span>
    @endif
</div>

<div class="field">
    <label for="skill_sort_order">Urutan</label>
    <input
        id="skill_sort_order"
        name="sort_order"
        type="number"
        min="0"
        value="{{ old('sort_order', $skill?->sort_order ?? 0) }}"
    >
    @if ($skillBag->has('sort_order'))
        <span class="error-text">{{ $skillBag->first('sort_order') }}</span>
    @endif
</div>
