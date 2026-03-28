@extends('layouts.site')

@section('content')
    <section class="page-section">
        <div class="container">
            <span class="section-kicker">Skills</span>
            <h1 class="page-title">Skill</h1>

            <div class="project-grid" style="margin-top: 2rem;">
                @foreach ($skills as $skill)
                    <article class="surface" style="display: grid; gap: 1rem;">
                        <h2 style="margin: 0; font-size: 1.3rem;">{{ $skill['title'] }}</h2>

                        <div class="tag-row">
                            @foreach ($skill['items'] as $item)
                                <span class="tag">{{ $item }}</span>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
