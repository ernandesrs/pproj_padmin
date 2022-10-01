<?php

namespace App\Http\Controllers\Auth;

use App\Events\ForgetPassword;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        return Inertia::render('Auth/Password/Forget', [
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

    /**
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function reset(string $token)
    {
        $tokenDecoded = explode("|", base64_decode($token));
        $email = $tokenDecoded[0] ?? null;
        $_token = $tokenDecoded[1] ?? null;

        $reset = PasswordReset::where("email", $email)->where("token", $_token)->first();
        if (!$reset) {
            session()->flash("flash_alert", [
                "variant" => "warning",
                "message" => "Link de recuperação inválido, solicite um novo link.",
            ]);
            return redirect()->route("auth.forget");
        }

        return Inertia::render("Auth/Password/Reset", [
            "email" => $email,
            "token" => $_token
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            "token" => ["required", "string"],
            "email" => ["required", "email"],
            "password" => ["required", "string", "confirmed"]
        ]);

        $reset = PasswordReset::where("email", $validated["email"])->where("token", $validated["token"])->first();
        if (!$reset) {
            session()->flash("flash_alert", [
                "variant" => "danger",
                "message" => "Link de recuperação de senha inválido, solicite um novo link."
            ]);
            return redirect()->route("auth.forget");
        }

        $user = User::where("email", $reset->email)->firstOrFail();
        $user->password = Hash::make($validated["password"]);
        $user->save();

        PasswordReset::where("email", $validated["email"])->delete();

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => "Sua senha foi atualizada com sucesso!"
        ]);
        return redirect()->route("auth.login");
    }
}
