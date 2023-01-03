<?php

namespace App\Console\Defaults;

use App\Models\Media\Image;
use App\Models\Page;
use App\Models\Slug;
use App\Models\User;

class PageBuilder
{
    /**
     * Create the home page
     */
    public function homePage(User $author, Image $cover)
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
            "cover" => $cover->path ?? null,
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
    public function privacyTermsPage(User $author, Image $cover)
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
            "cover" =>  $cover->path ?? null,
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
    public function useTermsPage(User $author, Image $cover)
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
            "cover" =>  $cover->path ?? null,
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
}
