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
            
            // Redirect away from these routes to user dashboard
            if (in_array($currentRoute, ['login', 'register', 'home'])) {
                return redirect()->route('user.dashboard');
            }
            
            // If user tries to access admin dashboard but isn't an admin, redirect to user dashboard
            if ($currentRoute === 'dashboard' && !$this->isAdmin($request->user())) {
                return redirect()->route('user.dashboard');
            }
        }

        return $response;
    }

    
         private function isAdmin($user): bool
          {
               return $user->isAdmin();
      }
}