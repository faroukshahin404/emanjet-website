<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Removes a supported locale segment from the beginning of the path so routes
 * stay locale-free (e.g. /ar/admin/login → /admin/login). Runs globally before
 * routing. API and other paths are skipped.
 */
class StripWebLocaleFromRequest
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldBypass($request)) {
            return $next($request);
        }

        $supported = array_keys(config('laravellocalization.supportedLocales', []));
        $path = trim($request->path(), '/');
        if ($path === '') {
            return $next($request);
        }

        $segments = explode('/', $path);
        $first = $segments[0] ?? '';

        if ($first === '' || ! in_array($first, $supported, true)) {
            return $next($request);
        }

        $rest = array_slice($segments, 1);
        $newPath = $rest === [] ? '/' : '/'.implode('/', $rest);
        $query = $request->getQueryString();
        $newRequestUri = $newPath.($query !== null && $query !== '' ? '?'.$query : '');

        $server = $request->server->all();
        $server['REQUEST_URI'] = $newRequestUri;

        $symfony = $request->duplicate(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $server
        );

        $symfony->attributes->set('locale_from_legacy_url', $first);

        return $next($symfony);
    }

    protected function shouldBypass(Request $request): bool
    {
        $path = trim($request->path(), '/');

        if ($path === '' || str_starts_with($path, 'api/') || $path === 'api') {
            return true;
        }

        foreach (config('laravellocalization.urlsIgnored', []) as $except) {
            $pattern = $except === '/' ? '/' : trim($except, '/');
            if ($pattern !== '' && $request->is($pattern)) {
                return true;
            }
        }

        return false;
    }
}
