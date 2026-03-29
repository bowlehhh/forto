@extends('layouts.site')

@push('styles')
    <style data-page-style>
        .dashboard-hero {
            display: grid;
            gap: 1rem;
        }

        .dashboard-topbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .dashboard-shell {
            display: grid;
            grid-template-columns: minmax(0, 0.86fr) minmax(0, 1.14fr);
            gap: 1.2rem;
            align-items: start;
        }

        .dashboard-column {
            display: grid;
            gap: 1.2rem;
            align-items: start;
        }

        .dashboard-note {
            color: rgba(239, 250, 248, 0.72);
            line-height: 1.85;
        }

        .dashboard-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .dashboard-meta span {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.52rem 0.8rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(184, 255, 223, 0.1);
            font-size: 0.82rem;
            color: rgba(239, 250, 248, 0.84);
        }

        .dashboard-card {
            display: grid;
            gap: 1rem;
        }

        .dashboard-card h2,
        .dashboard-list h2 {
            margin: 0;
            font-size: 1.25rem;
        }

        .dashboard-card p,
        .dashboard-list p {
            margin: 0;
            color: rgba(239, 250, 248, 0.72);
            line-height: 1.8;
        }

        .dashboard-list {
            display: grid;
            gap: 1rem;
        }

        .dashboard-form-card,
        .dashboard-static-list {
            display: grid;
            gap: 0.9rem;
        }

        .dashboard-form-grid {
            display: grid;
            gap: 1.2rem;
        }

        .dashboard-form-card .form-grid {
            margin-top: 0;
        }

        .dashboard-list-head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.8rem;
        }

        .dashboard-projects {
            display: grid;
            gap: 1rem;
        }

        .dashboard-skills {
            display: grid;
            gap: 1rem;
        }

        .dashboard-project {
            display: grid;
            gap: 1rem;
        }

        .dashboard-skill {
            display: grid;
            gap: 1rem;
        }

        .dashboard-project-top {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }

        .dashboard-skill-top {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .dashboard-project small {
            color: var(--accent);
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .dashboard-project h3 {
            margin: 0.4rem 0 0;
            font-size: 1.2rem;
        }

        .dashboard-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.7rem;
        }

        .dashboard-actions form {
            margin: 0;
        }

        .dashboard-source {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(239, 250, 248, 0.7);
            font-size: 0.82rem;
        }

        .dashboard-source strong {
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-size: 0.74rem;
        }

        .dashboard-empty {
            padding: 2rem;
            text-align: center;
        }

        @media (max-width: 1024px) {
            .dashboard-shell {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="surface dashboard-hero">
                <div class="dashboard-topbar">
                    <div>
                        <span class="section-kicker">Dashboard</span>
                        <h1 class="page-title" style="margin-top: 0.85rem;">Kelola project public dari satu tempat.</h1>
                    </div>

                    <div style="display: flex; flex-wrap: wrap; gap: 0.7rem;">
                        <a class="button secondary small" href="{{ route('projects') }}">Lihat Halaman Public</a>
                        <a class="button secondary small" href="{{ route('home') }}">Kembali ke Home</a>
                    </div>
                </div>

                <p class="dashboard-note">
                    Dashboard sekarang bisa CRUD project dan skill langsung dari database. Fallback ke data default
                    hanya dipakai kalau tabel content belum tersedia, jadi hapus dari dashboard akan benar-benar
                    menghapus tampilan project dan skill di halaman public.
                </p>

                <div class="dashboard-meta">
                    <span>Admin: {{ $admin['name'] ?? 'Admin' }}</span>
                    <span>Email: {{ $admin['email'] ?? '-' }}</span>
                    <span>Login: {{ $admin['logged_in_at'] ?? '-' }}</span>
                    <span>Total Projects: {{ count($projects) }}</span>
                    <span>Total Skills: {{ count($skills) }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section" style="padding-top: 0;">
        <div class="container dashboard-shell">
            <div class="dashboard-column">
                <div class="surface dashboard-card">
                    <span class="section-kicker">Status Deploy</span>
                    <h2>Public page aman, dashboard sekarang bisa CRUD</h2>
                    <p>
                        Project dan skill sekarang bisa dikelola dari dashboard. Selama tabel content sudah ada,
                        halaman public akan mengikuti isi database sepenuhnya.
                    </p>
                    <div class="dashboard-meta">
                        <span>Source Project: {{ $projectSource === 'database' ? 'Database' : 'Config Default' }}</span>
                        <span>Source Skill: {{ $skillSource === 'database' ? 'Database' : 'Config Default' }}</span>
                    </div>
                </div>

                <div class="dashboard-form-grid">
                    <div class="surface dashboard-form-card">
                        <span class="section-kicker">Tambah Project</span>
                        <h2>Project baru</h2>
                        <form class="form-grid" method="POST" action="{{ route('dashboard.projects.store') }}">
                            @csrf
                            @include('pages.partials.project-form-fields', ['project' => null, 'errorBag' => 'projectForm'])

                            <button class="button primary" type="submit">Simpan Project</button>
                        </form>
                    </div>

                    <div class="surface dashboard-form-card">
                        <span class="section-kicker">Tambah Skill</span>
                        <h2>Skill baru</h2>
                        <form class="form-grid" method="POST" action="{{ route('dashboard.skills.store') }}">
                            @csrf
                            @include('pages.partials.skill-form-fields', ['skill' => null, 'errorBag' => 'skillForm'])

                            <button class="button primary" type="submit">Simpan Skill</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="dashboard-column">
                <div class="dashboard-list">
                    <div class="dashboard-list-head">
                        <div>
                            <span class="section-kicker">Skill List</span>
                            <h2 style="margin-top: 0.85rem;">Skill di database</h2>
                        </div>
                        <span class="dashboard-source">
                            <strong>Public</strong>
                            <span>{{ $skillSource === 'database' ? 'Mengikuti database' : 'Masih pakai config default' }}</span>
                        </span>
                    </div>

                    @if (count($managedSkills))
                        <div class="dashboard-static-list dashboard-skills">
                            @foreach ($managedSkills as $skill)
                                <article class="surface dashboard-skill">
                                    <div class="dashboard-skill-top">
                                        <h3 style="margin: 0; font-size: 1.15rem;">{{ $skill['title'] }}</h3>
                                        <div class="dashboard-actions">
                                            <a class="button secondary small" href="{{ route('dashboard.skills.edit', $skill['id']) }}">Edit</a>
                                            <form
                                                method="POST"
                                                action="{{ route('dashboard.skills.destroy', $skill['id']) }}"
                                                data-confirm-title="Hapus skill ini?"
                                                data-confirm-message="Skill {{ $skill['title'] }} akan dihapus dari dashboard dan halaman public."
                                                data-confirm-action="Ya, hapus"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button class="button danger small" type="submit">Hapus</button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="tag-row">
                                        @foreach ($skill['items'] as $item)
                                            <span class="tag">{{ $item }}</span>
                                        @endforeach
                                    </div>

                                    <span class="status-badge">Urutan {{ $skill['sort_order'] }}</span>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="surface dashboard-empty">
                            <h3 style="margin: 0;">Belum ada skill di database</h3>
                            <p style="margin-top: 0.8rem;">
                                Tambahkan skill dari form dashboard. Saat masih kosong, halaman public skill juga akan kosong sampai ada data baru.
                            </p>
                        </div>
                    @endif

                    <div class="dashboard-list-head">
                        <div>
                            <span class="section-kicker">Project List</span>
                            <h2 style="margin-top: 0.85rem;">Project di database</h2>
                        </div>
                        <span class="dashboard-source">
                            <strong>Public</strong>
                            <span>{{ $projectSource === 'database' ? 'Mengikuti database' : 'Masih pakai config default' }}</span>
                        </span>
                    </div>

                    @if (count($managedProjects))
                        <div class="dashboard-static-list dashboard-projects">
                            @foreach ($managedProjects as $project)
                                <article class="surface dashboard-project">
                                    <div class="dashboard-project-top">
                                        <div>
                                            <small>{{ $project['category'] }}</small>
                                            <h3>{{ $project['title'] }}</h3>
                                        </div>

                                        <div class="dashboard-actions">
                                            <a class="button secondary small" href="{{ route('dashboard.projects.edit', $project['id']) }}">Edit</a>
                                            <form
                                                method="POST"
                                                action="{{ route('dashboard.projects.destroy', $project['id']) }}"
                                                data-confirm-title="Hapus project ini?"
                                                data-confirm-message="Project {{ $project['title'] }} akan dihapus dari dashboard dan halaman public."
                                                data-confirm-action="Ya, hapus"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button class="button danger small" type="submit">Hapus</button>
                                            </form>
                                        </div>
                                    </div>

                                    <p>{{ $project['summary'] }}</p>

                                    <div class="tag-row">
                                        @foreach ($project['stack'] as $stack)
                                            <span class="tag">{{ $stack }}</span>
                                        @endforeach
                                    </div>

                                    <div class="dashboard-meta">
                                        <span>Status: {{ $project['status'] }}</span>
                                        <span>Urutan: {{ $project['sort_order'] }}</span>
                                        <span>GitHub: {{ $project['github_url'] ?: 'Tidak ada' }}</span>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="surface dashboard-empty">
                            <h3 style="margin: 0;">Belum ada project di database</h3>
                            <p style="margin-top: 0.8rem;">
                                Tambahkan project dari form dashboard. Saat masih kosong, halaman public project juga akan kosong sampai ada data baru.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
