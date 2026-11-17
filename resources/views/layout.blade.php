<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    @if($noindex ?? false)<meta name="robots" content="noindex, follow">@endif
    <meta name="color-scheme" content="light dark">
    <script src="{{ asset('js/theme.js') }}?v={{ filemtime(public_path('js/theme.js')) }}"></script>
    <script src="{{ asset('js/preloader.js') }}?v={{ filemtime(public_path('js/preloader.js')) }}"></script>
    <title>Cyber Tech Security Systems</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta property="og:title" content="{{ $pageTitle }} | Cyber Tech Masaka">
    <meta property="og:description" content="{{ $pageDescription }}">
    <script type="application/ld+json">{!! json_encode([
        '@'.'context' => 'https://schema.org', '@type' => 'LocalBusiness',
        'name' => $company['name'], 'url' => route('home'),
        'logo' => asset('favicon.png'), 'telephone' => $company['phone'], 'email' => $company['email'],
        'address' => ['@type' => 'PostalAddress', 'streetAddress' => $company['address'], 'addressLocality' => 'Masaka City', 'addressCountry' => 'UG'],
    ], JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $pageImage ?? asset('images/team-equipment.jpg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ filemtime(public_path('favicon.png')) }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}?v={{ filemtime(public_path('css/fonts.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ filemtime(public_path('css/site.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/design.css') }}?v={{ filemtime(public_path('css/design.css')) }}">
    <script src="{{ asset('js/site.js') }}?v={{ filemtime(public_path('js/site.js')) }}" defer></script>
</head>
<body>
<div id="site-preloader" aria-hidden="true">
    <div class="preloader-content">
        <div class="preloader-mark"><img src="{{ asset('images/logo-white.jpg') }}" data-light-src="{{ asset('images/logo-white.jpg') }}" data-dark-src="{{ asset('images/logo-white-transparent.png') }}" width="1080" height="567" alt="" decoding="async"></div>
        <div class="preloader-line"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>
    </div>
</div>
<a class="skip-link" href="#main">Skip to content</a>
<div class="announcement">
    <div class="container topbar-inner">
        <div class="topbar-contact">
            <a class="topbar-location" href="{{ $company['directions'] }}" target="_blank" rel="noopener"><x-icon name="pin" :size="14" /><span>Masaka City, Uganda</span></a>
            <a href="tel:{{ $company['phone_link'] }}" aria-label="Call Cyber Tech on {{ $company['phone'] }}" title="{{ $company['phone'] }}"><x-icon name="phone" :size="14" /><span>Call us</span></a>
            <a href="https://wa.me/{{ $company['whatsapp'] }}" target="_blank" rel="noopener"><x-icon name="chat" :size="14" /><span>WhatsApp</span></a>
        </div>
            <div class="topbar-social" role="group" aria-label="Social media">
                @foreach(['facebook' => 'Facebook', 'instagram' => 'Instagram', 'x' => 'X', 'tiktok' => 'TikTok', 'youtube' => 'YouTube', 'linkedin' => 'LinkedIn', 'telegram' => 'Telegram'] as $platform => $label)
                    @if(!empty($company['socials'][$platform]))
                        <a class="social-square" href="{{ $company['socials'][$platform] }}" target="_blank" rel="noopener" aria-label="{{ $label }}" title="{{ $label }}"><x-icon :name="$platform" :size="15" /></a>
                    @else
                        <span class="social-square" role="img" aria-label="{{ $label }}" title="{{ $label }}"><x-icon :name="$platform" :size="15" /></span>
                    @endif
                @endforeach
            </div>
    </div>
</div>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="{{ route('home') }}" aria-label="Cyber Tech Security Systems home"><span class="brand-image"><img src="{{ asset('images/logo-white.jpg') }}" data-light-src="{{ asset('images/logo-white.jpg') }}" data-dark-src="{{ asset('images/logo-white-transparent.png') }}" alt="Cyber Tech Security Systems" width="1080" height="567"></span></a>
        <nav id="main-nav" aria-label="Main navigation">
            @foreach(['home' => 'Home', 'solutions' => 'Solutions', 'products' => 'Products', 'work' => 'Our work', 'about' => 'About', 'contact' => 'Contact'] as $destination => $label)
                @php($activeDestination = request()->routeIs($destination) || ($destination === 'products' && request()->routeIs('products.*')))
                <a href="{{ route($destination) }}" @class(['is-active' => $activeDestination]) @if($activeDestination) aria-current="page" @endif><span class="nav-link-index" aria-hidden="true">{{ sprintf('%02d', $loop->iteration) }}</span><span>{{ $label }}</span></a>
            @endforeach
        </nav>
        <div class="header-actions">
        <a class="button button-small nav-cta" href="{{ route('contact') }}">Let’s secure your space</a>

        <div class="theme-switch" role="group" aria-label="Color theme" hidden>
            <button type="button" data-theme-option="light" aria-pressed="false">Light</button>
            <button type="button" data-theme-option="dark" aria-pressed="false">Dark</button>
            <button type="button" data-theme-option="system" aria-pressed="false" title="Follow your device theme">System</button>
        </div>
        <button class="menu-toggle" aria-label="Open navigation" aria-expanded="false" aria-controls="main-nav"><x-icon name="menu" class="menu-open-icon" /><x-icon name="close" class="menu-close-icon" /></button>
        </div>
    </div>
</header>
<main id="main">
    @unless(request()->routeIs('home'))
    <div class="page-intro container">
        <div class="eyebrow">CYBER TECH SECURITY SYSTEMS / {{ $pageTitle }}</div>
        <h1>{{ $pageTitle }}</h1>
        <p>{{ $pageDescription }}</p>
    </div>
    @endunless
    @yield('content')
</main>
<footer class="site-footer"><div class="container"><div class="footer-main"><div><a class="footer-brand" href="{{ route('home') }}">CYBER<span>TECH</span><small>SECURITY SYSTEMS</small></a><p>Redefining Security Proactively.<br>For your home. Your business. Your peace of mind.</p></div><div><span class="small-label">EXPLORE</span><a href="{{ route('home') }}">Home</a><a href="{{ route('solutions') }}">Our solutions</a><a href="{{ route('products') }}">Our products</a><a href="{{ route('work') }}">Our work</a><a href="{{ route('about') }}">About Cyber Tech</a><a href="{{ route('contact') }}">Contact</a></div><div><span class="small-label">LET’S CONNECT</span><a href="https://wa.me/{{ $company['whatsapp'] }}" target="_blank" rel="noopener">WhatsApp </a><a href="tel:{{ $company['phone_link'] }}">{{ $company['phone'] }}</a><a href="mailto:{{ $company['email'] }}">{{ $company['email'] }}</a></div><div class="footer-location"><span class="small-label">BASED IN MASAKA</span><p>City View Building<br>Level 3, Room 226<br>Masaka City, Uganda</p><a href="{{ $company['directions'] }}" target="_blank" rel="noopener">Get directions </a></div></div><div class="footer-bottom"><span>© {{ date('Y') }} Cyber Tech Security Systems. All rights reserved.</span><span class="footer-credit">Designed and protected by <a href="https://texaro.it.com/" target="_blank" rel="noopener noreferrer">Texaro Technologies Limited</a></span><a class="footer-privacy" href="{{ route('privacy') }}">Privacy</a><a href="#main">BACK TO TOP </a></div></div></footer>
<a class="floating-chat" href="https://wa.me/{{ $company['whatsapp'] }}" target="_blank" rel="noopener" aria-label="Chat with Cyber Tech on WhatsApp"><x-icon name="chat" :size="24" /><span>Let’s talk</span></a>

@if(request()->routeIs('solutions'))
<dialog id="solution-dialog" class="detail-dialog"><button class="dialog-close" aria-label="Close solution details" data-close-dialog><x-icon name="close" /></button><div class="eyebrow red">A SOLUTION THAT FITS YOU</div><h2 id="solution-title"></h2><p id="solution-description"></p><div class="dialog-benefits"><span><x-icon name="check" :size="17" /> Tailored to your property</span><span><x-icon name="check" :size="17" /> Professional installation</span><span><x-icon name="check" :size="17" /> Local technical support</span></div><a class="button" id="solution-cta" href="{{ route('contact') }}">Discuss this solution</a></dialog>
@endif
@if(request()->routeIs('work') || (request()->routeIs('products.show') && !empty($productPhotos)))
<dialog id="gallery-dialog" class="gallery-dialog" aria-label="Installation photo viewer"><button class="dialog-close" data-close-dialog aria-label="Close photo viewer"><x-icon name="close" /></button><div class="gallery-stage"><button id="gallery-prev" class="gallery-control" aria-label="Previous photo">&lt;&lt;</button><img id="gallery-image" alt=""><button id="gallery-next" class="gallery-control" aria-label="Next photo">&gt;&gt;</button></div><div class="gallery-caption"><p id="gallery-caption"></p><span id="gallery-count"></span></div></dialog>
@endif

</body>
</html>
