@component('mail::message')
# 🎉 Selamat Datang di Wedding Planner!

Halo {{ $user->name ?? 'Wedding Strangers' }},

Terima kasih telah mendaftar di platform **Wedding Planner** kami.
Untuk mulai menggunakan layanan kami, silakan verifikasi email Anda dengan menekan tombol di bawah ini:

@component('mail::button', ['url' => $actionUrl, 'color' => 'success'])
Verifikasi Email Sekarang
@endcomponent

Jika Anda tidak merasa melakukan pendaftaran, Anda dapat mengabaikan email ini.

---

🤍 Salam hangat,
**Tim Wedding Planner**
[{{ config('app.url') }}]({{ config('app.url') }})
@endcomponent