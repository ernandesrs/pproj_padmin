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
    public function homePage(User $author, Image $cover, $s1, $s2, $s3)
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
            "cover" => $cover->id ?? null,
            "follow" => false,
            "status" => Page::STATUS_PUBLISHED,
            "content_type" => Page::CONTENT_TYPE_VIEW,
            "protection" => Page::PROTECTION_SYSTEM,
            "sections" => [
                [
                    "id" => $s1->id,
                ],
                [
                    "id" => $s2->id,
                ],
                [
                    "id" => $s3->id
                ]
            ],
            "sections_settings" => [
                [
                    "id" => $s1->id,
                    "alignment" => "left",
                    "order" => 1
                ],
                [
                    "id" => $s2->id,
                    "alignment" => "right",
                    "order" => 2
                ],
                [
                    "id" => $s3->id,
                    "alignment" => "left",
                    "order" => 3
                ]
            ],
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
            "cover" =>  $cover->id ?? null,
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
            "cover" =>  $cover->id ?? null,
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
