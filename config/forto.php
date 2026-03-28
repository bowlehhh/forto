<?php

return [
    'brand' => [
        'name' => 'Porto',
        'mark' => 'PT.',
        'tagline' => 'Your Design',
    ],

    'owner' => [
        'name' => 'Tio',
        'role' => 'Programmer',
        'intro' => 'Porto membantu brand dan personal portfolio tampil lebih premium lewat visual yang lebih rapi, lebih kuat, dan lebih terasa hidup.',
    ],

    'admin' => [
        'name' => env('FORTO_ADMIN_NAME', 'wtp'),
        'email' => env('FORTO_ADMIN_EMAIL', 'winkytiopratama@gmail.com'),
        'password' => env('FORTO_ADMIN_PASSWORD', 'winkyganteng'),
    ],

    'links' => [
        'github' => env('FORTO_GITHUB_URL', 'https://github.com'),
    ],

    'music' => [
        'track' => 'Dawin - Dessert ft. Silentó [NZp_axebSfQ].mp3',
        'label' => 'Putar lagu website',
        'volume' => 0.42,
    ],

    'site_like' => [
        'people' => [
            'Alya Ramadhani',
            'Raka Fadhil',
            'Nadia Putri',
            'Bima Akbar',
            'Salsa Maharani',
            'Dion Pratama',
        ],
    ],

    'highlights' => [
        'Identity',
        'Interaction',
        'Performance',
    ],

    'skills' => [
        [
            'title' => 'Front-end Development',
            'items' => ['Laravel Blade', 'Responsive Layout', 'Interactive UI'],
        ],
        [
            'title' => 'Web Design',
            'items' => ['Visual Hierarchy', 'Modern Styling', 'Component Polish'],
        ],
        [
            'title' => 'Creative Technology',
            'items' => ['Animation', 'Performance', 'User Experience'],
        ],
        [
            'title' => 'Music',
            'items' => ['Drum', 'Keyboard', 'Bass', 'Guitar'],
        ],
    ],

    'about' => [
        'headline' => 'About Me',
        'summary' => 'Saya adalah seorang yang memiliki passion di bidang musik dan teknologi.',
        'story' => [
            'Saya mampu memainkan beberapa alat musik seperti drum, keyboard, bass, dan gitar, yang membantu saya mengekspresikan kreativitas dalam berbagai bentuk.',
            'Saat ini saya bersekolah di SMKTI Airlangga Samarinda, di mana saya terus mengembangkan kemampuan dan pengetahuan saya, khususnya di bidang teknologi.',
            'Selain itu, saya juga memiliki minat dalam dunia digital, seperti membuat website dan aplikasi. Saya menikmati proses menciptakan sesuatu yang tidak hanya berfungsi dengan baik, tetapi juga memiliki tampilan yang menarik.',
            'Di waktu luang, saya senang menjelajahi wisata alam, karena bagi saya alam adalah sumber inspirasi dan ketenangan.',
        ],
        'points' => [],
    ],

    'contact' => [
        'email' => 'winkytiopratama@gmail.com',
        'instagram' => 'winkytioprtma',
        'instagram_url' => 'https://instagram.com/winkytioprtma',
        'location' => 'Samarinda, Indonesia',
    ],

    'projects' => [
        [
            'title' => 'Porto Portfolio',
            'category' => 'Portfolio Website',
            'summary' => 'Website personal dengan karakter visual yang kuat, layout yang lebih cinematic, dan navigasi multi-page yang lebih rapi.',
            'stack' => ['Laravel', 'Blade', 'UI Direction'],
            'status' => 'Ready',
        ],
        [
            'title' => 'Fintech Landing',
            'category' => 'Landing Page',
            'summary' => 'Landing page untuk brand fintech dengan fokus ke trust, clarity, dan presentasi produk yang lebih elegan.',
            'stack' => ['UX Writing', 'Responsive UI', 'Front-end'],
            'status' => 'Concept',
        ],
        [
            'title' => 'Interactive Product Page',
            'category' => 'Showcase Page',
            'summary' => 'Halaman showcase modern dengan motion halus, visual depth, dan storytelling yang lebih premium.',
            'stack' => ['Interaction', 'Motion', 'Branding'],
            'status' => 'Featured',
        ],
    ],
];
