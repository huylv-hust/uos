<?php
namespace Customer;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;
use Model_Salecustomer;
use Orm\Model;

class Controller_Email extends \Controller_CustomerBase
{
    public $template = 'customer';

    public function before()
    {
        parent::before();
        $this->template->title = 'メールアドレス変更 | しごさが';
    }

    public function action_index()
    {
        $login_info = Session::get('login_info');
        $customer = Model_Salecustomer::find_by_pk($login_info['customer_id']);
        $data = ['current_email' => $customer->email];
        $this->template->content = View::forge('email/index', $data);
    }

    public function action_confirm()
    {
        $login_info = Session::get('login_info');
        $customer = Model_Salecustomer::find_by_pk($login_info['customer_id']);
        $data = Input::post();
        $data['current_email'] = $customer->email;

        if (Input::method() == 'POST') {
            $_POST['email'] = strtolower(Input::post('email'));
            $data['validate'] = $customer->validation_email();
            if ($data['validate'] !== true) {
                $this->template->content = View::forge('email/index', $data);
                return;
            }
        }

        $this->template->content = View::forge('email/confirm', $data);
    }

    public function action_complete()
    {
        if (Input::method() == 'POST') {
            $login_info = Session::get('login_info');
            $customer = Model_Salecustomer::find_by_pk($login_info['customer_id']);
            $saveData = [
                'id' => $login_info['customer_id'],
                'email' => Input::post('email'),
                'time' => time()
            ];
            $saveKey = hash('md5', uniqid('emailupdate', true));
            \Model_Cache::saveJson($saveKey, $saveData, time() + 86400);

            $data = [
                'company_name' => $customer->company_name,
                'staff_name' => $customer->staff_name,
                'baseUrl' => Uri::base(),
                'contactUrl' => Uri::base() . 'contact/index',
                'emailUrl' => Uri::base() . 'customer/emailupdate?key=' . $saveKey
            ];

            \Utility::sendmail(
                Input::post('email'),
                '【しごさが】メールアドレス変更確認',
                $data,
                'email/email_change'
            );

            Response::redirect(Uri::base() . 'customer/email/complete');
        }

        $this->template->content = View::forge('email/complete');
    }
}
