<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class PolicyController extends BaseController
{
    /**
     * Terms and services
     * @return mixed
     */
    public function getTos()
    {
        return View::make('policy/tos')
            ->with('title', 'Terms Of Services');
    }

    /**
     * Privacy Policies
     * @return mixed
     */
    public function getPrivacy()
    {
        return View::make('policy/privacy')
            ->with('title', t('Privacy Policy'));
    }

    /**
     * Faq of the site
     * @return mixed
     */
    public function getFaq()
    {
        return View::make('policy/faq')
            ->with('title', t('FAQ'));
    }

    /**
     * About us
     * @return mixed
     */
    public function getAbout()
    {
        return View::make('policy/about')
            ->with('title', t('About Us'));
    }
}