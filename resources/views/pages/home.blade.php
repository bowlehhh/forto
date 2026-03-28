@extends('layouts.site')

@push('styles')
    <style data-page-style>
        body.home-page {
            --mx: 0px;
            --my: 0px;
            overflow: hidden;
        }

        body.home-page .page-main {
            min-height: calc(100svh - 5.75rem);
            padding-bottom: 0;
        }

        body.home-page .site-footer {
            display: none;
        }

        body.home-page .site-header {
            background: linear-gradient(180deg, rgba(3, 16, 21, 0.88), rgba(3, 16, 21, 0.42));
            border-bottom-color: rgba(184, 255, 223, 0.08);
        }

        .home-hero {
            position: relative;
            min-height: calc(100svh - 5.75rem);
            padding: clamp(1rem, 2vw, 1.75rem) 0 0;
            overflow: clip;
        }

        .home-hero::before,
        .home-hero::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .home-hero::before {
            background:
                radial-gradient(circle at 54% 38%, rgba(113, 239, 176, 0.22), transparent 28%),
                radial-gradient(circle at 30% 78%, rgba(139, 233, 255, 0.06), transparent 26%);
            filter: blur(18px);
            transform: translate3d(calc(var(--mx) * 0.18), calc(var(--my) * 0.12), 0);
            animation: auraShift 10s ease-in-out infinite;
        }

        .home-hero::after {
            background:
                linear-gradient(90deg, rgba(3, 16, 21, 0.68) 0%, rgba(3, 16, 21, 0.12) 22%, rgba(3, 16, 21, 0) 48%, rgba(3, 16, 21, 0.12) 78%, rgba(3, 16, 21, 0.62) 100%),
                linear-gradient(180deg, rgba(3, 16, 21, 0.08) 0%, rgba(3, 16, 21, 0.02) 34%, rgba(3, 16, 21, 0.2) 100%);
        }

        .hero-stage {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: minmax(0, 0.84fr) minmax(22rem, 1.16fr);
            align-items: center;
            gap: clamp(2rem, 4.5vw, 5rem);
            min-height: calc(100svh - 7.75rem);
        }

        .hero-copy {
            position: relative;
            z-index: 2;
            max-width: 33rem;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--accent);
        }

        .hero-eyebrow::before {
            content: "";
            width: 0.55rem;
            height: 0.55rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
            box-shadow: 0 0 16px rgba(113, 239, 176, 0.4);
        }

        .hero-title {
            margin: 1rem 0 0;
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(3rem, 6.1vw, 6rem);
            line-height: 0.92;
            letter-spacing: -0.07em;
            text-transform: uppercase;
        }

        .hero-title span {
            display: block;
        }

        .hero-title .accent {
            color: var(--accent);
            text-shadow: 0 0 18px rgba(113, 239, 176, 0.14);
        }

        .hero-copy p {
            max-width: 29rem;
            margin: 1.3rem 0 0;
            color: rgba(239, 250, 248, 0.8);
            line-height: 1.9;
            font-size: 1rem;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.9rem;
            margin-top: 1.8rem;
        }

        .hero-actions .button {
            min-width: 0;
        }

        .hero-like-strip {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.95rem 1.25rem;
            margin-top: 1.1rem;
        }

        .hero-quick-item {
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
        }

        .hero-like-trigger,
        .hero-quick-link {
            width: 3.45rem;
            height: 3.45rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: 1px solid rgba(184, 255, 223, 0.16);
            border-radius: 50%;
            background: rgba(8, 24, 30, 0.5);
            color: #93f4ff;
            cursor: pointer;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.18);
            transition: transform 180ms ease, border-color 180ms ease, background 180ms ease, color 180ms ease;
        }

        .hero-like-trigger:hover,
        .hero-like-trigger:focus-visible,
        .hero-quick-link:hover,
        .hero-quick-link:focus-visible {
            transform: translateY(-2px);
            border-color: rgba(184, 255, 223, 0.28);
            outline: none;
        }

        .hero-like-trigger[data-liked="true"] {
            background: linear-gradient(135deg, rgba(113, 239, 176, 0.96), rgba(139, 233, 255, 0.88));
            color: #031015;
            border-color: transparent;
        }

        .hero-like-trigger svg {
            width: 1.35rem;
            height: 1.35rem;
            fill: currentColor;
        }

        .hero-quick-link svg {
            width: 1.35rem;
            height: 1.35rem;
            fill: currentColor;
        }

        .hero-like-meta,
        .hero-quick-meta {
            display: grid;
            gap: 0.14rem;
        }

        .hero-like-meta strong,
        .hero-quick-meta strong {
            font-size: 1rem;
            line-height: 1;
        }

        .hero-like-meta span,
        .hero-quick-meta span {
            font-size: 0.74rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(239, 250, 248, 0.62);
        }

        .hero-highlights {
            display: flex;
            flex-wrap: wrap;
            gap: 0.9rem 1.5rem;
            margin-top: 1.8rem;
        }

        .hero-highlights span {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            color: rgba(239, 250, 248, 0.82);
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .hero-highlights span::before {
            content: "";
            width: 0.42rem;
            height: 0.42rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
            box-shadow: 0 0 12px rgba(113, 239, 176, 0.34);
        }

        .hero-visual {
            position: relative;
            min-height: clamp(29rem, 68svh, 45rem);
            isolation: isolate;
        }

        .hero-visual::after {
            content: "";
            position: absolute;
            inset: auto -6% -1.3rem -6%;
            height: 8.6rem;
            background: linear-gradient(
                180deg,
                rgba(3, 16, 21, 0) 0%,
                rgba(3, 16, 21, 0.14) 22%,
                rgba(3, 16, 21, 0.44) 52%,
                rgba(3, 16, 21, 0.82) 80%,
                #031015 100%
            );
            pointer-events: none;
            z-index: 3;
        }

        .hero-grid,
        .hero-ambient,
        .hero-rings,
        .hero-wave,
        .hero-beam,
        .hero-trace,
        .hero-particles,
        .hero-particles span,
        .hero-orb {
            position: absolute;
            pointer-events: none;
        }

        .hero-grid {
            inset: 6% 4% 12% 12%;
            background-image:
                linear-gradient(rgba(184, 255, 223, 0.12) 1px, transparent 1px),
                linear-gradient(90deg, rgba(184, 255, 223, 0.12) 1px, transparent 1px);
            background-size: 4.4rem 4.4rem;
            mask-image: linear-gradient(180deg, transparent 0%, black 12%, black 86%, transparent 100%);
            opacity: 0.7;
            transform: translate3d(calc(var(--mx) * -0.42), calc(var(--my) * -0.26), 0);
            animation: gridPulse 9s ease-in-out infinite;
        }

        .hero-ambient {
            left: 18%;
            top: 2%;
            width: 32rem;
            height: 32rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(113, 239, 176, 0.34), rgba(113, 239, 176, 0.08) 48%, transparent 72%);
            filter: blur(24px);
            opacity: 0.95;
            transform: translate3d(calc(var(--mx) * 0.32), calc(var(--my) * 0.18), 0);
            animation: glowPulse 8.4s ease-in-out infinite;
        }

        .hero-rings {
            inset: 22% -2% 8% 8%;
            border-radius: 50%;
            border: 1px solid rgba(184, 255, 223, 0.12);
            opacity: 0.24;
            transform: translate3d(calc(var(--mx) * -0.16), calc(var(--my) * -0.08), 0);
            animation: ringDrift 12s ease-in-out infinite;
        }

        .hero-rings.secondary {
            inset: 34% 6% 18% 18%;
            opacity: 0.14;
            animation-duration: 15s;
            animation-direction: reverse;
        }

        .hero-wave {
            left: -26%;
            right: -8%;
            border-top: 1px solid rgba(184, 255, 223, 0.26);
            border-radius: 50%;
            filter: drop-shadow(0 0 12px rgba(139, 233, 255, 0.16));
            transform-origin: center;
        }

        .hero-wave.one {
            top: 36%;
            height: 16rem;
            opacity: 0.72;
            animation: waveDrift 10s ease-in-out infinite;
        }

        .hero-wave.two {
            top: 58%;
            left: -16%;
            right: 2%;
            height: 9rem;
            opacity: 0.24;
            animation: waveDrift 13s ease-in-out infinite reverse;
        }

        .hero-beam {
            height: 0.22rem;
            border-radius: 999px;
            background: linear-gradient(90deg, transparent 0%, rgba(139, 233, 255, 0.76) 20%, rgba(184, 255, 223, 0.18) 100%);
            filter: drop-shadow(0 0 10px rgba(139, 233, 255, 0.18));
            opacity: 0.7;
        }

        .hero-beam.one {
            left: 8%;
            top: 28%;
            width: 8rem;
            animation: beamDrift 8s ease-in-out infinite;
        }

        .hero-beam.two {
            right: 4%;
            top: 47%;
            width: 8.5rem;
            animation: beamDrift 9.8s ease-in-out infinite reverse;
        }

        .hero-trace {
            height: 1px;
            border-radius: 999px;
            background: linear-gradient(90deg, transparent 0%, rgba(184, 255, 223, 0.46) 14%, rgba(184, 255, 223, 0.06) 100%);
            opacity: 0.44;
        }

        .hero-trace.one {
            left: 14%;
            top: 34%;
            width: 12rem;
            animation: traceFlicker 7s ease-in-out infinite;
        }

        .hero-trace.two {
            right: 9%;
            top: 56%;
            width: 10rem;
            animation: traceFlicker 8s ease-in-out infinite reverse;
        }

        .hero-particles {
            inset: 10% 6% 10% 8%;
        }

        .hero-particles span {
            left: var(--x);
            top: var(--y);
            width: var(--size);
            height: var(--size);
            border-radius: 999px;
            background: rgba(184, 255, 223, 0.74);
            box-shadow: 0 0 12px rgba(184, 255, 223, 0.24);
            opacity: 0.88;
            transform: translateY(0);
            animation: particleFloat var(--duration) ease-in-out infinite;
            animation-delay: var(--delay);
        }

        .hero-orb {
            left: 50%;
            bottom: 8%;
            width: 12rem;
            height: 4.6rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139, 233, 255, 0.2), rgba(113, 239, 176, 0.08) 52%, transparent 78%);
            filter: blur(16px);
            transform: translateX(-50%);
            animation: orbBlink 6.5s ease-in-out infinite;
        }

        .hero-photo {
            position: absolute;
            right: 0;
            bottom: -0.4rem;
            width: min(37rem, 100%);
            z-index: 2;
            transform: translate3d(calc(var(--mx) * 0.24), calc(var(--my) * 0.12), 0);
        }

        .hero-photo::before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 16%;
            width: 18rem;
            height: 8rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(137, 233, 255, 0.24), rgba(113, 239, 176, 0.1) 46%, transparent 76%);
            filter: blur(18px);
            transform: translateX(-50%);
            animation: orbBlink 7s ease-in-out infinite;
        }

        .hero-photo img {
            display: block;
            width: 100%;
            max-height: min(72svh, 43rem);
            margin: 0 auto;
            object-fit: contain;
            filter: brightness(1.13) contrast(1.08) saturate(1.08) drop-shadow(0 26px 40px rgba(0, 0, 0, 0.28));
            -webkit-mask-image: linear-gradient(
                180deg,
                #000 0%,
                #000 67%,
                rgba(0, 0, 0, 0.96) 76%,
                rgba(0, 0, 0, 0.72) 84%,
                rgba(0, 0, 0, 0.34) 93%,
                transparent 100%
            );
            mask-image: linear-gradient(
                180deg,
                #000 0%,
                #000 67%,
                rgba(0, 0, 0, 0.96) 76%,
                rgba(0, 0, 0, 0.72) 84%,
                rgba(0, 0, 0, 0.34) 93%,
                transparent 100%
            );
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
            animation: photoFloat 7s ease-in-out infinite;
        }

        @keyframes auraShift {
            0%,
            100% {
                opacity: 0.72;
                transform: translate3d(calc(var(--mx) * 0.18), calc(var(--my) * 0.12), 0) scale(1);
            }

            50% {
                opacity: 1;
                transform: translate3d(calc(var(--mx) * 0.22), calc(var(--my) * 0.16), 0) scale(1.04);
            }
        }

        @keyframes gridPulse {
            0%,
            100% {
                opacity: 0.48;
            }

            50% {
                opacity: 0.78;
            }
        }

        @keyframes glowPulse {
            0%,
            100% {
                opacity: 0.76;
                transform: translate3d(calc(var(--mx) * 0.32), calc(var(--my) * 0.18), 0) scale(0.98);
            }

            50% {
                opacity: 1;
                transform: translate3d(calc(var(--mx) * 0.36), calc(var(--my) * 0.2), 0) scale(1.04);
            }
        }

        @keyframes ringDrift {
            0%,
            100% {
                transform: translate3d(calc(var(--mx) * -0.16), calc(var(--my) * -0.08), 0) scale(1);
            }

            50% {
                transform: translate3d(calc(var(--mx) * -0.2), calc(var(--my) * -0.12), 0) scale(1.03);
            }
        }

        @keyframes waveDrift {
            0%,
            100% {
                transform: translate3d(0, 0, 0);
                opacity: 0.6;
            }

            50% {
                transform: translate3d(0, -0.7rem, 0);
                opacity: 0.86;
            }
        }

        @keyframes beamDrift {
            0%,
            100% {
                opacity: 0.34;
                transform: scaleX(0.88);
            }

            50% {
                opacity: 0.84;
                transform: scaleX(1.04);
            }
        }

        @keyframes traceFlicker {
            0%,
            100% {
                opacity: 0.24;
                transform: scaleX(0.84);
            }

            40%,
            60% {
                opacity: 0.56;
                transform: scaleX(1);
            }
        }

        @keyframes particleFloat {
            0%,
            100% {
                opacity: 0.28;
                transform: translate3d(0, 0, 0);
            }

            50% {
                opacity: 1;
                transform: translate3d(calc(var(--drift-x) * 1), calc(var(--drift-y) * -1), 0);
            }
        }

        @keyframes orbBlink {
            0%,
            100% {
                opacity: 0.34;
            }

            50% {
                opacity: 0.82;
            }
        }

        @keyframes photoFloat {
            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-0.7rem);
            }
        }

        @media (max-width: 1100px) {
            .hero-stage {
                grid-template-columns: minmax(0, 0.92fr) minmax(18rem, 1.08fr);
            }

            .hero-photo {
                width: min(33rem, 100%);
            }
        }

        @media (max-width: 900px) {
            body.home-page {
                overflow-y: auto;
            }

            body.home-page .page-main {
                min-height: auto;
            }

            .home-hero {
                min-height: auto;
                padding-bottom: 3rem;
            }

            .hero-stage {
                grid-template-columns: 1fr;
                min-height: auto;
                gap: 2rem;
            }

            .hero-copy {
                max-width: 36rem;
                margin: 0 auto;
                text-align: center;
            }

            .hero-copy p,
            .hero-highlights {
                margin-left: auto;
                margin-right: auto;
                justify-content: center;
            }

            .hero-actions {
                justify-content: center;
            }

            .hero-like-strip {
                margin-left: auto;
                margin-right: auto;
                justify-content: center;
            }

            .hero-visual {
                display: flex;
                align-items: flex-end;
                justify-content: center;
                min-height: 27rem;
                overflow: hidden;
            }

            .hero-visual::after {
                inset: auto -8% -1.15rem -8%;
                height: 7.2rem;
            }

            .hero-grid {
                inset: 4% 0 10% 0;
                background-size: 3rem 3rem;
            }

            .hero-photo {
                position: relative;
                left: auto;
                right: auto;
                bottom: -0.45rem;
                width: min(24rem, 90vw);
                transform: none;
                margin: 0 auto;
            }

            .hero-ambient {
                left: 50%;
                width: 24rem;
                height: 24rem;
                transform: translateX(-50%);
            }

            .hero-wave.one {
                top: 40%;
            }
        }

        @media (max-width: 640px) {
            .home-hero {
                padding-top: 0.65rem;
                padding-bottom: 2.2rem;
            }

            .hero-copy {
                max-width: 100%;
            }

            .hero-eyebrow {
                gap: 0.6rem;
                font-size: 0.72rem;
                letter-spacing: 0.16em;
            }

            .hero-title {
                font-size: clamp(2.25rem, 13vw, 3.5rem);
                line-height: 0.95;
            }

            .hero-copy p {
                max-width: 100%;
                font-size: 0.92rem;
                line-height: 1.78;
            }

            .hero-actions {
                flex-direction: column;
                align-items: stretch;
                margin-top: 1.35rem;
            }

            .hero-actions .button {
                width: 100%;
            }

            .hero-highlights {
                gap: 0.65rem 0.85rem;
                margin-top: 1.35rem;
            }

            .hero-highlights span {
                font-size: 0.68rem;
                letter-spacing: 0.1em;
            }

            .hero-visual {
                min-height: 19rem;
            }

            .hero-visual::after {
                inset: auto -10% -0.95rem -10%;
                height: 5.4rem;
            }

            .hero-grid {
                inset: 6% 0 12% 0;
                background-size: 2.3rem 2.3rem;
            }

            .hero-photo {
                width: min(17rem, 88vw);
                bottom: -0.8rem;
            }

            .hero-photo img {
                margin: 0 auto;
            }

            .hero-rings.secondary,
            .hero-beam.two,
            .hero-trace.two {
                display: none;
            }
        }

        @media (max-width: 420px) {
            .hero-visual {
                min-height: 17rem;
            }

            .hero-visual::after {
                height: 4.8rem;
            }

            .hero-photo {
                width: min(15rem, 84vw);
                bottom: -0.95rem;
            }

            .hero-ambient {
                width: 18rem;
                height: 18rem;
            }

            .hero-wave.one,
            .hero-beam.one,
            .hero-trace.one {
                opacity: 0.18;
            }
        }
    </style>
@endpush

@section('content')
    <section class="page-section home-hero">
        <div class="container hero-stage">
            <div class="hero-copy">
                <span class="hero-eyebrow">{{ $owner['role'] }}</span>
                <h1 class="hero-title">
                    <span>Selamat Datang</span>
                    <span class="accent">di Portofolio</span>
                    <span>Winky Tio</span>
                    <span>Pratama</span>
                </h1>

                <div class="hero-actions">
                    <a class="button primary" href="{{ route('projects') }}">View Projects</a>
                    <a class="button secondary" href="{{ route('about') }}">About Me</a>
                </div>

                @if (isset($siteLikeSummary) || isset($visitorSummary))
                    <div class="hero-like-strip">
                        @if (isset($siteLikeSummary))
                            <span class="hero-quick-item">
                                <button
                                    class="hero-like-trigger"
                                    type="button"
                                    data-open-like-prompt
                                    data-liked="false"
                                    aria-label="Buka popup like website"
                                >
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 21.35 10.55 20C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09A6 6 0 0 1 16.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35Z"/>
                                    </svg>
                                </button>

                                <span class="hero-like-meta">
                                    <strong data-site-like-total>{{ $siteLikeSummary['total'] }}</strong>
                                    <span>Like Website</span>
                                </span>
                            </span>
                        @endif

                        @if (isset($visitorSummary))
                            <span class="hero-quick-item">
                                <a class="hero-quick-link" href="{{ route('community') }}" aria-label="Buka halaman community">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M16 11c1.66 0 2.99-1.57 2.99-3.5S17.66 4 16 4s-3 1.57-3 3.5S14.34 11 16 11Zm-8 0c1.66 0 2.99-1.57 2.99-3.5S9.66 4 8 4 5 5.57 5 7.5 6.34 11 8 11Zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13Zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.96 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5Z"/>
                                    </svg>
                                </a>

                                <span class="hero-quick-meta">
                                    <strong data-site-visitor-total>{{ $visitorSummary['total'] }}</strong>
                                    <span>Visitors</span>
                                </span>
                            </span>
                        @endif

                        <span class="hero-quick-item">
                            <a class="hero-quick-link" href="{{ route('contact') }}" aria-label="Buka halaman contact">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-2 .9-2 2l.01 12c0 1.1.89 2 1.99 2H20c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2Zm0 4-8 5-8-5V6l8 5 8-5v2Z"/>
                                </svg>
                            </a>

                            <span class="hero-quick-meta">
                                <strong>Open</strong>
                                <span>Contact</span>
                            </span>
                        </span>
                    </div>
                @endif

                <div class="hero-highlights" aria-label="Core strengths">
                    @foreach ($highlights as $highlight)
                        <span>{{ $highlight }}</span>
                    @endforeach
                </div>
            </div>

            <div class="hero-visual" aria-hidden="true">
                <div class="hero-grid"></div>
                <div class="hero-ambient"></div>
                <div class="hero-rings"></div>
                <div class="hero-rings secondary"></div>
                <div class="hero-wave one"></div>
                <div class="hero-wave two"></div>
                <div class="hero-beam one"></div>
                <div class="hero-beam two"></div>
                <div class="hero-trace one"></div>
                <div class="hero-trace two"></div>

                <div class="hero-particles">
                    <span style="--x: 14%; --y: 22%; --size: 0.28rem; --drift-x: 0.6rem; --drift-y: 0.8rem; --duration: 7.4s; --delay: -0.8s;"></span>
                    <span style="--x: 24%; --y: 18%; --size: 0.34rem; --drift-x: 0.9rem; --drift-y: 0.6rem; --duration: 8.1s; --delay: -2.4s;"></span>
                    <span style="--x: 39%; --y: 14%; --size: 0.25rem; --drift-x: 0.5rem; --drift-y: 0.7rem; --duration: 6.6s; --delay: -1.9s;"></span>
                    <span style="--x: 68%; --y: 26%; --size: 0.3rem; --drift-x: -0.7rem; --drift-y: 0.8rem; --duration: 7.9s; --delay: -0.4s;"></span>
                    <span style="--x: 80%; --y: 31%; --size: 0.22rem; --drift-x: -0.5rem; --drift-y: 0.7rem; --duration: 6.9s; --delay: -1.1s;"></span>
                    <span style="--x: 88%; --y: 43%; --size: 0.34rem; --drift-x: -0.9rem; --drift-y: 0.5rem; --duration: 8.8s; --delay: -2.8s;"></span>
                    <span style="--x: 74%; --y: 58%; --size: 0.22rem; --drift-x: -0.6rem; --drift-y: 0.7rem; --duration: 6.7s; --delay: -1.4s;"></span>
                    <span style="--x: 52%; --y: 66%; --size: 0.18rem; --drift-x: 0.7rem; --drift-y: 0.8rem; --duration: 7.1s; --delay: -2.1s;"></span>
                    <span style="--x: 29%; --y: 74%; --size: 0.24rem; --drift-x: 0.8rem; --drift-y: 0.6rem; --duration: 8.4s; --delay: -1.7s;"></span>
                    <span style="--x: 20%; --y: 63%; --size: 0.2rem; --drift-x: 0.6rem; --drift-y: 0.5rem; --duration: 6.3s; --delay: -0.9s;"></span>
                </div>

                <div class="hero-orb"></div>

                <figure class="hero-photo">
                    <img src="{{ asset('img/winky.png') }}" alt="{{ $owner['name'] }}">
                </figure>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script data-page-script>
        (() => {
            const body = document.body;

            if (!body.classList.contains('home-page')) {
                return;
            }

            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                body.style.removeProperty('--mx');
                body.style.removeProperty('--my');
                return;
            }

            let targetX = 0;
            let targetY = 0;
            let currentX = 0;
            let currentY = 0;
            let frame = null;

            const render = () => {
                currentX += (targetX - currentX) * 0.08;
                currentY += (targetY - currentY) * 0.08;

                body.style.setProperty('--mx', `${currentX.toFixed(2)}px`);
                body.style.setProperty('--my', `${currentY.toFixed(2)}px`);

                if (Math.abs(targetX - currentX) < 0.08 && Math.abs(targetY - currentY) < 0.08) {
                    frame = null;
                    return;
                }

                frame = window.requestAnimationFrame(render);
            };

            const queueRender = () => {
                if (!frame) {
                    frame = window.requestAnimationFrame(render);
                }
            };

            const handlePointerMove = (event) => {
                targetX = ((event.clientX / window.innerWidth) - 0.5) * 34;
                targetY = ((event.clientY / window.innerHeight) - 0.5) * 22;
                queueRender();
            };

            const resetMotion = () => {
                targetX = 0;
                targetY = 0;
                queueRender();
            };

            window.addEventListener('pointermove', handlePointerMove);
            window.addEventListener('pointerleave', resetMotion);
            window.addEventListener('blur', resetMotion);

            window.PortoPage?.onCleanup(() => {
                window.removeEventListener('pointermove', handlePointerMove);
                window.removeEventListener('pointerleave', resetMotion);
                window.removeEventListener('blur', resetMotion);

                if (frame) {
                    window.cancelAnimationFrame(frame);
                }

                body.style.removeProperty('--mx');
                body.style.removeProperty('--my');
            });
        })();
    </script>
@endpush
