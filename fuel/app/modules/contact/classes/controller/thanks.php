<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @paramr: File controller group
 **/
namespace Contact;

use Fuel\Core\Controller;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;

class Controller_Thanks extends \Controller_Uos
{
    /**
     * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
     * action top
     */
    public function action_index()
    {
        if ($data_contact = Input::post()) {
            $contact = new \Model_Contact();
            if ($contact->validate() and $save_contact = $contact->save_data($data_contact)) {
                $data = array(
                    'id_contact' => $save_contact->contact_id,
                    'email' => $save_contact->mail,
                    'bo_url' => \Fuel\Core\Config::get('bo_url')
                );
                $this->template->content = \View::forge('thanks/index');

                /* ticket 1082 (save mail content to db) (thuanth6589) */
                $str_time = time();
                $now = date('Y-m-d H:i:s', $str_time);
                $mail_from = \Fuel\Core\Config::get('mail_from') . ',' . \Fuel\Core\Config::get('mail_from_name');
                //mail to user
                $data_user['send_time'] = $now;
                $data_user['mail_to'] = $data['email'];
                $data_user['mail_from'] = $mail_from;
                $data_user['subject'] = \Constants::$subject_mail_to_user_contact;
                $data_user['body'] = $this->get_mail_body_user();
                $data_user['created_at'] = $now;
                $data_user['updated_at'] = $now;
                // mail to admin
                $user = new \Model_Muser();
                if ($emails = $user->get_list_user_email() and !empty($emails)) {
                    foreach ($emails as $email) {
                        $listmail[] = $email['mail'];
                    }
                }

                $holidays = array_keys(\Utility::get_holidays());
                $data_admin['created_at'] = $now;
                $data_admin['updated_at'] = $now;
                $data_admin['mail_from'] = $mail_from;
                $data_admin['subject'] = \Constants::$subject_mail_to_admin_contact;
                $data_admin['mail_to'] = isset($listmail) ? implode(',', $listmail) : '';
                $data_admin['body'] = $this->get_mail_body_admin($data);
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

                return;
            }
        }

        Response::redirect(Uri::base() . 'contact/index');
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
この度はしごさがにお問い合わせいただき、誠にありがとうございます。

お問い合わせ頂いた内容を確認し、担当よりご返答差し上げますので
連絡をお待ちください。

※このメールは送信専用メールアドレスからお送りしています。
　ご返信いただいてもお答えすることができませんのでご了承ください。

━━━━━━━━━━━━━━━━━━━━━━━
しごさが　 http://oshigoto-n.jp/

運営会社：株式会社ユーオーエス

愛知県名古屋市中村区名駅南1-15-21
宇佐美名古屋ビル５階
━━━━━━━━━━━━━━━━━━━━━━━';
    }

    /**
     * get mail body for mail to admin
     * @param $data
     * @return string
     */
    private function get_mail_body_admin($data)
    {
        $data['id_contact'] = isset($data['id_contact']) ? $data['id_contact'] : '';
        return '【しごさが】にお問い合わせがありました。

求人管理システムからお問い合わせ内容をご確認下さい。' .
        $data['bo_url'] . 'support/contact/index/' . $data['id_contact'];
    }
}
