<div class="field">
    <label for="title">Judul Project</label>
    <input
        id="title"
        name="title"
        type="text"
        value="{{ old('title', $project['title'] ?? '') }}"
        required
    >
    @error('title')
        <span class="error-text">{{ $message }}</span>
    @enderror
</div>

<div class="field">
    <label for="category">Kategori</label>
    <input
        id="category"
        name="category"
        type="text"
        value="{{ old('category', $project['category'] ?? '') }}"
        required
    >
    @error('category')
        <span class="error-text">{{ $message }}</span>
    @enderror
</div>

<div class="field">
    <label for="summary">Deskripsi Singkat</label>
    <textarea
        id="summary"
        name="summary"
        required
    >{{ old('summary', $project['summary'] ?? '') }}</textarea>
    @error('summary')
        <span class="error-text">{{ $message }}</span>
    @enderror
</div>

<div class="field">
    <label for="stack">Stack / Tools</label>
    <input
        id="stack"
        name="stack"
        type="text"
        value="{{ old('stack', isset($project['stack']) ? implode(', ', $project['stack']) : '') }}"
    >
    <small>Pisahkan dengan koma. Contoh: Laravel, Blade, UI Design</small>
    @error('stack')
        <span class="error-text">{{ $message }}</span>
    @enderror
</div>

<div class="field">
    <label for="status">Status</label>
    <input
        id="status"
        name="status"
        type="text"
        value="{{ old('status', $project['status'] ?? 'Ready') }}"
        required
    >
    <small>Contoh: Live, Ready, Featured, Draft</small>
    @error('status')
        <span class="error-text">{{ $message }}</span>
    @enderror
</div>

<div class="field">
    <label for="github_url">GitHub URL</label>
    <input
        id="github_url"
        name="github_url"
        type="text"
        value="{{ old('github_url', $project['github_url'] ?? '') }}"
    >
    <small>Contoh: https://github.com/username/repository</small>
    @error('github_url')
        <span class="error-text">{{ $message }}</span>
    @enderror
</div>
