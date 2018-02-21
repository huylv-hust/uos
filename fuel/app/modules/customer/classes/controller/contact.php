<?php
namespace Customer;

use Email\Email;
use Fuel\Core\Config;
use Fuel\Core\Controller_Template;
use Fuel\Core\Input;
use Fuel\Core\Lang;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;
use Fuel\Core\Log;

/**
 * author thuanth6589
 * Class Controller_Contact
 * @package Customer
 */
class Controller_Contact extends Controller_Template
{
    public $template = 'customer';
    private $session;
    private $subject = [
        'user' => '【しごさが】お問い合わせを承りました',
        'admin' => '【しごさが】お問い合わせがありました'
    ];

    public function __construct()
    {
        Config::set('language', 'jp');
        Lang::load('label');
        $this->session = Session::forge(array('driver' => 'file', 'file' => array(
            'cookie_name' => 'fuelfid',
            'path' => APPPATH . 'tmp',
            'gc_probability' => 5
        )));
    }

    private function validate()
    {
        $validate = \Fuel\Core\Validation::forge('customer');
        $validate->add_callable('myrules');
        $validate->add_field('company_name', Lang::get('contact_company_name'), 'required|max_length[50]');
        $validate->add_field('company_kana', Lang::get('contact_company_kana'), 'required|kana|max_length[50]');
        $validate->add_field('zipcode1', Lang::get('zipcode1'), 'required|valid_string[numeric]|exact_length[3]');
        $validate->add_field('zipcode2', Lang::get('zipcode2'), 'required|valid_string[numeric]|exact_length[4]');
        $validate->add_field('prefecture_id', Lang::get('prefecture_id'), 'required');
        $validate->add_field('city', Lang::get('city'), 'required|max_length[10]');
        $validate->add_field('town', Lang::get('town'), 'required|max_length[50]');
        $validate->add_field('tel1', Lang::get('contact_tel'), 'required|valid_string[numeric]|max_length[5]');
        $validate->add_field('tel2', Lang::get('contact_tel'), 'required|valid_string[numeric]|max_length[4]');
        $validate->add_field('tel3', Lang::get('contact_tel'), 'required|valid_string[numeric]|max_length[4]');
        $validate->add_field('staff_name', Lang::get('contact_staff_name'), 'required|max_length[50]');
        $validate->add_field('staff_kana', Lang::get('contact_staff_kana'), 'required|kana|max_length[50]');
        $validate->add_field('email', Lang::get('contact_email'), 'required|valid_email|max_length[767]');
        $validate->add_field('comment', Lang::get('contact_comment'), 'required');

        return !$validate->run() ? $validate->error_message() : true;
    }

    /**
     * action contact
     */
    public function action_index()
    {
        if (Input::method() == 'POST') {
            $_POST['company_kana'] = mb_convert_kana($_POST['company_kana'], 'HVc', 'UTF-8');
            $_POST['staff_kana'] = mb_convert_kana($_POST['staff_kana'], 'HVc', 'UTF-8');
            $_POST['zipcode1'] = mb_convert_kana($_POST['zipcode1'], 'n', 'UTF-8');
            $_POST['zipcode2'] = mb_convert_kana($_POST['zipcode2'], 'n', 'UTF-8');
            $_POST['tel1'] = mb_convert_kana($_POST['tel1'], 'n', 'UTF-8');
            $_POST['tel2'] = mb_convert_kana($_POST['tel2'], 'n', 'UTF-8');
            $_POST['tel3'] = mb_convert_kana($_POST['tel3'], 'n', 'UTF-8');
            $validate = $this->validate();
            if ($validate === true) {
                if (!Input::post('hidden')) {
                    $this->session->set('customer_contact', Input::post());
                    return Response::redirect(Uri::base() . 'customer/contact/confirm');
                }
            }
        }
        $this->template->title = 'お問い合わせ | しごさが';
        $this->template->content = View::forge('contact/index', compact('validate'));
    }

    /**
     * contact confirm
     * send mail
     */
    public function action_confirm()
    {
        if (!$data = $this->session->get('customer_contact')) {
            return Response::redirect(Uri::base() . 'customer/contact');
        }
        if (Input::method() == 'POST') {
            $mail_from = \Fuel\Core\Config::get('mail_from') . ',' . \Fuel\Core\Config::get('mail_from_name');
            $now = date('Y-m-d H:i:s');

            //create data mail queue for user
            $data_user['send_time'] = $now;
            $data_user['mail_to'] = $data['email'];
            $data_user['mail_from'] = $mail_from;
            $data_user['subject'] = $this->subject['user'];
            $data_user['body'] = View::forge('email/contact_customer', [
                'baseUrl' => Uri::base(),
                'company_name' => $data['company_name'],
                'staff_name' => $data['staff_name'],
            ]);
            $data_user['created_at'] = $now;
            $data_user['updated_at'] = $now;

            //create data mail queue for admin

            $data_admin['created_at'] = $now;
            $data_admin['updated_at'] = $now;
            $data_admin['mail_from'] = $mail_from;
            $data_admin['subject'] = $this->subject['admin'];
            $data_admin['mail_to'] = Config::get('mail_admin');
            $data_admin['body'] = $this->get_mail_body_admin($data);
            //save to mail_queue table
            $data_admin['send_time'] = $now;
            $queue_obj = new \Model_Mailqueue();
            // No save data mail admin
            if ($queue_obj->save_data_after_confirm_person($data_user, array())) {
                $this->send_mail($data_admin);
                return Response::redirect(\Uri::base() . 'customer/contact/complete');
            }
        }
        $this->template->title = 'お問い合わせ | しごさが';
        $this->template->content = View::forge('contact/confirm', compact('data'));
    }

    /**
     * action complete
     */
    public function action_complete()
    {
        if (!$this->session->get('customer_contact')) {
            return Response::redirect(Uri::base() . 'customer/contact');
        }
        $this->session->delete('customer_contact');
        $this->template->title = 'お問い合わせ | しごさが';
        $this->template->content = View::forge('contact/complete');
    }

    /**
     * get mail body for user for admin
     * @param $data
     * @return string
     */
    private function get_mail_body_admin($data)
    {
        return 'お問い合わせ日時： ' . date('Y-m-d H:i:s') . '
御社名： ' . $data['company_name'] . '
御社名かな： ' . $data['company_kana'] . '
郵便番号： ' . $data['zipcode1'] . $data['zipcode2'] . '
都道府県： ' . \Constants::$addr1[$data['prefecture_id']] . '
市区町村： ' . $data['city'] . '
以降の住所： ' . $data['town'] . '
お電話番号： ' . $data['tel1'] . '-' . $data['tel2'] . '-' . $data['tel3'] . '
ご担当者様氏名： ' . $data['staff_name'] . '
ご担当者様氏名かな： ' . $data['staff_kana'] . '
ご担当者様メールアドレス： ' . $data['email'] . '
お問い合わせ内容：
' . $data['comment'];
    }

    /**
     * Send mail for admin
     * @param $value
     * @return array
     * @throws \FuelException
     */
    private function send_mail($value)
    {
        $mail_sent = [];
        if (trim($value['mail_to'], ',')) {
            $email = Email::forge();
            $from = explode(',', $value['mail_from']);
            $email->from($from[0], $from[1]);
            $mail_to = array_filter(explode(',', $value['mail_to']));
            $email->to($mail_to);
            $email->subject($value['subject']);
            $email->body($value['body']);
            try {
                $email->send();
                $mail_sent[] = true;
                \Config::set('log_threshold', \Fuel::L_INFO);
                Log::info('Mail sent success: ' . json_encode(['mail_to' => $mail_to, 'subject' => $value['subject']]));
            } catch (\EmailValidationFailedException $e) {
                Log::error('Mail validation: ' . json_encode(['mail_to' => $mail_to, 'subject' => $value['subject']]));
            } catch (\EmailSendingFailedException $e) {
                Log::error('Mail send failed: ' . json_encode(['mail_to' => $mail_to, 'subject' => $value['subject']]));
            }
        }

        return $mail_sent;
    }
}
