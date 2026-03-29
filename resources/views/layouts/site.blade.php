<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $pageTitle ?? config('forto.brand.name') }} | {{ config('forto.brand.name') }}</title>
        <meta
            name="description"
            content="Porto adalah portfolio multi-page dengan halaman terpisah untuk home, about, projects, contact, dan login."
        >
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon-pt.svg') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link
            href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800|space-grotesk:400,500,700"
            rel="stylesheet"
        />

        <style>
            :root {
                --bg: #031015;
                --bg-soft: #06171d;
                --panel: rgba(8, 24, 30, 0.72);
                --panel-soft: rgba(8, 24, 30, 0.44);
                --line: rgba(184, 255, 223, 0.14);
                --line-strong: rgba(184, 255, 223, 0.28);
                --text: #effaf8;
                --muted: #a9c7c0;
                --accent: #b8ffd8;
                --accent-strong: #71efb0;
                --accent-cyan: #8be9ff;
                --shadow: 0 24px 80px rgba(0, 0, 0, 0.34);
                --radius: 1.4rem;
            }

            * {
                box-sizing: border-box;
            }

            html {
                scroll-behavior: smooth;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: "Manrope", sans-serif;
                color: var(--text);
                background:
                    radial-gradient(circle at top left, rgba(123, 225, 255, 0.08), transparent 24%),
                    radial-gradient(circle at top right, rgba(113, 255, 190, 0.12), transparent 24%),
                    linear-gradient(180deg, #031015 0%, #04171d 52%, #051a21 100%);
                overflow-x: hidden;
            }

            body.like-prompt-open {
                overflow: hidden;
            }

            body::before,
            body::after {
                content: "";
                position: fixed;
                inset: 0;
                pointer-events: none;
                z-index: 0;
            }

            body::before {
                background:
                    linear-gradient(90deg, rgba(4, 16, 21, 0.86) 0%, rgba(4, 16, 21, 0.32) 18%, rgba(4, 16, 21, 0.06) 50%, rgba(4, 16, 21, 0.32) 82%, rgba(4, 16, 21, 0.86) 100%),
                    linear-gradient(180deg, rgba(4, 16, 21, 0.12) 0%, rgba(4, 16, 21, 0.02) 36%, rgba(4, 16, 21, 0.28) 100%);
            }

            body::after {
                background-image:
                    radial-gradient(circle at 18% 18%, rgba(255, 255, 255, 0.54) 0 0.55px, transparent 0.9px),
                    radial-gradient(circle at 74% 26%, rgba(255, 255, 255, 0.35) 0 0.55px, transparent 0.9px),
                    radial-gradient(circle at 62% 74%, rgba(255, 255, 255, 0.28) 0 0.55px, transparent 0.9px);
                background-size: 180px 180px;
                opacity: 0.16;
            }

            a {
                color: inherit;
                text-decoration: none;
            }

            img {
                display: block;
                max-width: 100%;
            }

            button,
            input,
            textarea {
                font: inherit;
            }

            .container {
                position: relative;
                z-index: 1;
                width: min(1180px, calc(100% - 2rem));
                margin: 0 auto;
            }

            .site-header {
                position: sticky;
                top: 0;
                z-index: 20;
                backdrop-filter: blur(14px);
                background: linear-gradient(180deg, rgba(3, 16, 21, 0.78), rgba(3, 16, 21, 0.28));
                border-bottom: 1px solid rgba(184, 255, 223, 0.06);
            }

            .header-inner {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                padding: 1rem 0;
            }

            .brand {
                display: inline-flex;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .brand-mark {
                font-family: "Space Grotesk", sans-serif;
                font-size: 2rem;
                font-weight: 700;
                line-height: 0.95;
                letter-spacing: -0.12em;
                color: var(--accent);
                text-shadow: 0 0 18px rgba(113, 239, 176, 0.24);
            }

            .brand-copy {
                display: grid;
                gap: 0.08rem;
                padding-top: 0.15rem;
            }

            .brand-copy strong,
            .brand-copy span {
                line-height: 1;
                text-transform: uppercase;
                letter-spacing: 0.14em;
            }

            .brand-copy strong {
                font-size: 0.98rem;
            }

            .brand-copy span {
                font-size: 0.8rem;
                color: var(--muted);
            }

            .site-nav {
                display: inline-flex;
                align-items: center;
                gap: 0.35rem;
                padding: 0.3rem 0.4rem;
                border-radius: 999px;
                background: rgba(8, 24, 30, 0.26);
                border: 1px solid rgba(184, 255, 223, 0.06);
            }

            .site-nav a {
                position: relative;
                padding: 0.72rem 0.96rem;
                font-size: 0.82rem;
                font-weight: 600;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                color: rgba(239, 250, 248, 0.86);
                transition: color 180ms ease;
            }

            .site-nav a::after {
                content: "";
                position: absolute;
                left: 1rem;
                right: 1rem;
                bottom: 0.3rem;
                height: 2px;
                border-radius: 999px;
                background: linear-gradient(90deg, rgba(184, 255, 223, 0.92), rgba(184, 255, 223, 0.18));
                transform: scaleX(0);
                transform-origin: left;
                transition: transform 180ms ease;
            }

            .site-nav a:hover,
            .site-nav a:focus-visible,
            .site-nav a.active {
                color: var(--text);
                outline: none;
            }

            .site-nav a:hover::after,
            .site-nav a:focus-visible::after,
            .site-nav a.active::after {
                transform: scaleX(1);
            }

            .header-actions {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .button,
            .button-inline {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.7rem;
                border-radius: 999px;
                border: 1px solid transparent;
                transition: transform 180ms ease, box-shadow 180ms ease, border-color 180ms ease, background 180ms ease;
            }

            .button {
                min-width: 10rem;
                padding: 0.92rem 1.4rem;
                font-weight: 700;
                letter-spacing: 0.04em;
            }

            .button.small {
                min-width: auto;
                padding: 0.7rem 1rem;
                font-size: 0.86rem;
            }

            .button.primary {
                background: linear-gradient(135deg, rgba(113, 239, 176, 0.96), rgba(139, 233, 255, 0.88));
                color: #031015;
                box-shadow: 0 16px 34px rgba(89, 214, 160, 0.24);
            }

            .button.secondary,
            .button.ghost {
                background: rgba(8, 24, 30, 0.42);
                border-color: rgba(184, 255, 223, 0.16);
                color: var(--text);
                backdrop-filter: blur(14px);
            }

            .button:hover,
            .button:focus-visible {
                transform: translateY(-2px);
                outline: none;
            }

            .button.danger {
                background: rgba(255, 112, 112, 0.08);
                border-color: rgba(255, 147, 147, 0.24);
                color: #ffd5d5;
            }

            .button.danger:hover,
            .button.danger:focus-visible {
                box-shadow: 0 16px 28px rgba(255, 112, 112, 0.12);
            }

            .toast-stack {
                position: fixed;
                top: 5.25rem;
                right: max(1rem, calc((100vw - 1180px) / 2 + 1rem));
                z-index: 40;
                width: min(24rem, calc(100vw - 2rem));
                pointer-events: none;
            }

            .toast {
                position: relative;
                display: grid;
                gap: 0.45rem;
                padding: 1rem 1.05rem 1rem 1.15rem;
                border-radius: 1.2rem;
                border: 1px solid rgba(184, 255, 223, 0.16);
                background:
                    linear-gradient(145deg, rgba(10, 28, 34, 0.96), rgba(8, 23, 29, 0.88)),
                    rgba(8, 24, 30, 0.88);
                box-shadow: 0 28px 54px rgba(0, 0, 0, 0.3);
                backdrop-filter: blur(18px);
                overflow: hidden;
                opacity: 0;
                transform: translate3d(0, -14px, 0) scale(0.98);
                animation: toastIn 320ms ease forwards, toastOut 420ms ease 5.2s forwards;
            }

            .toast::before {
                content: "";
                position: absolute;
                inset: 0 auto 0 0;
                width: 3px;
                background: linear-gradient(180deg, var(--toast-glow), transparent);
            }

            .toast::after {
                content: "";
                position: absolute;
                inset: auto auto -3.4rem -2rem;
                width: 9rem;
                height: 9rem;
                border-radius: 50%;
                background: radial-gradient(circle, var(--toast-surface), transparent 68%);
                filter: blur(6px);
                opacity: 0.75;
            }

            .toast.success {
                --toast-glow: rgba(113, 239, 176, 0.88);
                --toast-surface: rgba(113, 239, 176, 0.16);
            }

            .toast.info {
                --toast-glow: rgba(139, 233, 255, 0.88);
                --toast-surface: rgba(139, 233, 255, 0.18);
            }

            .toast.danger {
                --toast-glow: rgba(255, 138, 138, 0.92);
                --toast-surface: rgba(255, 138, 138, 0.18);
            }

            .toast-label {
                position: relative;
                z-index: 1;
                display: inline-flex;
                align-items: center;
                gap: 0.55rem;
                font-size: 0.76rem;
                font-weight: 700;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: rgba(239, 250, 248, 0.72);
            }

            .toast-label::before {
                content: "";
                width: 0.48rem;
                height: 0.48rem;
                border-radius: 50%;
                background: var(--toast-glow);
                box-shadow: 0 0 14px var(--toast-glow);
            }

            .toast strong,
            .toast p {
                position: relative;
                z-index: 1;
                margin: 0;
            }

            .toast strong {
                font-size: 1rem;
            }

            .toast p {
                color: rgba(239, 250, 248, 0.76);
                line-height: 1.75;
                font-size: 0.92rem;
            }

            @keyframes toastIn {
                to {
                    opacity: 1;
                    transform: translate3d(0, 0, 0) scale(1);
                }
            }

            @keyframes toastOut {
                to {
                    opacity: 0;
                    transform: translate3d(0, -8px, 0) scale(0.98);
                }
            }

            .page-main {
                position: relative;
                z-index: 1;
                padding-bottom: 4rem;
            }

            .page-section {
                padding: clamp(3.5rem, 8vw, 6rem) 0;
            }

            .section-kicker {
                display: inline-flex;
                align-items: center;
                gap: 0.7rem;
                color: var(--accent);
                font-size: 0.8rem;
                font-weight: 700;
                letter-spacing: 0.18em;
                text-transform: uppercase;
            }

            .section-kicker::before {
                content: "";
                width: 2.5rem;
                height: 1px;
                background: linear-gradient(90deg, rgba(184, 255, 223, 0.7), rgba(184, 255, 223, 0.05));
            }

            .page-title {
                margin: 1rem 0 0;
                font-family: "Space Grotesk", sans-serif;
                font-size: clamp(2.4rem, 5vw, 4.6rem);
                line-height: 0.98;
                letter-spacing: -0.05em;
            }

            .page-copy {
                max-width: 42rem;
                margin: 1rem 0 0;
                color: rgba(239, 250, 248, 0.78);
                line-height: 1.9;
                font-size: 1rem;
            }

            .split-grid {
                display: grid;
                grid-template-columns: minmax(0, 1fr) minmax(20rem, 0.85fr);
                gap: 2rem;
            }

            .details-list {
                display: grid;
                gap: 1.4rem;
            }

            .details-item {
                padding-top: 1.35rem;
                border-top: 1px solid rgba(184, 255, 223, 0.12);
            }

            .details-item:first-child {
                padding-top: 0;
                border-top: 0;
            }

            .details-item h3 {
                margin: 0;
                font-size: 1.2rem;
            }

            .details-item p {
                margin: 0.8rem 0 0;
                color: rgba(239, 250, 248, 0.74);
                line-height: 1.8;
            }

            .surface {
                padding: 1.5rem;
                border-radius: var(--radius);
                background:
                    linear-gradient(145deg, rgba(9, 28, 34, 0.88), rgba(8, 22, 28, 0.68)),
                    rgba(8, 24, 30, 0.72);
                border: 1px solid rgba(184, 255, 223, 0.12);
                box-shadow: var(--shadow);
            }

            .project-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 1rem;
            }

            .project-card {
                display: grid;
                gap: 1rem;
                padding: 1.4rem;
                border-radius: var(--radius);
                background:
                    linear-gradient(145deg, rgba(9, 28, 34, 0.86), rgba(8, 22, 28, 0.68)),
                    rgba(8, 24, 30, 0.72);
                border: 1px solid rgba(184, 255, 223, 0.12);
                box-shadow: var(--shadow);
                transition: transform 180ms ease, border-color 180ms ease;
            }

            .project-card:hover,
            .project-card:focus-within {
                transform: translateY(-4px);
                border-color: rgba(184, 255, 223, 0.24);
            }

            .project-card small,
            .status-badge {
                color: var(--accent);
                font-size: 0.76rem;
                font-weight: 700;
                letter-spacing: 0.16em;
                text-transform: uppercase;
            }

            .project-card h3,
            .auth-card h1,
            .dashboard-panel h2 {
                margin: 0;
                font-size: 1.28rem;
            }

            .project-card p,
            .dashboard-panel p {
                margin: 0;
                color: rgba(239, 250, 248, 0.74);
                line-height: 1.8;
            }

            .tag-row {
                display: flex;
                flex-wrap: wrap;
                gap: 0.6rem;
            }

            .tag {
                display: inline-flex;
                align-items: center;
                gap: 0.45rem;
                padding: 0.5rem 0.72rem;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(184, 255, 223, 0.1);
                font-size: 0.8rem;
                color: rgba(239, 250, 248, 0.84);
            }

            .tag::before {
                content: "";
                width: 0.35rem;
                height: 0.35rem;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
            }

            .contact-list {
                display: grid;
                gap: 1rem;
                margin-top: 2rem;
            }

            .contact-row {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                padding: 1rem 0;
                border-bottom: 1px solid rgba(184, 255, 223, 0.12);
            }

            .contact-row strong {
                display: block;
                font-size: 1rem;
            }

            .contact-row span {
                color: rgba(239, 250, 248, 0.72);
            }

            .auth-shell {
                display: grid;
                place-items: center;
                min-height: calc(100svh - 9rem);
            }

            .auth-card {
                width: min(30rem, 100%);
                padding: 2rem;
                border-radius: 1.6rem;
                background:
                    linear-gradient(145deg, rgba(9, 28, 34, 0.92), rgba(8, 22, 28, 0.76)),
                    rgba(8, 24, 30, 0.78);
                border: 1px solid rgba(184, 255, 223, 0.12);
                box-shadow: var(--shadow);
            }

            .auth-card p {
                color: rgba(239, 250, 248, 0.74);
                line-height: 1.8;
            }

            .form-grid {
                display: grid;
                gap: 1rem;
                margin-top: 1.5rem;
            }

            .field {
                display: grid;
                gap: 0.55rem;
            }

            .field label {
                font-size: 0.86rem;
                color: rgba(239, 250, 248, 0.82);
            }

            .field input {
                width: 100%;
                padding: 0.92rem 1rem;
                border-radius: 1rem;
                border: 1px solid rgba(184, 255, 223, 0.12);
                background: rgba(5, 19, 24, 0.88);
                color: var(--text);
                outline: none;
            }

            .field textarea {
                width: 100%;
                min-height: 8.4rem;
                padding: 0.92rem 1rem;
                border-radius: 1rem;
                border: 1px solid rgba(184, 255, 223, 0.12);
                background: rgba(5, 19, 24, 0.88);
                color: var(--text);
                outline: none;
                resize: vertical;
            }

            .field small {
                color: rgba(239, 250, 248, 0.56);
                line-height: 1.6;
            }

            .field input:focus {
                border-color: rgba(184, 255, 223, 0.28);
                box-shadow: 0 0 0 3px rgba(113, 239, 176, 0.12);
            }

            .field textarea:focus {
                border-color: rgba(184, 255, 223, 0.28);
                box-shadow: 0 0 0 3px rgba(113, 239, 176, 0.12);
            }

            .error-text {
                color: #ffb1b1;
                font-size: 0.86rem;
            }

            .dashboard-panel {
                display: grid;
                gap: 1rem;
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
                padding: 0.52rem 0.72rem;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(184, 255, 223, 0.1);
                font-size: 0.82rem;
            }

            .site-footer {
                position: relative;
                z-index: 1;
                padding: 0 0 2.5rem;
                color: rgba(239, 250, 248, 0.56);
                text-align: center;
                font-size: 0.92rem;
                letter-spacing: 0.04em;
            }

            .site-music {
                position: fixed;
                right: max(1rem, calc((100vw - 1180px) / 2 + 1rem));
                bottom: 1.35rem;
                z-index: 45;
                display: grid;
                justify-items: center;
                gap: 0.55rem;
            }

            .site-music-button {
                position: relative;
                width: 3.9rem;
                height: 3.9rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                border: 1px solid rgba(184, 255, 223, 0.16);
                border-radius: 50%;
                background:
                    linear-gradient(145deg, rgba(10, 31, 37, 0.96), rgba(8, 23, 29, 0.92)),
                    rgba(8, 24, 30, 0.92);
                color: #97f2ff;
                box-shadow:
                    0 20px 36px rgba(0, 0, 0, 0.32),
                    inset 0 1px 0 rgba(255, 255, 255, 0.06);
                cursor: pointer;
                overflow: hidden;
                transition: transform 180ms ease, border-color 180ms ease, box-shadow 180ms ease;
            }

            .site-music-button::before {
                content: "";
                position: absolute;
                inset: 0.32rem;
                border-radius: 50%;
                border: 1px solid rgba(184, 255, 223, 0.08);
                opacity: 0.92;
            }

            .site-music-button::after {
                content: "";
                position: absolute;
                inset: auto auto 0.4rem 0.58rem;
                width: 2.2rem;
                height: 2.2rem;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(113, 239, 176, 0.18), transparent 72%);
                filter: blur(8px);
            }

            .site-music-button:hover,
            .site-music-button:focus-visible {
                transform: translateY(-2px) scale(1.02);
                border-color: rgba(184, 255, 223, 0.26);
                box-shadow:
                    0 24px 42px rgba(0, 0, 0, 0.36),
                    0 0 28px rgba(113, 239, 176, 0.14);
                outline: none;
            }

            .site-music-button[data-playing="true"] {
                color: #c9fff1;
                border-color: rgba(184, 255, 223, 0.28);
                box-shadow:
                    0 24px 42px rgba(0, 0, 0, 0.38),
                    0 0 30px rgba(113, 239, 176, 0.18);
            }

            .site-music-disc {
                position: relative;
                z-index: 1;
                width: 2.1rem;
                height: 2.1rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background:
                    radial-gradient(circle at 35% 35%, rgba(139, 233, 255, 0.24), transparent 46%),
                    linear-gradient(145deg, rgba(18, 45, 52, 0.96), rgba(7, 19, 24, 0.96));
                border: 1px solid rgba(184, 255, 223, 0.12);
                box-shadow:
                    inset 0 0 0 0.22rem rgba(3, 16, 21, 0.56),
                    inset 0 0 0 0.5rem rgba(255, 255, 255, 0.02);
                transition: transform 220ms ease;
            }

            .site-music-button[data-playing="true"] .site-music-disc {
                animation: siteMusicSpin 5.2s linear infinite;
            }

            .site-music-disc svg {
                width: 0.92rem;
                height: 0.92rem;
                fill: currentColor;
            }

            .site-music-indicator {
                position: absolute;
                top: 0.72rem;
                right: 0.72rem;
                width: 0.45rem;
                height: 0.45rem;
                border-radius: 50%;
                background: rgba(169, 199, 192, 0.44);
                transition: background 180ms ease, box-shadow 180ms ease;
            }

            .site-music-button[data-playing="true"] .site-music-indicator {
                background: var(--accent-strong);
                box-shadow: 0 0 12px rgba(113, 239, 176, 0.72);
            }

            .site-music-label {
                font-size: 0.68rem;
                font-weight: 700;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                color: rgba(239, 250, 248, 0.58);
            }

            @keyframes siteMusicSpin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            .like-prompt[hidden] {
                display: none;
            }

            .like-prompt {
                position: fixed;
                inset: 0;
                z-index: 70;
                display: grid;
                place-items: center;
                padding: 1rem;
            }

            .like-prompt-backdrop {
                position: absolute;
                inset: 0;
                border: 0;
                background: rgba(1, 7, 10, 0.82);
                backdrop-filter: blur(12px);
                cursor: pointer;
            }

            .like-prompt-dialog {
                position: relative;
                z-index: 1;
                width: min(34rem, 100%);
                display: grid;
                gap: 1rem;
                padding: clamp(1.2rem, 2.5vw, 1.5rem);
                border-radius: 1.6rem;
                background:
                    linear-gradient(145deg, rgba(12, 34, 41, 0.96), rgba(8, 23, 29, 0.92)),
                    rgba(8, 24, 30, 0.9);
                border: 1px solid rgba(184, 255, 223, 0.14);
                box-shadow: 0 32px 80px rgba(0, 0, 0, 0.36);
                overflow: hidden;
            }

            .like-prompt-dialog::before {
                content: "";
                position: absolute;
                top: -4rem;
                right: -3rem;
                width: 11rem;
                height: 11rem;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(139, 233, 255, 0.2), transparent 70%);
                filter: blur(8px);
                pointer-events: none;
            }

            .like-prompt-icon {
                width: 3.4rem;
                height: 3.4rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 1.1rem;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(184, 255, 223, 0.12);
                color: #9cf3ff;
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
            }

            .like-prompt-icon svg,
            .like-prompt-action svg {
                width: 1.4rem;
                height: 1.4rem;
                fill: currentColor;
            }

            .like-prompt-kicker {
                color: var(--accent);
                font-size: 0.78rem;
                font-weight: 700;
                letter-spacing: 0.18em;
                text-transform: uppercase;
            }

            .like-prompt-dialog h2,
            .like-prompt-dialog p,
            .like-prompt-socialproof strong,
            .like-prompt-socialproof span {
                margin: 0;
            }

            .like-prompt-dialog h2 {
                font-family: "Space Grotesk", sans-serif;
                font-size: clamp(2rem, 5vw, 2.8rem);
                line-height: 0.96;
                letter-spacing: -0.05em;
            }

            .like-prompt-dialog p {
                color: rgba(239, 250, 248, 0.76);
                line-height: 1.8;
            }

            .like-prompt-action {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.7rem;
                width: 100%;
                padding: 0.95rem 1.2rem;
                border: 1px solid rgba(184, 255, 223, 0.16);
                border-radius: 999px;
                background: linear-gradient(135deg, rgba(113, 239, 176, 0.96), rgba(139, 233, 255, 0.88));
                color: #031015;
                font-weight: 800;
                cursor: pointer;
                transition: transform 180ms ease, box-shadow 180ms ease;
                box-shadow: 0 18px 34px rgba(89, 214, 160, 0.2);
            }

            .like-prompt-action:hover,
            .like-prompt-action:focus-visible {
                transform: translateY(-2px);
                outline: none;
            }

            .like-prompt-action.is-liked {
                background: rgba(8, 24, 30, 0.42);
                color: var(--text);
                box-shadow: none;
            }

            .like-prompt-socialproof {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                padding: 0.95rem 1rem;
                border-radius: 1.1rem;
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(184, 255, 223, 0.08);
            }

            .like-prompt-socialproof strong {
                display: block;
                font-size: 1.4rem;
            }

            .like-prompt-socialproof span {
                color: rgba(239, 250, 248, 0.62);
                font-size: 0.9rem;
            }

            .like-avatar-row {
                display: flex;
                align-items: center;
                justify-content: flex-end;
            }

            .like-avatar {
                width: 2.4rem;
                height: 2.4rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin-left: -0.55rem;
                border-radius: 50%;
                border: 2px solid rgba(3, 16, 21, 0.88);
                background: linear-gradient(135deg, rgba(113, 239, 176, 0.96), rgba(139, 233, 255, 0.88));
                color: #031015;
                font-size: 0.76rem;
                font-weight: 800;
                letter-spacing: 0.04em;
            }

            .like-avatar:first-child {
                margin-left: 0;
            }

            .like-name-list {
                display: flex;
                flex-wrap: wrap;
                gap: 0.55rem;
            }

            .like-name-pill {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.58rem 0.72rem;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.035);
                border: 1px solid rgba(184, 255, 223, 0.08);
                color: rgba(239, 250, 248, 0.84);
                font-size: 0.84rem;
            }

            .like-name-pill::before {
                content: "";
                width: 0.38rem;
                height: 0.38rem;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
                box-shadow: 0 0 10px rgba(139, 233, 255, 0.22);
            }

            .like-prompt-dismiss {
                justify-self: center;
                padding: 0;
                border: 0;
                background: transparent;
                color: rgba(239, 250, 248, 0.64);
                cursor: pointer;
            }

            @media (max-width: 1024px) {
                .header-inner,
                .split-grid {
                    grid-template-columns: 1fr;
                }

                .header-inner {
                    flex-direction: column;
                    align-items: stretch;
                }

                .site-nav,
                .header-actions {
                    justify-content: center;
                }

                .project-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 1366px) and (min-width: 721px) {
                .site-music {
                    right: 1rem;
                    bottom: 1rem;
                    gap: 0.42rem;
                }

                .site-music-button {
                    width: 3.55rem;
                    height: 3.55rem;
                }

                .site-music-disc {
                    width: 1.95rem;
                    height: 1.95rem;
                }

                .site-music-label {
                    font-size: 0.64rem;
                    letter-spacing: 0.16em;
                }
            }

            @media (max-height: 860px) and (min-width: 721px) {
                .site-music {
                    bottom: 0.8rem;
                }

                .site-music-label {
                    display: none;
                }
            }

            @media (max-width: 840px) {
                .page-section {
                    padding: clamp(2.4rem, 9vw, 4rem) 0;
                }

                .page-title {
                    font-size: clamp(2rem, 11vw, 3.4rem);
                }

                .page-copy {
                    font-size: 0.96rem;
                    line-height: 1.8;
                }

                .toast-stack {
                    top: 4.8rem;
                    right: 0.75rem;
                    width: min(22rem, calc(100vw - 1.5rem));
                }
            }

            @media (max-width: 720px) {
                .container {
                    width: min(1180px, calc(100% - 1rem));
                }

                .site-header {
                    position: static;
                }

                .header-inner {
                    padding: 0.85rem 0;
                    gap: 0.85rem;
                }

                .brand {
                    justify-content: center;
                }

                .brand-mark {
                    font-size: 1.7rem;
                }

                .brand-copy strong {
                    font-size: 0.9rem;
                }

                .brand-copy span {
                    font-size: 0.72rem;
                }

                .site-nav {
                    width: 100%;
                    flex-wrap: wrap;
                    gap: 0.2rem;
                    padding: 0.25rem;
                }

                .site-nav a {
                    flex: 1 1 calc(50% - 0.2rem);
                    padding: 0.72rem 0.58rem;
                    font-size: 0.72rem;
                    text-align: center;
                    letter-spacing: 0.12em;
                }

                .header-actions {
                    width: 100%;
                }

                .header-actions > * {
                    flex: 1 1 auto;
                }

                .header-actions form,
                .header-actions .button.small {
                    width: 100%;
                }

                .project-grid {
                    grid-template-columns: 1fr;
                }

                .contact-row {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .contact-row .button {
                    width: 100%;
                    min-width: 0;
                }

                .site-footer {
                    padding: 0 0 1.6rem;
                    font-size: 0.82rem;
                    line-height: 1.7;
                }

                .site-music {
                    right: 0.75rem;
                    bottom: 1rem;
                }

                .site-music-button {
                    width: 3.55rem;
                    height: 3.55rem;
                }

                .site-music-disc {
                    width: 1.95rem;
                    height: 1.95rem;
                }
            }

            @media (max-width: 520px) {
                .section-kicker {
                    gap: 0.55rem;
                    font-size: 0.74rem;
                    letter-spacing: 0.14em;
                }

                .section-kicker::before {
                    width: 2rem;
                }

                .page-title {
                    font-size: clamp(1.85rem, 12vw, 2.8rem);
                }

                .page-copy {
                    font-size: 0.92rem;
                }

                .site-nav a {
                    font-size: 0.68rem;
                    letter-spacing: 0.1em;
                }

                .button {
                    padding: 0.88rem 1rem;
                }

                .like-prompt {
                    padding: 0.75rem;
                }

                .like-prompt-dialog {
                    gap: 0.85rem;
                    padding: 1rem;
                    border-radius: 1.2rem;
                }

                .like-prompt-socialproof {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .like-avatar-row {
                    justify-content: flex-start;
                }

                .site-music-button {
                    width: 3.3rem;
                    height: 3.3rem;
                }

                .site-music-disc {
                    width: 1.82rem;
                    height: 1.82rem;
                }

                .site-music-label {
                    font-size: 0.62rem;
                    letter-spacing: 0.14em;
                }
            }
        </style>

        @stack('styles')
    </head>
    @php
        $publicRouteName = request()->route()?->getName();
        $trackablePublicRoutes = ['home', 'about', 'projects', 'contact'];
        $shouldShowLikePrompt = isset($siteLikeSummary);
        $musicTrack = config('forto.music.track');
        $musicTrackUrl = $musicTrack ? asset(str_replace('%2F', '/', rawurlencode($musicTrack))) : null;
    @endphp
    <body
        class="{{ $bodyClass ?? '' }}"
        data-route-name="{{ $publicRouteName ?? '' }}"
        data-public-page="{{ $shouldShowLikePrompt ? $publicRouteName : '' }}"
    >
        <header class="site-header">
            <div class="container header-inner">
                <a class="brand" href="{{ route('home') }}">
                    <div class="brand-mark">{{ config('forto.brand.mark', 'PT.') }}</div>
                    <div class="brand-copy">
                        <strong>{{ config('forto.brand.name') }}</strong>
                    </div>
                </a>

                <nav class="site-nav" aria-label="Main navigation">
                    <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                    <a class="{{ request()->routeIs('projects') ? 'active' : '' }}" href="{{ route('projects') }}">Projects</a>
                    <a class="{{ request()->routeIs('skills') ? 'active' : '' }}" href="{{ route('skills') }}">Skill</a>
                </nav>

                <div class="header-actions">
                    @if (session('forto_admin.authenticated'))
                        <a class="button ghost small" href="{{ route('dashboard') }}">Dashboard</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="button ghost small" type="submit">Logout</button>
                        </form>
                    @else
                        <a class="button ghost small" href="{{ route('login') }}">Login</a>
                    @endif
                </div>
            </div>
        </header>

        @if (session('status'))
            <div class="toast-stack" aria-live="polite">
                <div class="toast {{ session('status_type', 'success') }}">
                    <span class="toast-label">{{ session('status_type', 'success') }}</span>
                    <strong>{{ session('status_title', 'Porto Update') }}</strong>
                    <p>{{ session('status') }}</p>
                </div>
            </div>
        @endif

        <main class="page-main">
            @yield('content')
        </main>

        <footer class="site-footer">
            &copy; {{ now()->year }} {{ strtoupper(config('forto.brand.name')) }}. ALL RIGHTS RESERVED.
        </footer>

        @if ($musicTrackUrl)
            <div class="site-music" data-site-music>
                <audio
                    id="site-music-audio"
                    preload="auto"
                    loop
                    playsinline
                    data-track-url="{{ $musicTrackUrl }}"
                    data-volume="{{ config('forto.music.volume', 0.42) }}"
                ></audio>

                <button
                    class="site-music-button"
                    type="button"
                    data-music-toggle
                    data-playing="false"
                    data-play-label="{{ config('forto.music.label', 'Putar lagu website') }}"
                    data-pause-label="Pause lagu website"
                    aria-pressed="false"
                    aria-label="{{ config('forto.music.label', 'Putar lagu website') }}"
                    title="{{ config('forto.music.label', 'Putar lagu website') }}"
                >
                    <span class="site-music-disc" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 3v10.55a3.95 3.95 0 1 0 2 3.45V8.8l5-1.45V5.27L12 7.3V3Z"/>
                        </svg>
                    </span>
                    <span class="site-music-indicator" aria-hidden="true"></span>
                </button>

                <span class="site-music-label">Lagu</span>
            </div>
        @endif

        @if ($shouldShowLikePrompt)
            <div
                class="like-prompt"
                id="site-like-prompt"
                hidden
                data-current-page="{{ $publicRouteName }}"
                data-required-pages='@json($trackablePublicRoutes)'
                data-like-endpoint="{{ route('site-like.store') }}"
                data-initial-summary='@json($siteLikeSummary)'
            >
                <button class="like-prompt-backdrop" type="button" data-like-close aria-label="Tutup popup like"></button>

                <div class="like-prompt-dialog" role="dialog" aria-modal="true" aria-labelledby="site-like-title">
                    <span class="like-prompt-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 21.35 10.55 20C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09A6 6 0 0 1 16.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35Z"/>
                        </svg>
                    </span>
                    <span class="like-prompt-kicker">Porto Reaction</span>
                    <h2 id="site-like-title">Suka sama website ini?</h2>
                    <p>
                        Kamu sudah keliling halaman utama Porto. Kalau tampilannya cocok, tekan icon hati
                        ini buat kasih like.
                    </p>

                    <button class="like-prompt-action" type="button" data-like-submit>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 21.35 10.55 20C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09A6 6 0 0 1 16.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35Z"/>
                        </svg>
                        <span>Like Website Ini</span>
                    </button>

                    <div class="like-prompt-socialproof">
                        <div>
                            <strong data-like-total>{{ $siteLikeSummary['total'] }}</strong>
                            <span>orang sudah like</span>
                        </div>

                        <div class="like-avatar-row" data-like-avatars>
                            @foreach ($siteLikeSummary['people'] as $person)
                                <span class="like-avatar" title="{{ $person['name'] }}">{{ $person['initials'] }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="like-name-list" data-like-names>
                        @foreach ($siteLikeSummary['people'] as $person)
                            <span class="like-name-pill">{{ $person['name'] }}</span>
                        @endforeach
                    </div>

                    <button class="like-prompt-dismiss" type="button" data-like-close>Nanti saja</button>
                </div>
            </div>
        @endif

        <script>
            (() => {
                if (window.PortoPage) {
                    return;
                }

                const body = document.body;
                const main = document.querySelector('.page-main');
                const pageStyleSelector = 'style[data-page-style]';
                let activeRequest = null;

                const onCleanup = (callback) => {
                    if (typeof callback !== 'function') {
                        return;
                    }

                    window.PortoPage.cleanupFns.push(callback);
                };

                const runCleanup = () => {
                    const callbacks = [...window.PortoPage.cleanupFns];
                    window.PortoPage.cleanupFns = [];

                    callbacks.forEach((callback) => {
                        try {
                            callback();
                        } catch (error) {
                            console.error(error);
                        }
                    });
                };

                const syncBodyDataset = (nextBody) => {
                    const publicPage = nextBody?.dataset.publicPage || '';
                    const routeName = nextBody?.dataset.routeName || '';

                    body.className = nextBody?.className || '';
                    body.dataset.publicPage = publicPage;
                    body.dataset.routeName = routeName;
                };

                const syncNavigation = (pathname) => {
                    document.querySelectorAll('.site-nav a').forEach((link) => {
                        const url = new URL(link.href, window.location.origin);
                        link.classList.toggle('active', url.pathname === pathname);
                    });
                };

                const replacePageStyles = (nextDocument) => {
                    document.head.querySelectorAll(pageStyleSelector).forEach((element) => {
                        element.remove();
                    });

                    nextDocument.querySelectorAll(pageStyleSelector).forEach((element) => {
                        document.head.appendChild(element.cloneNode(true));
                    });
                };

                const executePageScripts = (nextDocument) => {
                    const pageScriptStack = document.getElementById('page-script-stack');

                    if (!pageScriptStack) {
                        return;
                    }

                    pageScriptStack.innerHTML = '';

                    nextDocument.querySelectorAll('script[data-page-script]').forEach((script) => {
                        const clone = document.createElement('script');

                        Array.from(script.attributes).forEach((attribute) => {
                            clone.setAttribute(attribute.name, attribute.value);
                        });

                        clone.textContent = script.textContent;
                        pageScriptStack.appendChild(clone);
                    });
                };

                const applyPageDocument = (nextDocument, url, options = {}) => {
                    if (!main) {
                        window.location.href = url.href;
                        return;
                    }

                    const nextMain = nextDocument.querySelector('.page-main');

                    if (!nextMain) {
                        window.location.href = url.href;
                        return;
                    }

                    runCleanup();
                    window.PortoLikePrompt?.closePrompt(false);
                    replacePageStyles(nextDocument);
                    main.innerHTML = nextMain.innerHTML;
                    syncBodyDataset(nextDocument.body);
                    syncNavigation(url.pathname);
                    document.title = nextDocument.title;
                    executePageScripts(nextDocument);

                    if (window.PortoLikePrompt) {
                        const promptSeed = nextDocument.getElementById('site-like-prompt');
                        window.PortoLikePrompt.syncFromPrompt(promptSeed);
                        window.PortoLikePrompt.recordVisit(body.dataset.routeName || '');
                        window.PortoLikePrompt.syncSummary();
                        window.PortoLikePrompt.syncLikeButtons();
                    }

                    if (options.scroll !== false) {
                        window.scrollTo({ top: 0, left: 0, behavior: 'auto' });
                    }
                };

                const navigate = async (href, options = {}) => {
                    const targetUrl = new URL(href, window.location.origin);
                    const currentUrl = new URL(window.location.href);

                    if (
                        targetUrl.origin !== window.location.origin ||
                        (targetUrl.pathname === currentUrl.pathname &&
                            targetUrl.search === currentUrl.search &&
                            (targetUrl.hash === '' || targetUrl.hash === currentUrl.hash))
                    ) {
                        return;
                    }

                    if (activeRequest) {
                        activeRequest.abort();
                    }

                    activeRequest = new AbortController();

                    try {
                        const response = await fetch(targetUrl.href, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            signal: activeRequest.signal,
                        });

                        if (!response.ok) {
                            throw new Error('Navigation failed');
                        }

                        const html = await response.text();
                        const parser = new DOMParser();
                        const nextDocument = parser.parseFromString(html, 'text/html');
                        const resolvedUrl = new URL(response.url || targetUrl.href);

                        applyPageDocument(nextDocument, resolvedUrl, options);

                        if (options.replace) {
                            window.history.replaceState({}, '', resolvedUrl.href);
                        } else {
                            window.history.pushState({}, '', resolvedUrl.href);
                        }
                    } catch (error) {
                        if (error.name === 'AbortError') {
                            return;
                        }

                        window.location.href = targetUrl.href;
                    } finally {
                        activeRequest = null;
                    }
                };

                const shouldHandleLink = (link, event) => {
                    if (!link) {
                        return false;
                    }

                    if (
                        event.defaultPrevented ||
                        event.button !== 0 ||
                        event.metaKey ||
                        event.ctrlKey ||
                        event.shiftKey ||
                        event.altKey
                    ) {
                        return false;
                    }

                    const href = link.getAttribute('href');

                    if (
                        !href ||
                        href.startsWith('#') ||
                        href.startsWith('mailto:') ||
                        href.startsWith('tel:') ||
                        link.hasAttribute('download') ||
                        link.target === '_blank' ||
                        link.dataset.noPjax !== undefined
                    ) {
                        return false;
                    }

                    const url = new URL(link.href, window.location.origin);

                    if (
                        url.pathname === window.location.pathname &&
                        url.search === window.location.search &&
                        url.hash !== ''
                    ) {
                        return false;
                    }

                    return url.origin === window.location.origin;
                };

                document.addEventListener('click', (event) => {
                    const link = event.target.closest('a[href]');

                    if (!shouldHandleLink(link, event)) {
                        return;
                    }

                    event.preventDefault();
                    navigate(link.href);
                });

                window.addEventListener('popstate', () => {
                    navigate(window.location.href, { replace: true, scroll: false });
                });

                window.PortoPage = {
                    cleanupFns: [],
                    onCleanup,
                    runCleanup,
                    navigate,
                };
            })();
        </script>

        <div id="page-script-stack" hidden>
            @stack('scripts')
        </div>
        @if ($musicTrackUrl)
            <script>
                (() => {
                    const audio = document.getElementById('site-music-audio');
                    const toggle = document.querySelector('[data-music-toggle]');

                    if (!audio || !toggle) {
                        return;
                    }

                    const enabledKey = 'forto.music.enabled';
                    const timeKey = 'forto.music.time';
                    const trackUrl = audio.dataset.trackUrl;
                    const volume = Number.parseFloat(audio.dataset.volume || '0.42');
                    const playLabel = toggle.dataset.playLabel || 'Putar lagu website';
                    const pauseLabel = toggle.dataset.pauseLabel || 'Pause lagu website';
                    let pendingResume = false;
                    let lastStoredSecond = -1;

                    audio.src = trackUrl;
                    audio.volume = Number.isFinite(volume) ? Math.min(Math.max(volume, 0), 1) : 0.42;

                    const syncState = () => {
                        const playing = !audio.paused;
                        toggle.dataset.playing = playing ? 'true' : 'false';
                        toggle.setAttribute('aria-pressed', playing ? 'true' : 'false');
                        toggle.setAttribute('aria-label', playing ? pauseLabel : playLabel);
                        toggle.setAttribute('title', playing ? pauseLabel : playLabel);
                    };

                    const restoreTime = () => {
                        const saved = Number.parseFloat(localStorage.getItem(timeKey) || '0');

                        if (!Number.isFinite(saved) || saved <= 0) {
                            return;
                        }

                        const duration = Number.isFinite(audio.duration) && audio.duration > 0 ? audio.duration : null;

                        if (duration && saved >= duration) {
                            localStorage.setItem(timeKey, '0');

                            return;
                        }

                        try {
                            audio.currentTime = saved;
                        } catch (error) {
                            // Ignore out-of-range seek errors on fresh metadata loads.
                        }
                    };

                    const persistTime = () => {
                        if (!Number.isFinite(audio.currentTime) || audio.currentTime <= 0) {
                            return;
                        }

                        localStorage.setItem(timeKey, String(audio.currentTime));
                    };

                    const attemptPlay = async () => {
                        try {
                            await audio.play();
                            localStorage.setItem(enabledKey, '1');
                            pendingResume = false;
                            syncState();
                        } catch (error) {
                            pendingResume = true;
                            syncState();
                        }
                    };

                    const pauseAudio = () => {
                        audio.pause();
                        persistTime();
                        localStorage.setItem(enabledKey, '0');
                        pendingResume = false;
                        syncState();
                    };

                    const unlockPlayback = () => {
                        if (!pendingResume || localStorage.getItem(enabledKey) !== '1') {
                            return;
                        }

                        attemptPlay();
                    };

                    audio.addEventListener('loadedmetadata', restoreTime, { once: true });
                    audio.addEventListener('play', syncState);
                    audio.addEventListener('pause', syncState);
                    audio.addEventListener('timeupdate', () => {
                        const currentSecond = Math.floor(audio.currentTime);

                        if (currentSecond === lastStoredSecond || currentSecond % 2 !== 0) {
                            return;
                        }

                        lastStoredSecond = currentSecond;
                        persistTime();
                    });

                    window.addEventListener('pagehide', persistTime);
                    document.addEventListener('visibilitychange', () => {
                        if (document.hidden) {
                            persistTime();
                        }
                    });

                    document.addEventListener('pointerdown', unlockPlayback, { passive: true });
                    document.addEventListener('keydown', unlockPlayback);

                    toggle.addEventListener('click', () => {
                        if (audio.paused) {
                            attemptPlay();

                            return;
                        }

                        pauseAudio();
                    });

                    if (localStorage.getItem(enabledKey) === '1') {
                        attemptPlay();
                    } else {
                        syncState();
                    }
                })();
            </script>
        @endif
        @if ($shouldShowLikePrompt)
            <script>
                (() => {
                    const prompt = document.getElementById('site-like-prompt');

                    if (!prompt) {
                        return;
                    }

                    const visitedKey = 'forto.public.visited';
                    const likedKey = 'forto.website.liked';
                    const dismissedKey = 'forto.website.like.dismissed';
                    const aliasKey = 'forto.website.like.alias';
                    let currentPage = prompt.dataset.currentPage || document.body.dataset.routeName || '';
                    let requiredPages = JSON.parse(prompt.dataset.requiredPages || '[]');
                    let endpoint = prompt.dataset.likeEndpoint;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                    let summary = JSON.parse(prompt.dataset.initialSummary || '{"total":0,"people":[]}');
                    const totalElement = prompt.querySelector('[data-like-total]');
                    const avatarsElement = prompt.querySelector('[data-like-avatars]');
                    const namesElement = prompt.querySelector('[data-like-names]');
                    const submitButton = prompt.querySelector('[data-like-submit]');
                    const aliasPool = ['Alya', 'Raka', 'Nabila', 'Faris', 'Salsa', 'Arga', 'Nanda', 'Dion'];
                    let autoOpenTimer = null;

                    const renderSummary = (nextSummary = summary) => {
                        summary = {
                            total: Number(nextSummary?.total ?? 0),
                            people: Array.isArray(nextSummary?.people) ? nextSummary.people : [],
                        };

                        totalElement.textContent = summary.total;
                        avatarsElement.innerHTML = summary.people
                            .map((person) => `<span class="like-avatar" title="${person.name}">${person.initials}</span>`)
                            .join('');
                        namesElement.innerHTML = summary.people
                            .map((person) => `<span class="like-name-pill">${person.name}</span>`)
                            .join('');
                        document.querySelectorAll('[data-site-like-total]').forEach((element) => {
                            element.textContent = summary.total;
                        });
                        document.querySelectorAll('[data-site-like-avatars]').forEach((element) => {
                            element.innerHTML = summary.people
                                .map((person) => `<span class="like-avatar" title="${person.name}">${person.initials}</span>`)
                                .join('');
                        });
                        document.querySelectorAll('[data-site-like-names]').forEach((element) => {
                            element.innerHTML = summary.people
                                .map((person) => `<span class="like-name-pill">${person.name}</span>`)
                                .join('');
                        });
                    };

                    const readVisited = () => {
                        try {
                            const parsed = JSON.parse(localStorage.getItem(visitedKey) || '[]');
                            return Array.isArray(parsed) ? parsed : [];
                        } catch {
                            return [];
                        }
                    };

                    const writeVisited = (pages) => {
                        localStorage.setItem(visitedKey, JSON.stringify([...new Set(pages)]));
                    };

                    const readLikedState = () => localStorage.getItem(likedKey) === '1';
                    const readDismissedState = () => localStorage.getItem(dismissedKey) === '1';

                    const ensureAlias = () => {
                        const existing = localStorage.getItem(aliasKey);

                        if (existing) {
                            return existing;
                        }

                        const base = aliasPool[Math.floor(Math.random() * aliasPool.length)];
                        const alias = `${base} ${Math.floor(10 + Math.random() * 90)}`;
                        localStorage.setItem(aliasKey, alias);

                        return alias;
                    };

                    const openPrompt = () => {
                        prompt.hidden = false;
                        document.body.classList.add('like-prompt-open');
                    };

                    const closePrompt = (dismiss = true) => {
                        prompt.hidden = true;
                        document.body.classList.remove('like-prompt-open');

                        if (dismiss) {
                            localStorage.setItem(dismissedKey, '1');
                        }
                    };

                    const syncLikeButtons = () => {
                        const liked = readLikedState();

                        document.querySelectorAll('[data-open-like-prompt]').forEach((button) => {
                            button.dataset.liked = liked ? 'true' : 'false';
                        });

                        if (liked) {
                            submitButton.classList.add('is-liked');
                            submitButton.querySelector('span').textContent = 'Kamu sudah kasih like';
                            submitButton.disabled = false;
                        } else {
                            submitButton.classList.remove('is-liked');
                            submitButton.querySelector('span').textContent = 'Like Website Ini';
                            submitButton.disabled = false;
                        }
                    };

                    const maybeAutoOpenPrompt = () => {
                        const visitedPages = readVisited();
                        const hasVisitedAllPages = requiredPages.every((page) => visitedPages.includes(page));

                        if (autoOpenTimer) {
                            window.clearTimeout(autoOpenTimer);
                            autoOpenTimer = null;
                        }

                        if (hasVisitedAllPages && !readLikedState() && !readDismissedState()) {
                            autoOpenTimer = window.setTimeout(openPrompt, 650);
                        }
                    };

                    const recordVisit = (pageName) => {
                        currentPage = pageName || currentPage;

                        if (currentPage === '') {
                            return;
                        }

                        if (requiredPages.includes(currentPage)) {
                            const visitedPages = new Set(readVisited());
                            visitedPages.add(currentPage);
                            writeVisited([...visitedPages]);
                        }

                        maybeAutoOpenPrompt();
                    };

                    const syncFromPrompt = (seedPrompt) => {
                        if (!seedPrompt) {
                            return;
                        }

                        currentPage = seedPrompt.dataset.currentPage || currentPage;
                        endpoint = seedPrompt.dataset.likeEndpoint || endpoint;

                        try {
                            requiredPages = JSON.parse(seedPrompt.dataset.requiredPages || '[]');
                        } catch {
                            requiredPages = requiredPages;
                        }

                        if (seedPrompt.dataset.initialSummary) {
                            try {
                                renderSummary(JSON.parse(seedPrompt.dataset.initialSummary));
                            } catch {
                                renderSummary(summary);
                            }
                        }
                    };

                    prompt.addEventListener('click', async (event) => {
                        if (event.target.closest('[data-like-close]')) {
                            closePrompt(true);
                            return;
                        }

                        if (!event.target.closest('[data-like-submit]')) {
                            return;
                        }

                        if (submitButton.disabled) {
                            return;
                        }

                        submitButton.disabled = true;

                        try {
                            const response = await fetch(endpoint, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                },
                                body: JSON.stringify({
                                    name: ensureAlias(),
                                }),
                            });

                            if (!response.ok) {
                                throw new Error('Like request failed');
                            }

                            const summary = await response.json();
                            renderSummary(summary);
                            localStorage.setItem(likedKey, '1');
                            localStorage.removeItem(dismissedKey);
                            submitButton.classList.add('is-liked');
                            submitButton.querySelector('span').textContent = 'Makasih, like kamu masuk!';
                            syncLikeButtons();

                            window.setTimeout(() => {
                                closePrompt(false);
                            }, 1200);
                        } catch (error) {
                            submitButton.disabled = false;
                            submitButton.querySelector('span').textContent = 'Coba lagi ya';
                        }
                    });

                    document.addEventListener('click', (event) => {
                        const openButton = event.target.closest('[data-open-like-prompt]');

                        if (!openButton) {
                            return;
                        }

                        event.preventDefault();
                        openPrompt();
                    });

                    window.PortoLikePrompt = {
                        closePrompt,
                        openPrompt,
                        recordVisit,
                        renderSummary,
                        syncFromPrompt,
                        syncSummary: () => renderSummary(summary),
                        syncLikeButtons,
                    };

                    renderSummary(summary);
                    syncLikeButtons();
                    recordVisit(currentPage);
                })();
            </script>
        @endif
    </body>
</html>
