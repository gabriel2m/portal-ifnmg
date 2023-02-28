<?php

namespace App\Http\Middleware;

use App\Enums\NivelUser;
use Closure;
use Illuminate\Http\Request;

abstract class AbstractNivel
{
    /** @var NivelUser[] */
    protected $niveis;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        foreach ($this->niveis as $nivel) {
            if (auth()->user()->nivel == $nivel) {
                return $next($request);
            }
        }
        abort(403);
    }
}
