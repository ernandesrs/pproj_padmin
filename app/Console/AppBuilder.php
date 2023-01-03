<?php

namespace App\Console;

use App\Models\Admin\Role;
use App\Models\Content;
use App\Models\Page;
use App\Models\Slug;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AppBuilder
{
    /**
     * The builder
     */
    public function build(string $mail, string $pass)
    {
        if (config("app.env") == "production") {
            return;
        }

        $visitor = $this->visitorRole();
        $this->administratorRole();

        $user = $this->userMaster($mail, $pass);
        $this->userVisitor($visitor);

        $this->homePage($user);
        $this->privacyTermsPage($user);
        $this->useTermsPage($user);
        $this->frontSettings();
    }

    /**
     * Start a default visitor role
     *
     * @return Role
     */
    private function visitorRole()
    {
        $rulables = array_fill_keys(Role::RULABLES, array_fill_keys(Role::RULES, false));
        foreach ($rulables as $rulableName => $rulableValue) {
            foreach ($rulableValue as $ruleKey => $ruleValue) {
                if (in_array($ruleKey, ["view", "viewAny"]))
                    $rulables[$rulableName][$ruleKey] = true;
            }
        }

        return (new Role())->create([
            "name" => "Visitor",
            "admin_access" => true,
            "rulables" => $rulables
        ]);
    }

    /**
     * Start a default administrator role
     *
     * @return Role
     */
    private function administratorRole()
    {
        $rulables = array_fill_keys(Role::RULABLES, array_fill_keys(Role::RULES, true));
        foreach ($rulables as $rulableName => $rulableValue) {
            if (in_array($rulableName, ["role"])) {
                foreach ($rulableValue as $ruleKey => $ruleValue) {
                    if (!in_array($ruleKey, ["view", "viewAny"]))
                        $rulables[$rulableName][$ruleKey] = false;
                }
            }
        }

        return (new Role())->create([
            "name" => "Administrator",
            "admin_access" => true,
            "rulables" => $rulables
        ]);
    }

    /**
     * Create the master user
     */
    private function userMaster(string $mail, string $pass)
    {
        if (User::where("email", $mail)->first()) {
            echo "master user exists\n";
            return;
        }

        $user = User::create([
            "first_name" => "Master",
            "last_name" => "Last Name",
            "username" => "Master",
            "email" => $mail,
            "password" => Hash::make($pass),
            "is_superadmin" => true,
            "email_verified_at" => now(),
        ]);

        if (!$user) {
            echo "fail on create the master user\n";
        } else {
            echo "the master user has been created\n";
        }

        return $user;
    }

    /**
     * Create the visitor user
     * 
     * @param Role $role
     */
    private function userVisitor(Role $role)
    {
        $mail = "guest@guest.mail";
        if (User::where("email", $mail)->first()) {
            echo "guest user exists\n";
            return;
        }

        $user = User::create([
            "first_name" => "Visitante",
            "last_name" => "Last Name",
            "username" => "Visitante",
            "email" => $mail,
            "password" => Hash::make("guestpassword"),
            "email_verified_at" => now(),
            "role_id" => $role->id,
        ]);

        if (!$user) {
            echo "fail on create the guest user\n";
        } else {
            echo "the guest user has been created\n";
        }

        return $user;
    }

    /**
     * Create the home page
     */
    private function homePage($author)
    {
        if (Slug::where(config("app.locale"), "inicio")->first()) {
            echo "home page exists\n";
            return;
        }

        $page = Page::create([
            "slug" => "inicio",
            "lang" => config("app.locale"),
            "title" => "Página inicial",
            "description" => "Uma descrição boa para a página inicial do seu site. Isso ajudará os mecanismos de busca como o Google, Bing, etc, a encontra-lo",
            "cover" => null,
            "follow" => false,
            "status" => Page::STATUS_PUBLISHED,
            "content_type" => Page::CONTENT_TYPE_VIEW,
            "view_path" => "Front/Index",
            "protection" => Page::PROTECTION_SYSTEM,
        ], $author);

        if (!$page) {
            echo "fail on home page create\n";
        } else {
            echo "success on home page create\n";
        }
    }

    /**
     * Create the privacy terms page
     */
    private function privacyTermsPage($author)
    {
        if (Slug::where(config("app.locale"), "termos-de-privacidade")->first()) {
            echo "privacy terms page exists\n";
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
            "content" => "Os termos de privacidade do seu site.",
            "protection" => Page::PROTECTION_SYSTEM,
        ], $author);

        if (!$page) {
            echo "fail on privacy terms page create\n";
        } else {
            echo "success on privacy terms page create\n";
        }
    }

    /**
     *  Create the use terms page
     */
    private function useTermsPage($author)
    {
        if (Slug::where(config("app.locale"), "termos-de-uso")->first()) {
            echo "use terms page exists\n";
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
            "content" => "Os termos de uso do seu website.",
            "protection" => Page::PROTECTION_SYSTEM,
        ], $author);

        if (!$page) {
            echo "fail on use terms page create\n";
        } else {
            echo "success on use terms page create\n";
        }
    }

    /**
     * @return void
     */
    private function frontSettings()
    {
        $contentName = "front_settings";
        if (Content::where("name", $contentName)->first()) {
            echo "front settings exists\n";
            return;
        }

        $content = [
            "locale" => config("app.locale"),
            "header" => [
                "favicon" => null,
                "logo" => null,
                "menu_main" => null,
            ],
            "home" => [
                "section_1" => null,
                "section_2" => null,
                "section_3" => null,
            ],
            "footer" => [
                "menu_footer" => null,
            ],
        ];

        $settings = Content::create([
            "name" => $contentName,
            "is_json" => true,
            "content" => json_encode($content),
        ]);

        if (!$settings) {
            echo "default front settings create fail\n";
        } else {
            echo "default front settings created\n";
        }

        return $settings;
    }
}