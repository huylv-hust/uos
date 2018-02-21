<?php
/**
 * Created by PhpStorm.
 * User: Huy
 * Date: 4/27/2017
 * Time: 9:21 AM
 */
namespace Customer;

use Composer\DependencyResolver\Transaction;
use Fuel\Core\Controller_Template;
use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;
use Model_Salecustomer;
use Utility;

class Controller_Reminder extends Controller_Template
{
    public $template = 'customer';

    /**
     * action Reminder Password
     */
    public function action_index()
    {
        Session::delete('reminder');

        //process input
        if (Input::method() == 'POST' && !Input::post('confirm')) {
            $url = Uri::base() . 'customer/reminder/confirm';
            $email = strtolower(Input::post('email'));
            $obj = new Model_Salecustomer();

            //check validation email
            $validate = $obj->validation_reminder();
            if ($validate === true) {
                $customer = $obj::find_one_by(DB::expr("LOWER (email)"), $email);
                if ($customer && $customer->status == 2) {
                    Session::set('reminder', $email);
                    Response::redirect($url);
                }
                Session::set_flash('error', 'メールアドレスをご確認ください');
            }
        }
        $this->template->title = 'パスワードを忘れた方 | しごさが';
        $this->template->content = View::forge('reminder/index', compact('validate'));
    }

    /**
     * action Confirm reminder password
     */
    public function action_confirm()
    {
        //check isset session
        if (!($email = Session::get('reminder'))) {
            Response::redirect(Uri::base() . 'customer/reminder');
        }
        //process input
        if (Input::method() == 'POST') {
            $customer = Model_Salecustomer::find_one_by(DB::expr("LOWER (email)"), $email);
            $password = $this->set_password();
            if ($customer->reminder_password($email, $password, $customer)) {
                Response::redirect(Uri::base() . 'customer/reminder/complete');
            }
            Session::set_flash('error', '失敗しました');
            Response::redirect(Uri::base() . 'customer/reminder');
        }
        $this->template->title = 'パスワードを忘れた方 | しごさが';
        $this->template->content = View::forge('reminder/confirm', compact('email'));
    }

    /**
     * action Completed reminder password
     */
    public function action_complete()
    {
        //check isset session
        if (!Session::get('reminder')) {
            Response::redirect(Uri::base() . 'customer/reminder');
        }
        Session::delete('reminder');
        $this->template->title = 'パスワードを忘れた方 | しごさが';
        $this->template->content = View::forge('reminder/complete');
    }

    /**
     * action general new password
     * @return string
     */
    public function set_password()
    {
        $count = rand(1, 11);
        $number = '23456789';
        $character = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $password = substr(str_shuffle($number), 0, $count) . substr(str_shuffle($character), 0, 12 - $count);
        return str_shuffle($password);
    }
}
