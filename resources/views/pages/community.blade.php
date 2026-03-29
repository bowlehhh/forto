@extends('layouts.site')

@push('styles')
    <style data-page-style>
        .community-metrics {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }

        .community-metric {
            display: grid;
            gap: 0.45rem;
        }

        .community-metric strong {
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 0.9;
        }

        .community-shell {
            margin-top: 1.2rem;
        }

        .community-list {
            display: grid;
            gap: 0.85rem;
        }

        .community-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.9rem 1rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(184, 255, 223, 0.08);
        }

        .community-item-main {
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            min-width: 0;
        }

        .community-avatar {
            width: 2.7rem;
            height: 2.7rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(113, 239, 176, 0.96), rgba(139, 233, 255, 0.88));
            color: #031015;
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            flex-shrink: 0;
        }

        .community-item-main strong,
        .community-item-main span,
        .community-item-time {
            margin: 0;
        }

        .community-item-main strong {
            display: block;
            font-size: 1rem;
        }

        .community-item-main span,
        .community-item-time {
            color: rgba(239, 250, 248, 0.62);
            font-size: 0.84rem;
        }

        @media (max-width: 900px) {
            .community-metrics {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <section class="page-section">
        <div class="container">
            <span class="section-kicker">Community</span>
            <h1 class="page-title">Community</h1>

            <div class="community-metrics">
                <article class="surface community-metric">
                    <span class="section-kicker">Likes</span>
                    <strong data-site-like-total>{{ $siteLikeSummary['total'] }}</strong>
                </article>
            </div>

            <div class="community-shell">
                <article class="surface">
                    <span class="section-kicker">Likes</span>
                    <h2 style="margin: 0.85rem 0 0;">Apresiasi yang masuk ke website</h2>
                    <p style="margin: 0.65rem 0 0; color: rgba(239, 250, 248, 0.72); line-height: 1.8;">
                        Halaman ini sekarang fokus menampilkan like yang masuk dari pengunjung.
                    </p>

                    <div class="community-list" style="margin-top: 1.2rem;">
                        @forelse ($likes as $like)
                            <div class="community-item">
                                <div class="community-item-main">
                                    <span class="community-avatar">{{ $like['initials'] }}</span>
                                    <div>
                                        <strong>{{ $like['name'] }}</strong>
                                        <span>Liked</span>
                                    </div>
                                </div>

                                <span class="community-item-time">{{ \Illuminate\Support\Carbon::parse($like['liked_at'])->format('d M Y') }}</span>
                            </div>
                        @empty
                            <div class="community-item">
                                <strong>Belum ada data</strong>
                            </div>
                        @endforelse
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
