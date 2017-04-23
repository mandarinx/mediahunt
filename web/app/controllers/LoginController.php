<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class LoginController extends BaseController {

    public function index()
    {
        return View::make('login/index');
    }

    public function postLogin()
    {
        // Check if input type is email or not
        if (filter_var(Input::get('username'), FILTER_VALIDATE_EMAIL))
        {
            $input = [
                'email'    => Input::get('username'),
                'password' => Input::get('password')
            ];

            $v = [
                'email'    => ['required'],
                'password' => ['required']
            ];
        }
        else
        {
            $input = [
                'username' => Input::get('username'),
                'password' => Input::get('password')
            ];

            $v = [
                'username' => ['required'],
                'password' => ['required']
            ];
        }
        $v = Validator::make($input, $v);
        if ($v->fails())
        {
            return Redirect::route('login')->withErrors($v);
        }
        $remember = Input::get('remember-me');
        if ( ! empty($remember))
        {
            if (Auth::attempt($input, true))
            {
                if (Auth::user()->confirmed != 1)
                {
                    Auth::logout();

                    return Redirect::route('login')->with('flashError', t('Email activation is required'));
                }
                $user = Auth::user();
                $user->ip_address = Request::getClientIp();
                $user->save();

                return Redirect::route('trending')->with('flashSuccess', t('You are now logged in'));
            }
        }
        if (Auth::attempt($input))
        {
            $user = Auth::user();
            if (Auth::user()->confirmed != 1)
            {
                Auth::logout();

                return Redirect::route('login')->with('flashError', t('Email activation is required'));
            }
            $user->ip_address = Request::getClientIp();
            $user->save();

            return Redirect::route('trending')->with('flashSuccess', t('You are now logged in'));
        }

        return Redirect::route('login')->with('flashError', t('Your username/password combination was incorrect'));
    }


    public function destroy()
    {
        Auth::logout();

        return Redirect::route('home')->with('flashSuccess', t("Logout successfully"));
    }


    /**
     * Login by facebook, check if only email address in database
     * then save users facebook is to database for future user.
     * If both not exits starts session and redirect to registration page
     *
     * @return mixed
     */
    public function loginWithFacebook()
    {
        $code = Input::get('code');
        $fb = OAuth::consumer('Facebook');
        if ( ! empty($code))
        {
            $token = $fb->requestAccessToken($code);
            $facebook = json_decode($fb->request('/me'), true);
            if (isset($facebook['id']) && isset($facebook['email']))
            {
                $user = User::where('fbid', '=', $facebook['id'])->first();
                if ($user)
                {
                    if ($user['fbid'] == $facebook['id'])
                    {
                        Auth::loginUsingId($user->id);
                        $user = Auth::user();
                        $user->ip_address = Request::getClientIp();
                        $user->save();

                        return Redirect::route('home')->with('flashSuccess', t('You are now logged in'));
                    }
                }

                $user = User::where('email', '=', $facebook['email'])->first();
                if ($user)
                {
                    if ($user->email == $facebook['email'])
                    {
                        Auth::loginUsingId($user->id);
                        $user->fbid = $facebook['id'];
                        $user->ip_address = Request::getClientIp();
                        $user->save();

                        return Redirect::route('home')->with('flashSuccess', t('You are now logged in'));
                    }
                }
            }
            else
            {
                return Redirect::to('login')->with('flashError', t('Please try again'));
            }
            Session::put('facebookDetails', $facebook);

            return Redirect::to('registration/facebook');

        }
        else
        {
            $url = $fb->getAuthorizationUri();

            return Redirect::to((string) $url);
        }

    }


    public function loginWithGoogle()
    {
        $code = Input::get('code');
        $googleService = OAuth::consumer('Google');
        if ( ! empty($code))
        {
            $token = $googleService->requestAccessToken($code);
            $google = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);
            if (isset($google['id']) && isset($google['email']))
            {
                $user = User::where('gid', '=', $google['id'])->first();
                if ($user)
                {
                    if ($user['gid'] == $google['id'])
                    {
                        Auth::loginUsingId($user->id);
                        $user = Auth::user();
                        $user->ip_address = Request::getClientIp();
                        $user->save();

                        return Redirect::route('home')->with('flashSuccess', t('You are now logged in'));
                    }
                }
                $user = User::where('email', '=', $google['email'])->first();
                if ($user)
                {
                    if ($user->email == $google['email'])
                    {
                        Auth::loginUsingId($user->id);
                        $user->gid = $google['id'];
                        $user->ip_address = Request::getClientIp();
                        $user->save();

                        return Redirect::route('home')->with('flashSuccess', t('You are now logged in'));
                    }
                }
            }
            else
            {
                return Redirect::to('login')->with('flashError', t('Please try again'));
            }
            Session::put('googleDetails', $google);

            return Redirect::to('registration/google');
        }
        else
        {
            $url = $googleService->getAuthorizationUri();

            return Redirect::to((string) $url);
        }
    }
}