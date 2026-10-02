<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\AccountType;
use App\Models\User;
use App\Models\EmailOtp;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function register(array $data)
    {
        $touristType = AccountType::where('type', AccountType::TOURIST)->firstOrFail();

        $user = User::create([
            'account_type_id' => $touristType->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password']
        ]);

        $this->sendOtp($user);

        return $user;
    }
    public function login(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! \Hash::check($credentials['password'], $user->password))
            throw new \InvalidArgumentException('Invalid Credentials');

        if (! $user->email_verified_at)
            throw new \InvalidArgumentException('The account is not active');

        if ($user->status === 'suspended')
            throw new \InvalidArgumentException('This account is suspended');

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function sendOtp(User $user): void
    {
        $code = (string)random_int(100000, 999999);

        EmailOtp::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new OtpMail($code));
    }

    public function verifyOtp(User $user, string $code): array
    {
        $otp = EmailOtp::where('user_id', $user->id)
            ->where('code', $code)
            ->latest()
            ->first();

        if (! $otp || $otp->isExpired())
            throw new \InvalidArgumentException('Code is invalid');

        $user->update([
            'email_verified_at' => now(),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
    public function resendOtp(User $user): void
    {
        if ($user->email_verified_at)
            throw new \InvalidArgumentException('Email is already verified');

        EmailOtp::where('user_id', $user->id)->delete();

        $this->sendOtp($user);
    }
}
