<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            if (! $user) {
                $view->with('notif_data', []);
                return;
            }
            $notifications = $user->notifications()->latest()->take(20)->get();
            $notif_data = $notifications->map(function ($n) {
                $d = $n->data ?? [];
                return [
                    'id'     => $n->id,
                    'icon'   => $d['icon'] ?? 'bi-bell',
                    'cls'    => $d['cls'] ?? 'ni-gold',
                    'text'   => $d['message'] ?? ($d['text'] ?? ''),
                    'time'   => $d['time'] ?? ($n->created_at ? $n->created_at->diffForHumans() : ''),
                    'ts'     => $n->created_at ? $n->created_at->toIso8601String() : null,
                    'unread' => $n->read_at ? false : true,
                    'data'   => $d,
                ];
            })->toArray();
            $view->with('notif_data', $notif_data);
        });

        Blade::directive('role', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->roleName() === {$expression}): ?>";
        });

        Blade::directive('endrole', function () {
            return '<?php endif; ?>';
        });
    }
}
