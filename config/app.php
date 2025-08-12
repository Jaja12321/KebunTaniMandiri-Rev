<?php

return [

    /*
    |----------------------------------------------------------------------
    | Nama Aplikasi
    |----------------------------------------------------------------------
    |
    | Nilai ini adalah nama aplikasi Anda. Nilai ini digunakan ketika
    | framework perlu menempatkan nama aplikasi di notifikasi atau di
    | lokasi lain yang diperlukan oleh aplikasi atau paket-paketnya.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |----------------------------------------------------------------------
    | Lingkungan Aplikasi
    |----------------------------------------------------------------------
    |
    | Nilai ini menentukan "lingkungan" aplikasi Anda saat ini berjalan.
    | Ini dapat menentukan bagaimana Anda mengonfigurasi berbagai
    | layanan yang digunakan aplikasi. Atur ini di file ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |----------------------------------------------------------------------
    | Mode Debug Aplikasi
    |----------------------------------------------------------------------
    |
    | Ketika aplikasi Anda dalam mode debug, pesan kesalahan yang rinci
    | dengan jejak tumpukan akan ditampilkan pada setiap kesalahan yang
    | terjadi dalam aplikasi Anda. Jika dinonaktifkan, halaman kesalahan
    | generik yang sederhana akan ditampilkan.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |----------------------------------------------------------------------
    | URL Aplikasi
    |----------------------------------------------------------------------
    |
    | URL ini digunakan oleh konsol untuk menghasilkan URL yang benar
    | saat menggunakan alat Artisan. Anda harus mengatur ini ke root
    | aplikasi Anda sehingga dapat digunakan saat menjalankan tugas Artisan.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |----------------------------------------------------------------------
    | Zona Waktu Aplikasi
    |----------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan zona waktu default untuk aplikasi Anda,
    | yang akan digunakan oleh fungsi PHP untuk tanggal dan waktu. Kami telah
    | mengatur ini ke default yang masuk akal untuk Anda secara default.
    |
    */

    'timezone' => 'Asia/Jakarta',

    /*
    |----------------------------------------------------------------------
    | Konfigurasi Lokal Aplikasi
    |----------------------------------------------------------------------
    |
    | Lokasi aplikasi menentukan bahasa default yang akan digunakan oleh
    | penyedia layanan terjemahan. Anda bebas mengatur nilai ini ke salah
    | satu dari lokal yang akan didukung oleh aplikasi.
    |
    */

    'locale' => 'id',

    /*
    |----------------------------------------------------------------------
    | Lokasi Cadangan Aplikasi
    |----------------------------------------------------------------------
    |
    | Lokasi cadangan menentukan bahasa yang akan digunakan ketika lokasi
    | yang saat ini tidak tersedia. Anda dapat mengubah nilai ini agar
    | sesuai dengan salah satu folder bahasa yang disediakan oleh aplikasi.
    |
    */

    'fallback_locale' => 'id',

    /*
    |----------------------------------------------------------------------
    | Lokal Faker
    |----------------------------------------------------------------------
    |
    | Lokal ini akan digunakan oleh pustaka Faker PHP ketika menghasilkan
    | data palsu untuk seed basis data Anda. Misalnya, ini akan digunakan
    | untuk mendapatkan nomor telepon yang dilokalkan, alamat jalan, dan lainnya.
    |
    */

    'faker_locale' => 'id_ID',

    /*
    |----------------------------------------------------------------------
    | Kunci Enkripsi
    |----------------------------------------------------------------------
    |
    | Kunci ini digunakan oleh layanan enkripsi Illuminate dan harus diatur
    | ke string acak yang panjangnya 32 karakter, jika tidak maka string
    | yang dienkripsi tidak akan aman. Harap lakukan ini sebelum meluncurkan aplikasi!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |----------------------------------------------------------------------
    | Penyedia Layanan yang Dimuat Secara Otomatis
    |----------------------------------------------------------------------
    |
    | Penyedia layanan yang tercantum di sini akan dimuat secara otomatis
    | saat aplikasi Anda meminta layanan tersebut. Anda dapat menambahkan
    | layanan lain ke array ini untuk memberikan fungsionalitas lebih pada aplikasi Anda.
    |
    */

    'providers' => [

        /*
         * Penyedia Layanan Laravel Framework...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        Barryvdh\Snappy\ServiceProvider::class, // Menambahkan Snappy sebagai provider PDF

        /*
         * Penyedia Layanan Paket...
         */

        /*
         * Penyedia Layanan Aplikasi...
         */
        App\Providers\FortifyServiceProvider::class,
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ],

    /*
    |----------------------------------------------------------------------
    | Alias Kelas
    |----------------------------------------------------------------------
    |
    | Array alias kelas ini akan didaftarkan saat aplikasi ini dimulai.
    | Anda bebas mendaftarkan alias sesuai kebutuhan Anda karena alias ini
    | dimuat "secara malas", sehingga tidak mempengaruhi kinerja aplikasi.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        
        // Alias untuk Snappy PDF
        'PDF' => Barryvdh\Snappy\Facades\SnappyPdf::class,

    ],

];
