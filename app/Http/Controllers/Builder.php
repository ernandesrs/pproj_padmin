<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Page;
use App\Models\Slug;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Builder extends Controller
{
    /**
     * The builder
     */
    public function build()
    {
        if (config("app.env") == "production") return;

        $user = $this->userMaster();
        $this->homePage($user);
        $this->privacyTermsPage($user);
        $this->useTermsPage($user);
        $this->frontSettings();
    }

    /**
     * Create the master user
     */
    private function userMaster()
    {
        $mail = env("MAIL_ADMIN_ADDRESS", "master@master.com");
        if (User::where("email", $mail)->first()) {
            echo "master user exists<br>";
            return;
        }

        $user = User::create([
            "first_name" => "Master",
            "last_name" => "Last Name",
            "username" => "Master",
            "email" => $mail,
            "password" => Hash::make("password"),
            "level" => User::LEVEL_MASTER,
            "email_verified_at" => now()
        ]);

        if (!$user) echo "fail on create the master user<br>";
        else echo "the master user has been created<br>";

        return $user;
    }

    /**
     * Create the home page
     */
    private function homePage($author)
    {
        if (Slug::where(config("app.locale"), "inicio")->first()) {
            echo "home page exists<br>";
            return;
        }

        $page = Page::create([
            "slug" => "inicio",
            "lang" => config("app.locale"),
            "title" => "Página inicial",
            "description" => "Descrição para a página inicial",
            "cover" => null,
            "follow" => true,
            "status" => Page::STATUS_PUBLISHED,
            "content_type" => Page::CONTENT_TYPE_VIEW,
            "view_path" => "Front/Index",
            "protection" => Page::PROTECTION_SYSTEM,
        ], $author);

        if (!$page) echo "fail on home page create<br>";
        else echo "success on home page create<br>";
    }

    /**
     * Create the privacy terms page
     */
    private function privacyTermsPage($author)
    {
        if (Slug::where(config("app.locale"), "termos-de-privacidade")->first()) {
            echo "privacy terms page exists<br>";
            return;
        }

        $page = Page::create([
            "slug" => "termos-de-privacidade",
            "lang" => config("app.locale"),
            "title" => "Termos de privacidade",
            "description" => "Descrição para a termos de privacidade",
            "cover" => null,
            "follow" => false,
            "status" => Page::STATUS_PUBLISHED,
            "content_type" => Page::CONTENT_TYPE_TEXT,
            "content" => "Your website terms.",
            "protection" => Page::PROTECTION_SYSTEM
        ], $author);

        if (!$page) echo "fail on privacy terms page create<br>";
        else echo "success on privacy terms page create<br>";
    }

    /**
     *  Create the use terms page
     */
    private function useTermsPage($author)
    {
        if (Slug::where(config("app.locale"), "termos-de-uso")->first()) {
            echo "use terms page exists<br>";
            return;
        }

        $page = Page::create([
            "slug" => "termos-de-uso",
            "lang" => config("app.locale"),
            "title" => "Termos de uso",
            "description" => "Descrição para a termos de uso",
            "cover" => null,
            "follow" => false,
            "status" => Page::STATUS_PUBLISHED,
            "content_type" => Page::CONTENT_TYPE_TEXT,
            "content" => "Your website terms.",
            "protection" => Page::PROTECTION_SYSTEM,
        ], $author);

        if (!$page) echo "fail on use terms page create<br>";
        else echo "success on use terms page create<br>";
    }

    /**
     * @return void
     */
    private function frontSettings()
    {
        if (Content::where("name", "front_settings")->first()) {
            echo "front settings exists<br>";
            return;
        }

        $content = [
            "name" => config("app.name"),
            "title" => "Your website title",
            "description" => "Your website description for the search mechanisms(Google, Bing, etc)",
            "follow" => false,
            "favicon" => null,
            "logo" => null,
            "locale" => config("app.locale")
        ];

        $settings = Content::create([
            "name" => "front_settings",
            "content" => json_encode($content)
        ]);

        if (!$settings) echo "default front settings create fail<br>";
        else echo "default front settings created<br>";

        return $settings;
    }
}
