@php
    $projectBag = $errors->getBag($errorBag ?? 'projectForm');
@endphp

<div class="field">
    <label for="project_title">Judul Project</label>
    <input
        id="project_title"
        name="title"
        type="text"
        value="{{ old('title', $project?->title ?? '') }}"
        required
    >
    @if ($projectBag->has('title'))
        <span class="error-text">{{ $projectBag->first('title') }}</span>
    @endif
</div>

<div class="field">
    <label for="project_category">Kategori</label>
    <input
        id="project_category"
        name="category"
        type="text"
        value="{{ old('category', $project?->category ?? 'Project') }}"
    >
    @if ($projectBag->has('category'))
        <span class="error-text">{{ $projectBag->first('category') }}</span>
    @endif
</div>

<div class="field">
    <label for="project_summary">Deskripsi</label>
    <textarea id="project_summary" name="summary">{{ old('summary', $project?->summary ?? '') }}</textarea>
    @if ($projectBag->has('summary'))
        <span class="error-text">{{ $projectBag->first('summary') }}</span>
    @endif
</div>

<div class="field">
    <label for="project_stack">Stack</label>
    <textarea id="project_stack" name="stack">{{ old('stack', $project?->stack ?? '') }}</textarea>
    <small>Pisahkan dengan enter atau koma. Contoh: Laravel, Blade, MySQL</small>
    @if ($projectBag->has('stack'))
        <span class="error-text">{{ $projectBag->first('stack') }}</span>
    @endif
</div>

<div class="field">
    <label for="project_status">Status</label>
    <input
        id="project_status"
        name="status"
        type="text"
        value="{{ old('status', $project?->status ?? 'Ready') }}"
    >
    @if ($projectBag->has('status'))
        <span class="error-text">{{ $projectBag->first('status') }}</span>
    @endif
</div>

<div class="field">
    <label for="project_github_url">GitHub URL</label>
    <input
        id="project_github_url"
        name="github_url"
        type="text"
        value="{{ old('github_url', $project?->github_url ?? '') }}"
        placeholder="https://github.com/username/project"
    >
    @if ($projectBag->has('github_url'))
        <span class="error-text">{{ $projectBag->first('github_url') }}</span>
    @endif
</div>

<div class="field">
    <label for="project_sort_order">Urutan</label>
    <input
        id="project_sort_order"
        name="sort_order"
        type="number"
        min="0"
        value="{{ old('sort_order', $project?->sort_order ?? 0) }}"
    >
    @if ($projectBag->has('sort_order'))
        <span class="error-text">{{ $projectBag->first('sort_order') }}</span>
    @endif
</div>
