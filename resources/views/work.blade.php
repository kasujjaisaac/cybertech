@extends('layout')

@section('content')
    <section id="work" class="section work-section"><div class="container">
        <div class="section-heading reveal"><div><div class="eyebrow red">ON THE GROUND. MAKING A DIFFERENCE.</div><h2>Good technology.<br><span class="serif">Even better hands.</span></h2></div><div><p>A glimpse into our work: the people, the process,<br>and the protection we put in place.</p><span class="gallery-hint">Tap a photo to take a closer look</span></div></div>
        <div class="work-grid portfolio-grid">
            @foreach(config('gallery') as [$image, $category, $caption, $class])
            <a href="{{ asset('images/'.$image) }}" class="work-photo {{ $class }} reveal" data-gallery="{{ asset('images/'.$image) }}" data-caption="{{ $caption }}" aria-label="View photo: {{ $caption }}"><img src="{{ asset('images/'.$image) }}" alt="{{ $category }} by Cyber Tech Security Systems" width="1080" height="810" loading="lazy" decoding="async"><span class="photo-overlay"><span><small>{{ $category }}</small><strong>{{ $caption }}</strong></span></span></a>
            @endforeach
        </div>
    </div></section>
@endsection
