<?php
namespace Form;

use Fuel\Core\Config;
use Fuel\Core\Session;
use Fuel\Core\Response;

/**
 * @author NamNT
 * Class Controller_Persons
 * @package Persons
 */
class Controller_Form extends \Controller_Uos
{
    /**
     * @author NamNT
     * action index
     */
    public function action_index()
    {

        $data = array();
        $model = new \Model_Person();
        $model_job = new \Model_Job();
        $sssale_id = null;
        $data['person_info'] = null;
        $job_id = \Input::post('job_id');
        if (\Input::post('job_id')) {
            $job_id = \Input::post('job_id');
            \Fuel\Core\Session::set('job_id', $job_id);
        } else {
            $job_id = \Fuel\Core\Session::get('job_id');
        }

        if ($job_id == null) {
            Response::redirect('search');
        }

        if ($job_id == null) {
            Response::redirect('search');
        }

        $data['job'] = $model_job->find_by_pk($job_id);
        if ($data['job'] == null || $model_job->count_data(array('job_id' => $job_id)) == 0) {
            Session::set_flash('error', '応募可能期間が終了しています');
        }

        $name = \Input::post('name', null);
        if (\Input::method() == 'POST' && isset($name)) {
            $_POST['name_kana'] = mb_convert_kana(\Input::post('name_kana'), 'HVc');
            $datas = array();
            $dataPost = \Input::post();
            $datas = $model->get_person_data($dataPost);
            $datas['created_at'] = date('Y-m-d H:i:s');
            $datas['application_date'] = date('Y-m-d H:i:s');
            $datas['business_user_id'] = $model->get_default_business_user_id($job_id);
            $datas['interview_user_id'] = $datas['business_user_id'];
            $datas['agreement_user_id'] = $datas['business_user_id'];
            $datas['job_id'] = $job_id;
            $datas['sssale_id'] = $data['job']->sssale_id;
            $datas['ss_id'] = $data['job']->ss_id;
            $datas['workplace_sssale_id'] = $datas['sssale_id'];
            foreach (\Input::post() as $key => $value) {
                if (\Input::post($key) == '') {
                    $datas[$key] = null;
                }
            }

            if (!$model->validate()) {
                $error = $model->get_list_error();
                $data['error'] = $error;
            } else {
                \Fuel\Core\Session::set('notes', $datas['notes']);
                unset($datas['notes']);
                \Fuel\Core\Session::set('person_data', json_encode($datas));

                if (!\Input::post('flg'))
                    Response::redirect('form/confirm');
            }
        }

        $this->template->title = 'UOS求人システム';
        $this->template->content = \View::forge('form/person', $data);

    }

    public function action_confirm()
    {
        if (!\Fuel\Core\Session::get('person_data')) {
            Response::redirect('form');
        }
        $model = new \Model_Person();
        $model_job = new \Model_Job();
        $sssale_id = null;

        $data = json_decode(\Fuel\Core\Session::get('person_data'), true);
        $data['notes'] = \Fuel\Core\Session::get('notes');
        $pesron_data = $model->get_mail_data($data['job_id']);

        $data['post_company_name'] = $pesron_data['post_company_name'];
        $data['job_category'] = $pesron_data['job_category'];

        if (\Input::method() == 'POST' && \Uri::segment(2) == 'confirm') {
            $model_user = new \Model_Muser();
            $email = array(
                0 => $data['mail_addr1'],
                1 => $data['mail_addr2'],
            );
            if (!$model->validate()) {
                $error = $model->get_list_error();
                $data['error'] = $error;
            } elseif ($pesron_data == null || $model_job->count_data(array('job_id' => $data['job_id'])) == 0) {
                Session::set_flash('error', '応募可能期間が終了しています');
            } else {
                $data['status'] = \Constants::$_status_person['approval'];
                $data['is_read'] = 0;
                $data['post_id'] = Config::get('site_post_id');
                $model->set($data);
                if ($model->save()) {
                    $last_id = $model->person_id;

                    //send mail
                    $model_user = new \Model_Muser();
                    $list_emails = $model_user->get_list_user_email();
                    $department_id = ($pesron_data['department_id']) ? $pesron_data['department_id'] : 0;
                    $list_email_department = $model_user->get_list_mail_department($department_id);
                    $datamail_user = array(
                        'phone_number' => isset($pesron_data['phone_number1']) ? $pesron_data['phone_number1'] : '',
                        'email' => $email,
                    );

                    $datamail_department = array(
                        'application_date' => date('Y-m-d H:i', strtotime($data['application_date'])),
                        'name' => $data['name'],
                        'name_kana' => $data['name_kana'],
                        'age' => \Utility::calculate_age($data['birthday']),
                        'gender' => $data['gender'] == 1 ? '女性' : '男性',
                        'media_name' => 'しごさが',
                        'addr1' => \Constants::$addr1[$data['addr1']],
                        'addr2' => $data['addr2'],
                        'addr3' => $data['addr3'],
                        'tel' => $data['tel'],
                        'mobile' => $data['mobile'],
                        'mail_addr1' => $data['mail_addr1'],
                        'mail_addr2' => $data['mail_addr2'],
                        'occupation_now' => \Constants::$occupation_now[$data['occupation_now']],
                        'notes' => $data['notes'],
                        'm_group' => isset($pesron_data['m_group_name']) ? $pesron_data['m_group_name'] : '',
                        'branch_name' => isset($pesron_data['branch_name']) ? $pesron_data['branch_name'] : '',
                        'ss_name' => isset($pesron_data['ss_name']) ? $pesron_data['ss_name'] : '',
                        'sale_type' => isset($pesron_data['sale_type']) ? \Constants::$sale_type[$pesron_data['sale_type']] : '',
                        'sale_name' => isset($pesron_data['sale_name']) ? $pesron_data['sale_name'] : '',
                        'list_emails' => $list_emails,
                        'last_id' => $last_id,
                        'bo_url' => \Fuel\Core\Config::get('bo_url')
                    );

                    /* ticket 1082 (save mail content to db) (thuanth6589) */
                    $str_time = time();
                    $now = date('Y-m-d H:i:s', $str_time);
                    $mail_from = \Fuel\Core\Config::get('mail_from') . ',' . \Fuel\Core\Config::get('mail_from_name');
                    //mail to user
                    $data_user['send_time'] = $now;
                    $data_user['mail_to'] = implode(',', $email);
                    $data_user['mail_from'] = $mail_from;
                    $data_user['subject'] = \Constants::$subject_mail_to_user_form;
                    $data_user['body'] = $this->get_mail_body_user($datamail_user['phone_number']);
                    $data_user['created_at'] = $now;
                    $data_user['updated_at'] = $now;
                    // mail to department
                    $mailto = [];
                    foreach ($datamail_department['list_emails'] as $email) {
                        if ($email['mail']) {
                            $mailto[] = $email['mail'];
                        }
                    }
                    //ticket 1177 (get user from mail group) (thuanth6589)
                    $ss = \Model_Mss::find_by_pk($data['ss_id']);
                    $sssale = \Model_Sssale::find_by_pk($data['sssale_id']);
                    $partner_sale = ',' . $ss->partner_code . '-' . $sssale->sale_type . ',';
                    $mailgroup_obj = new \Model_Mailgroup();
                    $mail_group = $mailgroup_obj->get_data(['partner_sales' => $partner_sale]);
                    $users = [];
                    foreach ($mail_group as $k => $v) {
                        if ($v['users']) {
                            $users = array_merge($users, explode(',', trim($v['users'], ',')));
                        }
                    }
                    $m_user = new \Model_Muser();
                    $mails = $m_user->get_list_mail_by_user($users);
                    foreach ($mails as $k => $v) {
                        if ($v['mail']) {
                            $mailto[] = $v['mail'];
                        }
                    }

                    $mailto = array_unique($mailto);

                    $holidays = array_keys(\Utility::get_holidays());
                    $data_department['created_at'] = $now;
                    $data_department['updated_at'] = $now;
                    $data_department['mail_from'] = $mail_from;
                    $data_department['subject'] = '【' . $datamail_department['sale_type'] . '】新着応募/' . $datamail_department['m_group'] . $datamail_department['branch_name'] . $datamail_department['ss_name'];
                    $data_department['mail_to'] = implode(',', $mailto);
                    $data_department['body'] = render('email/person_admin.php', $datamail_department);
                    $day = date('N', time());
                    // monday - friday, 08:30 - 18:00
                    if ($day > 0 && $day < 6 && !in_array(date('Ymd', $str_time), $holidays) &&
                        strtotime(date('Y-m-d 08:30:00', $str_time)) < $str_time &&
                        $str_time < strtotime(date('Y-m-d 18:00:59', $str_time))
                    ) {
                        $data_department['send_time'] = $now;
                    }
                    // monday - friday 00:00 - 08:29
                    if (
                        $day > 0 && $day < 6 &&
                        in_array(date('Ymd', $str_time), $holidays) == false &&
                        date('Hi', $str_time) < '0830'
                    ) {
                        $data_department['send_time'] = date('Y-m-d 08:30:00', $str_time);
                    }
                    // monday - friday, 18:01 - 23:59 or is holiday or saturday, sunday
                    if (
                        ($day > 0 && $day < 6 && date('Hi', $str_time) > '1800') ||
                        $day == 6 || $day == 7 || in_array(date('Ymd', $str_time), $holidays)
                    ) {
                        $data_department['send_time'] = date('Y-m-d 08:30:00', \Utility::get_date_out_of_holiday($str_time, $holidays));
                    }

                    $queue_obj = new \Model_Mailqueue();
                    if ($queue_obj->save_data_after_confirm_person($data_user, $data_department)) {
                        Response::redirect('form/thanks');
                    } else {
                        Session::set_flash('error', \Constants::$message_create_error);
                    }
                } else {
                    Session::set_flash('error', \Constants::$message_create_error);
                }
            }
        }

        $this->template->title = 'UOS求人システム';
        $this->template->content = \View::forge('form/confirm', $data);
    }

    /**
     * get mail body for mail to user
     * @param $phone_number
     * @return string
     */
    private function get_mail_body_user($phone_number)
    {
        $tmp = $phone_number ? '応募情報を確認次第、「080」「090」の携帯電話もしくは「' . $phone_number . '」で始まる番号からご連絡をさせて頂きます。' : '応募情報を確認次第、「080」「090」の携帯電話からご連絡をさせて頂きます。';
        return 'しごさがをご利用いただきありがとうございます。

運営会社の株式会社ユーオーエス（宇佐美グループ）と申します。
この度は、ご応募頂きまして、誠にありがとうございます。' .

        $tmp .
        'お手数ですが、着信拒否設定を解除して頂きますようお願い申し上げます。

※2～3日たっても弊社から電話連絡がない場合、手違い等も考えられますのでお手数ですが、一度下記までご連絡下さい。

株式会社ユーオーエス/受付係 [代表電話]
(月～土9：00～18：00受付　※ただし土曜は17：00まで）
※お問い合わせにつきましては下記ＵＲＬからも受け付けております。
https://oshigoto-n.jp/contact/

※このメールは送信専用メールアドレスからお送りしています。
 ご返信いただいてもお答えすることができませんのでご了承ください。

※応募書類は返却致しません。ご了承下さい。
━━━━━━━━━━━━━━━━━━━━━━━
しごさが　http://oshigoto-n.jp/

運営会社：株式会社ユーオーエス

愛知県名古屋市中村区名駅南1-15-21
宇佐美名古屋ビル５階
━━━━━━━━━━━━━━━━━━━━━━━';
    }

    public function action_thanks()
    {
        Session::delete('person_data');
        Session::delete('notes');
        Session::delete('job_id');
        $this->template->title = 'UOS求人システム';
        $this->template->content = \View::forge('form/thanks');
    }
}
