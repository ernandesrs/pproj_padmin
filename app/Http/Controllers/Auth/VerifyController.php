<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerifyController extends Controller
{
    /**
     * Render the verify notification view
     * 
     * @return \Inertia\Response
     */
    public function notify()
    {
        return Inertia::render("Auth/Verification/Notify", [
            "hasSent" => session()->get("hasSent", false)
        ]);
    }

    /**
     * Verification link resend
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verificationResend()
    {
        $user = auth()->user();
        if ($user->email_verified_at) {
            session()->flash("flash_alert", [
                "variant" => "info",
                "messaeg" =>  $user->first_name . ", sua conta já está verificada!"
            ]);

            return Inertia::location(route("front.index"));
        }

        event(new UserRegistered($user));

        return back()->with("hasSent", true);
    }

    /**
     * Render the verification view
     *
     * @return void
     */
    public function verify(string $token)
    {
        return Inertia::render("Auth/Verification/Verify", [
            "token" => $token,
            "hasError" => session()->get("hasError", false),
            "hasVerified" => session()->get("hasVerified", false),
            "hasSent" => session()->get("hasSent", false),
        ]);
    }

    /**
     * Register verify
     * 
     * @param string $token
     * @return void
     */
    public function verifyRegister(Request $request)
    {
        $validated = $request->validate(["token" => ["required", "string"]]);

        $token = (explode("|", base64_decode($validated["token"])))[0] ?? null;

        $user = User::where("confirmation_token", $token)->first();
        if (!$user)
            return back()->with("hasError", true);

        $user->confirmation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return back()->with("hasVerified", true);
    }
}
