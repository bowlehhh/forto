@extends('layouts.site')

@section('content')
    <section class="page-section">
        <div class="container">
            <span class="section-kicker">Dashboard</span>
            <h1 class="page-title">Edit Skill</h1>
            <p class="page-copy">
                Perbarui data skill di database. Perubahan yang disimpan akan langsung dipakai halaman public.
            </p>

            <div class="auth-card" style="width: min(42rem, 100%); margin-top: 2rem;">
                <form class="form-grid" method="POST" action="{{ route('dashboard.skills.update', $skill) }}">
                    @csrf
                    @method('PUT')
                    @include('pages.partials.skill-form-fields', ['skill' => $skill, 'errorBag' => 'skillForm'])

                    <div style="display: flex; flex-wrap: wrap; gap: 0.8rem;">
                        <button class="button primary" type="submit">Simpan Perubahan</button>
                        <a class="button secondary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
