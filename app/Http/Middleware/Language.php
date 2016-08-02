<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class Language {
    protected $app;
    protected $redirector;
    protected $request;

    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Make sure current locale exists.
        $locale = $request->segment(1);

        if ( ! array_key_exists($locale, config('app.locales'))) {
            $segments = $request->segments();
            $segments[0] = config('app.fallback_locale');

            return $this->redirector->to(implode('/', $segments));
        }

        App::setLocale($locale);

        return $next($request);
    }
}
