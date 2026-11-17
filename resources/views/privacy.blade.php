@extends('layout')

@section('content')
<section class="section container privacy-content">
    <h2>Your information</h2>
    <p>When you send an enquiry, we store your name, contact details, selected solution, property type and project description so our team can respond and discuss your requirements. Sending an enquiry does not subscribe you to marketing messages.</p>
    <h2>Browser preferences and cookies</h2>
    <p>We save your selected color theme in your browser. The site uses session cookies to support enquiry forms, validation and security.</p>
    <h2>Contact and third-party links</h2>
    <p>WhatsApp, social media and map links open third-party services with their own privacy policies. Please avoid including passwords, camera access codes or other sensitive security information in your enquiry.</p>
    <p>To ask about your information or request its deletion, email <a href="mailto:{{ $company['email'] }}">{{ $company['email'] }}</a>.</p>
</section>
@endsection
