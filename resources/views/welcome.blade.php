<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Porto</title>
        <meta
            name="description"
            content="Porto portfolio dengan hero futuristik, animasi halus, dan karakter utama sebagai fokus visual."
        >

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link
            href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800|space-grotesk:400,500,700"
            rel="stylesheet"
        />

        <style>
            :root {
                --bg: #031015;
                --bg-deep: #05171d;
                --bg-soft: #081f27;
                --panel: rgba(8, 25, 31, 0.68);
                --panel-strong: rgba(8, 25, 31, 0.84);
                --panel-soft: rgba(10, 30, 36, 0.48);
                --line: rgba(183, 255, 220, 0.16);
                --line-strong: rgba(183, 255, 220, 0.36);
                --text: #effaf8;
                --muted: #abc8c2;
                --accent: #b8ffd8;
                --accent-strong: #76f4b2;
                --accent-cyan: #89ecff;
                --accent-soft: #f7fffb;
                --shadow: 0 28px 90px rgba(0, 0, 0, 0.42);
                --glow: rgba(118, 244, 178, 0.42);
                --pointer-x: 0;
                --pointer-y: 0;
                --scroll-shift: 0px;
                --cursor-x: 50vw;
                --cursor-y: 50vh;
                --photo-url: url("{{ asset('img/winky.png') }}");
            }

            * {
                box-sizing: border-box;
            }

            html {
                scroll-behavior: smooth;
            }

            body {
                margin: 0;
                color: var(--text);
                font-family: "Manrope", sans-serif;
                background:
                    radial-gradient(circle at top left, rgba(127, 215, 255, 0.08), transparent 24%),
                    radial-gradient(circle at top right, rgba(133, 255, 196, 0.12), transparent 24%),
                    linear-gradient(180deg, #031015 0%, #04161c 46%, #05181f 100%);
                overflow-x: hidden;
            }

            a {
                color: inherit;
                text-decoration: none;
            }

            button,
            input,
            textarea {
                font: inherit;
            }

            .cursor-spotlight,
            .cursor-ring {
                position: fixed;
                left: 0;
                top: 0;
                pointer-events: none;
                z-index: 40;
                opacity: 0;
                transition: opacity 220ms ease;
            }

            .cursor-spotlight {
                width: 30rem;
                height: 30rem;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(118, 244, 178, 0.18) 0%, rgba(118, 244, 178, 0.08) 26%, transparent 72%);
                mix-blend-mode: screen;
                filter: blur(14px);
                transform: translate3d(calc(var(--cursor-x) - 50%), calc(var(--cursor-y) - 50%), 0);
            }

            .cursor-ring {
                width: 2rem;
                height: 2rem;
                border-radius: 50%;
                border: 1px solid rgba(182, 255, 220, 0.52);
                box-shadow: 0 0 18px rgba(118, 244, 178, 0.26);
                transform: translate3d(calc(var(--cursor-x) - 50%), calc(var(--cursor-y) - 50%), 0);
            }

            .landing {
                position: relative;
                min-height: max(100svh, 48rem);
                overflow: hidden;
                isolation: isolate;
                background:
                    radial-gradient(circle at 54% 36%, rgba(128, 255, 176, 0.24), transparent 28%),
                    radial-gradient(circle at 24% 64%, rgba(104, 225, 255, 0.08), transparent 18%),
                    linear-gradient(180deg, rgba(4, 17, 22, 0.1) 0%, rgba(4, 17, 22, 0.28) 100%);
            }

            .landing::before,
            .landing::after {
                content: "";
                position: absolute;
                inset: 0;
                pointer-events: none;
            }

            .landing::before {
                background:
                    linear-gradient(90deg, rgba(3, 13, 17, 0.84) 0%, rgba(3, 13, 17, 0.32) 22%, rgba(3, 13, 17, 0.08) 50%, rgba(3, 13, 17, 0.32) 78%, rgba(3, 13, 17, 0.84) 100%),
                    linear-gradient(180deg, rgba(4, 16, 21, 0.12) 0%, rgba(4, 16, 21, 0.02) 34%, rgba(4, 16, 21, 0.3) 100%);
                z-index: 1;
            }

            .landing::after {
                background-image:
                    radial-gradient(circle at 16% 16%, rgba(255, 255, 255, 0.75) 0 0.55px, transparent 0.95px),
                    radial-gradient(circle at 78% 22%, rgba(255, 255, 255, 0.42) 0 0.55px, transparent 0.92px),
                    radial-gradient(circle at 58% 72%, rgba(255, 255, 255, 0.36) 0 0.5px, transparent 0.9px);
                background-size: 180px 180px;
                opacity: 0.18;
                z-index: 1;
            }

            .scene {
                position: absolute;
                inset: -4%;
                pointer-events: none;
            }

            .scene.back {
                z-index: 0;
                transform: translate3d(
                    calc(var(--pointer-x) * -34px),
                    calc(var(--pointer-y) * -24px + (var(--scroll-shift) * -0.18)),
                    0
                );
            }

            .scene.front {
                z-index: 2;
                transform: translate3d(
                    calc(var(--pointer-x) * 26px),
                    calc(var(--pointer-y) * 14px + (var(--scroll-shift) * 0.12)),
                    0
                );
            }

            .facet {
                position: absolute;
                background: linear-gradient(145deg, rgba(110, 182, 200, 0.08), rgba(17, 47, 59, 0.01));
                border: 1px solid rgba(130, 220, 229, 0.03);
                opacity: 0.85;
                filter: blur(0.2px);
            }

            .facet.left-1 {
                top: 4%;
                left: -2%;
                width: 29vw;
                height: 35vh;
                clip-path: polygon(0 8%, 100% 0, 84% 100%, 10% 76%);
            }

            .facet.left-2 {
                top: 22%;
                left: 1%;
                width: 23vw;
                height: 28vh;
                clip-path: polygon(4% 0, 100% 18%, 67% 100%, 0 72%);
            }

            .facet.left-3 {
                top: 54%;
                left: -2%;
                width: 25vw;
                height: 22vh;
                clip-path: polygon(0 15%, 100% 0, 88% 100%, 16% 80%);
            }

            .facet.right-1 {
                top: 5%;
                right: -2%;
                width: 31vw;
                height: 35vh;
                clip-path: polygon(16% 0, 100% 12%, 86% 100%, 0 76%);
            }

            .facet.right-2 {
                top: 23%;
                right: 1%;
                width: 24vw;
                height: 26vh;
                clip-path: polygon(14% 0, 100% 12%, 82% 100%, 0 72%);
            }

            .facet.right-3 {
                top: 55%;
                right: -2%;
                width: 24vw;
                height: 23vh;
                clip-path: polygon(8% 0, 100% 20%, 100% 100%, 0 82%);
            }

            .mist {
                position: absolute;
                width: 38rem;
                height: 38rem;
                border-radius: 50%;
                filter: blur(90px);
                opacity: 0.3;
                animation: glowBreath 8s ease-in-out infinite;
            }

            .mist.left {
                top: 12%;
                left: -12rem;
                background: rgba(106, 153, 255, 0.34);
            }

            .mist.right {
                top: 10%;
                right: -13rem;
                background: rgba(108, 255, 177, 0.34);
                animation-delay: -3s;
            }

            .grid {
                position: absolute;
                top: 10%;
                left: 50%;
                width: min(42vw, 44rem);
                height: 68vh;
                transform: translateX(-8%);
                background-image:
                    linear-gradient(rgba(170, 255, 225, 0.14) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(170, 255, 225, 0.14) 1px, transparent 1px);
                background-size: 4.6rem 4.6rem;
                mask-image: linear-gradient(180deg, transparent 0%, black 14%, black 88%, transparent 100%);
                opacity: 0.82;
                animation: gridPulse 8.5s ease-in-out infinite;
            }

            .grid.secondary {
                top: 22%;
                left: 24%;
                width: min(20vw, 19rem);
                height: 29vh;
                transform: none;
                background-size: 2.2rem 2.2rem;
                opacity: 0.28;
                animation-delay: -2.4s;
            }

            .grid.tertiary {
                top: 52%;
                left: 68%;
                width: min(18vw, 16rem);
                height: 22vh;
                transform: none;
                background-size: 2rem 2rem;
                opacity: 0.22;
                animation-delay: -4.7s;
            }

            .light-wave,
            .halo,
            .ring,
            .mesh-arc {
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                border-radius: 50%;
            }

            .light-wave {
                width: min(110rem, 132vw);
                height: min(28rem, 38vw);
                border-top: 2px solid rgba(176, 255, 245, 0.42);
                filter: drop-shadow(0 0 22px rgba(137, 255, 239, 0.18));
                opacity: 0.72;
                animation: waveFlow 12s ease-in-out infinite;
            }

            .light-wave.one {
                top: 36%;
            }

            .light-wave.two {
                top: 59%;
                width: min(96rem, 118vw);
                height: min(20rem, 28vw);
                opacity: 0.18;
                border-top-color: rgba(176, 255, 245, 0.16);
                animation-delay: -5.2s;
            }

            .light-wave::after {
                content: "";
                position: absolute;
                top: -0.3rem;
                width: 5.4rem;
                height: 0.35rem;
                border-radius: 999px;
                background: rgba(146, 255, 245, 0.88);
                box-shadow: 1.7rem 0 rgba(146, 255, 245, 0.36), 3.5rem 0 rgba(246, 200, 255, 0.24);
            }

            .light-wave.one::after {
                left: 10%;
                animation: shuttle 9s linear infinite;
            }

            .light-wave.two::after {
                right: 14%;
                animation: shuttleReverse 10s linear infinite;
            }

            .mesh-arc {
                top: 56%;
                border: 1px solid rgba(176, 255, 219, 0.08);
                opacity: 0.5;
                animation: ringDrift 14s ease-in-out infinite;
            }

            .mesh-arc.one {
                width: min(100rem, 132vw);
                height: min(44rem, 54vw);
            }

            .mesh-arc.two {
                top: 60%;
                width: min(80rem, 104vw);
                height: min(32rem, 42vw);
                border-color: rgba(176, 255, 219, 0.1);
                animation-delay: -4.5s;
            }

            .mesh-arc.three {
                top: 63%;
                width: min(58rem, 76vw);
                height: min(22rem, 30vw);
                border-color: rgba(176, 255, 219, 0.08);
                opacity: 0.26;
                animation-delay: -7s;
            }

            .ring {
                top: 59%;
                border: 1px solid rgba(171, 255, 216, 0.14);
                box-shadow: 0 0 32px rgba(117, 255, 175, 0.08);
                animation: radarPulse 8s ease-in-out infinite;
            }

            .ring.one {
                width: 28rem;
                height: 28rem;
            }

            .ring.two {
                width: 38rem;
                height: 38rem;
                border-color: rgba(171, 255, 216, 0.08);
                animation-delay: -3.5s;
            }

            .ring.three {
                width: 48rem;
                height: 48rem;
                border-color: rgba(171, 255, 216, 0.05);
                animation-delay: -7s;
            }

            .glow-field {
                position: absolute;
                left: 50%;
                top: 49%;
                width: min(52rem, 58vw);
                height: min(52rem, 58vw);
                transform: translate(-50%, -50%);
                border-radius: 50%;
                background: radial-gradient(circle at center, rgba(125, 255, 173, 0.34) 0%, rgba(125, 255, 173, 0.16) 36%, rgba(125, 255, 173, 0.05) 58%, transparent 74%);
                filter: blur(24px);
                opacity: 0.92;
                animation: glowBreath 6.5s ease-in-out infinite;
            }

            .beam {
                position: absolute;
                top: 6%;
                width: 8rem;
                height: 82vh;
                border-radius: 999px;
                background: linear-gradient(180deg, rgba(139, 255, 182, 0.24), transparent 18%, rgba(139, 255, 182, 0.1) 54%, transparent 100%);
                filter: blur(42px);
                opacity: 0.22;
                animation: beamFloat 9s ease-in-out infinite;
            }

            .beam.left {
                left: 30%;
                animation-delay: -2.3s;
            }

            .beam.center {
                left: 50%;
                transform: translateX(-50%);
                width: 9rem;
                height: 88vh;
                background: linear-gradient(180deg, rgba(132, 255, 175, 0.16), rgba(132, 255, 175, 0.24) 24%, rgba(132, 255, 175, 0.08) 56%, transparent 100%);
                opacity: 0.34;
                filter: blur(36px);
                animation: beamCenterPulse 7s ease-in-out infinite;
            }

            .beam.right {
                right: 18%;
                background: linear-gradient(180deg, rgba(135, 255, 198, 0.18), transparent 18%, rgba(135, 255, 198, 0.12) 56%, transparent 100%);
                animation-delay: -4.6s;
            }

            .data-card,
            .hud-panel {
                display: none;
                position: absolute;
                border-radius: 1.55rem;
                border: 1px solid rgba(173, 255, 224, 0.12);
                background:
                    linear-gradient(145deg, rgba(13, 39, 42, 0.34), rgba(8, 22, 28, 0.08)),
                    rgba(8, 22, 28, 0.18);
                box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.015);
                backdrop-filter: blur(14px);
                opacity: 0.42;
                animation: panelFloat 10s ease-in-out infinite;
            }

            .data-card::before,
            .data-card::after,
            .hud-panel::before,
            .hud-panel::after {
                content: "";
                position: absolute;
            }

            .data-card {
                width: 10rem;
                height: 12rem;
            }

            .data-card::before {
                left: 1.2rem;
                right: 1.2rem;
                top: 2.6rem;
                height: 1px;
                background: rgba(149, 255, 211, 0.28);
                box-shadow: 0 1.35rem rgba(149, 255, 211, 0.22), 0 2.7rem rgba(149, 255, 211, 0.16), 0 4.05rem rgba(149, 255, 211, 0.1);
            }

            .data-card::after {
                left: 1.2rem;
                top: 1rem;
                width: 0.35rem;
                height: 0.35rem;
                border-radius: 50%;
                background: rgba(149, 255, 211, 0.36);
                box-shadow: 0.7rem 0 rgba(149, 255, 211, 0.22), 1.4rem 0 rgba(149, 255, 211, 0.14);
            }

            .data-card.left {
                left: 10%;
                top: 64%;
                transform: rotate(-8deg);
            }

            .data-card.right {
                right: 11%;
                top: 54%;
                transform: rotate(8deg);
                animation-delay: -4.2s;
            }

            .hud-panel {
                width: 14rem;
                height: 10rem;
            }

            .hud-panel::before {
                inset: 1rem;
                border-radius: 1rem;
                border: 1px solid rgba(173, 255, 224, 0.08);
            }

            .hud-panel::after {
                left: 1.45rem;
                right: 1.45rem;
                top: 2.2rem;
                height: 1px;
                background: rgba(157, 255, 205, 0.26);
                box-shadow: 0 1.4rem rgba(157, 255, 205, 0.2), 0 2.8rem rgba(157, 255, 205, 0.14), 0 4.2rem rgba(157, 255, 205, 0.08);
            }

            .hud-panel.left {
                left: 5%;
                top: 73%;
                transform: rotate(-10deg);
            }

            .hud-panel.right {
                right: 7%;
                top: 18%;
                width: 9rem;
                height: 7rem;
                transform: rotate(8deg);
                opacity: 0.34;
                animation-delay: -2.6s;
            }

            .node-trail {
                position: absolute;
                width: 15rem;
                height: 4rem;
                opacity: 0.84;
                animation: nodeDrift 9s ease-in-out infinite;
            }

            .node-trail::after {
                content: "";
                position: absolute;
                left: 0;
                right: 0;
                top: 1.8rem;
                height: 1px;
                background: linear-gradient(90deg, transparent 0%, rgba(157, 255, 205, 0.52) 18%, rgba(157, 255, 205, 0.08) 100%);
            }

            .node-trail.left {
                left: 14%;
                top: 44%;
                transform: rotate(8deg);
                opacity: 0.38;
            }

            .node-trail.right {
                right: 10%;
                top: 32%;
                transform: rotate(-8deg);
                opacity: 0.56;
                animation-delay: -3.5s;
            }

            .node-trail span,
            .spark-group span,
            .particle-field span {
                position: absolute;
                border-radius: 50%;
                background: rgba(157, 255, 205, 0.95);
                box-shadow: 0 0 14px rgba(157, 255, 205, 0.46);
            }

            .node-trail span:nth-child(1) {
                left: 0.8rem;
                top: 0.8rem;
                width: 0.32rem;
                height: 0.32rem;
            }

            .node-trail span:nth-child(2) {
                left: 3.2rem;
                top: 1.65rem;
                width: 0.22rem;
                height: 0.22rem;
            }

            .node-trail span:nth-child(3) {
                left: 6rem;
                top: 1rem;
                width: 0.28rem;
                height: 0.28rem;
            }

            .node-trail span:nth-child(4) {
                left: 8.8rem;
                top: 1.7rem;
                width: 0.22rem;
                height: 0.22rem;
            }

            .node-trail span:nth-child(5) {
                left: 11.4rem;
                top: 0.95rem;
                width: 0.28rem;
                height: 0.28rem;
            }

            .spark-group,
            .spark-cloud {
                position: absolute;
                opacity: 0.82;
            }

            .spark-group {
                width: 12rem;
                height: 6rem;
            }

            .spark-group.left {
                left: 12%;
                top: 40%;
                opacity: 0.48;
            }

            .spark-group.right {
                right: 11%;
                top: 29%;
            }

            .spark-group span {
                width: 0.34rem;
                height: 0.34rem;
                animation: particleBlink 3.2s ease-in-out infinite;
            }

            .spark-group span:nth-child(1) {
                left: 0.8rem;
                top: 1rem;
            }

            .spark-group span:nth-child(2) {
                left: 3.2rem;
                top: 2rem;
                width: 0.24rem;
                height: 0.24rem;
            }

            .spark-group span:nth-child(3) {
                left: 6rem;
                top: 1.35rem;
            }

            .spark-group span:nth-child(4) {
                left: 8.5rem;
                top: 2.6rem;
                width: 0.22rem;
                height: 0.22rem;
            }

            .spark-group span:nth-child(5) {
                left: 10rem;
                top: 1.6rem;
                width: 0.28rem;
                height: 0.28rem;
            }

            .spark-group::after {
                content: "";
                position: absolute;
                left: 0;
                right: 0;
                top: 2rem;
                height: 1px;
                background: linear-gradient(90deg, transparent 0%, rgba(157, 255, 205, 0.52) 18%, rgba(157, 255, 205, 0.06) 100%);
            }

            .spark-cloud {
                width: 9rem;
                height: 7rem;
            }

            .spark-cloud.one {
                left: 39%;
                top: 16%;
            }

            .spark-cloud.two {
                right: 29%;
                top: 21%;
            }

            .spark-cloud.three {
                left: 25%;
                bottom: 16%;
            }

            .spark-cloud span {
                width: 0.24rem;
                height: 0.24rem;
                animation: particleBlink 2.8s ease-in-out infinite;
            }

            .spark-cloud span:nth-child(1) {
                left: 0.5rem;
                top: 0.8rem;
            }

            .spark-cloud span:nth-child(2) {
                left: 2.1rem;
                top: 2.2rem;
                width: 0.18rem;
                height: 0.18rem;
            }

            .spark-cloud span:nth-child(3) {
                left: 4.2rem;
                top: 1.1rem;
            }

            .spark-cloud span:nth-child(4) {
                left: 6rem;
                top: 2.8rem;
                width: 0.18rem;
                height: 0.18rem;
            }

            .spark-cloud span:nth-child(5) {
                left: 7.2rem;
                top: 1.4rem;
            }

            .scanline {
                position: absolute;
                pointer-events: none;
                opacity: 0.28;
            }

            .scanline.horizontal {
                left: 8%;
                right: 8%;
                height: 1px;
                background: linear-gradient(90deg, transparent 0%, rgba(185, 255, 214, 0.14) 20%, rgba(185, 255, 214, 0.46) 50%, rgba(185, 255, 214, 0.14) 80%, transparent 100%);
                animation: scanHorizontal 12s linear infinite;
            }

            .scanline.horizontal.one {
                top: 33%;
            }

            .scanline.horizontal.two {
                top: 66%;
                animation-delay: -6s;
            }

            .scanline.vertical {
                top: 8%;
                bottom: 10%;
                width: 1px;
                background: linear-gradient(180deg, transparent 0%, rgba(185, 255, 214, 0.1) 18%, rgba(185, 255, 214, 0.34) 50%, rgba(185, 255, 214, 0.1) 82%, transparent 100%);
                animation: scanVertical 14s linear infinite;
            }

            .scanline.vertical.one {
                left: 45%;
            }

            .scanline.vertical.two {
                left: 58%;
                animation-delay: -7s;
            }

            .particle-field {
                position: absolute;
                inset: 10% 4% 10%;
                overflow: hidden;
            }

            .particle-field span {
                left: var(--x);
                top: var(--y);
                width: var(--size);
                height: var(--size);
                opacity: 0.35;
                animation: particleFloat var(--duration) linear infinite;
                animation-delay: var(--delay);
            }

            .digital-trail {
                position: absolute;
                width: 11rem;
                height: 0.26rem;
                border-radius: 999px;
                background: linear-gradient(90deg, transparent 0%, rgba(157, 255, 205, 0.5) 24%, rgba(157, 255, 205, 0.08) 100%);
                box-shadow: 0 0 18px rgba(157, 255, 205, 0.14);
                opacity: 0.66;
                animation: pillFlicker 5.5s ease-in-out infinite;
            }

            .digital-trail.one {
                left: 24%;
                top: 42%;
                transform: rotate(-2deg);
            }

            .digital-trail.two {
                right: 14%;
                top: 48%;
                transform: rotate(1deg);
                animation-delay: -2.3s;
            }

            .digital-trail.three {
                left: 38%;
                top: 56%;
                width: 7rem;
                opacity: 0.4;
            }

            .deco-pill {
                position: absolute;
                width: 8rem;
                height: 0.32rem;
                border-radius: 999px;
                background: linear-gradient(90deg, rgba(157, 255, 205, 0.04), rgba(157, 255, 205, 0.42), rgba(157, 255, 205, 0.1));
                opacity: 0.86;
                box-shadow: 0 0 16px rgba(157, 255, 205, 0.12);
                animation: pillFlicker 5s ease-in-out infinite;
            }

            .deco-pill.a {
                left: 8%;
                top: 28%;
                transform: rotate(-2deg);
            }

            .deco-pill.b {
                right: 8%;
                top: 30%;
                transform: rotate(1deg);
            }

            .deco-pill.c {
                left: 22%;
                top: 60%;
                width: 10rem;
                opacity: 0.36;
            }

            .deco-pill.d {
                right: 28%;
                top: 58%;
                width: 7rem;
                opacity: 0.44;
                animation-delay: -2.4s;
            }

            .photo-stack {
                position: absolute;
                left: 70%;
                bottom: 0.35rem;
                width: min(34rem, 38vw);
                height: min(47rem, 76vh);
                transform: translateX(-50%);
                pointer-events: auto;
                cursor: pointer;
            }

            .photo-shadow,
            .photo-glow,
            .photo-core {
                position: absolute;
                inset: 0;
                background-image: var(--photo-url);
                background-repeat: no-repeat;
                background-position: center bottom;
                background-size: contain;
            }

            .photo-shadow {
                filter: blur(22px) brightness(1.24) saturate(1.3);
                opacity: 0.24;
                transform: translateY(18px) scale(1.01);
                animation: floatPhoto 7.2s ease-in-out infinite;
            }

            .photo-glow {
                filter: blur(62px) brightness(1.2) saturate(1.28);
                opacity: 0.48;
                transform: scale(0.95);
                animation: glowBreath 5.5s ease-in-out infinite;
            }

            .photo-core {
                filter: brightness(1.16) contrast(1.08) saturate(1.12) drop-shadow(0 26px 36px rgba(0, 0, 0, 0.24));
                opacity: 1;
                animation: floatPhoto 7.2s ease-in-out infinite;
            }

            .photo-flare,
            .photo-orb {
                position: absolute;
                left: 50%;
                border-radius: 50%;
                transform: translateX(-50%);
            }

            .photo-flare {
                bottom: 18%;
                width: 26rem;
                height: 12rem;
                background: radial-gradient(circle at center, rgba(144, 255, 214, 0.34) 0%, rgba(144, 255, 214, 0.08) 44%, transparent 76%);
                filter: blur(18px);
                animation: glowBreath 4.8s ease-in-out infinite;
            }

            .photo-flare.secondary {
                bottom: 10%;
                width: 16rem;
                height: 8rem;
                background: radial-gradient(circle at center, rgba(137, 236, 255, 0.2) 0%, rgba(137, 236, 255, 0.05) 44%, transparent 76%);
                animation-delay: -2.4s;
            }

            .photo-orb {
                bottom: 8%;
                width: 8rem;
                height: 8rem;
                background: radial-gradient(circle at center, rgba(149, 255, 241, 0.56) 0%, rgba(149, 255, 241, 0.22) 34%, transparent 70%);
                filter: blur(14px);
                animation: orbPulse 4.2s ease-in-out infinite;
            }

            .photo-stack.burst .photo-glow,
            .photo-stack.burst .photo-flare,
            .photo-stack.burst .photo-orb {
                animation-duration: 1s;
                opacity: 0.88;
                filter: blur(48px) brightness(1.34);
            }

            .shell {
                position: relative;
                z-index: 5;
                width: min(1440px, 100%);
                min-height: max(100svh, 48rem);
                margin: 0 auto;
                padding: 1.6rem clamp(1rem, 3vw, 3rem) 3rem;
                display: flex;
                flex-direction: column;
            }

            .topbar {
                display: grid;
                grid-template-columns: 1fr auto 1fr;
                align-items: center;
                gap: 1rem;
                position: relative;
                z-index: 7;
            }

            .brand {
                display: inline-flex;
                align-items: flex-start;
                gap: 0.85rem;
                justify-self: start;
            }

            .brand-mark {
                font-family: "Space Grotesk", sans-serif;
                font-size: clamp(2.1rem, 4vw, 2.9rem);
                font-weight: 700;
                letter-spacing: -0.12em;
                line-height: 0.95;
                color: var(--accent);
                text-shadow: 0 0 22px rgba(146, 255, 240, 0.16);
            }

            .brand-copy {
                display: grid;
                gap: 0.12rem;
                padding-top: 0.18rem;
            }

            .brand-copy strong,
            .brand-copy span {
                text-transform: uppercase;
                letter-spacing: 0.13em;
                line-height: 1;
            }

            .brand-copy strong {
                font-size: clamp(1rem, 1.5vw, 1.18rem);
            }

            .brand-copy span {
                color: var(--muted);
                font-size: clamp(0.8rem, 1.2vw, 0.95rem);
            }

            .nav {
                display: inline-flex;
                align-items: center;
                gap: 0.45rem;
                justify-self: center;
                padding: 0.28rem 0.42rem;
                border-radius: 999px;
                background: rgba(8, 22, 28, 0.26);
                border: 1px solid rgba(181, 255, 220, 0.05);
                backdrop-filter: blur(14px);
                box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.02);
            }

            .nav a {
                position: relative;
                padding: 0.76rem 1rem;
                color: rgba(239, 247, 247, 0.88);
                font-size: 0.88rem;
                font-weight: 600;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                transition: color 180ms ease;
            }

            .nav a::after {
                content: "";
                position: absolute;
                left: 1rem;
                right: 1rem;
                bottom: 0.34rem;
                height: 2px;
                border-radius: 999px;
                background: linear-gradient(90deg, rgba(147, 255, 241, 0.94), rgba(147, 255, 241, 0.28));
                transform: scaleX(0);
                transform-origin: left;
                transition: transform 220ms ease;
            }

            .nav a:hover,
            .nav a:focus-visible,
            .nav a.active {
                color: var(--accent-soft);
                outline: none;
            }

            .nav a:hover::after,
            .nav a:focus-visible::after,
            .nav a.active::after {
                transform: scaleX(1);
            }

            .nav-spacer {
                justify-self: end;
                width: 7rem;
                height: 1px;
            }

            .hero {
                position: relative;
                display: grid;
                grid-template-columns: minmax(0, 0.92fr) minmax(20rem, 1.08fr);
                gap: clamp(2rem, 4vw, 4rem);
                flex: 1;
                align-items: center;
                min-height: clamp(39rem, calc(100svh - 8rem), 46rem);
                padding-bottom: 2rem;
            }

            .hero-copy {
                position: relative;
                z-index: 7;
                max-width: 32rem;
                padding-top: 2.4rem;
                padding-left: clamp(0rem, 1vw, 1rem);
            }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0;
                color: var(--accent-soft);
                font-size: 0.8rem;
                font-weight: 600;
                letter-spacing: 0.18em;
                text-transform: uppercase;
            }

            .eyebrow::before {
                content: "";
                width: 0.55rem;
                height: 0.55rem;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
                box-shadow: 0 0 14px rgba(118, 244, 178, 0.44);
            }

            .eyebrow::after {
                content: "";
                width: 2.6rem;
                height: 1px;
                background: linear-gradient(90deg, rgba(181, 255, 220, 0.78), rgba(181, 255, 220, 0.04));
            }

            .hero-title {
                margin: 1rem 0 0;
                max-width: none;
                font-family: "Space Grotesk", sans-serif;
                font-size: clamp(2.7rem, 5.2vw, 4.7rem);
                line-height: 0.94;
                letter-spacing: -0.06em;
                text-transform: uppercase;
                text-shadow: 0 0 38px rgba(11, 17, 17, 0.26);
            }

            .hero-title .line {
                display: block;
            }

            .hero-title .accent {
                color: var(--accent);
            }

            .hero-subtext {
                max-width: 24rem;
                margin: 1.25rem 0 0;
                color: rgba(239, 250, 248, 0.84);
                font-size: clamp(0.98rem, 1.45vw, 1.08rem);
                line-height: 1.9;
            }

            .hero-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 0.95rem;
                margin-top: 1.8rem;
            }

            .button {
                position: relative;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.7rem;
                min-width: 10.8rem;
                padding: 0.95rem 1.45rem;
                border-radius: 999px;
                border: 1px solid transparent;
                font-weight: 700;
                letter-spacing: 0.04em;
                transition: transform 220ms ease, border-color 220ms ease, box-shadow 220ms ease, background 220ms ease;
                overflow: hidden;
            }

            .button::before {
                content: "";
                position: absolute;
                inset: 0;
                border-radius: inherit;
                opacity: 0;
                transition: opacity 220ms ease;
            }

            .button.primary {
                background: linear-gradient(135deg, rgba(117, 244, 178, 0.92), rgba(137, 236, 255, 0.88));
                color: #031015;
                box-shadow: 0 18px 34px rgba(86, 214, 170, 0.26);
            }

            .button.primary::before {
                background: radial-gradient(circle at center, rgba(255, 255, 255, 0.38), transparent 60%);
            }

            .button.secondary {
                border-color: rgba(181, 255, 220, 0.18);
                background: rgba(8, 24, 30, 0.44);
                color: var(--accent-soft);
                backdrop-filter: blur(12px);
            }

            .button:hover,
            .button:focus-visible {
                transform: translateY(-3px) scale(1.01);
                outline: none;
            }

            .button:hover::before,
            .button:focus-visible::before {
                opacity: 1;
            }

            .button.secondary:hover,
            .button.secondary:focus-visible {
                border-color: rgba(181, 255, 220, 0.32);
                box-shadow: 0 16px 26px rgba(10, 24, 30, 0.24);
            }

            .toolbelt {
                display: flex;
                flex-wrap: wrap;
                gap: 0.9rem 1.35rem;
                max-width: 24rem;
                margin-top: 1.7rem;
            }

            .tool-pill {
                display: inline-flex;
                align-items: center;
                gap: 0.55rem;
                padding: 0;
                color: rgba(239, 250, 248, 0.86);
                font-size: 0.82rem;
                font-weight: 600;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                position: relative;
                transition: transform 200ms ease, text-shadow 200ms ease;
            }

            .tool-pill::before {
                content: "";
                width: 0.45rem;
                height: 0.45rem;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
                box-shadow: 0 0 10px rgba(118, 244, 178, 0.32);
            }

            .tool-pill::after {
                content: "";
                width: 2.2rem;
                height: 1px;
                margin-left: 0.15rem;
                background: linear-gradient(90deg, rgba(181, 255, 220, 0.68), rgba(181, 255, 220, 0.04));
            }

            .tool-pill:last-child::after {
                display: none;
            }

            .tool-pill:hover,
            .tool-pill:focus-visible {
                transform: translateY(-2px);
                text-shadow: 0 0 18px rgba(118, 244, 178, 0.28);
                outline: none;
            }

            .hero-floating {
                display: none;
            }

            .floating-note {
                display: none;
            }

            .floating-note small {
                display: block;
                color: rgba(239, 250, 248, 0.62);
                font-size: 0.72rem;
                letter-spacing: 0.14em;
                text-transform: uppercase;
            }

            .floating-note strong {
                display: block;
                margin-top: 0.45rem;
                font-size: 0.98rem;
                line-height: 1.52;
            }

            .floating-note.left {
                left: auto;
                bottom: auto;
                transform: none;
            }

            .floating-note.right {
                right: auto;
                bottom: auto;
                transform: none;
            }

            .socials {
                position: absolute;
                left: 0;
                bottom: 1rem;
                z-index: 8;
                display: inline-flex;
                gap: 0.8rem;
            }

            .socials a {
                position: relative;
                display: grid;
                place-items: center;
                width: 2.55rem;
                height: 2.55rem;
                border-radius: 999px;
                transition: transform 180ms ease, color 180ms ease;
            }

            .socials a::before {
                content: "";
                position: absolute;
                inset: 0.18rem;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(118, 244, 178, 0.18), transparent 68%);
                opacity: 0;
                transition: opacity 180ms ease;
            }

            .socials a:hover,
            .socials a:focus-visible {
                transform: translateY(-4px) scale(1.04);
                outline: none;
            }

            .socials a:hover::before,
            .socials a:focus-visible::before {
                opacity: 1;
            }

            .socials svg {
                width: 1.25rem;
                height: 1.25rem;
                fill: rgba(239, 247, 247, 0.92);
            }

            .pager {
                display: none;
            }

            .diamond {
                width: 2.85rem;
                height: 2.85rem;
                border-radius: 1rem;
                background: rgba(239, 247, 247, 0.92);
                clip-path: polygon(50% 0, 100% 50%, 50% 100%, 0 50%);
                box-shadow: 0 10px 22px rgba(0, 0, 0, 0.24);
                opacity: 0.95;
                animation: pagerPulse 4.4s ease-in-out infinite;
            }

            .pager strong {
                font-size: 1.05rem;
                font-weight: 500;
                letter-spacing: 0.04em;
            }

            .scroll-indicator {
                position: absolute;
                left: 50%;
                bottom: 1rem;
                z-index: 8;
                display: inline-flex;
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
                color: rgba(239, 247, 247, 0.82);
                transform: translateX(-50%);
            }

            .scroll-indicator span {
                font-size: 0.82rem;
                letter-spacing: 0.18em;
                text-transform: uppercase;
            }

            .scroll-indicator i {
                width: 1.55rem;
                height: 2.4rem;
                border-radius: 999px;
                border: 1px solid rgba(181, 255, 220, 0.18);
                position: relative;
                display: inline-block;
            }

            .scroll-indicator i::after {
                content: "";
                position: absolute;
                left: 50%;
                top: 0.4rem;
                width: 0.28rem;
                height: 0.55rem;
                border-radius: 999px;
                background: rgba(181, 255, 220, 0.8);
                transform: translateX(-50%);
                animation: scrollDown 1.8s ease-in-out infinite;
            }

            .content {
                position: relative;
                z-index: 4;
                background:
                    radial-gradient(circle at top center, rgba(118, 244, 178, 0.1), transparent 20%),
                    linear-gradient(180deg, #04161c 0%, #061920 24%, #071b22 100%);
            }

            .section {
                position: relative;
                padding: clamp(5rem, 10vw, 8rem) clamp(1rem, 3vw, 3rem);
            }

            .section::before {
                content: "";
                position: absolute;
                inset: 0;
                pointer-events: none;
                opacity: 0.6;
                background:
                    linear-gradient(90deg, transparent 0%, rgba(182, 255, 220, 0.04) 50%, transparent 100%),
                    linear-gradient(180deg, rgba(182, 255, 220, 0.02) 0%, transparent 30%, transparent 70%, rgba(182, 255, 220, 0.02) 100%);
                mask-image: linear-gradient(180deg, transparent, black 12%, black 88%, transparent);
            }

            .section-shell {
                position: relative;
                z-index: 2;
                width: min(1280px, 100%);
                margin: 0 auto;
            }

            .section-head {
                max-width: 42rem;
                margin-bottom: 2.2rem;
            }

            .section-kicker {
                display: inline-flex;
                align-items: center;
                gap: 0.6rem;
                color: var(--accent);
                font-size: 0.82rem;
                font-weight: 700;
                letter-spacing: 0.18em;
                text-transform: uppercase;
            }

            .section-kicker::before {
                content: "";
                width: 2.4rem;
                height: 1px;
                background: linear-gradient(90deg, rgba(181, 255, 220, 0.1), rgba(181, 255, 220, 0.72));
            }

            .section-title {
                margin: 0.95rem 0 0;
                font-family: "Space Grotesk", sans-serif;
                font-size: clamp(2rem, 4vw, 3.4rem);
                line-height: 1.02;
                letter-spacing: -0.05em;
            }

            .section-copy {
                margin: 1rem 0 0;
                max-width: 38rem;
                color: rgba(239, 250, 248, 0.72);
                font-size: 1rem;
                line-height: 1.8;
            }

            .glass-card {
                position: relative;
                overflow: hidden;
                border-radius: 1.65rem;
                border: 1px solid rgba(183, 255, 220, 0.14);
                background:
                    linear-gradient(145deg, rgba(10, 30, 36, 0.9), rgba(7, 22, 28, 0.68)),
                    rgba(8, 25, 31, 0.72);
                box-shadow: var(--shadow);
                backdrop-filter: blur(18px);
            }

            .glass-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, rgba(181, 255, 220, 0.08), transparent 42%);
                pointer-events: none;
            }

            .about-grid {
                display: grid;
                grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
                gap: 1.25rem;
            }

            .profile-panel {
                padding: 2rem;
                display: grid;
                gap: 1.25rem;
            }

            .profile-chip {
                display: inline-flex;
                align-items: center;
                gap: 0.6rem;
                padding: 0.6rem 0.9rem;
                width: fit-content;
                border-radius: 999px;
                background: rgba(181, 255, 220, 0.08);
                color: var(--accent-soft);
                font-size: 0.86rem;
            }

            .profile-chip::before {
                content: "";
                width: 0.5rem;
                height: 0.5rem;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
            }

            .profile-lead {
                max-width: 28rem;
                color: rgba(239, 250, 248, 0.9);
                font-size: 1.08rem;
                line-height: 1.9;
            }

            .profile-stats {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 0.9rem;
            }

            .profile-stats div {
                padding: 1rem;
                border-radius: 1.2rem;
                background: rgba(255, 255, 255, 0.02);
                border: 1px solid rgba(181, 255, 220, 0.1);
            }

            .profile-stats strong {
                display: block;
                font-size: 1.3rem;
            }

            .profile-stats span {
                display: block;
                margin-top: 0.3rem;
                color: rgba(239, 250, 248, 0.68);
                font-size: 0.88rem;
                line-height: 1.5;
            }

            .about-side {
                display: grid;
                gap: 1.25rem;
            }

            .info-card {
                padding: 1.7rem;
            }

            .info-card h3 {
                margin: 0;
                font-size: 1.15rem;
            }

            .info-card p {
                margin: 0.8rem 0 0;
                color: rgba(239, 250, 248, 0.72);
                line-height: 1.8;
            }

            .stack-list {
                display: flex;
                flex-wrap: wrap;
                gap: 0.7rem;
                margin-top: 1rem;
            }

            .stack-list span {
                padding: 0.6rem 0.78rem;
                border-radius: 999px;
                border: 1px solid rgba(181, 255, 220, 0.12);
                background: rgba(255, 255, 255, 0.02);
                color: rgba(239, 250, 248, 0.86);
                font-size: 0.86rem;
            }

            .services-grid,
            .work-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 1.15rem;
            }

            .service-card,
            .work-card {
                padding: 1.6rem;
                transition: transform 220ms ease, border-color 220ms ease, box-shadow 220ms ease;
            }

            .service-card:hover,
            .service-card:focus-within,
            .work-card:hover,
            .work-card:focus-within {
                transform: translateY(-6px);
                border-color: rgba(183, 255, 220, 0.26);
                box-shadow: 0 24px 62px rgba(0, 0, 0, 0.28);
            }

            .service-index,
            .work-index {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2.4rem;
                height: 2.4rem;
                border-radius: 0.8rem;
                background: rgba(181, 255, 220, 0.08);
                color: var(--accent);
                font-size: 0.86rem;
                font-weight: 700;
                letter-spacing: 0.08em;
            }

            .service-card h3,
            .work-card h3 {
                margin: 1rem 0 0;
                font-size: 1.25rem;
            }

            .service-card p,
            .work-card p {
                margin: 0.8rem 0 0;
                color: rgba(239, 250, 248, 0.72);
                line-height: 1.8;
            }

            .service-points {
                display: grid;
                gap: 0.55rem;
                margin-top: 1rem;
                color: rgba(239, 250, 248, 0.84);
                font-size: 0.92rem;
            }

            .service-points span::before {
                content: "•";
                margin-right: 0.5rem;
                color: var(--accent);
            }

            .work-thumb {
                position: relative;
                height: 15rem;
                border-radius: 1.35rem;
                overflow: hidden;
                background:
                    radial-gradient(circle at 20% 20%, rgba(137, 236, 255, 0.2), transparent 34%),
                    radial-gradient(circle at 78% 16%, rgba(118, 244, 178, 0.18), transparent 28%),
                    linear-gradient(145deg, rgba(10, 28, 34, 0.96), rgba(8, 20, 26, 0.82));
                border: 1px solid rgba(181, 255, 220, 0.1);
            }

            .work-thumb::before,
            .work-thumb::after {
                content: "";
                position: absolute;
                inset: 1.1rem;
                border-radius: 1rem;
                border: 1px solid rgba(181, 255, 220, 0.08);
            }

            .work-thumb::after {
                inset: auto 1.3rem 1.4rem;
                height: 1px;
                border: 0;
                background: linear-gradient(90deg, rgba(181, 255, 220, 0.12), rgba(181, 255, 220, 0.46), rgba(181, 255, 220, 0.08));
                box-shadow: 0 -2.8rem rgba(181, 255, 220, 0.18), 0 -5.6rem rgba(181, 255, 220, 0.1);
            }

            .work-thumb .preview-chip {
                position: absolute;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.52rem 0.74rem;
                border-radius: 999px;
                background: rgba(8, 24, 30, 0.56);
                border: 1px solid rgba(181, 255, 220, 0.14);
                color: rgba(239, 250, 248, 0.92);
                font-size: 0.8rem;
                backdrop-filter: blur(12px);
            }

            .work-thumb .preview-chip::before {
                content: "";
                width: 0.44rem;
                height: 0.44rem;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--accent-strong), var(--accent-cyan));
            }

            .work-thumb .preview-chip.one {
                top: 1.2rem;
                left: 1.2rem;
            }

            .work-thumb .preview-chip.two {
                right: 1.2rem;
                bottom: 1.2rem;
            }

            .work-card .tags {
                display: flex;
                flex-wrap: wrap;
                gap: 0.55rem;
                margin-top: 1rem;
            }

            .work-card .tags span {
                padding: 0.45rem 0.72rem;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.02);
                border: 1px solid rgba(181, 255, 220, 0.12);
                color: rgba(239, 250, 248, 0.82);
                font-size: 0.8rem;
            }

            .contact-panel {
                display: grid;
                grid-template-columns: minmax(0, 1fr) auto;
                gap: 1.5rem;
                align-items: center;
                padding: 2rem;
            }

            .contact-panel h2 {
                margin: 0;
                font-family: "Space Grotesk", sans-serif;
                font-size: clamp(2rem, 4vw, 3.1rem);
                line-height: 1.04;
                letter-spacing: -0.05em;
            }

            .contact-panel p {
                margin: 0.9rem 0 0;
                max-width: 38rem;
                color: rgba(239, 250, 248, 0.74);
                line-height: 1.8;
            }

            .contact-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 0.9rem;
                justify-content: flex-end;
            }

            .site-footer {
                padding: 0 1rem 2.5rem;
                color: rgba(239, 250, 248, 0.58);
                text-align: center;
                font-size: 0.92rem;
                letter-spacing: 0.04em;
            }

            [data-reveal] {
                opacity: 0;
                transform: translateY(32px);
                transition: opacity 720ms ease, transform 720ms cubic-bezier(0.2, 1, 0.22, 1);
            }

            [data-reveal].is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            @keyframes gridPulse {
                0%,
                100% {
                    opacity: 0.36;
                }

                50% {
                    opacity: 0.88;
                }
            }

            @keyframes glowBreath {
                0%,
                100% {
                    opacity: 0.34;
                }

                50% {
                    opacity: 0.62;
                }
            }

            @keyframes beamFloat {
                0%,
                100% {
                    opacity: 0.16;
                    transform: translateY(0);
                }

                50% {
                    opacity: 0.34;
                    transform: translateY(-18px);
                }
            }

            @keyframes beamCenterPulse {
                0%,
                100% {
                    opacity: 0.24;
                    transform: translateX(-50%) scaleY(1);
                }

                50% {
                    opacity: 0.42;
                    transform: translateX(-50%) scaleY(1.04);
                }
            }

            @keyframes waveFlow {
                0%,
                100% {
                    opacity: 0.54;
                    transform: translateX(-50%) translateY(0);
                }

                50% {
                    opacity: 0.86;
                    transform: translateX(-50%) translateY(-10px);
                }
            }

            @keyframes shuttle {
                0% {
                    transform: translateX(0) rotate(-4deg);
                }

                50% {
                    transform: translateX(22rem) rotate(2deg);
                }

                100% {
                    transform: translateX(0) rotate(-4deg);
                }
            }

            @keyframes shuttleReverse {
                0% {
                    transform: translateX(0) rotate(5deg);
                }

                50% {
                    transform: translateX(-18rem) rotate(-2deg);
                }

                100% {
                    transform: translateX(0) rotate(5deg);
                }
            }

            @keyframes ringDrift {
                0%,
                100% {
                    transform: translateX(-50%) scale(1);
                }

                50% {
                    transform: translateX(-50%) scale(1.03);
                }
            }

            @keyframes radarPulse {
                0%,
                100% {
                    opacity: 0.16;
                    transform: translateX(-50%) scale(0.98);
                }

                50% {
                    opacity: 0.34;
                    transform: translateX(-50%) scale(1.02);
                }
            }

            @keyframes panelFloat {
                0%,
                100% {
                    translate: 0 0;
                }

                50% {
                    translate: 0 -14px;
                }
            }

            @keyframes nodeDrift {
                0%,
                100% {
                    translate: 0 0;
                    opacity: 0.62;
                }

                50% {
                    translate: 0 -10px;
                    opacity: 0.9;
                }
            }

            @keyframes pillFlicker {
                0%,
                100% {
                    opacity: 0.18;
                }

                50% {
                    opacity: 0.76;
                }
            }

            @keyframes particleBlink {
                0%,
                100% {
                    opacity: 0.34;
                    transform: scale(0.8);
                }

                50% {
                    opacity: 1;
                    transform: scale(1.28);
                }
            }

            @keyframes particleFloat {
                0% {
                    transform: translate3d(0, 0, 0) scale(0.8);
                    opacity: 0;
                }

                15%,
                85% {
                    opacity: 0.65;
                }

                100% {
                    transform: translate3d(1.8rem, -5rem, 0) scale(1.08);
                    opacity: 0;
                }
            }

            @keyframes floatPhoto {
                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-12px);
                }
            }

            @keyframes orbPulse {
                0%,
                100% {
                    opacity: 0.34;
                    transform: translateX(-50%) scale(0.9);
                }

                50% {
                    opacity: 0.82;
                    transform: translateX(-50%) scale(1.06);
                }
            }

            @keyframes scrollDown {
                0% {
                    transform: translate(-50%, 0);
                    opacity: 0;
                }

                30% {
                    opacity: 1;
                }

                100% {
                    transform: translate(-50%, 1rem);
                    opacity: 0;
                }
            }

            @keyframes pagerPulse {
                0%,
                100% {
                    transform: rotate(0deg) scale(1);
                }

                50% {
                    transform: rotate(45deg) scale(1.05);
                }
            }

            @keyframes scanHorizontal {
                0% {
                    transform: translateX(-4%);
                    opacity: 0;
                }

                12%,
                82% {
                    opacity: 0.32;
                }

                100% {
                    transform: translateX(4%);
                    opacity: 0;
                }
            }

            @keyframes scanVertical {
                0% {
                    transform: translateY(-3%);
                    opacity: 0;
                }

                15%,
                80% {
                    opacity: 0.22;
                }

                100% {
                    transform: translateY(3%);
                    opacity: 0;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                *,
                *::before,
                *::after {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                    scroll-behavior: auto !important;
                }

                .cursor-spotlight,
                .cursor-ring {
                    display: none;
                }
            }

            @media (max-width: 1200px) {
                .hero {
                    grid-template-columns: minmax(0, 1fr);
                    min-height: 42rem;
                }

                .hero-copy {
                    max-width: 36rem;
                    padding-top: 3.2rem;
                }

                .photo-stack {
                    left: 62%;
                    bottom: 0.2rem;
                    width: min(33rem, 44vw);
                    height: min(44rem, 72vh);
                }

                .about-grid,
                .contact-panel {
                    grid-template-columns: 1fr;
                }

                .contact-actions {
                    justify-content: flex-start;
                }
            }

            @media (max-width: 1100px) {
                .topbar {
                    grid-template-columns: 1fr;
                    justify-items: center;
                    gap: 1rem;
                }

                .brand,
                .nav,
                .nav-spacer {
                    justify-self: center;
                }

                .nav-spacer {
                    display: none;
                }

                .services-grid,
                .work-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .grid {
                    width: min(54vw, 40rem);
                    transform: translateX(-18%);
                }

                .grid.secondary {
                    left: 8%;
                    top: 26%;
                    width: 18rem;
                }

                .data-card.left {
                    left: 7%;
                }

                .data-card.right {
                    right: 7%;
                }

                .hud-panel.left {
                    left: 4%;
                }

                .socials {
                    left: 0.5rem;
                }
            }

            @media (max-width: 860px) {
                .landing {
                    min-height: auto;
                }

                .shell {
                    min-height: auto;
                    padding-bottom: 9rem;
                }

                .hero {
                    min-height: auto;
                    padding: 3rem 0 22rem;
                }

                .hero-copy {
                    max-width: 100%;
                    margin-inline: auto;
                    text-align: center;
                    padding-top: 1rem;
                }

                .hero-title {
                    margin-inline: auto;
                }

                .hero-subtext,
                .toolbelt,
                .hero-floating {
                    margin-inline: auto;
                }

                .hero-actions {
                    justify-content: center;
                }

                .grid.secondary,
                .data-card.right,
                .hud-panel.right,
                .spark-group.right,
                .spark-cloud.two,
                .facet.right-3,
                .mesh-arc.three {
                    display: none;
                }

                .photo-stack {
                    left: 50%;
                    width: min(28rem, 84vw);
                    height: 33rem;
                    bottom: -0.2rem;
                }

                .floating-note {
                    margin-top: 1rem;
                    max-width: none;
                }

                .socials,
                .scroll-indicator,
                .pager {
                    position: relative;
                    left: auto;
                    right: auto;
                    bottom: auto;
                    transform: none;
                    justify-content: center;
                    margin-top: 1.25rem;
                }

                .socials {
                    display: flex;
                }

                .pager {
                    display: flex;
                    align-items: center;
                    gap: 0.8rem;
                }
            }

            @media (max-width: 680px) {
                .hero-floating,
                .profile-stats,
                .services-grid,
                .work-grid {
                    grid-template-columns: 1fr;
                }

                .button {
                    width: 100%;
                }

                .photo-stack {
                    width: min(23rem, 94vw);
                    height: 28rem;
                    bottom: 0;
                }

                .section {
                    padding-inline: 0.9rem;
                }

                .profile-panel,
                .service-card,
                .work-card,
                .contact-panel {
                    padding: 1.35rem;
                }
            }

            @media (max-width: 560px) {
                .shell {
                    padding-inline: 0.75rem;
                }

                .brand {
                    flex-direction: column;
                    align-items: center;
                    gap: 0.45rem;
                    text-align: center;
                }

                .nav {
                    flex-wrap: wrap;
                    justify-content: center;
                }

                .nav a {
                    padding: 0.6rem 0.8rem;
                    font-size: 0.78rem;
                }

                .grid {
                    top: 18%;
                    width: 74vw;
                    height: 38vh;
                    transform: translateX(-34%);
                    background-size: 2.8rem 2.8rem;
                }

                .beam.left,
                .beam.right,
                .data-card.left,
                .hud-panel.left,
                .node-trail.left,
                .node-trail.right,
                .spark-cloud.one,
                .spark-cloud.three,
                .light-wave.two,
                .ring.three,
                .deco-pill.c,
                .deco-pill.d {
                    display: none;
                }

                .hero {
                    padding-bottom: 19rem;
                }

                .hero-title {
                    font-size: clamp(2.45rem, 11vw, 3.7rem);
                }

                .photo-stack {
                    height: 24rem;
                }

                .scroll-indicator span {
                    font-size: 0.74rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="cursor-spotlight" aria-hidden="true"></div>
        <div class="cursor-ring" aria-hidden="true"></div>

        <section class="landing" id="home">
            <div class="scene back" aria-hidden="true">
                <div class="facet left-1"></div>
                <div class="facet left-2"></div>
                <div class="facet left-3"></div>
                <div class="facet right-1"></div>
                <div class="facet right-2"></div>
                <div class="facet right-3"></div>
                <div class="mist left"></div>
                <div class="mist right"></div>
                <div class="grid"></div>
                <div class="grid secondary"></div>
                <div class="grid tertiary"></div>
                <div class="beam left"></div>
                <div class="beam center"></div>
                <div class="beam right"></div>
                <div class="light-wave one"></div>
                <div class="light-wave two"></div>
                <div class="mesh-arc one"></div>
                <div class="mesh-arc two"></div>
                <div class="mesh-arc three"></div>
                <div class="ring one"></div>
                <div class="ring two"></div>
                <div class="ring three"></div>
                <div class="glow-field"></div>
                <div class="data-card left"></div>
                <div class="data-card right"></div>
                <div class="hud-panel left"></div>
                <div class="hud-panel right"></div>
                <div class="node-trail left">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="node-trail right">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="spark-group left">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="spark-group right">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="spark-cloud one">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="spark-cloud two">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="spark-cloud three">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="digital-trail one"></div>
                <div class="digital-trail two"></div>
                <div class="digital-trail three"></div>
                <div class="deco-pill a"></div>
                <div class="deco-pill b"></div>
                <div class="deco-pill c"></div>
                <div class="deco-pill d"></div>
                <div class="scanline horizontal one"></div>
                <div class="scanline horizontal two"></div>
                <div class="scanline vertical one"></div>
                <div class="scanline vertical two"></div>
                <div class="particle-field">
                    @foreach (range(1, 18) as $particle)
                        <span
                            style="
                                --x: {{ 6 + (($particle * 5) % 88) }}%;
                                --y: {{ 14 + (($particle * 7) % 70) }}%;
                                --size: {{ 0.16 + (($particle % 4) * 0.08) }}rem;
                                --duration: {{ 9 + ($particle % 6) }}s;
                                --delay: {{ $particle * -0.55 }}s;
                            "
                        ></span>
                    @endforeach
                </div>
            </div>

            <div class="scene front" aria-hidden="true">
                <div class="photo-stack">
                    <div class="photo-shadow"></div>
                    <div class="photo-glow"></div>
                    <div class="photo-core"></div>
                    <div class="photo-flare"></div>
                    <div class="photo-flare secondary"></div>
                    <div class="photo-orb"></div>
                </div>
            </div>

            <div class="shell">
                <header class="topbar">
                    <a class="brand" href="#home" aria-label="Porto home">
                        <div class="brand-mark">PT.</div>
                        <div class="brand-copy">
                            <strong>Porto</strong>
                            <span>Your Design</span>
                        </div>
                    </a>

                    <nav class="nav" aria-label="Main navigation">
                        <a class="active" href="#home">Home</a>
                        <a href="#about">About</a>
                        <a href="#work">Work</a>
                        <a href="#contact">Contact</a>
                    </nav>

                    <div class="nav-spacer" aria-hidden="true"></div>
                </header>

                <div class="hero">
                    <div class="hero-copy" data-reveal>
                        <div class="eyebrow">Hi, I&apos;m Tio - Digital Designer</div>
                        <h1 class="hero-title">
                            <span class="line">Design That</span>
                            <span class="line accent">Speaks Your</span>
                            <span class="line">Vision</span>
                        </h1>
                        <p class="hero-subtext">
                            We build modern, aesthetic, and high-performance designs that
                            make your brand feel bold, premium, and impossible to ignore.
                        </p>

                        <div class="hero-actions">
                            <a class="button primary" href="#contact">Start Project</a>
                            <a class="button secondary" href="#work">View Portfolio</a>
                        </div>

                        <div class="toolbelt" aria-label="Tech stack preview">
                            <span class="tool-pill">Identity</span>
                            <span class="tool-pill">Interaction</span>
                            <span class="tool-pill">Performance</span>
                        </div>
                    </div>
                </div>

                <div class="socials" aria-label="Social links">
                    <a href="#" aria-label="GitHub">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2C6.48 2 2 6.58 2 12.23C2 16.75 4.87 20.59 8.84 21.94C9.34 22.03 9.52 21.72 9.52 21.46C9.52 21.22 9.51 20.42 9.5 19.57C6.73 20.19 6.14 18.37 6.14 18.37C5.68 17.16 5.03 16.84 5.03 16.84C4.12 16.2 5.1 16.21 5.1 16.21C6.1 16.28 6.63 17.27 6.63 17.27C7.52 18.84 8.97 18.39 9.54 18.12C9.63 17.46 9.89 17.01 10.18 16.75C7.97 16.49 5.65 15.61 5.65 11.67C5.65 10.55 6.04 9.64 6.68 8.92C6.58 8.66 6.23 7.63 6.78 6.24C6.78 6.24 7.62 5.96 9.5 7.27C10.3 7.04 11.15 6.93 12 6.92C12.85 6.93 13.7 7.04 14.5 7.27C16.38 5.96 17.22 6.24 17.22 6.24C17.77 7.63 17.42 8.66 17.32 8.92C17.96 9.64 18.35 10.55 18.35 11.67C18.35 15.62 16.03 16.49 13.81 16.75C14.18 17.07 14.5 17.69 14.5 18.64C14.5 20 14.49 21.09 14.49 21.46C14.49 21.72 14.67 22.04 15.18 21.94C19.15 20.59 22 16.75 22 12.23C22 6.58 17.52 2 12 2Z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4.98 3.5A2.48 2.48 0 1 0 5 8.46A2.48 2.48 0 0 0 4.98 3.5ZM3 9.5H7V21H3V9.5ZM9.5 9.5H13.33V11.07H13.38C13.91 10.1 15.21 9.08 17.15 9.08C21.19 9.08 22 11.67 22 15.03V21H18V15.72C18 14.46 17.98 12.84 16.24 12.84C14.47 12.84 14.2 14.18 14.2 15.63V21H10.2V9.5H9.5Z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Behance">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M9.4 11.1C10.48 10.62 11.13 9.68 11.13 8.45C11.13 5.91 9.28 4.88 6.89 4.88H2V19.12H7.13C9.77 19.12 11.95 17.8 11.95 14.82C11.95 13.09 11.08 11.72 9.4 11.1ZM4.79 7.1H6.76C7.51 7.1 8.27 7.31 8.27 8.28C8.27 9.32 7.59 9.62 6.7 9.62H4.79V7.1ZM6.96 16.9H4.79V11.75H6.96C7.96 11.75 8.97 12.15 8.97 14.08C8.97 15.63 8 16.9 6.96 16.9ZM15.75 6.41H20.8V7.61H15.75V6.41ZM22 14.79C22 11.66 20.19 9.5 16.96 9.5C13.95 9.5 12 11.71 12 14.67C12 17.73 13.9 19.5 16.95 19.5C19.17 19.5 20.78 18.47 21.61 16.4H18.98C18.68 17.05 17.96 17.51 17.05 17.51C15.56 17.51 14.73 16.72 14.64 15.23H22V14.79ZM14.69 13.67C14.73 12.48 15.58 11.49 16.87 11.49C18.05 11.49 18.79 12.54 18.85 13.67H14.69Z"/>
                        </svg>
                    </a>
                </div>

                <a class="scroll-indicator" href="#about">
                    <span>Scroll Down</span>
                    <i aria-hidden="true"></i>
                </a>

                <div class="pager" aria-hidden="true">
                    <span class="diamond"></span>
                    <strong>1./3.</strong>
                </div>
            </div>
        </section>

        <main class="content">
            <section class="section" id="about">
                <div class="section-shell">
                    <div class="section-head" data-reveal>
                        <span class="section-kicker">About</span>
                        <h2 class="section-title">Designing visuals that feel bold, clear, and unmistakably yours.</h2>
                        <p class="section-copy">
                            Porto is built for brands and personal portfolios that want a
                            stronger first impression. The goal is simple: premium visuals,
                            sharp storytelling, and a modern experience that still feels fast.
                        </p>
                    </div>

                    <div class="about-grid">
                        <div class="glass-card profile-panel" data-reveal>
                            <span class="profile-chip">Creative Direction + Web Experience</span>
                            <p class="profile-lead">
                                I help shape digital experiences that connect visual identity,
                                interface design, and front-end polish so the final result is
                                not just beautiful, but also memorable and conversion-ready.
                            </p>

                            <div class="profile-stats">
                                <div>
                                    <strong>24+</strong>
                                    <span>Interface concepts explored with clear visual systems.</span>
                                </div>
                                <div>
                                    <strong>3 Core</strong>
                                    <span>Focus areas: design, development, and branding feel.</span>
                                </div>
                                <div>
                                    <strong>Fast Flow</strong>
                                    <span>From moodboard to polished landing page without losing momentum.</span>
                                </div>
                            </div>
                        </div>

                        <div class="about-side">
                            <div class="glass-card info-card" data-reveal>
                                <h3>What I Bring</h3>
                                <p>
                                    Clean hierarchy, motion that feels premium, and layouts that
                                    immediately tell visitors what you do and why it matters.
                                </p>
                            </div>

                            <div class="glass-card info-card" data-reveal>
                                <h3>Tools & Stack</h3>
                                <p>Built with a visual-first workflow and modern front-end execution.</p>
                                <div class="stack-list">
                                    <span>Figma</span>
                                    <span>Laravel</span>
                                    <span>React</span>
                                    <span>Tailwind</span>
                                    <span>GSAP</span>
                                    <span>Framer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section" id="services">
                <div class="section-shell">
                    <div class="section-head" data-reveal>
                        <span class="section-kicker">Services</span>
                        <h2 class="section-title">The kind of work that makes the brand feel more expensive.</h2>
                        <p class="section-copy">
                            From interface systems to landing page execution, each service is shaped
                            to give your product a stronger identity and a smoother user journey.
                        </p>
                    </div>

                    <div class="services-grid">
                        <article class="glass-card service-card" data-reveal>
                            <span class="service-index">01</span>
                            <h3>UI/UX Design</h3>
                            <p>
                                High-impact interface direction for landing pages, dashboards,
                                and product previews that need a premium first impression.
                            </p>
                            <div class="service-points">
                                <span>Wireframe to polished UI</span>
                                <span>Visual hierarchy and interaction flow</span>
                                <span>Responsive design systems</span>
                            </div>
                        </article>

                        <article class="glass-card service-card" data-reveal>
                            <span class="service-index">02</span>
                            <h3>Web Development</h3>
                            <p>
                                Fast front-end execution with animated details, clean structure,
                                and a visual style that matches the concept from the start.
                            </p>
                            <div class="service-points">
                                <span>Laravel and modern web stacks</span>
                                <span>Interactive hero and micro animation</span>
                                <span>Performance-aware implementation</span>
                            </div>
                        </article>

                        <article class="glass-card service-card" data-reveal>
                            <span class="service-index">03</span>
                            <h3>Branding Direction</h3>
                            <p>
                                Helping the brand feel consistent across tone, layout, color,
                                and presentation so the whole experience feels intentional.
                            </p>
                            <div class="service-points">
                                <span>Creative mood and art direction</span>
                                <span>Visual language refinement</span>
                                <span>Stronger digital identity</span>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="section" id="work">
                <div class="section-shell">
                    <div class="section-head" data-reveal>
                        <span class="section-kicker">Featured Work</span>
                        <h2 class="section-title">A quick look at the kind of visual stories I like to build.</h2>
                        <p class="section-copy">
                            These previews show the direction: clean structure, strong mood,
                            modern motion, and detail that keeps the layout from feeling generic.
                        </p>
                    </div>

                    <div class="work-grid">
                        <article class="glass-card work-card" data-reveal>
                            <div class="work-thumb">
                                <span class="preview-chip one">Fintech App</span>
                                <span class="preview-chip two">UX Flow</span>
                            </div>
                            <span class="work-index">01</span>
                            <h3>Fintech Mobile Concept</h3>
                            <p>
                                A product direction focused on trust, clarity, and a lighter visual
                                system for finance products that need to feel modern but safe.
                            </p>
                            <div class="tags">
                                <span>Mobile UI</span>
                                <span>Prototype</span>
                                <span>Dashboard</span>
                            </div>
                        </article>

                        <article class="glass-card work-card" data-reveal>
                            <div class="work-thumb">
                                <span class="preview-chip one">Web Platform</span>
                                <span class="preview-chip two">Motion</span>
                            </div>
                            <span class="work-index">02</span>
                            <h3>Interactive Web Platform</h3>
                            <p>
                                A darker, more cinematic landing experience for brands that want
                                stronger atmosphere, stronger messaging, and a premium feel.
                            </p>
                            <div class="tags">
                                <span>Landing Page</span>
                                <span>Animation</span>
                                <span>Brand Story</span>
                            </div>
                        </article>

                        <article class="glass-card work-card" data-reveal>
                            <div class="work-thumb">
                                <span class="preview-chip one">Creative UI</span>
                                <span class="preview-chip two">Identity</span>
                            </div>
                            <span class="work-index">03</span>
                            <h3>Interactive Brand Showcase</h3>
                            <p>
                                A portfolio-style concept that blends illustration, interface
                                depth, and hover-driven storytelling into one cohesive layout.
                            </p>
                            <div class="tags">
                                <span>Portfolio</span>
                                <span>Branding</span>
                                <span>Showcase</span>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="section" id="contact">
                <div class="section-shell">
                    <div class="glass-card contact-panel" data-reveal>
                        <div>
                            <span class="section-kicker">Contact</span>
                            <h2>Let&apos;s build something that looks premium and feels alive.</h2>
                            <p>
                                If you want a stronger portfolio, landing page, or a more striking
                                brand presentation, this is a good place to start. We can shape the
                                visual direction first, then turn it into a polished live experience.
                            </p>
                        </div>

                        <div class="contact-actions">
                            <a class="button primary" href="mailto:hello@porto.dev">Hire Me</a>
                            <a class="button secondary" href="#home">Back To Top</a>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="site-footer">
                &copy; {{ now()->year }} PORTO. ALL RIGHTS RESERVED.
            </footer>
        </main>

        <script>
            (() => {
                const root = document.documentElement;
                const spotlight = document.querySelector(".cursor-spotlight");
                const ring = document.querySelector(".cursor-ring");
                const hero = document.querySelector(".landing");
                const photoStack = document.querySelector(".photo-stack");
                const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

                const setPointer = (clientX, clientY) => {
                    const x = (clientX / window.innerWidth) - 0.5;
                    const y = (clientY / window.innerHeight) - 0.5;

                    root.style.setProperty("--pointer-x", x.toFixed(4));
                    root.style.setProperty("--pointer-y", y.toFixed(4));
                    root.style.setProperty("--cursor-x", `${clientX}px`);
                    root.style.setProperty("--cursor-y", `${clientY}px`);
                };

                const setScroll = () => {
                    const shift = Math.min(window.scrollY * 0.08, 40);
                    root.style.setProperty("--scroll-shift", `${shift}px`);
                };

                if (!prefersReducedMotion) {
                    window.addEventListener("pointermove", (event) => {
                        setPointer(event.clientX, event.clientY);
                        spotlight.style.opacity = "1";
                        ring.style.opacity = "1";
                    });

                    window.addEventListener("pointerleave", () => {
                        spotlight.style.opacity = "0";
                        ring.style.opacity = "0";
                        root.style.setProperty("--pointer-x", "0");
                        root.style.setProperty("--pointer-y", "0");
                    });

                    window.addEventListener("scroll", setScroll, { passive: true });
                    setScroll();
                }

                const reveals = document.querySelectorAll("[data-reveal]");
                const revealObserver = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add("is-visible");
                        }
                    });
                }, { threshold: 0.18 });

                reveals.forEach((element) => revealObserver.observe(element));

                const sections = document.querySelectorAll("section[id]");
                const navLinks = document.querySelectorAll(".nav a");

                const navObserver = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) {
                            return;
                        }

                        navLinks.forEach((link) => {
                            const matches = link.getAttribute("href") === `#${entry.target.id}`;
                            link.classList.toggle("active", matches);
                        });
                    });
                }, { rootMargin: "-35% 0px -40% 0px", threshold: 0.1 });

                sections.forEach((section) => navObserver.observe(section));

                if (photoStack && !prefersReducedMotion) {
                    photoStack.addEventListener("click", () => {
                        photoStack.classList.remove("burst");
                        window.requestAnimationFrame(() => {
                            photoStack.classList.add("burst");
                            window.setTimeout(() => {
                                photoStack.classList.remove("burst");
                            }, 900);
                        });
                    });
                }

                if (hero && window.matchMedia("(hover: none)").matches) {
                    spotlight.style.display = "none";
                    ring.style.display = "none";
                }
            })();
        </script>
    </body>
</html>
