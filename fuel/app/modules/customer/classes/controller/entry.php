<?php
/**
 * Created by PhpStorm.
 * User: Huy
 * Date: 4/28/2017
 * Time: 9:00 PM
 */
namespace Customer;

use Fuel\Core\Controller_Template;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;
use Utility;
use Model_Salecustomer;

class Controller_Entry extends Controller_Template
{
    public $template = 'customer';

    public function action_index()
    {
        if (Input::method() == 'GET' && Input::get('error') == '1') {
            $_POST = Session::get('entry');
        } else {
            Session::delete('entry');
        }

        // Process input
        if (Input::method() == 'POST' && !Input::post('confirm')) {
            $url = Uri::base() . 'customer/entry/confirm';
            $obj = new Model_Salecustomer();

            // Validation data
            $_POST['company_kana'] = mb_convert_kana($_POST['company_kana'], 'HVc', 'UTF-8');
            $_POST['president_kana'] = mb_convert_kana($_POST['president_kana'], 'HVc', 'UTF-8');
            $_POST['staff_kana'] = mb_convert_kana($_POST['staff_kana'], 'HVc', 'UTF-8');
            $validate = $obj->validation_entry();
            if ($validate === true) {
                Session::set('entry', Input::post());
                Response::redirect($url);
            }
        }

        $this->template->title = '申込みフォーム | しごさが';
        $this->template->content = View::forge('entry/index', compact('validate'));
    }

    public function action_confirm()
    {
        //check isset session
        if (!($data = Session::get('entry'))) {
            Response::redirect(Uri::base() . 'customer/entry');
        }

        //process input
        if (Input::method() == 'POST') {
            $obj = new Model_Salecustomer();
            $obj->set_data(Session::get('entry'));
            if (!$obj->save_data()) {
                Session::set_flash('error', '失敗しました');
                Response::redirect(Uri::base() . 'customer/entry?error=1');
            }

            $subject = '【しごさが】本登録用URLのお知らせ';
            $encrypted = Utility::encrypt([
                'time' => time(),
                'id' => $obj->fields['customer_id']
            ]);
            $data = [
                'email' => $obj->fields['email'],
                'company_name' => $obj->fields['company_name'],
                'staff_name' => $obj->fields['staff_name'],
                'contactUrl' => Uri::base() . 'contact/index',
                'emailUrl' => Uri::base() . 'customer/entry/email?key=' . $encrypted
            ];
            $template = 'email/entry_complete';
            Utility::sendmail($obj->fields['email'], $subject, $data, $template);
            Response::redirect(Uri::base() . 'customer/entry/complete');
        }

        $this->template->title = '申込みフォーム | しごさが';
        $this->template->content = View::forge('entry/confirm', compact('data'));
    }

    public function action_complete()
    {
        if (!Session::get('entry')) {
            Response::redirect(Uri::base() . 'customer/entry');
        }
        $session = Session::get('entry');
        Session::delete('entry');
        $this->template->title = '申込みフォーム | しごさが';
        $this->template->content = View::forge('entry/complete', ['email' => $session['email']]);
    }

    public function get_email()
    {
        $decoded = Utility::decrypt(Input::get('key'));

        $data = ['error' => null];

        do {
            if ($decoded == null) {
                $data['error'] = 'ご指定のURLが正しくありません';
                break;
            }

            $customer = Model_Salecustomer::find_by_pk($decoded['id']);

            if (isset($customer->status) == false) {
                $data['error'] = 'ご指定のURLは有効期限切れか処理済みです';
                break;
            }

            if ($customer->status != 0) {
                $data['error'] = 'ご指定のURLは処理済みです';
                break;
            }

            $customer->is_new(false);
            $customer->status = 1;
            $customer->updated_at = date('Y-m-d H:i:s');
            $customer->save();

            Response::redirect(Uri::base() . 'customer/entry/emailcomplete');

        } while (false);

        $this->template->title = 'メールアドレス確認 | しごさが';
        $this->template->content = View::forge('entry/email', $data);
    }

    public function get_emailcomplete()
    {
        $this->template->title = 'メールアドレス確認完了 | しごさが';
        $this->template->content = View::forge('entry/email', ['error' => null]);
    }
}
