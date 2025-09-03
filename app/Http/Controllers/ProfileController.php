<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Session;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class ProfileController extends Controller
{
    /**
     * Show the user's profile form.
     */
    public function show(Request $request)
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->forceFill(['email_verified_at' => null])->save();
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.show')->with('success', 'Password updated successfully!');
    }

    /**
     * Enable two factor authentication for the user.
     */
    public function enableTwoFactorAuthentication(Request $request, EnableTwoFactorAuthentication $enable)
    {
        $user = $request->user();

        $enable($user);

        // Generate QR Code for setup
        $qrCode = $this->generateQrCode($user);

        return redirect()->route('profile.show')
            ->with('success', 'Two-factor authentication has been enabled.')
            ->with('two_factor_qr_code', $qrCode);
    }

    /**
     * Disable two factor authentication for the user.
     */
    public function disableTwoFactorAuthentication(Request $request, DisableTwoFactorAuthentication $disable)
    {
        $disable($request->user());

        return redirect()->route('profile.show')
            ->with('success', 'Two-factor authentication has been disabled.');
    }

    /**
     * Generate QR code for two-factor authentication.
     */
    protected function generateQrCode($user)
    {
        $qrCodeUri = $this->twoFactorQrCodeUrl($user);
        
        $qrCode = new QrCode($qrCodeUri);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return 'data:image/png;base64,' . base64_encode($result->getString());
    }

    /**
     * Get the two-factor authentication QR code URL.
     */
    protected function twoFactorQrCodeUrl($user)
    {
        return app(TwoFactorAuthenticationProvider::class)->qrCodeUrl(
            config('app.name'),
            $user->email,
            decrypt($user->two_factor_secret)
        );
    }

    /**
     * Destroy other browser sessions for the user.
     */
    public function destroySessions(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        if (config('session.driver') !== 'database') {
            return redirect()->route('profile.show')
                ->with('error', 'Session management requires database session driver.');
        }

        Auth::logoutOtherDevices($request->password);

        $this->deleteOtherSessionRecords($request);

        return redirect()->route('profile.show')
            ->with('success', 'Successfully logged out from other devices.');
    }

    /**
     * Delete other session records from storage.
     */
    protected function deleteOtherSessionRecords(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))
            ->table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }

    /**
     * Get browser sessions for the user.
     */
    public function getSessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))
                ->table(config('session.table', 'sessions'))
                ->where('user_id', $request->user()->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) use ($request) {
            return (object) [
                'agent' => [
                    'is_desktop' => $this->isDesktop($session->user_agent),
                    'platform' => $this->getPlatform($session->user_agent),
                    'browser' => $this->getBrowser($session->user_agent),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    /**
     * Simple user agent parsing methods to replace jenssegers/agent
     */
    protected function isDesktop($userAgent)
    {
        $mobileKeywords = ['Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone'];
        foreach ($mobileKeywords as $keyword) {
            if (strpos($userAgent, $keyword) !== false) {
                return false;
            }
        }
        return true;
    }

    protected function getPlatform($userAgent)
    {
        if (strpos($userAgent, 'Windows') !== false) return 'Windows';
        if (strpos($userAgent, 'Mac') !== false) return 'macOS';
        if (strpos($userAgent, 'Linux') !== false) return 'Linux';
        if (strpos($userAgent, 'Android') !== false) return 'Android';
        if (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) return 'iOS';
        return 'Unknown';
    }

    protected function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Safari') !== false && strpos($userAgent, 'Chrome') === false) return 'Safari';
        if (strpos($userAgent, 'Edge') !== false) return 'Edge';
        if (strpos($userAgent, 'Opera') !== false) return 'Opera';
        return 'Unknown';
    }
}