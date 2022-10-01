<?php

namespace App\Http\Controllers\Auth;

use App\Events\ForgetPassword;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ForgetController extends Controller
{
    /**
     * Render the forget view
     *
     * @return \Inertia\Response
     */
    public function forget()
    {
        return Inertia::render('Auth/Forget', [
            'hasSent' => session()->get('hasSent', false)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendRecoveryLink(Request $request)
    {
        $validated = $this->validate($request, ['email' => ['required', 'email']]);

        $user = User::where("email", $validated["email"])->first();
        if (!$user) {
            session()->flash("flash_alert", [
                "variant" => "danger",
                "message" => "Endereço de e-mail não cadastrado."
            ]);
            return redirect()->route("auth.register");
        }

        $passReset = new PasswordReset();
        $passReset->token = \Illuminate\Support\Str::random(25);
        $passReset->email = $user->email;
        $passReset->save();

        event(new ForgetPassword($user, $passReset));

        return redirect()->back()->with('hasSent', true);
    }
}
