@extends('layout')

@section('content')
    <section class="hero container" aria-label="Security highlights" aria-roledescription="carousel">
        <div class="hero-slide" role="group" aria-roledescription="slide" aria-label="1 of 3">
        <div class="hero-copy">
            <div class="eyebrow"><span class="status-dot"></span> LOCAL EXPERTISE. SMARTER PROTECTION.</div>
            <h1 id="hero-title" class="hero-title">A safer space.<br>A <span class="serif">clearer</span> view<span class="red">.</span></h1>
            <p class="hero-description">Peace of mind, powered by technology. We bring intelligent security to your home, business and everything that matters.</p>
            <div class="hero-actions"><a class="button" href="{{ route('solutions') }}">Find your solution</a><a class="text-link" href="{{ route('work') }}"><span class="play-icon"><x-icon name="play" :size="13" /></span> See our work</a></div>
            <div class="hero-footnote"><span class="mini-shield"><x-icon name="shield" :size="20" /></span><p>Designed for your space.<br><strong>Installed by your local experts.</strong></p></div>
        </div>
        <div class="hero-visual hero-visual-photo">
            <div class="hero-orbit orbit-one"></div><div class="hero-orbit orbit-two"></div>
            <img class="hero-product" src="{{ asset('images/solar-installation.jpg') }}" alt="Solar camera and lighting installed on a pole" width="1080" height="1066" fetchpriority="high">
        </div>
        </div>
        <div class="hero-slide" role="group" aria-roledescription="slide" aria-label="2 of 3" hidden>
        <div class="hero-copy">
            <div class="eyebrow"><span class="status-dot"></span> SOLAR POWER. EVERYDAY PEACE OF MIND.</div>
            <h2 id="hero-title-2" class="hero-title">More sunshine.<br>More <span class="serif">peace</span> of mind<span class="red">.</span></h2>
            <p class="hero-description">Keep an eye on what matters with solar-powered cameras. Smart protection for your home, farm or business, wherever you need it.</p>
            <div class="hero-actions"><a class="button" href="{{ route('products') }}">Explore solar cameras</a><a class="text-link" href="{{ route('work') }}"><span class="play-icon"><x-icon name="play" :size="13" /></span> View installations</a></div>
            <div class="hero-footnote"><span class="mini-shield"><x-icon name="shield" :size="20" /></span><p>Powered by daylight.<br><strong>Protection that keeps going.</strong></p></div>
        </div>
        <div class="hero-visual hero-visual-photo">
            <div class="hero-orbit orbit-one"></div><div class="hero-orbit orbit-two"></div>
            <img class="hero-product" src="{{ asset('images/technician-solar.jpg') }}" alt="Technician preparing solar camera equipment" width="1080" height="1066" loading="lazy">
        </div>
        </div>
        <div class="hero-slide" role="group" aria-roledescription="slide" aria-label="3 of 3" hidden>
        <div class="hero-copy">
            <div class="eyebrow"><span class="status-dot"></span> YOUR LOCAL TEAM. PROTECTION THAT FITS.</div>
            <h2 id="hero-title-3" class="hero-title">Expert hands.<br>A <span class="serif">safer</span> tomorrow<span class="red">.</span></h2>
            <p class="hero-description">From choosing the right system to professional installation, our Masaka team helps you secure your space with confidence.</p>
            <div class="hero-actions"><a class="button" href="{{ route('contact') }}">Talk to our team</a><a class="text-link" href="{{ route('work') }}"><span class="play-icon"><x-icon name="play" :size="13" /></span> Explore our work</a></div>
            <div class="hero-footnote"><span class="mini-shield"><x-icon name="shield" :size="20" /></span><p>Local knowledge. Personal support.<br><strong>With you from start to finish.</strong></p></div>
        </div>
        <div class="hero-visual hero-visual-photo">
            <div class="hero-orbit orbit-one"></div><div class="hero-orbit orbit-two"></div>
            <img class="hero-product" src="{{ asset('images/team-installation.jpg') }}" alt="Cyber Tech team installing a security system" width="1080" height="1066" loading="lazy">
        </div>
        </div>
        <div class="hero-controls" hidden>
            <button type="button" data-hero-prev aria-label="Previous slide">&lt;&lt;</button>
            <div class="hero-dots" aria-label="Choose a slide">
                <button type="button" data-hero-slide="0" aria-label="Slide 1: Smart protection" aria-current="true"></button>
                <button type="button" data-hero-slide="1" aria-label="Slide 2: Solar security" aria-current="false"></button>
                <button type="button" data-hero-slide="2" aria-label="Slide 3: Professional installation" aria-current="false"></button>
            </div>
            <button type="button" data-hero-next aria-label="Next slide">&gt;&gt;</button>
            <span class="sr-only" data-hero-status aria-live="off">Slide 1 of 3</span>
        </div>
    </section>
<div class="assurance-strip"><div class="container assurance-items"><span><x-icon name="shield" :size="21" /> Proactive protection</span><span><x-icon name="wrench" :size="21" /> Professional installation</span><span><x-icon name="eye" :size="21" /> Technology that sees more</span><span><x-icon name="pin" :size="21" /> Local support, always close</span></div></div>

    @include('product-collection')



    <section class="section container home-discover">
        <div class="section-heading"><div><div class="eyebrow red">PROTECTION MADE PERSONAL</div><h2>Your space. Your priorities.<br><span class="serif">The right protection.</span></h2></div><p>Explore our solutions, see the systems we offer, and get to know the team behind your installation.</p></div>
        <div class="solutions-grid">
            <a class="solution-card" href="{{ route('solutions') }}"><div class="card-top"><span class="solution-icon"><x-icon name="shield" :size="28" /></span></div><h3>Security that fits your life</h3><p>CCTV, solar security, access control, alarms and vehicle tracking, tailored to your needs.</p><span class="card-link">Explore solutions</span></a>
            <a class="solution-card" href="{{ route('products') }}"><div class="card-top"><span class="solution-icon"><x-icon name="camera" :size="28" /></span></div><h3>Find your next system</h3><p>Browse our camera systems and security equipment, then ask our team about the right setup.</p><span class="card-link">Browse products</span></a>
            <a class="solution-card" href="{{ route('work') }}"><div class="card-top"><span class="solution-icon"><x-icon name="wrench" :size="28" /></span></div><h3>See our team at work</h3><p>A closer look at local installations, monitoring systems and the people who bring them to life.</p><span class="card-link">View our work</span></a>
        </div>
    </section>
    <div class="home-contact-band"><div class="container"><div><div class="eyebrow">LET’S TALK SECURITY</div><h2>Ready for a safer space?</h2></div><a class="button" href="{{ route('contact') }}">Talk to our team</a></div></div>

@endsection
