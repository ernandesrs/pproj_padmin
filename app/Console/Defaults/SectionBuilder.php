<?php

namespace App\Console\Defaults;

use App\Http\Services\SectionService;
use App\Models\Section\Section;
use App\Models\User;

class SectionBuilder
{
    /**
     * Undocumented function
     *
     * @return Section
     */
    public function sectionBannerImages(User $author)
    {
        $name = "Default Banner";
        if (Section::where("name", $name)->count()) {
            echo "{$name} exists\n";
            return;
        }

        $image1 = (new ImageBuilder())->save($author, resource_path("img/examples/padmin_preview_1_right.png"), "sections");
        $image2 = (new ImageBuilder())->save($author, resource_path("img/examples/padmin_preview_2_right.png"), "sections");

        $section = (new SectionService())->store([
            "name" => $name,
            "title" => "Bem vindo ao live-preview do PADMIN",
            "visible" => true,
            "type" => Section::TYPE_BANNER_IMAGES,
            "content" => [
                "description" => "PADMIN é um painel administrativo criado com o objetivo de colocar em teste meus conhecimentos em Vue JS com Inertia JS no frontend e Laravel no backend.",
                "images" => [
                    [
                        "id" => $image1->id,
                        "interval" => 3.5
                    ],
                    [
                        "id" => $image2->id,
                        "interval" => 3.5
                    ],
                ]
            ],
            "buttons" => [
                [
                    "text" => "Acessar painel",
                    "title" => "Acessar o painel administrativo",
                    "target" => "_self",
                    "url" => route("admin.index"),
                    "style" => "primary",
                    "icon" => [
                        "source" => "local",
                        "class" => null,
                        "name" => "pieChart",
                        "position" => "start"
                    ],
                ],
                [
                    "text" => "Conhecer mais",
                    "title" => "Conhecer mais",
                    "target" => "_self",
                    "url" => "#sobre",
                    "style" => "outline-primary",
                    "icon" => [
                        "source" => "local",
                        "class" => null,
                        "name" => "arrowDown",
                        "position" => "end"
                    ],
                ]
            ]
        ]);
        return $section;
    }

    /**
     * Undocumented function
     *
     * @param User $author
     * @return Section
     */
    public function sectionDefaultImages(User $author)
    {
        $name = "Sobre";
        if (Section::where("name", $name)->count()) {
            echo "{$name} exists\n";
            return;
        }

        $image1 = (new ImageBuilder())->save($author, resource_path("img/examples/padmin_preview_1_left.png"), "sections");
        $image2 = (new ImageBuilder())->save($author, resource_path("img/examples/padmin_preview_2_left.png"), "sections");

        $section = (new SectionService())->store([
            "name" => $name,
            "title" => "Oque é o PADMIN?",
            "subtitle" => "PADMIN é um painel administrativo!",
            "visible" => true,
            "type" => Section::TYPE_DEFAULT_IMAGES,
            "content" => [
                "content" => "<p>Ele foi criado para colocar em teste meus conhecimentos adquiridos em Laravel e Vue JS com Inertia JS. Ele possui toda a parte de autenticação criada do zero, além do gerenciamento de usuários, regras, mídias; e o gerenciamento de um site.</p><h4>Este site é gerenciado por um painel PADMIN!</h4>",
                "images" => [
                    [
                        "id" => $image1->id,
                        "interval" => 3.5
                    ],
                    [
                        "id" => $image2->id,
                        "interval" => 2.5
                    ],
                ]
            ],
            "buttons" => [
                [
                    "text" => "Previsualização",
                    "title" => "Previsualizar o painel",
                    "target" => "_self",
                    "url" => route("admin.index"),
                    "style" => "primary",
                    "icon" => [
                        "source" => "local",
                        "class" => null,
                        "name" => "pieChart",
                        "position" => "start"
                    ],
                ],
                [
                    "text" => "Código fonte",
                    "title" => "Código fonte no Github",
                    "target" => "_blank",
                    "url" => "https://github.com/ernandesrs/pproj_padmin",
                    "style" => "outline-primary",
                    "icon" => [
                        "source" => "local",
                        "class" => null,
                        "name" => "arrowRight",
                        "position" => "end"
                    ],
                ]
            ]
        ]);
        return $section;
    }
}
