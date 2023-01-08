<?php

namespace App\Providers;

use App\Models\Admin\Role;
use App\Models\Front\Service;
use App\Models\Media\Image;
use App\Models\Media\Video;
use App\Models\Page;
use App\Models\Section\Section;
use App\Models\Setting;
use App\Models\User;

use App\Policies\Admin\RolePolicy;
use App\Policies\Front\ServicePolicy;
use App\Policies\Media\ImagePolicy;
use App\Policies\Media\VideoPolicy;
use App\Policies\PagePolicy;
use App\Policies\Section\SectionPolicy;
use App\Policies\SettingPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Image::class => ImagePolicy::class,
        Video::class => VideoPolicy::class,
        Page::class => PagePolicy::class,
        Role::class => RolePolicy::class,

        Service::class => ServicePolicy::class,
        Section::class => SectionPolicy::class,
        Setting::class => SettingPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
