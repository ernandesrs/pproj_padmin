<?php

use App\Models\Page;
use App\Models\User;

return [
    'user' => [
        'level' => [
            'level_' . User::LEVEL_1 => 'Usuário',
            'level_' . User::LEVEL_2 => 'Membro',
            'level_' . User::LEVEL_8 => 'Administrador',
            'level_' . User::LEVEL_MASTER => 'Master',
        ],
        'gender' => [
            'gender_' . User::GENDER_NONE => 'Indefinido',
            'gender_' . User::GENDER_MALE => 'Masculino',
            'gender_' . User::GENDER_FEMALE => 'Feminino',
        ]
    ],
    'page' => [
        'status' => [
            'status_' . Page::STATUS_DRAFT => 'Rascunho',
            'status_' . Page::STATUS_SCHEDULED => 'Agendado',
            'status_' . Page::STATUS_PUBLISHED => 'Publicado',
        ],
        'type' => [
            Page::CONTENT_TYPE_TEXT => 'Texto',
            Page::CONTENT_TYPE_VIEW => 'Customizado',
        ]
    ]
];
