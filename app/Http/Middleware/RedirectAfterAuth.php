<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectAfterAuth
{
    /**
     * Handle an incoming request.
     */
     public function handle(Request $request, Closure $next): Response
{
    $response = $next($request);

    // Check if user is authenticated and visiting certain pages
    if (Auth::check()) {
        $currentRoute = $request->route()->getName();
        $user = $request->user();
        
        // Redirect away from auth pages when already logged in
        if (in_array($currentRoute, ['login', 'register'])) {
            if ($this->isAdmin($user)) {
                return redirect()->route('dashboard'); // Admin to admin dashboard
            } else {
                return redirect()->route('user.dashboard'); // User to user dashboard
            }
        }
        
        // If user tries to access admin dashboard but isn't an admin, redirect to user dashboard
        if ($currentRoute === 'dashboard' && !$this->isAdmin($user)) {
            return redirect()->route('user.dashboard');
        }
        
        // If admin tries to access user dashboard, redirect to admin dashboard
        if ($currentRoute === 'user.dashboard' && $this->isAdmin($user)) {
            return redirect()->route('dashboard');
        }
    }

    return $response;
}

    
         private function isAdmin($user): bool
          {
               return $user->isAdmin();
      }
}