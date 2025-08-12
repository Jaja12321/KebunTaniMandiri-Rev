<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PasswordOtp extends Model
{
    protected $fillable = ['email', 'otp', 'expires_at'];
    protected $dates = ['expires_at'];
    public $timestamps = false;

    /**
     * Mengecek apakah OTP masih berlaku
     */
    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expires_at);
    }

    /**
     * Cari data OTP terbaru berdasarkan email
     */
    public static function getLatestOtp($email)
    {
        return self::where('email', $email)->latest('expires_at')->first();
    }

    /**
     * Validasi OTP dan email
     */
    public static function validateOtp($email, $otp)
    {
        $record = self::where('email', $email)
                      ->where('otp', $otp)
                      ->where('expires_at', '>', now())
                      ->first();

        return $record !== null;
    }
}
