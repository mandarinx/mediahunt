<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function ($request)
{
    //
});


App::after(function ($request, $response)
{
    //
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function ()
{
    if (Auth::guest()) return Redirect::guest('login')->with('flashError', t('You need to login first'));
});


Route::filter('auth.basic', function ()
{
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function ()
{
    if (Auth::check()) return Redirect::to('/');
});

Route::filter('admin', function () {
    if (Auth::guest()) return Redirect::route('home');
    if (Auth::user()->permission != 'admin') return Redirect::route('home');
});

Route::filter('ban', function ()
{
    if (Auth::check()) if (Auth::user()->permission == 'ban') return Redirect::route('home')->with('flashError', 'You are not allowed');
});

Route::filter('ajaxban', function ()
{
    if (Auth::check() == true)
        if (Auth::user()->permission == 'ban')
            return t('You are not allowed');
});

Route::filter('ajax', function ()
{
    if ( ! Auth::check()) return t('Login');

    if ( ! Request::ajax()) return t('You are not allowed');
});
/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function ()
{
    if (Session::token() != Input::get('_token'))
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});


/*
|--------------------------------------------------------------------------
| Events
|--------------------------------------------------------------------------
|
| Register events that are to be handel separately.
|
*/
Event::listen('posts.views', 'Mediavenue\Events\NewsViewHandler');

/*
|--------------------------------------------------------------------------
| Composer
|--------------------------------------------------------------------------
|
| Register composer to handel separately.
|
*/
View::composer(Paginator::getViewName(), function ($view)
{
    $query = array_except(Input::query(), Paginator::getPageName());
    $view->paginator->appends($query);
});
