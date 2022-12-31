<?php

namespace App\Providers;

use App\Models\Admin\Role;
use App\Models\Media\Image;
use App\Models\Media\Video;
use App\Models\Page;
use App\Models\User;
use App\Policies\Admin\RolePolicy;
use App\Policies\Media\ImagePolicy;
use App\Policies\Media\VideoPolicy;
use App\Policies\PagePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Role::class => RolePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update_settings', function (User $user) {
            return $user->is_superadmin;
        });
    }
}
