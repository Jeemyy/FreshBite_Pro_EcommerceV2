<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        /** @var \App\Models\Admin|null */
        $admin = Auth::guard('admin')->user();

        if (! $admin) {
            return redirect()->route('admin.login');
        }

        if ($admin->isSuperAdmin()) {
            return $next($request);
        }

        if (! $admin->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
