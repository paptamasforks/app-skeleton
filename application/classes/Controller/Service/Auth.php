<?php defined('SYSPATH') or die('No direct script access.');
/*
 * @package		App-skeleton
 * @author      Pap Tamas
 * @copyright   (c) 2011-2012 Pap Tamas
 * @website		https://github.com/paptamas/app-skeleton
 *
 */
class Controller_Service_Auth extends Controller_Service {

    /**
     * @var bool Check if user is authenticated
     */
    public $check_authenticated = false;

    /**
     * Signup a new user
     */
    public function action_signup()
    {
        // Get post data
        $post = $this->request->post('signup');

        $values = array(
            'full_name' => Arr::get($post, 'full_name'),
            'username' => Arr::get($post, 'username'),
            'email' => Arr::get($post, 'email'),
            'password' => Arr::get($post, 'password'),
            'password_confirm' => Arr::get($post, 'password')
        );

        $auth = Auth_Manager::instance();

        try
        {
            $user = $auth->signup($values);

            // Registration was successful, log in the user
            $identity = Identity::factory();
            if ($identity->authenticate_with_id($user->pk()))
            {
                User::instance()->login($identity);

                // Registration and login was successful
                $this->response->body(json_encode(array(
                    'next' => URL::map('auth.after_signup')
                )));
            }
        }
        catch (Auth_Validation_Exception $e)
        {
            // Invalid data
            $this->response->status(409);

            $this->response->body(json_encode(array(
                'code' => 1,
                'errors' => array(
                    'signup' => $e->getErrors()
                )
            )));
        }
        catch (Kohana_Exception $e)
        {
            // Some database error
            $this->response->status(409);

            $this->response->body(json_encode(array(
                'code' => 2,
                'message' => $e->getMessage()
            )));
        }
    }

    /**
     * Edit profile
     */
    public function action_edit()
    {
        // Get post data
        $post = $this->request->post('edit');

        $values = array(
            'full_name' => Arr::get($post, 'full_name'),
            'username' => Arr::get($post, 'username'),
            'email' => Arr::get($post, 'email'),
            'password' => Arr::get($post, 'password'),
            'password_confirm' => Arr::get($post, 'password_confirm')
        );

        $auth = Auth_Manager::instance();

        try
        {
            $auth->edit_user_data($values);

            // Profile update was successful
            $this->response->body(json_encode(array(
                'next' => URL::map('auth.after_edit')
            )));
        }
        catch (Auth_Validation_Exception $e)
        {
            // Invalid data
            $this->response->status(409);

            $this->response->body(json_encode(array(
                'code' => 1,
                'errors' => array(
                    'edit' => $e->getErrors()
                )
            )));
        }
        catch (Kohana_Exception $e)
        {
            // Some database error
            $this->response->status(409);

            $this->response->body(json_encode(array(
                'code' => 2,
                'message' => $e->getMessage()
            )));
        }
    }

    /**
	 * Log in the user or return error
     *
     * Because some browsers (ex. Chrome) does not ask the user to save or not password on login
     * if the form submission was prevented, or the form was submitted to an iframe, we want to
     * handle both ajax and non-ajax requests here.
     *
     * @return void
     */
    public function action_login()
    {
        // Get post data
        $post = $this->request->post('login');
        $username = Arr::get($post, 'username');
        $password = Arr::get($post, 'password');
        $remember_me = Arr::get($post, 'remember-me');

        $identity = Identity::factory($username, $password);
        if ($identity->authenticate()) {
            // Valid login
            User::instance()->login($identity,  ! empty($remember_me));
            $next = Arr::get($post, 'next', URL::map('auth.after_login'));

            // Login was successful
            if ($this->request->is_ajax())
            {
                // This is an ajax request
                $this->response->body(json_encode(array(
                    'next' => $next
                )));
            }
            else
            {
                // This is not an ajax request
                $this->request->redirect($next);
            }
        }
        else
        {
            // Invalid login
            $errors_array = array(
                'errors' => array(
                    'login' => array(
                        'username' => $identity->error_message()
                    )
                )
            );

            if ($this->request->is_ajax())
            {
                // This is an ajax request
                $this->response->status(409);

                $this->response->body(json_encode($errors_array));
            }
            else
            {
                // This not an ajax request
                $session = Session::instance();
                $session->set('auth.form.errors', $errors_array);
                $session->set('auth.form.data', Arr::get($this->request->post(), 'login'));

                // Go back to login page
                $this->request->redirect(URL::map('auth.login'));
            }
        }
    }

    /**
     * Recover password/return error
     *
     * @return void
     */
    public function action_recover()
    {
        // Get email from post data
        $post = $this->request->post('recover');
        $email = Arr::get($post, 'email');
        $auth = Auth_Manager::instance();

        // Try to recover password
        try
        {
            $auth->recover_password($email);

            // Recovery mail sent
            $this->response->body(json_encode(array(
                'next' => URL::map('auth.after_recover')
            )));
        }
        catch (Auth_Recovery_Email_Exception $e)
        {
            // Invalid email
            $this->response->status(409);

            $this->response->body(json_encode(array(
                'code' => 1,
                'errors' => array(
                    'recover' => array(
                        'email' => $e->getMessage()
                    )
                )
            )));
        }
        catch (Email_Exception $e)
        {
            // Problem with email sending
            $this->response->status(409);

            $this->response->body(json_encode(array(
                'code' => 2,
                'message' => 'There was a problem sending you recovery email. Please try again later.'
            )));
        }
    }

    /**
     * Reset password/return error
     *
     * @throws Kohana_Exception
     * @return void
     */
    public function action_reset()
    {
        // Get data from post
        $data = $this->request->post('reset');
        $secure_key = Arr::get($data, 'secure_key');
        $password = Arr::get($data, 'password');
        $password_confirm = Arr::get($data, 'password_confirm');

        $auth = Auth_Manager::instance();

        try
        {
            $auth->reset_password($secure_key, $password, $password_confirm);

            // Password was reset, user is logged in
            $this->response->body(json_encode(array(
                'next' => URL::map('auth.after_login')
            )));
        }
        catch(Auth_Validation_Exception $e)
        {
            // Problem with password validation
            $this->response->status(409);

            $this->response->body(json_encode(array(
                'code' => 2,
                'errors' => array(
                    'reset' => $e->getErrors()
                )
            )));
        }
        catch(Auth_Recovery_Link_Exception $e)
        {
            // Invalid secure key
            $this->response->status(409);

            $this->response->body(json_encode(array(
                'code' => 1,
                'message' => $e->getMessage()
            )));
        }
    }
}