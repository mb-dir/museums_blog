<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('allow-post-operations', function (User $user, Post $post) {
            return $user->role === "admin" || ($user->id === $post->user_id && $user->status === "active");
        });

        Gate::define('is-admin', function (User $user) {
            return $user->role === "admin";
        });

        Gate::define('is-active', function (User $user) {
            return $user->status === "active";
        });
        Gate::define('allow-update-user', function ($loggedInUser, User $targetUser) {
            return $loggedInUser->id === $targetUser->id || $loggedInUser->role === 'admin';
        });
        Gate::define('allow-show-user', function ($loggedInUser, User $targetUser) {
            return $loggedInUser->id === $targetUser->id;
        });
    }
}
