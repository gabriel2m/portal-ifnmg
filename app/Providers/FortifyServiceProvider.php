<?php

namespace App\Providers;

use App\Actions\Fortify\AttemptToAuthenticate;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Responses\Fortify\PasswordUpdateResponse;
use App\Http\Responses\Fortify\SuccessfulPasswordResetLinkRequestResponse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse as SuccessfulPasswordResetLinkRequestResponseContract;
use Laravel\Fortify\Actions\AttemptToAuthenticate as FortifyAttemptToAuthenticate;
use Laravel\Fortify\Contracts\PasswordUpdateResponse as PasswordUpdateResponseContract;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyAuthenticatedSessionController;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            SuccessfulPasswordResetLinkRequestResponseContract::class,
            SuccessfulPasswordResetLinkRequestResponse::class
        );
        $this->app->singleton(
            PasswordUpdateResponseContract::class,
            PasswordUpdateResponse::class
        );
        $this->app->bind(
            FortifyAttemptToAuthenticate::class,
            AttemptToAuthenticate::class
        );
        $this->app->bind(
            FortifyAuthenticatedSessionController::class,
            AuthenticatedSessionController::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::viewPrefix('auth.');
        Route::group([
            'middleware' => [
                ...config('fortify.middleware', ['web']),
                'auth:' . config('fortify.guard'),
            ]
        ], function () {
            Route::view('user/password', 'auth.user-password-update');
            Route::view('user/profile-information', 'auth.user-profile-information-update')
                ->middleware('password.confirm');
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
