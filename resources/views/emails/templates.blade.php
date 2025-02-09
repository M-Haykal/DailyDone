@php
    $sharedUser = $data['project']
        ->sharedUsers()
        ->where('user_id', auth()->id())
        ->first();
@endphp

@component('mail::message')
    # Anda telah diberikan akses ke proyek: {{ $data['project']->name }}

    Anda mendapatkan akses sebagai
    **{{ $sharedUser ? $sharedUser->pivot->permissions : 'Tidak diketahui' }}**.

    Klik tombol di bawah untuk membuka proyek:

    @component('mail::button', ['url' => route('projects.access', ['token' => $data['token']])])
        Akses Proyek
    @endcomponent

    Terima kasih,<br>
    {{ config('app.name') }}
@endcomponent
