@php
    $sharedUser = $data['project']
        ->sharedUsers()
        ->where('user_id', auth()->id())
        ->first();
@endphp

@component('mail::message')
    #🎉 Selamat! 🎉

    Anda telah diberikan akses ke proyek:

    ##{{ $data['project']->name }}

    @component('mail::button', [
        'url' => route('projects.access', [
            'slug' => $data['project']->slug,
            'token' => $data['token'],
        ]),
    ])
        Akses Proyek
    @endcomponent

    Terima kasih,
    {{ config('app.name') }}
@endcomponent
