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

        .dashboard-visitors {
            display: grid;
            gap: 0.85rem;
        }

        .dashboard-visitor {
            display: grid;
            gap: 0.32rem;
            padding: 0.95rem 1rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(184, 255, 223, 0.08);
        }

        .dashboard-visitor-top {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.8rem;
        }

        .dashboard-visitor strong {
            font-size: 1rem;
        }

        .dashboard-visitor span {
            color: rgba(239, 250, 248, 0.64);
            font-size: 0.86rem;
            line-height: 1.7;
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
                    Setelah login, kamu sekarang bisa tambah, edit, dan hapus project langsung dari dashboard.
                    Semua perubahan otomatis tampil di halaman public `Projects`.
                </p>

                <div class="dashboard-meta">
                    <span>Admin: {{ $admin['name'] ?? config('forto.admin.name') }}</span>
                    <span>Email: {{ $admin['email'] ?? '-' }}</span>
                    <span>Login: {{ $admin['logged_in_at'] ?? '-' }}</span>
                    <span>Total Projects: {{ count($projects) }}</span>
                    <span>Total Skills: {{ count($skills) }}</span>
                    <span>Total Pengunjung: {{ count($visitors) }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section" style="padding-top: 0;">
        <div class="container dashboard-shell">
            <div class="dashboard-column">
                <div class="surface dashboard-card">
                    <span class="section-kicker">Tambah Project</span>
                    <h2>Publish project baru</h2>
                    <p>Isi form ini lalu simpan. Project baru akan langsung masuk ke halaman public dengan popup notifikasi yang lebih rapi.</p>

                    <form class="form-grid" method="POST" action="{{ route('dashboard.projects.store') }}">
                        @csrf
                        @include('pages.partials.project-form-fields', ['project' => null])

                        <button class="button primary" type="submit">Simpan Project</button>
                    </form>
                </div>

                <div class="surface dashboard-card">
                    <span class="section-kicker">Tambah Skill</span>
                    <h2>Tambahkan skill baru</h2>

                    <form class="form-grid" method="POST" action="{{ route('dashboard.skills.store') }}">
                        @csrf

                        <div class="field">
                            <label for="skill_title">Nama Skill</label>
                            <input
                                id="skill_title"
                                name="title"
                                type="text"
                                value="{{ old('title') }}"
                                required
                            >
                        </div>

                        <div class="field">
                            <label for="skill_items">Item Skill</label>
                            <textarea
                                id="skill_items"
                                name="items"
                                placeholder="Laravel, Blade, UI"
                            >{{ old('items') }}</textarea>
                        </div>

                        <button class="button primary" type="submit">Simpan Skill</button>
                    </form>
                </div>
            </div>

            <div class="dashboard-column">
                <div class="surface dashboard-card">
                    <span class="section-kicker">Visitor Log</span>
                    <h2 style="margin-top: 0.85rem;">Nama pengunjung yang masuk web</h2>
                    <p>Pengunjung yang isi nama saat masuk website akan tercatat di sini. Nama admin `wtp` otomatis tidak masuk daftar.</p>

                    @if (count($visitors))
                        <div class="dashboard-visitors">
                            @foreach ($visitors as $visitor)
                                <article class="dashboard-visitor">
                                    <div class="dashboard-visitor-top">
                                        <strong>{{ $visitor['name'] }}</strong>
                                        <span>{{ \Illuminate\Support\Carbon::parse($visitor['first_visited_at'])->format('d M Y, H:i') }}</span>
                                    </div>

                                    <span>Terakhir aktif: {{ \Illuminate\Support\Carbon::parse($visitor['last_visited_at'])->format('d M Y, H:i') }}</span>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="surface dashboard-empty" style="padding: 1.35rem;">
                            <h3 style="margin: 0;">Belum ada pengunjung tercatat</h3>
                            <p style="margin-top: 0.6rem;">Nama yang masuk pertama kali ke website akan muncul di sini.</p>
                        </div>
                    @endif
                </div>

                <div class="dashboard-list">
                    <div class="dashboard-list-head">
                        <div>
                            <span class="section-kicker">Skill List</span>
                            <h2 style="margin-top: 0.85rem;">Skill aktif di halaman public</h2>
                        </div>
                        <span class="tag-row">
                            <span class="tag">{{ count($skills) }} total skill</span>
                        </span>
                    </div>

                    @if (count($skills))
                        <div class="dashboard-skills">
                            @foreach ($skills as $skill)
                                <article class="surface dashboard-skill">
                                    <div class="dashboard-skill-top">
                                        <h3 style="margin: 0; font-size: 1.15rem;">{{ $skill['title'] }}</h3>

                                        <div class="dashboard-actions">
                                            <form
                                                method="POST"
                                                action="{{ route('dashboard.skills.destroy', $skill['id']) }}"
                                                onsubmit="return confirm('Hapus skill ini dari dashboard dan halaman public?')"
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
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="surface dashboard-empty">
                            <h3 style="margin: 0;">Belum ada skill</h3>
                            <p style="margin-top: 0.8rem;">
                                Skill pertama yang kamu tambah dari dashboard akan langsung muncul di halaman public.
                            </p>
                        </div>
                    @endif

                    <div class="dashboard-list-head">
                        <div>
                            <span class="section-kicker">Project List</span>
                            <h2 style="margin-top: 0.85rem;">Project aktif di halaman public</h2>
                        </div>
                        <span class="tag-row">
                            <span class="tag">{{ count($projects) }} total project</span>
                        </span>
                    </div>

                    @if (count($projects))
                        <div class="dashboard-projects">
                            @foreach ($projects as $project)
                                <article class="surface dashboard-project">
                                    <div class="dashboard-project-top">
                                        <div>
                                            <small>{{ $project['category'] }}</small>
                                            <h3>{{ $project['title'] }}</h3>
                                        </div>

                                        <div class="dashboard-actions">
                                            <a class="button secondary small" href="{{ route('dashboard.projects.edit', $project['id']) }}">
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('dashboard.projects.destroy', $project['id']) }}"
                                                onsubmit="return confirm('Hapus project ini dari dashboard dan halaman public?')"
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

                                    <span class="status-badge">{{ $project['status'] }}</span>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="surface dashboard-empty">
                            <h3 style="margin: 0;">Belum ada project</h3>
                            <p style="margin-top: 0.8rem;">
                                Project pertama yang kamu tambah dari dashboard akan langsung muncul di halaman public.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
