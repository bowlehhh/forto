@extends('layouts.site')

@section('content')
    <section class="page-section auth-shell">
        <div class="auth-card">
            <span class="section-kicker">Login</span>
            <h1 style="margin-top: 1rem;">Masuk ke dashboard Porto</h1>
            <p>Masuk untuk membuka dashboard pengelolaan website Porto.</p>

            <form class="form-grid" method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email admin"
                        required
                        autocomplete="username"
                        autocapitalize="off"
                        spellcheck="false"
                    >
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <button class="button primary" type="submit">Login</button>
            </form>
        </div>
    </section>
@endsection
