<?php

/**
 * Register controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 30/10/2015
 */
class Controller_Register extends Controller_Uos
{
    public function action_index()
    {
        $this->template->title = '無料コンシェルジュ 登録フォーム | しごさが';

        $this->template->content = self::view('register/index');
    }

    public function action_confirm()
    {
        $this->template->title = '無料コンシェルジュ 登録フォーム | しごさが';

        if (\Input::method() == 'POST') {
            $_POST['name_kana'] = mb_convert_kana(Input::post('name_kana'), 'HVc');

            $data['info'] = \Input::post();

            $model = new \Model_Register();
            if (!$model->validate()) {
                //get errors pass to view
                $data['errors'] = $model->get_list_errors();
                $this->template->content = self::view('register/index', $data);
            } else {
                if ($data['info']['pass'] == 'true') {
                    $model = new Model_Register();
                    if ($last = $model->save_data($data['info'])) {
                        //send mail
                        $model_user = new \Model_Muser();
                        $list_emails = $model_user->get_list_user_email();
                        $datamail = array(
                            'register_id' => $last[0],
                            'email' => $data['info']['mail'],
                            'email2' => $data['info']['mail2'],
                            'list_emails' => $list_emails,
                            'bo_url' => \Fuel\Core\Config::get('bo_url')
                        );

                        /* ticket 1082 (save mail content to db) (thuanth6589) */
                        $str_time = time();
                        $now = date('Y-m-d H:i:s', $str_time);
                        $mail_from = \Fuel\Core\Config::get('mail_from') . ',' . \Fuel\Core\Config::get('mail_from_name');
                        //mail to user
                        $data_user['send_time'] = $now;
                        $data_user['mail_to'] = trim($datamail['email'] . ',' . $datamail['email2'], ',');
                        $data_user['mail_from'] = $mail_from;
                        $data_user['subject'] = \Constants::$subject_mail_to_user_register;
                        $data_user['body'] = $this->get_mail_body_user();
                        $data_user['created_at'] = $now;
                        $data_user['updated_at'] = $now;
                        // mail to admin
                        $mailto = [];
                        foreach ($datamail['list_emails'] as $email) {
                            if ($email['mail']) {
                                $mailto[] = $email['mail'];
                            }
                        }
                        $holidays = array_keys(\Utility::get_holidays());
                        $data_admin['created_at'] = $now;
                        $data_admin['updated_at'] = $now;
                        $data_admin['mail_from'] = $mail_from;
                        $data_admin['subject'] = \Constants::$subject_mail_to_admin_register;
                        $data_admin['mail_to'] = implode(',', $mailto);
                        $data_admin['body'] = $this->get_mail_body_admin($datamail);
                        $day = date('N', time());
                        // monday - friday, 08:30 - 18:00
                        if ($day > 0 && $day < 6 && !in_array(date('Ymd', $str_time), $holidays) &&
                            strtotime(date('Y-m-d 08:30:00', $str_time)) < $str_time &&
                            $str_time < strtotime(date('Y-m-d 18:00:59', $str_time))
                        ) {
                            $data_admin['send_time'] = $now;
                        }
                        // monday - friday 00:00 - 08:29
                        if (
                            $day > 0 && $day < 6 &&
                            in_array(date('Ymd', $str_time), $holidays) == false &&
                            date('Hi', $str_time) < '0830'
                        ) {
                            $data_admin['send_time'] = date('Y-m-d 08:30:00', $str_time);
                        }
                        // monday - friday, 18:01 - 23:59 or is holiday or saturday, sunday
                        if (
                            ($day > 0 && $day < 6 && date('Hi', $str_time) > '1800') ||
                            $day == 6 || $day == 7 || in_array(date('Ymd', $str_time), $holidays)
                        ) {
                            $data_admin['send_time'] = date('Y-m-d 08:30:00', \Utility::get_date_out_of_holiday($str_time, $holidays));
                        }

                        $queue_obj = new \Model_Mailqueue();
                        if ($queue_obj->save_data_after_confirm_person($data_user, $data_admin)) {
                            \Response::redirect(\Uri::base() . 'register/thanks');
                        }
                    }
                }
                $this->template->content = self::view('register/confirm', $data);
            }
        } else {
            \Response::redirect(\Uri::base() . 'register');
        }
    }

    public function action_thanks()
    {
        $this->template->title = '無料コンシェルジュ 登録フォーム | しごさが';

        $this->template->content = self::view('register/thanks');
    }

    /**
     * author thuanth6589
     * get mail body for mail to user
     * @return string
     */
    private function get_mail_body_user()
    {
        return 'しごさがをご利用いただきありがとうございます。
運営会社の株式会社ユーオーエス（宇佐美グループ）と申します。

しごさがコンシェルジュ登録が完了しました。
ご登録頂いた情報をもとに求人案件をご連絡差し上げます。

弊社求人案件担当からの連絡をお待ちください。

※このメールは送信専用メールアドレスからお送りしています。
　ご返信いただいてもお答えすることができませんのでご了承ください。

お問い合わせにつきましては下記ＵＲＬからお願いいたします。
https://oshigoto-n.jp/contact/

━━━━━━━━━━━━━━━━━━━━━━━
しごさが　http://oshigoto-n.jp/

運営会社：株式会社ユーオーエス

愛知県名古屋市中村区名駅南1-15-21
宇佐美名古屋ビル５階
━━━━━━━━━━━━━━━━━━━━━━━';
    }

    /**
     * author thuanth6589
     * get mail body for mail to admin
     * @param $data
     * @return string
     */
    private function get_mail_body_admin($data)
    {
        return '【しごさが】にコンシェルジュ登録がありました。

求人管理システムから登録内容をご確認下さい。' .
        $data['bo_url'] . 'support/concierge?register_id=' . $data['register_id'];
    }
}
