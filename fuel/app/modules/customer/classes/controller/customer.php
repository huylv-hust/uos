<?php
/**
 * Created by PhpStorm.
 * User: Huy
 * Date: 4/25/2017
 * Time: 3:11 PM
 */
namespace Customer;

use Fuel\Core\Controller_Template;
use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;
use Model_Salecustomer;

class Controller_Customer extends Controller_Template
{
    public $template = 'customer';

    /**
     * author HuyLV6635
     * action login
     */
    public function action_index()
    {
        $url = Uri::base() . 'customer/jobs';
        if (Session::get('uri_before_login')) {
            $url = Session::get('uri_before_login');
        }

        if (Session::get('login_info')) {
            Session::delete('uri_before_login');
            Response::redirect($url);
        }

        if (Input::method() == 'POST') {
            $email = strtolower(Input::post('email'));
            $password = hash('SHA256', Input::post('password'));

            $obj = new Model_Salecustomer();
            $validate = $obj->validation_login();
            if ($validate === true) {
                $customer = $obj::find_one_by(DB::expr("LOWER (email)"), $email);
                if (
                    $customer && $customer->password == $password &&
                    ($customer->status == 1 || $customer->status == 2)
                ) {
                    $login_info = array(
                        'customer_id' => $customer->customer_id,
                        'company_name' => $customer->company_name,
                        'email' => $customer->email,
                        'tel' => $customer->tel,
                        'staff_name' => $customer->staff_name,
                        'expired' => time() + 30 * 60,
                        'status' => $customer->status,
                    );
                    Session::set('login_info', $login_info);
                    Session::delete('uri_before_login');
                    Response::redirect($url);
                }
                Session::set_flash('error', 'メールアドレスまたはパスワードをご確認ください');
            }
        } else {
            if (Input::get('email')) {
                $_POST['email'] = Input::get('email');
            }
        }

        $this->template->title = 'ログイン | しごさが';
        $this->template->content = View::forge('index/index', compact('validate'));
    }

    public function action_logout()
    {
        $url = Uri::base() . 'customer/';
        Session::delete('login_info');
        Session::delete('uri_before_login');
        Response::redirect($url);
    }

    public function action_summary()
    {
        $this->template->title = 'サマリー | しごさが';
        $this->template->content = View::forge('comingsoon');
    }

    public function action_rules()
    {
        $this->template->title = '利用規約 | しごさが';
        $this->template->content = View::forge('comingsoon');
    }
}
