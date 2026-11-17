@extends('layout')

@section('content')
    <section id="solutions" class="section container">
        <div class="section-heading reveal"><div><div class="eyebrow red">SECURITY THAT FITS YOUR LIFE</div><h2>Different spaces.<br>One less thing to <span class="serif">worry about.</span></h2></div><p>From your front door to your entire business.<br>Explore protection built around you.</p></div>
        <div class="solution-photo-strip">
            @foreach([['cctv-camera-profile.jpg', 'Camera placement'], ['solar-assembly-wide.jpg', 'Equipment preparation'], ['ceiling-installation-detail.jpg', 'Installation work']] as [$photo, $caption])
            <figure><img src="{{ asset('images/'.$photo) }}" alt="{{ $caption }} by Cyber Tech Security Systems" width="810" height="1080" loading="lazy" decoding="async"><figcaption>{{ $caption }}</figcaption></figure>
            @endforeach
        </div>
        <div class="solutions-grid">
            @foreach([
                ['camera','CCTV surveillance','A clearer picture. Wherever you are.','Hikvision monitoring, multi-lens coverage and remote viewing for homes and businesses.','CCTV surveillance','01'],
                ['sun','Solar-powered security','Go further. Stay protected.','Energy-independent camera solutions for farms, remote properties and places with unreliable power.','Solar security','02'],
                ['fingerprint','Access & attendance','The right people. The right access.','Fingerprint, facial recognition and attendance systems that make secure entry effortless.','Access control','03'],
                ['car','Vehicle & asset tracking','Keep what moves within reach.','Real-time GPS tracking for vehicle location, speed and status, plus automatic mirror folders.','Vehicle tracking','04'],
                ['bell','Intrusion & alarms','Know sooner. Respond smarter.','Intelligent detection and instant alerts to help deter intruders before threats escalate.','Alarm systems','05'],
            ] as [$icon,$title,$lead,$description,$service,$number])
            <a href="{{ route('contact', ['service' => $service]) }}" class="solution-card reveal" data-solution="{{ $service }}" data-title="{{ $title }}" data-description="{{ $description }}">
                @if(isset($solutionPhotos[$service]))<img class="solution-card-photo" src="{{ asset('images/'.$solutionPhotos[$service]) }}" alt="{{ $title }} installation and equipment" width="1080" height="810" loading="lazy" decoding="async">@endif
                <div class="solution-card-content">
                <div class="card-top"><span class="solution-icon"><x-icon :name="$icon" :size="28" /></span><span class="card-number">{{ $number }}</span></div>
                <h3>{{ $title }}</h3><strong>{{ $lead }}</strong><p>{{ $description }}</p><span class="card-link">Explore solution</span></div>
            </a>
            @endforeach
            <div class="solution-help reveal"><div class="small-label">LET’S FIGURE IT OUT, TOGETHER</div><h3>Not sure where<br>to <span class="serif">start?</span></h3><p>Tell us about your space. We’ll help you choose a practical solution.</p><a class="button button-white" href="{{ route('contact', ['service' => 'Help me choose']) }}" data-select-service="Help me choose">Ask our team</a></div>
        </div>
    </section>
@endsection
