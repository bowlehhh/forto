@extends('layouts.site')

@section('content')
    <section class="page-section">
        <div class="container">
            <span class="section-kicker">Contact</span>
            <h1 class="page-title">Contact</h1>

            <div class="contact-list">
                <div class="contact-row">
                    <div>
                        <strong>Email</strong>
                        <span>{{ $contact['email'] }}</span>
                    </div>
                    <a class="button secondary small" href="mailto:{{ $contact['email'] }}">Send Email</a>
                </div>

                <div class="contact-row">
                    <div>
                        <strong>Instagram</strong>
                        <span>{{ $contact['instagram'] }}</span>
                    </div>
                    <a class="button secondary small" href="{{ $contact['instagram_url'] }}" target="_blank" rel="noreferrer">Open Instagram</a>
                </div>

                <div class="contact-row">
                    <div>
                        <strong>Location</strong>
                        <span>{{ $contact['location'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
