<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
use Mediavenue\Mailers\UserMailer as Mailer;
use Mediavenue\Repository\UsersRepositoryInterface;
use Mediavenue\Validator\UsersValidator;

class RegistrationController extends BaseController {

    /**
     * @param Mailer                   $mailer
     * @param UsersValidator           $validator
     * @param UsersRepositoryInterface $user
     */
    public function __construct(Mailer $mailer, UsersValidator $validator, UsersRepositoryInterface $user)
    {
        $this->mailer = $mailer;
        $this->validator = $validator;
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return View::make('registration/index')
            ->with('title', 'Registration');
    }

    /**
     * @return mixed
     */
    public function postIndex()
    {
        if ( ! $this->validator->validRegistration(Input::all()))
        {
            return Redirect::to('registration')->withErrors($this->validator->errors());
        }

        if ( ! $this->user->create(Input::all()))
        {
            return Redirect::to('registration')->with('flashError', 'Please try again, enable to create user');
        }

        return Redirect::to('login')->with('flashSuccess', t('A confirmation email is sent to your mail'));
    }

    /**
     * @return mixed
     */
    public function getFacebook()
    {
        if ( ! Session::get('facebookDetails'))
        {
            return Redirect::to('login')->with('flashError', t('Please try again'));
        }

        return View::make('registration/facebook')
            ->with('title', 'Facebook Login');
    }

    /**
     * @return mixed
     */
    public function postFacebook()
    {
        $session = Session::get('facebookDetails');
        if ( ! $session)
        {
            return Redirect::to('login');
        }

        if ( ! $this->validator->validFacebookRegistration(Input::all()))
        {
            return Redirect::to('registration/facebook')->withErrors($this->validator->errors());
        }

        if ($this->user->createFacebookUser(Input::all(), $session))
        {
            return Redirect::route('home')->with('flashSuccess', t('Congratulations your account is created and activated'));
        }
    }

    /**
     * @return mixed
     */
    public function getGoogle()
    {
        if (Session::get('googleDetails'))
        {
            return View::make('registration/google')->with('title', t('Registration'));
        }

        return Redirect::to('login')->with('flashError', t('Please try again'));
    }

    /**
     * @return mixed
     */
    public function postGoogle()
    {
        $session = Session::get('googleDetails');
        if ( ! $session)
        {
            return Redirect::to('login')->with('flashError', t('Please try again'));
        }

        if ( ! $this->validator->validGoogleRegistration(Input::all()))
        {
            return Redirect::to('registration/google')->withErrors($this->validator->errors());
        }

        if ($this->user->createGoogleUser(Input::all(), $session))
        {
            return Redirect::route('home')->with('flashSuccess', t('Congratulations your account is created and activated'));
        }
    }

    /**
     * @param $username
     * @param $code
     * @return mixed
     */
    public function validateUser($username, $code)
    {
        if ( ! $user = $this->user->activate($username, $code))
        {
            return Redirect::to('login')->with('flashError', t('You are not registered with us'));
        }
        Auth::loginUsingId($user->id);

        return Redirect::route('home')->with('flashSuccess', t('Your account is now activated'));
    }
}