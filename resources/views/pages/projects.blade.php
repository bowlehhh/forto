@extends('layouts.site')

@push('styles')
    <style data-page-style>
        .projects-hero {
            padding-bottom: clamp(0.85rem, 1.8vw, 1.35rem);
        }

        .project-page-title {
            margin: 1rem 0 0;
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(2.2rem, 4.2vw, 3.4rem);
            line-height: 0.98;
            letter-spacing: -0.06em;
        }

        .project-page-title .accent {
            background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 20px rgba(139, 233, 255, 0.18);
        }

        .project-page-copy {
            max-width: 36rem;
        }

        .projects-showcase {
            padding-top: clamp(0.35rem, 1vw, 0.8rem);
        }

        .projects-grid-rich {
            gap: 1.35rem;
        }

        .project-card {
            position: relative;
            min-height: 100%;
            display: grid;
            gap: 1.1rem;
            padding: 1.55rem;
            overflow: hidden;
            isolation: isolate;
            transform-style: preserve-3d;
            background:
                linear-gradient(165deg, rgba(15, 41, 49, 0.92), rgba(8, 22, 28, 0.74) 58%, rgba(6, 18, 24, 0.96)),
                rgba(8, 24, 30, 0.78);
            border: 1px solid rgba(184, 255, 223, 0.12);
            box-shadow:
                0 28px 54px rgba(0, 0, 0, 0.26),
                inset 0 1px 0 rgba(255, 255, 255, 0.04);
            transition: transform 220ms ease, border-color 220ms ease, box-shadow 220ms ease;
        }

        .project-card::before,
        .project-card::after {
            content: "";
            position: absolute;
            inset: auto;
            pointer-events: none;
        }

        .project-card::before {
            top: -18%;
            right: -14%;
            width: 13rem;
            height: 13rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139, 233, 255, 0.22), transparent 68%);
            filter: blur(8px);
            opacity: 0.88;
            transform: translateZ(0);
        }

        .project-card::after {
            left: 1rem;
            right: 1rem;
            bottom: -1.4rem;
            height: 2.4rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 0, 0, 0.34), transparent 72%);
            filter: blur(12px);
            opacity: 0.85;
        }

        .project-card:hover,
        .project-card:focus-within {
            transform: translateY(-10px) rotateX(6deg) rotateY(-5deg);
            border-color: rgba(184, 255, 223, 0.24);
            box-shadow:
                0 36px 68px rgba(0, 0, 0, 0.34),
                0 0 0 1px rgba(139, 233, 255, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.06);
        }

        .project-card:nth-child(2n):hover,
        .project-card:nth-child(2n):focus-within {
            transform: translateY(-10px) rotateX(6deg) rotateY(5deg);
        }

        .project-card-graphic,
        .project-card-body {
            position: relative;
            z-index: 1;
        }

        .project-card-graphic {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .project-card-grid,
        .project-card-orbit,
        .project-card-beam {
            position: absolute;
        }

        .project-card-grid {
            inset: 0;
            background-image:
                linear-gradient(rgba(184, 255, 223, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(184, 255, 223, 0.08) 1px, transparent 1px);
            background-size: 3.4rem 3.4rem;
            mask-image: linear-gradient(180deg, transparent 8%, black 34%, transparent 100%);
            opacity: 0.22;
        }

        .project-card-orbit {
            top: 1.15rem;
            right: 1.2rem;
            width: 6.25rem;
            height: 6.25rem;
            border-radius: 50%;
            border: 1px solid rgba(184, 255, 223, 0.16);
            opacity: 0.4;
        }

        .project-card-orbit::before,
        .project-card-orbit::after {
            content: "";
            position: absolute;
            border-radius: 50%;
        }

        .project-card-orbit::before {
            inset: 0.8rem;
            border: 1px solid rgba(139, 233, 255, 0.18);
        }

        .project-card-orbit::after {
            top: 0.65rem;
            right: 1rem;
            width: 0.55rem;
            height: 0.55rem;
            background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
            box-shadow: 0 0 18px rgba(139, 233, 255, 0.28);
        }

        .project-card-beam {
            top: 4.1rem;
            right: -1rem;
            width: 7rem;
            height: 0.18rem;
            border-radius: 999px;
            background: linear-gradient(90deg, transparent 0%, rgba(139, 233, 255, 0.8) 26%, rgba(184, 255, 223, 0.08) 100%);
            filter: drop-shadow(0 0 10px rgba(139, 233, 255, 0.18));
            opacity: 0.76;
        }

        .project-card-body > * {
            transform: translateZ(16px);
        }

        .project-card-link {
            position: absolute;
            right: 1.25rem;
            bottom: 1.25rem;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            border: 1px solid rgba(184, 255, 223, 0.14);
            background: rgba(8, 24, 30, 0.72);
            color: rgba(239, 250, 248, 0.9);
            box-shadow:
                0 12px 26px rgba(0, 0, 0, 0.18),
                inset 0 1px 0 rgba(255, 255, 255, 0.04);
            transition: transform 180ms ease, border-color 180ms ease, background 180ms ease;
        }

        .project-card-link:hover,
        .project-card-link:focus-visible {
            transform: translateY(-3px);
            border-color: rgba(184, 255, 223, 0.3);
            background: rgba(10, 28, 34, 0.88);
            outline: none;
        }

        .project-card-link svg {
            width: 1.25rem;
            height: 1.25rem;
            fill: currentColor;
        }

        .project-card h3 {
            margin: 0;
            max-width: 10ch;
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(2rem, 3vw, 2.8rem);
            line-height: 0.95;
            letter-spacing: -0.06em;
            text-transform: uppercase;
        }

        @media (max-width: 1024px) {
            .projects-grid-rich {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .project-page-title {
                font-size: clamp(1.9rem, 11vw, 2.8rem);
            }

            .project-page-copy {
                font-size: 0.92rem;
                line-height: 1.75;
            }

            .projects-grid-rich {
                grid-template-columns: 1fr;
            }

            .project-card {
                padding: 1.15rem 1.15rem 3.9rem;
            }

            .project-card::before {
                top: -10%;
                right: -18%;
                width: 9rem;
                height: 9rem;
                opacity: 0.75;
            }

            .project-card-orbit {
                top: 0.95rem;
                right: 1rem;
                width: 4.6rem;
                height: 4.6rem;
            }

            .project-card-orbit::before {
                inset: 0.6rem;
            }

            .project-card-orbit::after {
                top: 0.5rem;
                right: 0.75rem;
                width: 0.42rem;
                height: 0.42rem;
            }

            .project-card-beam {
                top: 3.2rem;
                right: -0.75rem;
                width: 4.6rem;
            }

            .project-card-link {
                right: 1rem;
                bottom: 1rem;
                width: 2.55rem;
                height: 2.55rem;
            }

            .project-card-link svg {
                width: 1.05rem;
                height: 1.05rem;
            }

            .project-card h3 {
                max-width: 9ch;
                font-size: clamp(1.45rem, 9vw, 2.15rem);
            }

            .project-card:hover,
            .project-card:focus-within,
            .project-card:nth-child(2n):hover,
            .project-card:nth-child(2n):focus-within {
                transform: translateY(-6px);
            }
        }

        @media (max-width: 420px) {
            .project-card {
                padding: 1rem 1rem 3.6rem;
            }

            .project-card h3 {
                font-size: clamp(1.3rem, 10vw, 1.8rem);
            }

            .project-card-link {
                width: 2.35rem;
                height: 2.35rem;
            }
        }
    </style>
@endpush

@section('content')
    <section class="page-section projects-hero">
        <div class="container">
            <span class="section-kicker">Projects</span>
            <h1 class="project-page-title">Project <span class="accent">.</span></h1>
        </div>
    </section>

    <section class="page-section projects-showcase">
        <div class="container project-grid projects-grid-rich">
            @forelse ($projects as $project)
                <article class="project-card">
                    <div class="project-card-graphic" aria-hidden="true">
                        <span class="project-card-grid"></span>
                        <span class="project-card-orbit"></span>
                        <span class="project-card-beam"></span>
                    </div>

                    <a
                        class="project-card-link"
                        href="{{ $project['github_url'] ?? config('forto.links.github') }}"
                        target="_blank"
                        rel="noreferrer"
                        aria-label="Buka GitHub untuk {{ $project['title'] }}"
                    >
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 .5C5.65.5.5 5.66.5 12.03c0 5.1 3.3 9.43 7.88 10.96.58.11.79-.25.79-.56 0-.27-.01-1.17-.02-2.12-3.2.7-3.88-1.36-3.88-1.36-.52-1.34-1.28-1.69-1.28-1.69-1.05-.72.08-.7.08-.7 1.16.08 1.77 1.2 1.77 1.2 1.03 1.77 2.71 1.26 3.37.96.1-.75.4-1.26.73-1.55-2.56-.29-5.25-1.29-5.25-5.74 0-1.27.45-2.3 1.19-3.12-.12-.29-.52-1.47.11-3.06 0 0 .97-.31 3.19 1.19a10.97 10.97 0 0 1 5.8 0c2.21-1.5 3.18-1.19 3.18-1.19.63 1.59.24 2.77.12 3.06.74.82 1.18 1.85 1.18 3.12 0 4.46-2.69 5.44-5.26 5.73.41.36.78 1.06.78 2.15 0 1.55-.01 2.8-.01 3.18 0 .31.21.68.8.56A11.54 11.54 0 0 0 23.5 12.03C23.5 5.66 18.35.5 12 .5Z"/>
                        </svg>
                    </a>

                    <div class="project-card-body">
                        <h3>{{ $project['title'] }}</h3>
                    </div>
                </article>
            @empty
                <article class="surface" style="grid-column: 1 / -1; text-align: center;">
                    <h3 style="margin: 0;">Belum ada project public</h3>
                    <p style="margin-top: 0.9rem;">
                        Tambahkan project dulu dari dashboard, nanti otomatis muncul di sini.
                    </p>
                </article>
            @endforelse
        </div>
    </section>
@endsection
