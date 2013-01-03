<?php defined('SYSPATH') or die('No direct script access.');
/*
 * @package		App-skeleton
 * @author      Pap Tamas
 * @copyright   (c) 2011-2012 Pap Tamas
 * @website		https://github.com/paptamas/app-skeleton
 *
 */
class Controller_Auth extends Controller_Template_Main {

    /**
     * @var  View  page template
     */
    public $template = 'templates/auth';

    /**
     * @var bool Check if user is authenticated
     */
    public $check_authenticated = false;

    /**
     * Display sign up form
     */
    public function action_signup()
    {
        // Redirect the user if already signed in
        if (User::instance()->logged_in())
        {
            $this->request->redirect(URL::map('auth.after_login'));
        }

        // Display login page
        $this->template
            ->set('title', __('Sign up'))
            ->set('content', View::factory('Auth/Signup'));
    }

    /**
     * Display edit profile form
     */
    public function action_edit()
    {
        $user = User::instance();
        // User must be logged in
        if ( ! $user->logged_in())
        {
            $next = URL::map('auth.login').'?next='.URL::map('auth.edit');
            $this->request->redirect($next);
        }

        $fields = array('full_name', 'username', 'email');
        $user_data = Auth_Manager::instance()->get_user_data($user->id(), $fields);

        // Display login page
        $this->template
            ->set('title', __('Edit your profile'))
            ->set('content', View::factory('Auth/Edit')->set('user_data', $user_data));
    }

    /**
	 * Display login form/log in the user
     */
    public function action_login()
    {
        // If user is already logged in, redirect him to base url
        if (User::instance()->logged_in())
        {
            $this->request->redirect(URL::map('auth.after_login'));
        }

        // Try to login with cookie
        $this->cookie_login();

        // Display login page
        $this->template
            ->set('title', __('Log in'))
            ->set('content', View::factory('Auth/Login'));
    }

    /**
     * Try to log in with cookie
     *
     * @return void
     */
    public function cookie_login()
    {
        $identity = Identity::factory();

        if ($identity->authenticate_with_cookie())
        {
            User::instance()->login($identity);

            // Redirect user to home
            $this->request->redirect(URL::map('auth.after_login'));
        }
    }

    /**
	 * Log out the user
     */
    public function action_logout()
    {
        $user = User::instance();
        if ($user->logged_in())
        {
            if ($user->authenticated_with() == 'facebook')
            {
                Facebook_OAuth::instance()->logout();
            }
            elseif ($user->authenticated_with() == 'google')
            {
                Google_OAuth::instance()->logout();
            }

            $user->log_out();
        }

        // Redirect to login page
        $this->request->redirect(URL::map('auth.after_logout'));
    }

    /**
	 * Display recovery form/recover password
     *
     * @return void
     */
    public function action_recover()
    {
        // Display the password recovery form
        $this->template
            ->set('title', __('Recover your password'))
            ->set('content', View::factory('Auth/Recover'));
    }

    /**
	 * Display reset form/reset password
     *
     * @return void
     */
    public function action_reset()
    {
        // Get recovery url
        $secure_key = $this->request->param('id');

        $auth = Auth_Manager::instance();

        // Check if secure key is valid
        try
        {
            $email = $auth->get_recovery_email($secure_key);

            // Display the password recovery form
            $this->template
                ->set('title', __('Reset your password'))
                ->set('content', View::factory('Auth/Reset'));
        }
        catch (Auth_Recovery_Link_Exception $e)
        {
            // Invalid or expired secure key
            $this->request->redirect(URL::map('auth.reset_expired'));
        }
    }

    /**
     * Display message to user
     *
     * @throws HTTP_Exception_404
     * @return void
     */
    public function action_message()
    {
        $valid = array('expired_link', 'recovered');
        $view_id = $this->request->param('id');

        if ( ! in_array($view_id, $valid))
        {
            throw new HTTP_Exception_404();
        }

        $this->template
            ->set('title', __('Message'))
            ->set('content', View::factory('Auth/Message/'.ucfirst($view_id)));
    }

    /**
     * Redirect to login page
     *
     * @return void
     */
    public function action_index()
    {
        $this->request->redirect(URL::map('auth.login'));
    }
}