@php
    $sharedUser = $data['project']
        ->sharedUsers()
        ->where('user_id', auth()->id())
        ->first();
@endphp

@component('mail::message')
    <div style="text-align: center; font-family: Arial, sans-serif; color: #4a4a4a;">
        <h1 style="color: #5a5a5a;">🎉 Selamat! 🎉</h1>
        <p style="font-size: 18px;">Anda telah diberikan akses ke proyek:</p>
        <h2 style="color: #2a9d8f;">{{ $data['project']->name }}</h2>

        <p style="font-size: 16px;">
            Anda mendapatkan akses sebagai
            <strong style="color: #e76f51;">{{ $sharedUser ? $sharedUser->pivot->permissions : 'Tidak diketahui' }}</strong>.
        </p>

        @component('mail::button', ['url' => route('projects.access', ['token' => $data['token']])])
            Akses Proyek
        @endcomponent

        <p style="font-size: 14px;">Terima kasih,<br>{{ config('app.name') }}</p>
    </div>
@endcomponent
