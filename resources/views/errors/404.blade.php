@extends('layout', ['company' => config('company'), 'noindex' => true, 'pageTitle' => 'Page not found', 'pageDescription' => 'This page may have moved or the address may be incorrect. Let us help you find your way.'])

@section('content')
<section class="section container error-content">
    <span class="eyebrow red">404</span>
    <h2>Let’s get you back on track.</h2>
    <p>Explore our security products or return to the home page.</p>
    <div class="hero-actions"><a class="button" href="{{ route('home') }}">Back to home</a><a class="text-link" href="{{ route('products') }}">Browse products</a></div>
</section>
@endsection
