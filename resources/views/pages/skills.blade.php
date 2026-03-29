@extends('layouts.site')

@section('content')
    <section class="page-section">
        <div class="container">
            <span class="section-kicker">Skills</span>
            <h1 class="page-title">Skill</h1>

            <div class="project-grid" style="margin-top: 2rem;">
                @forelse ($skills as $skill)
                    <article class="surface" style="display: grid; gap: 1rem;">
                        <h2 style="margin: 0; font-size: 1.3rem;">{{ $skill['title'] }}</h2>

                        <div class="tag-row">
                            @foreach ($skill['items'] as $item)
                                <span class="tag">{{ $item }}</span>
                            @endforeach
                        </div>
                    </article>
                @empty
                    <article class="surface" style="grid-column: 1 / -1; text-align: center;">
                        <h3 style="margin: 0;">Belum ada skill public</h3>
                        <p style="margin-top: 0.9rem; color: rgba(239, 250, 248, 0.74);">
                            Tambahkan skill dari dashboard admin, lalu daftar skill akan tampil di sini.
                        </p>
                    </article>
                @endforelse
            </div>
        </div>
    </section>
@endsection
