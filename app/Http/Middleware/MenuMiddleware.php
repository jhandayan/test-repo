<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Menu;
use Auth;
class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {



        Menu::make('AdminMenu', function($menu) use ($request){
            if (Auth::check()) {
                $menu->add('Dashboard', ['route' => 'dashboard']);

                if (Auth::user()->can('view_clients')) {
                    $menu->add('Clients', ['route' => 'clients']);
                    if($request->segment(2) == 'clients'){
                        $menu->clients->attr(['class' => 'active']);
                    }
                }

                if (Auth::user()->can('view_users')) {
                    $menu->add('Users', ['route' => 'users']);
                    if($request->segment(2) == 'users'){
                        $menu->users->attr(['class' => 'active']);
                    }
                }

                if (Auth::user()->can('view_roles')) {
                    $menu->add('Roles', ['route' => 'role_list']);
                    if($request->segment(2) == 'roles'){
                        $menu->roles->attr(['class' => 'active']);
                    }
                }

                if (Auth::user()->can('view_permissions')) {
                    $menu->add('Permissions', ['route' => 'permission_list']);
                    if($request->segment(2) == 'permissions'){
                        $menu->permissions->attr(['class' => 'active']);
                    }
                }

                if(Auth::user()->can('view_logs')){
                    $menu->add('Logs', ['route' => 'logs']);
//                    if($request->segment(2) == 'logs'){
//                        $menu->permissions->attr(['class' => 'active']);
//                    }
                }

//                $menu->add('Logout', ['route' => 'logout']);
            }
        });

        Menu::make('TopMenu', function($menu) use ($request){
            if (Auth::check()) {
                $menu->add('Dashboard', ['route' => 'dashboard']);
                if (Auth::user()->can('view_clients')) {
                    $menu->add('Clients', ['route' => 'clients']);
                    if($request->segment(2) == 'clients'){
                        $menu->clients->attr(['class' => 'active']);
                    }

                }


                $menu->add('Settings', ['url' => 'javascript:;', 'class' => 'dropdown']);

//                $userName = Auth::user()->username;
//                ${$userName} = $menu->add( $userName, ['url' => 'javascript:;','class' => 'dropdown']);

                $menu->group(['prefix' => 'settings', 'data-role' => 'navigation'], function($a) use ($menu){
                    if (Auth::user()->can('view_users')) {
                        $menu->settings->add('Users', ['route' => 'users']);
                    }

                    if (Auth::user()->can('view_roles')) {
                        $menu->settings->add('Roles', ['route' => 'role_list']);
                    }
                    if (Auth::user()->can('view_permissions')) {
                        $menu->settings->add('Permissions', ['route' => 'permission_list']);
                    }
                    if(Auth::user()->can('view_logs')){
                        $menu->settings->add('Logs', ['route' => ['user_logs', Auth::user()->id]]);
                    }
                    $menu->settings->add('Profile', ['route' => 'user_show'])->divide( ['class' => 'divider', 'role' => 'presentation']);
                    $menu->settings->add('Logout', ['route' => 'logout']);
                });
            }
        });

        Menu::make('FrontMenu', function($menu) use ($request){
            if (Auth::check()) {
                $menu->add('Logout', ['route' => 'logout']);
            }else{
                $menu->add('Login', ['route' => 'login']);
                $menu->add('Register', ['route' => 'signup']);
            }
        });

        return $next($request);
    }
}
