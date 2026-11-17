@props(['name', 'size' => 24])
<svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" {{ $attributes }}>
@switch($name)
@case('arrow')<path d="M4 12h15M13 6l6 6-6 6"/>@break
@case('diagonal')<path d="M6 18 18 6M6 6h12v12"/>@break
@case('shield')<path d="m12 3 8 3v6c0 4-4.5 7.5-8 9-3.5-1.5-8-5-8-9V6l8-3Z"/><path d="m8 12 3 3 5-6"/>@break
@case('camera')<path d="M4 7h11a2 2 0 0 1 2 2v8H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z"/><path d="m17 10 5-3v10l-5-3M8 17v4m-3 0h6"/><circle cx="8" cy="12" r="2"/>@break
@case('sun')<circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M2 12h2m16 0h2M5 5l1.5 1.5m11 11L19 19M5 19l1.5-1.5m11-11L19 5"/>@break
@case('fingerprint')<path d="M4 10a8 8 0 0 1 16 0v3m-13 4v-7a5 5 0 0 1 10 0v4c0 3-1 5-2 7M10 20V10a2 2 0 0 1 4 0v5m-10-2v3m8-2v6m7-4-1 4"/>@break
@case('pin')<path d="M20 10c0 6-8 11-8 11S4 16 4 10a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>@break
@case('car')<path d="m4 10 2-6h12l2 6M3 10h18v8H3zM5 18v3m14-3v3M6 14h2m8 0h2"/>@break
@case('bell')<path d="M6 8a6 6 0 0 1 12 0c0 7 3 8 3 8H3s3-1 3-8Zm4 12h4M12 2V1"/>@break
@case('check')<path d="m5 12 4 4L19 6"/>@break
@case('phone')<path d="m7 3 3 5-3 3a16 16 0 0 0 6 6l3-3 5 3c0 3-2 4-4 4C9 21 3 15 3 7c0-2 1-4 4-4Z"/>@break
@case('mail')<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 6 10 7L22 6"/>@break
@case('chat')<path d="M21 11a9 9 0 0 1-9 9 10 10 0 0 1-4-1l-6 2 2-6a10 10 0 0 1-1-4 9 9 0 0 1 18 0Z"/><path d="M8 8c0 4 2 6 6 6l1-2-2-1-1 1-2-2 1-1-1-2-2 1Z"/>@break
@case('plus')<path d="M12 5v14M5 12h14"/>@break
@case('close')<path d="m6 6 12 12M6 18 18 6"/>@break
@case('menu')<path d="M4 7h16M4 12h16M4 17h16"/>@break
@case('play')<path d="m9 5 11 7-11 7V5Z"/>@break
@case('wrench')<path d="m14 6 4 4 3-3a6 6 0 0 1-7 7l-7 7-4-4 7-7a6 6 0 0 1 7-7l-3 3Z"/>@break
@case('eye')<path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/>@break
@case('facebook')<path d="M14 21v-8h3l.5-4H14V7c0-1 .5-2 2-2h2V2h-3c-3 0-5 2-5 5v2H7v4h3v8"/>@break
@case('instagram')<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".7" fill="currentColor" stroke="none"/>@break
@case('x')<path d="M4 3h4l12 18h-4L4 3Zm16 0L4 21"/>@break
@case('tiktok')<path d="M14 3v12a5 5 0 1 1-5-5m5-7c0 4 3 6 6 6V6c-2 0-3-1-3-3h-3Z"/>@break
@case('youtube')<rect x="2" y="5" width="20" height="14" rx="4"/><path d="m10 9 6 3-6 3V9Z"/>@break
@case('linkedin')<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M7 10v7m4 0v-7m0 3a3 3 0 0 1 6 0v4"/><circle cx="7" cy="7" r=".7" fill="currentColor" stroke="none"/>@break
@case('telegram')<path d="m3 10 18-7-4 18-6-5-4 3v-6l10-7-8 8-6-4Z"/>@break
@endswitch
</svg>
