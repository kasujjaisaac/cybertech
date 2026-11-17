@extends('layout')

@section('content')
    <section id="about" class="section container about-layout"><div class="about-copy reveal"><div class="eyebrow red">YOUR SECURITY. OUR RESPONSIBILITY.</div><h2>Big on technology.<br><span class="serif">Closer to home.</span></h2><p class="large-copy">We’re Cyber Tech Security Systems, your security technology team in the heart of Masaka City.</p><p>Our belief is simple: feeling safe should be straightforward. We bridge the gap between advanced technology and everyday life, with systems designed around your space and people who care about getting it right.</p><div class="about-signature"><span class="signature-line"></span><strong>Redefining Security Proactively</strong></div><a class="text-link" href="{{ $company['directions'] }}" target="_blank" rel="noopener">Come meet us in Masaka</a></div><div class="values-list reveal">
        @foreach([['01','We think ahead.','Detection, deterrence and timely alerts. We design security to help you act before a problem grows.'],['02','Your space sets the brief.','From a single car tracker to a commercial CCTV network, we tailor the system to your needs and budget.'],['03','We make the complex simple.','Clear recommendations, careful installation and a proper introduction to your new system.'],['04','We’re here, locally.','Visit our Masaka showroom for advice, product demonstrations, maintenance and technical support.']] as [$n,$title,$text])
        <div class="value-row"><span>{{ $n }}</span><div><h3>{{ $title }}</h3><p>{{ $text }}</p></div><x-icon name="plus" :size="17" /></div>
        @endforeach
    </div></section>
<section class="section container team-photo-section">
    <div class="section-heading"><div><div class="eyebrow red">PEOPLE BEHIND THE PROTECTION</div><h2>Local knowledge.<br><span class="serif">Hands-on experience.</span></h2></div><p>From product demonstrations to preparing your equipment, meet the people behind the work.</p></div>
    <div class="team-photo-grid">
        <figure><img src="{{ asset('images/team-product-demonstration.jpg') }}" alt="A Cyber Tech team member demonstrating solar camera equipment" width="1080" height="810" loading="lazy" decoding="async"><figcaption>Getting to know the equipment</figcaption></figure>
        <figure><img src="{{ asset('images/camera-product-advice.jpg') }}" alt="A technician with a solar camera assembly before installation" width="1080" height="810" loading="lazy" decoding="async"><figcaption>Preparing your security setup</figcaption></figure>
        <figure><img src="{{ asset('images/team-equipment.jpg') }}" alt="A technician with camera equipment and installation tools" width="810" height="1080" loading="lazy" decoding="async"><figcaption>Equipment ready for the project</figcaption></figure>
    </div>
</section>
<section class="section container showroom-section">
    <figure class="showroom-photo"><img src="{{ asset('images/showroom.jpg') }}" alt="Solar security camera systems in the Cyber Tech showroom" width="810" height="1080" loading="lazy"><figcaption>Our showroom in Masaka City</figcaption></figure>
    <div class="showroom-copy"><div class="eyebrow red">MEET YOUR LOCAL TEAM</div><h2>See the systems.<br><span class="serif">Ask your questions.</span></h2><p>Visit us for advice, product demonstrations and help choosing a security setup for your space.</p><div class="showroom-address"><x-icon name="pin" :size="22" /><p>{{ $company['address'] }}, Uganda</p></div><p>Contact us before travelling to arrange a convenient time and confirm the products you would like to see.</p><div class="hero-actions"><a class="button" href="{{ $company['directions'] }}" target="_blank" rel="noopener">Get directions</a><a class="text-link" href="{{ route('contact') }}">Contact our team</a></div></div>
</section>
@endsection
