# Google OAuth Setup (Laravel)

## 1. Buat Google API Credentials

1. Buka Google Cloud Console:
   - https://console.cloud.google.com/apis/credentials
2. Buat project baru (atau pilih project existing).
3. Aktifkan API:
   - Google Identity Services (OAuth)
   - Google+ API (kadang diperlukan)
4. Buat OAuth 2.0 Client ID:
   - Application type: `Web application`
   - Name: `putik-py-center`
   - `Authorized redirect URIs`:
     - `http://localhost:8000/auth/google/callback`
     - (tambahkan production URL nanti)
5. Salin:
   - `Client ID`
   - `Client secret`

---

## 2. .env (Laravel)

```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

> Pastikan `APP_URL=http://localhost:8000`.

---

## 3. config/services.php

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

---

## 4. Instalasi Socialite

```bash
composer require laravel/socialite
```

Jika sudah diinstal, lanjut.

---

## 5. Route

`routes/web.php`:

```php
use App\Http\Controllers\AuthController;

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
```

---

## 6. Controller

`app/Http/Controllers/AuthController.php`:

```php
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

public function redirectToGoogle()
{
    return Socialite::driver('google')
        ->scopes(['openid','profile','email'])
        ->redirect();
}

public function handleGoogleCallback()
{
    try {
        Log::info('Google OAuth callback started');
        $googleUser = Socialite::driver('google')->stateless()->user();

        if (! $googleUser->getEmail()) {
            return redirect()->route('login')->with('error', 'Google account tidak memiliki email.');
        }

        $user = User::firstOrNew(['email' => $googleUser->getEmail()]);
        $user->name = $user->name ?: $googleUser->getName() ?: $googleUser->getNickname() ?: 'Google User';
        $user->google_id = $googleUser->getId();
        $user->role = $user->role ?: 'user';
        $user->email_verified_at = $user->email_verified_at ?: now();
        if (! $user->exists) {
            $user->password = Hash::make(Str::random(24));
        }
        $user->save();

        Auth::login($user, true);

        return redirect()->intended(route('userDashboard'));
    } catch (\Exception $e) {
        Log::error('Google OAuth error', ['message' => $e->getMessage()]);
        return redirect()->route('login')->with('error', 'Google auth failed: '.$e->getMessage());
    }
}
```

---

## 7. Model User

`app/Models/User.php`:

```php
protected $fillable = [
    'name','email','password','google_id','role',
];

protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // ...
    ];
}
```

Migration `google_id` maintained sudah ada.

---

## 8. UI (Login button)

`resources/js/pages/auth/Login.vue`:

```html
<a href="/auth/google" class="...">Masuk dengan Google</a>
```

Tempatkan di bawah form, dan beri styling `w-full` supaya terlihat tombol.

---

## 9. Perbaikan cURL (Windows / Laragon)

Jika error:
- `cURL error 77 ... cacert.pem`

Set di `php.ini`:

```ini
curl.cainfo = "D:/Projects/Laragon-installer/8.0-W64/etc/ssl/cacert.pem"
openssl.cafile = "D:/Projects/Laragon-installer/8.0-W64/etc/ssl/cacert.pem"
```

Restart server.

---

## 10. Verifikasi

1. `php artisan migrate`
2. `php artisan serve` / Jalankan dev server
3. Buka `/login`
4. Klik `Masuk dengan Google`
5. Login Google; seharusnya redirect ke `userDashboard`
6. Cek tabel `users` -> baris baru `google_id` terisi

---

## 11. Troubleshoot umum

- `Invalid end tag` = template Vue tak beres (tutup tag salah)
- `CSRF mismatch` = jangan panggil `->stateless()` di production; kalau sekali coba sementara
- `redirect_uri_mismatch` = URI di Google Console harus cocok persis
- `route('userDashboard')` butuh middleware `auth` aktif

---

## 12. Test

Pastikan minimal unit test:
- login via `/auth/google/callback` dengan data dummy (mock Socialite)
- assert redirect `userDashboard`
- assert user terbangun / diupdate

---
