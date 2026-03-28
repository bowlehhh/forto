@extends('layouts.site')

@push('styles')
    <style data-page-style>
        .project-edit-shell {
            display: grid;
            gap: 1.2rem;
        }

        .project-edit-head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .project-edit-head p {
            margin: 0.8rem 0 0;
            color: rgba(239, 250, 248, 0.72);
            line-height: 1.8;
        }

        .project-edit-card {
            width: min(44rem, 100%);
        }
    </style>
@endpush

@section('content')
    <section class="page-section">
        <div class="container project-edit-shell">
            <div class="project-edit-head">
                <div>
                    <span class="section-kicker">Edit Project</span>
                    <h1 class="page-title" style="margin-top: 0.85rem;">Perbarui project tanpa sentuh kode.</h1>
                    <p>Setelah disimpan, halaman public `Projects` langsung ikut berubah.</p>
                </div>

                <div style="display: flex; flex-wrap: wrap; gap: 0.7rem;">
                    <a class="button secondary small" href="{{ route('projects') }}">Lihat Public</a>
                    <a class="button secondary small" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
                </div>
            </div>

            <div class="surface project-edit-card">
                <form class="form-grid" method="POST" action="{{ route('dashboard.projects.update', $project['id']) }}">
                    @csrf
                    @method('PUT')

                    @include('pages.partials.project-form-fields', ['project' => $project])

                    <div style="display: flex; flex-wrap: wrap; gap: 0.8rem;">
                        <button class="button primary" type="submit">Update Project</button>
                        <a class="button secondary" href="{{ route('dashboard') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
