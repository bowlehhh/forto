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
                    <h2 style="margin: 0.85rem 0 0;">Counter like sederhana tanpa database</h2>
                    <p style="margin: 0.65rem 0 0; color: rgba(239, 250, 248, 0.72); line-height: 1.8;">
                        Tombol like sekarang hanya menghitung klik. Setiap tombol love ditekan, angkanya langsung bertambah tanpa tabel like, tanpa nama pengunjung, dan tanpa proses database tambahan.
                    </p>
                </article>
            </div>
        </div>
    </section>
@endsection
