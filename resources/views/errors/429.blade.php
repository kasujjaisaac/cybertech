@php($company = config('company'))
@extends('layout', ['company' => config('company'), 'pageTitle' => 'Please try again shortly', 'pageDescription' => 'Several enquiries were submitted in a short period. Please wait a moment before sending another.', 'noindex' => true])

@section('content')
<section class="section container error-content">
    <h2>Need to speak to us now?</h2>
    <p>Call {{ $company['phone'] }} or contact our team on WhatsApp.</p>
    <div class="hero-actions"><a class="button" href="tel:{{ $company['phone_link'] }}">Call us</a><a class="text-link" href="https://wa.me/{{ $company['whatsapp'] }}" target="_blank" rel="noopener">WhatsApp</a></div>
</section>
@endsection
