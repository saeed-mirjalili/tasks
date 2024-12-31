<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        Gate::define('admin-access', function ($user) {
            return $user->role === 'admin';
        });
        Gate::define('supervisor-access', function ($user, $task_id=null) {
            if(is_null($task_id)){
                if ($user->role === 'supervisor'){
                    return true;
                }else{
                    return false;
                }
            }else{
                $task = Task::findOrFail($task_id);
                if ($user->role === 'supervisor'){
                    return $task->users->contains($user);
                };
            }
            return false;
        });

        Gate::define('user-access', function ($user, $task_id) {
            $task = Task::find($task_id);
            if (!$task) {
                return false;
            }
            return $task->groups->contains(function ($group) use ($user) {
                return $group->users->contains($user);
            });
        });

    }
}
