@extends('layouts.site')

@push('styles')
    <style data-page-style>
        body.album-open {
            overflow: hidden;
        }

        .about-story-layout {
            align-items: start;
            gap: clamp(1.5rem, 3vw, 2.4rem);
            grid-template-columns: minmax(15.5rem, 0.68fr) minmax(0, 1.32fr);
        }

        .about-hero-section {
            padding-bottom: clamp(0.75rem, 1.6vw, 1.25rem);
        }

        .about-content-section {
            padding-top: clamp(0.4rem, 1vw, 0.9rem);
        }

        .about-story-copy {
            max-width: 46rem;
        }

        .about-story-intro {
            max-width: 40rem;
            margin-bottom: 1.3rem;
        }

        .about-story-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--accent);
        }

        .about-story-eyebrow::before {
            content: "";
            width: 0.55rem;
            height: 0.55rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
            box-shadow: 0 0 16px rgba(139, 233, 255, 0.4);
        }

        .about-story-title {
            margin: 1rem 0 0;
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(2.4rem, 4vw, 4.2rem);
            line-height: 1.06;
            letter-spacing: -0.06em;
            padding-bottom: 0.08em;
        }

        .about-story-title span {
            display: block;
        }

        .about-story-title .accent {
            background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 22px rgba(139, 233, 255, 0.18);
        }

        .about-story-summary {
            max-width: 36rem;
            margin: 1.15rem 0 0;
            color: rgba(239, 250, 248, 0.8);
            line-height: 1.9;
            font-size: 1.06rem;
        }

        .about-story-paragraph {
            max-width: 40rem;
            margin-top: 1.35rem;
            color: rgba(239, 250, 248, 0.84);
            line-height: 1.95;
            font-size: 1.16rem;
        }

        .about-story-paragraph:first-of-type {
            margin-top: 0.4rem;
        }

        .about-side-album {
            display: grid;
            gap: 0.85rem;
            padding: 0.95rem;
            align-self: start;
            width: 100%;
            max-width: 22rem;
            margin-left: 0;
            position: sticky;
            top: 6.5rem;
        }

        .about-side-album-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
        }

        .about-side-album-title {
            display: grid;
            gap: 0.2rem;
        }

        .about-side-album-title strong {
            margin: 0;
            color: var(--accent);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .about-side-album-title span {
            margin: 0;
            color: rgba(239, 250, 248, 0.62);
            font-size: 0.9rem;
        }

        .about-side-album-count {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.64rem 0.82rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(184, 255, 223, 0.12);
            color: rgba(239, 250, 248, 0.78);
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .about-side-album-count::before {
            content: "";
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
            box-shadow: 0 0 18px rgba(113, 239, 176, 0.45);
        }

        .about-side-album-stage {
            position: relative;
            border-radius: 1.15rem;
            overflow: hidden;
            border: 1px solid rgba(184, 255, 223, 0.12);
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.03), rgba(255, 255, 255, 0)),
                rgba(7, 22, 28, 0.86);
        }

        .about-side-album-stage button {
            position: relative;
            display: block;
            width: 100%;
            padding: 0;
            border: 0;
            background: transparent;
            cursor: pointer;
        }

        .about-side-album-stage img {
            width: 100%;
            aspect-ratio: 4 / 5;
            object-fit: cover;
            transition: transform 260ms ease;
        }

        .about-side-album-stage button:hover img,
        .about-side-album-stage button:focus-visible img {
            transform: scale(1.03);
        }

        .about-side-album-overlay {
            position: absolute;
            inset: auto 0 0;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 0.85rem;
            padding: 0.85rem;
            background: linear-gradient(180deg, rgba(3, 16, 21, 0), rgba(3, 16, 21, 0.9));
        }

        .about-side-album-overlay-copy {
            display: grid;
            gap: 0.25rem;
            text-align: left;
        }

        .about-side-album-overlay-copy strong {
            font-size: 0.92rem;
        }

        .about-side-album-overlay-copy span {
            color: rgba(239, 250, 248, 0.72);
            font-size: 0.8rem;
        }

        .about-side-album-index {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.55rem;
            padding: 0.45rem 0.58rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.12);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        .about-side-album-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .about-side-album-hint {
            color: rgba(239, 250, 248, 0.62);
            font-size: 0.8rem;
            line-height: 1.7;
        }

        .about-side-album-actions {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }

        .about-side-album-nav {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border: 1px solid rgba(184, 255, 223, 0.14);
            border-radius: 50%;
            background: rgba(7, 22, 28, 0.74);
            color: var(--text);
            cursor: pointer;
            transition: transform 180ms ease, border-color 180ms ease, background 180ms ease;
        }

        .about-side-album-nav:hover,
        .about-side-album-nav:focus-visible,
        .about-side-thumb:hover,
        .about-side-thumb:focus-visible,
        .about-lightbox-nav:hover,
        .about-lightbox-nav:focus-visible,
        .about-lightbox-close:hover,
        .about-lightbox-close:focus-visible,
        .about-lightbox-thumb:hover,
        .about-lightbox-thumb:focus-visible {
            transform: translateY(-2px);
            border-color: rgba(184, 255, 223, 0.28);
            outline: none;
        }

        .about-side-thumb-track {
            display: grid;
            grid-auto-flow: column;
            grid-auto-columns: 3.8rem;
            gap: 0.55rem;
            overflow-x: auto;
            padding: 0.15rem 0.1rem 0.2rem;
            scroll-snap-type: x proximity;
            scrollbar-width: thin;
            scrollbar-color: rgba(184, 255, 223, 0.28) rgba(255, 255, 255, 0.03);
            cursor: grab;
            touch-action: pan-y;
        }

        .about-side-thumb-track::-webkit-scrollbar {
            height: 0.45rem;
        }

        .about-side-thumb-track::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 999px;
        }

        .about-side-thumb-track::-webkit-scrollbar-thumb {
            border-radius: 999px;
            background: rgba(184, 255, 223, 0.24);
        }

        .about-side-thumb-track.is-dragging {
            cursor: grabbing;
            scroll-snap-type: none;
            user-select: none;
        }

        .about-side-thumb {
            scroll-snap-align: start;
            padding: 0;
            border: 1px solid rgba(184, 255, 223, 0.12);
            border-radius: 0.85rem;
            background: rgba(7, 22, 28, 0.86);
            overflow: hidden;
            cursor: pointer;
            opacity: 0.68;
            transition: transform 180ms ease, border-color 180ms ease, opacity 180ms ease;
        }

        .about-side-thumb.is-active {
            opacity: 1;
            border-color: rgba(184, 255, 223, 0.32);
            box-shadow: 0 0 0 2px rgba(113, 239, 176, 0.12);
        }

        .about-side-thumb img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
        }

        .about-lightbox[hidden] {
            display: none;
        }

        .about-lightbox {
            position: fixed;
            inset: 0;
            z-index: 60;
            display: grid;
            place-items: center;
            padding: 1rem;
        }

        .about-lightbox-backdrop {
            position: absolute;
            inset: 0;
            padding: 0;
            border: 0;
            background: rgba(1, 8, 11, 0.84);
            backdrop-filter: blur(14px);
            cursor: pointer;
        }

        .about-lightbox-dialog {
            position: relative;
            z-index: 1;
            width: min(1120px, 100%);
            max-height: calc(100vh - 2rem);
            display: grid;
            gap: 1rem;
            padding: clamp(1rem, 2.5vw, 1.35rem);
            border-radius: 1.6rem;
            background:
                linear-gradient(145deg, rgba(9, 28, 34, 0.94), rgba(8, 22, 28, 0.88)),
                rgba(8, 24, 30, 0.84);
            border: 1px solid rgba(184, 255, 223, 0.14);
            box-shadow: 0 30px 120px rgba(0, 0, 0, 0.42);
        }

        .about-lightbox-topbar {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }

        .about-lightbox-meta {
            display: grid;
            gap: 0.35rem;
        }

        .about-lightbox-meta strong {
            font-size: 1.2rem;
        }

        .about-lightbox-meta span {
            color: rgba(239, 250, 248, 0.66);
            font-size: 0.92rem;
        }

        .about-lightbox-close,
        .about-lightbox-nav,
        .about-lightbox-thumb {
            border: 1px solid rgba(184, 255, 223, 0.14);
            background: rgba(5, 19, 24, 0.78);
            color: var(--text);
        }

        .about-lightbox-close {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 180ms ease, border-color 180ms ease, background 180ms ease;
        }

        .about-lightbox-frame {
            position: relative;
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 1rem;
            min-height: 0;
        }

        .about-lightbox-figure {
            min-height: 0;
            display: grid;
            place-items: center;
            padding: clamp(0.5rem, 1vw, 0.9rem);
            border-radius: 1.4rem;
            background: rgba(3, 14, 18, 0.74);
            border: 1px solid rgba(184, 255, 223, 0.08);
        }

        .about-lightbox-figure img {
            width: auto;
            max-width: 100%;
            max-height: calc(100vh - 15rem);
            border-radius: 1rem;
            object-fit: contain;
        }

        .about-lightbox-nav {
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 180ms ease, border-color 180ms ease, background 180ms ease;
        }

        .about-lightbox-thumbs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(4.5rem, 1fr));
            gap: 0.75rem;
            max-height: 11rem;
            overflow-y: auto;
            padding-right: 0.2rem;
        }

        .about-lightbox-thumb {
            padding: 0;
            border-radius: 1rem;
            overflow: hidden;
            cursor: pointer;
            transition: transform 180ms ease, border-color 180ms ease, opacity 180ms ease;
            opacity: 0.72;
        }

        .about-lightbox-thumb.is-active {
            opacity: 1;
            border-color: rgba(184, 255, 223, 0.32);
            box-shadow: 0 0 0 2px rgba(113, 239, 176, 0.12);
        }

        .about-lightbox-thumb img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
        }

        @media (max-width: 960px) {
            .about-story-layout {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }

            .about-story-copy {
                order: -1;
                max-width: none;
            }

            .about-side-album {
                position: static;
                order: 1;
                max-width: min(100%, 20.5rem);
                margin: 0 auto 0 0;
            }

            .about-side-album-head,
            .about-side-album-toolbar,
            .about-lightbox-topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .about-lightbox-frame {
                grid-template-columns: 1fr;
            }

            .about-lightbox-nav {
                display: none;
            }

            .about-lightbox-figure img {
                max-height: calc(100vh - 20rem);
            }

            .about-story-intro {
                max-width: none;
                margin-bottom: 1rem;
            }

            .about-story-title {
                font-size: clamp(2rem, 10vw, 3.15rem);
                line-height: 1.04;
            }

            .about-story-summary {
                max-width: none;
                font-size: 0.98rem;
            }

            .about-story-paragraph {
                max-width: none;
                margin-top: 1.05rem;
                font-size: 1rem;
                line-height: 1.85;
            }
        }

        @media (max-width: 720px) {
            .about-side-album {
                max-width: 100%;
                padding: 0.8rem;
            }

            .about-side-album-head {
                align-items: flex-start;
            }

            .about-side-album-toolbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .about-side-thumb-track {
                grid-auto-columns: 3.15rem;
                gap: 0.45rem;
            }

            .about-story-title {
                font-size: clamp(1.9rem, 12vw, 2.65rem);
                line-height: 1.05;
            }

            .about-story-summary {
                font-size: 0.94rem;
                line-height: 1.8;
            }

            .about-story-paragraph {
                font-size: 0.96rem;
                line-height: 1.78;
            }

            .about-lightbox {
                padding: 0.6rem;
            }

            .about-lightbox-dialog {
                gap: 0.85rem;
                padding: 0.85rem;
                max-height: calc(100vh - 1.2rem);
                border-radius: 1.2rem;
            }

            .about-lightbox-meta strong {
                font-size: 1.02rem;
            }

            .about-lightbox-figure img {
                max-height: calc(100vh - 16rem);
            }

            .about-lightbox-thumbs {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                max-height: 8.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <section class="page-section about-hero-section">
        <div class="container">
            <span class="section-kicker">About</span>
            <h1 class="page-title">{{ $about['headline'] }}</h1>
        </div>
    </section>

    <section class="page-section about-content-section">
        <div class="container split-grid about-story-layout">
            <aside class="surface about-side-album" data-album-root>
                <div class="about-side-album-head">
                    <div class="about-side-album-title">
                        <strong>Album</strong>
                        <span>Foto singkat tentang saya</span>
                    </div>

                    <div class="about-side-album-count">{{ count($galleryPhotos) }} Foto</div>
                </div>

                <div class="about-side-album-stage">
                    <button type="button" data-album-preview-open aria-label="Buka foto aktif">
                        <img src="{{ $galleryPhotos[0]['src'] }}" alt="{{ $galleryPhotos[0]['alt'] }}" data-album-preview-image>

                        <div class="about-side-album-overlay">
                            <div class="about-side-album-overlay-copy">
                                <strong data-album-preview-caption>{{ $galleryPhotos[0]['caption'] }}</strong>
                                <span>Klik untuk lihat ukuran besar</span>
                            </div>

                            <span class="about-side-album-index" data-album-preview-index>01</span>
                        </div>
                    </button>
                </div>

                <div class="about-side-album-toolbar">
                    <div class="about-side-album-hint">Geser thumbnail atau pakai tombol panah.</div>

                    <div class="about-side-album-actions" aria-label="Album navigation">
                        <button class="about-side-album-nav" type="button" data-album-step="prev" aria-label="Foto sebelumnya">
                            &#8592;
                        </button>
                        <button class="about-side-album-nav" type="button" data-album-step="next" aria-label="Foto berikutnya">
                            &#8594;
                        </button>
                    </div>
                </div>

                <div class="about-side-thumb-track" data-album-track>
                    @foreach ($galleryPhotos as $photo)
                        <button
                            class="about-side-thumb {{ $loop->first ? 'is-active' : '' }}"
                            type="button"
                            data-album-thumb="{{ $loop->index }}"
                            aria-label="Pilih {{ $photo['caption'] }}"
                        >
                            <img src="{{ $photo['src'] }}" alt="{{ $photo['alt'] }}" loading="lazy">
                        </button>
                    @endforeach
                </div>

                <div class="about-lightbox" data-album-lightbox hidden>
                    <button class="about-lightbox-backdrop" type="button" data-album-close tabindex="-1" aria-hidden="true"></button>

                    <div class="about-lightbox-dialog" role="dialog" aria-modal="true" aria-label="Porto album viewer">
                        <div class="about-lightbox-topbar">
                            <div class="about-lightbox-meta">
                                <strong data-album-caption>{{ $galleryPhotos[0]['caption'] }}</strong>
                                <span data-album-counter>1 / {{ count($galleryPhotos) }}</span>
                            </div>

                            <button class="about-lightbox-close" type="button" data-album-close aria-label="Tutup album">
                                &#10005;
                            </button>
                        </div>

                        <div class="about-lightbox-frame">
                            <button class="about-lightbox-nav" type="button" data-album-step="prev" aria-label="Foto sebelumnya">
                                &#8592;
                            </button>

                            <figure class="about-lightbox-figure">
                                <img src="{{ $galleryPhotos[0]['src'] }}" alt="{{ $galleryPhotos[0]['alt'] }}" data-album-image>
                            </figure>

                            <button class="about-lightbox-nav" type="button" data-album-step="next" aria-label="Foto berikutnya">
                                &#8594;
                            </button>
                        </div>

                        <div class="about-lightbox-thumbs" data-album-thumbs>
                            @foreach ($galleryPhotos as $photo)
                                <button
                                    class="about-lightbox-thumb {{ $loop->first ? 'is-active' : '' }}"
                                    type="button"
                                    data-album-thumb="{{ $loop->index }}"
                                    aria-label="Pilih {{ $photo['caption'] }}"
                                >
                                    <img src="{{ $photo['src'] }}" alt="{{ $photo['alt'] }}" loading="lazy">
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            <div class="about-story-copy">
                <div class="about-story-intro">
                    <span class="about-story-eyebrow">About Me</span>
                    <h2 class="about-story-title">
                        <span>Musik, teknologi,</span>
                        <span class="accent">dan kreativitas digital.</span>
                    </h2>
                    <p class="about-story-summary">{{ $about['summary'] }}</p>
                </div>

                @foreach ($about['story'] as $paragraph)
                    <p class="about-story-paragraph">
                        {{ $paragraph }}
                    </p>
                @endforeach

                @if (filled($about['points']))
                    <div class="details-list" style="margin-top: 2rem;">
                        @foreach ($about['points'] as $point)
                            <article class="details-item">
                                <h3>{{ $point['title'] }}</h3>
                                <p>{{ $point['copy'] }}</p>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script data-page-script>
        (() => {
            const root = document.querySelector('[data-album-root]');

            if (!root) {
                return;
            }

            const photos = @json($galleryPhotos);
            const body = document.body;
            const track = root.querySelector('[data-album-track]');
            const previewButton = root.querySelector('[data-album-preview-open]');
            const previewImage = root.querySelector('[data-album-preview-image]');
            const previewCaption = root.querySelector('[data-album-preview-caption]');
            const previewIndex = root.querySelector('[data-album-preview-index]');
            const lightbox = root.querySelector('[data-album-lightbox]');
            const lightboxImage = root.querySelector('[data-album-image]');
            const lightboxCaption = root.querySelector('[data-album-caption]');
            const lightboxCounter = root.querySelector('[data-album-counter]');
            const thumbButtons = Array.from(root.querySelectorAll('[data-album-thumb]'));
            const closeButtons = Array.from(root.querySelectorAll('[data-album-close]'));
            const navButtons = Array.from(root.querySelectorAll('[data-album-step]'));

            let activeIndex = 0;
            let lastTrigger = null;
            let pointerDown = false;
            let dragMoved = false;
            let startX = 0;
            let startScrollLeft = 0;

            const renderActivePhoto = (index) => {
                activeIndex = (index + photos.length) % photos.length;

                const activePhoto = photos[activeIndex];
                previewImage.src = activePhoto.src;
                previewImage.alt = activePhoto.alt;
                previewCaption.textContent = activePhoto.caption;
                previewIndex.textContent = String(activeIndex + 1).padStart(2, '0');
                lightboxImage.src = activePhoto.src;
                lightboxImage.alt = activePhoto.alt;
                lightboxCaption.textContent = activePhoto.caption;
                lightboxCounter.textContent = `${activeIndex + 1} / ${photos.length}`;

                thumbButtons.forEach((button) => {
                    const thumbIndex = Number(button.dataset.albumThumb);
                    const isActive = thumbIndex === activeIndex;
                    button.classList.toggle('is-active', isActive);
                    button.setAttribute('aria-current', isActive ? 'true' : 'false');

                    if (isActive && button.offsetParent !== null) {
                        button.scrollIntoView({ block: 'nearest', inline: 'nearest', behavior: 'smooth' });
                    }
                });
            };

            const openLightbox = (index, trigger) => {
                lastTrigger = trigger ?? null;
                renderActivePhoto(index);
                lightbox.hidden = false;
                body.classList.add('album-open');
                root.querySelector('.about-lightbox-close')?.focus();
            };

            const closeLightbox = () => {
                lightbox.hidden = true;
                body.classList.remove('album-open');
                lastTrigger?.focus();
            };

            const handlePreviewClick = () => {
                openLightbox(activeIndex, previewButton);
            };

            previewButton.addEventListener('click', handlePreviewClick);

            const closeHandlers = closeButtons.map((button) => {
                button.addEventListener('click', closeLightbox);
                return { button, handler: closeLightbox };
            });

            const navHandlers = navButtons.map((button) => {
                const handler = () => {
                    renderActivePhoto(activeIndex + (button.dataset.albumStep === 'next' ? 1 : -1));
                };

                button.addEventListener('click', handler);

                return { button, handler };
            });

            const thumbHandlers = thumbButtons.map((button) => {
                const handler = (event) => {
                    if (dragMoved && button.closest('[data-album-track]')) {
                        event.preventDefault();
                        return;
                    }

                    renderActivePhoto(Number(button.dataset.albumThumb));
                };

                button.addEventListener('click', handler);

                return { button, handler };
            });

            const handlePointerDown = (event) => {
                pointerDown = true;
                dragMoved = false;
                startX = event.clientX;
                startScrollLeft = track.scrollLeft;
                track.classList.add('is-dragging');
                track.setPointerCapture(event.pointerId);
            };

            const handlePointerMove = (event) => {
                if (!pointerDown) {
                    return;
                }

                const delta = event.clientX - startX;

                if (Math.abs(delta) > 6) {
                    dragMoved = true;
                }

                track.scrollLeft = startScrollLeft - delta;
            };

            const stopDragging = () => {
                pointerDown = false;
                track.classList.remove('is-dragging');

                window.setTimeout(() => {
                    dragMoved = false;
                }, 80);
            };

            track.addEventListener('pointerdown', handlePointerDown);
            track.addEventListener('pointermove', handlePointerMove);
            track.addEventListener('pointerup', stopDragging);
            track.addEventListener('pointerleave', stopDragging);
            track.addEventListener('pointercancel', stopDragging);

            const handleKeydown = (event) => {
                if (lightbox.hidden) {
                    return;
                }

                if (event.key === 'Escape') {
                    closeLightbox();
                }

                if (event.key === 'ArrowRight') {
                    renderActivePhoto(activeIndex + 1);
                }

                if (event.key === 'ArrowLeft') {
                    renderActivePhoto(activeIndex - 1);
                }
            };

            document.addEventListener('keydown', handleKeydown);

            renderActivePhoto(0);

            window.PortoPage?.onCleanup(() => {
                previewButton.removeEventListener('click', handlePreviewClick);
                closeHandlers.forEach(({ button, handler }) => {
                    button.removeEventListener('click', handler);
                });
                navHandlers.forEach(({ button, handler }) => {
                    button.removeEventListener('click', handler);
                });
                thumbHandlers.forEach(({ button, handler }) => {
                    button.removeEventListener('click', handler);
                });
                track.removeEventListener('pointerdown', handlePointerDown);
                track.removeEventListener('pointermove', handlePointerMove);
                track.removeEventListener('pointerup', stopDragging);
                track.removeEventListener('pointerleave', stopDragging);
                track.removeEventListener('pointercancel', stopDragging);
                document.removeEventListener('keydown', handleKeydown);
                body.classList.remove('album-open');
            });
        })();
    </script>
@endpush
