<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Utility
{
    /*
     * Send mail
     *
     * @since 05/06/2015
     * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
     */
    public static function sendmail($mailto, $subject, $data, $template = false)
    {
        $body = isset($data['body']) ? $data['body'] : null;

        $email = \Email::forge();
        $email->from(\Fuel\Core\Config::get('mail_from'), \Fuel\Core\Config::get('mail_from_name'));

        //if is array mail
        $mail_to = array();
        if (is_array($mailto) && count($mailto)) {
            foreach ($mailto as $key => $value) {
                $mailto_arr = explode(',', trim($value, ','));
                if (count($mailto_arr)) {
                    foreach ($mailto_arr as $k => $v) {
                        if ($v) {
                            $mail_to[$v] = $v;
                        }
                    }
                }
            }

            $email->to($mail_to);
        } else {
            $email->to($mailto);
        }

        $email->subject($subject);
        $email->body($body);

        //use template
        if ($template) {
            $email->body(\View::forge($template, $data)); //$data is var pass to template
        }

        //if have attach
        //$email->attach(DOCROOT.'my-pic.jpg');
        try {
            $email->send();
            return true;
        } catch (\EmailValidationFailedException $e) {
            Fuel\Core\Log::error('Mail validation: ' . json_encode($mailto));
            return false;
        } catch (\EmailSendingFailedException $e) {
            Fuel\Core\Log::error('Mail send failed: ' . json_encode($mailto));
            return false;
        }
    }

    /*
     * Debug data
     *
     * @since 05/09/2015
     * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
     */
    public static function debug($value, $die = true)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        if ($die) {
            die();
        }
    }

    public static function get_default_data($table_name)
    {
        $fields = \DB::list_columns($table_name);
        foreach ($fields as $k => $v) {
            $_data_default[$k] = $v['default'];
        }

        $_data_default['is_new'] = true;
        return $_data_default;
    }

    /*
     * Validate
     * @singce 2015/10/28
     * @author Dang Bui 6591
     * */
    public static function format_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function validate_required($value)
    {
        if (self::format_input($value) == '')
            return false;
        else
            return true;
    }

    public static function validate_email($value)
    {
        if (!filter_var(self::format_input($value), FILTER_VALIDATE_EMAIL))
            return false;
        else
            return true;
    }

    /**
     * @author thuanth6589
     * @param $date
     * @return string
     */
    public static function get_day_of_week($date)
    {
        $day = date('N', strtotime($date));
        return isset(Constants::$day_of_week[$day]) ? Constants::$day_of_week[$day] : '';
    }

    /**
     * @author thuanth6589
     * crop tring, add ...
     * @param $str
     * @param $length
     * @param string $char
     * @return string
     */
    public static function crop_string($str, $length, $char = ' ...')
    {
        $str = trim($str);

        // nếu str < length, return str
        $strlen = mb_strlen($str, 'UTF-8');

        if ($strlen <= $length) return $str;

        // Cắt chiều dài chuỗi tới đoạn cần lấy
        $substr = mb_substr($str, 0, $length, 'UTF-8');
        return $substr . $char;
    }

    private static function _bit2mask($bit)
    {
        $bit = intval($bit);
        return bindec(
            str_repeat('1', $bit) . str_repeat('0', 32 - $bit)
        );
    }

    /*
     * check IP range.
     *
     * @author Y.Hasegawa <hasegawa@d-o-m.jp>
     * @return boolean
     */
    public static function is_include_ip($ip, $ranges)
    {
        if (is_array($ranges) == false) {
            $ranges = array($ranges);
        }

        $ip_long = ip2long($ip);

        foreach ($ranges as $range) {
            @list($range_ip, $bit) = explode('/', $range);
            if (strlen($bit)) {
                $range_ip_long = ip2long($range_ip);
                $mask = self::_bit2mask($bit);
                if (($ip_long & $mask) == ($range_ip_long & $mask)) {
                    return true;
                }
            } else if ($ip == $range) {
                return true;
            }
        }

        return false;
    }


    public static function get_head_seo()
    {
        $urlcurrent = preg_replace('/\?.*$/', '', Fuel\Core\Input::server('REQUEST_URI'));
        $_matched = null;
        $pos1 = '';
        if (preg_match('@https?://[^/]+(/.+/)$@', Fuel\Core\Uri::base(), $_matched)) {
            $pos1 = substr($urlcurrent, strlen($_matched[1]));
        }
        $pos1 = str_replace('.html', '', $pos1);
        $pos1 = ltrim($pos1, '/');
        $pos1 = rtrim($pos1, '/');
        $pos1 = strtolower($pos1);
        if (strpos($pos1, 'search/detail') !== false) {
            $pos1 = 'search/detail';
        } elseif (strpos($pos1, 'search') !== false) {
            $jobs = new Model_Job();
            if ($jobs->count_data(\Fuel\Core\Input::get()) == 0)
                $pos1 = 'search/no';
            else
                $pos1 = 'search';
        } elseif ($pos1 === 'search') {
            $pos1 = 'search';
        }

        if (array_key_exists($pos1, Constants::$head_meta)) {
            return Constants::$head_meta[$pos1];
        }

        return array(
            'title' => '404 Page Not Found. | しごさが',
            'h1' => '404 Page Not Found.',
            'keywords' => '404',
            'description' => '404 Page Not Found',
            'h_des' => 'お探しのページは見つかりません。',
        );
    }

    /**
     * Encrypt
     * @author Y.Hasegawa <hasegawa@d-o-m.jp>
     * @param mixed
     * @return string
     */
    public static function encrypt($data)
    {
        return bin2hex(mcrypt_encrypt(
            MCRYPT_BLOWFISH,
            pack("H*", Fuel\Core\Config::get('preview_encrypt_key')),
            serialize($data),
            MCRYPT_MODE_CBC,
            pack("H*", Fuel\Core\Config::get('preview_encrypt_iv'))
        ));
    }

    /**
     * Decrypt
     * @author Y.Hasegawa <hasegawa@d-o-m.jp>
     * @param string
     * @return mixed
     */
    public static function decrypt($encrypted)
    {
        try {
            $decrypted = rtrim(mcrypt_decrypt(
                MCRYPT_BLOWFISH,
                pack("H*", Fuel\Core\Config::get('preview_encrypt_key')),
                pack("H*", $encrypted),
                MCRYPT_MODE_CBC,
                pack("H*", Fuel\Core\Config::get('preview_encrypt_iv'))
            ));

            return unserialize($decrypted);
        } catch (Fuel\Core\PhpErrorException $ex) {
            return null;
        }
    }

    /**
     * Japanese holidays
     * @author Y.Hasegawa <hasegawa@d-o-m.jp>
     * @return array
     */
    public static function get_holidays()
    {
        $identifier = 'holidays';
        $cache = new Model_Cache();
        $holidays_database = $cache->get_info_data('uos-holidays');
        $holidays_database_ymd = array();
        if ($holidays_database !== false && count($holidays_database)) {
            foreach ($holidays_database as $value) {
                $holidays_database_ymd[date('Ymd', strtotime($value))] = 'Holiday database-' . $value;
            }
        }

        try {
            $cache = \Fuel\Core\Cache::get($identifier);

            if (is_array($cache)) {
                return $cache + $holidays_database_ymd;
            }
        } catch (\Fuel\Core\CacheNotFoundException $ex) {
        }

        $url = 'https://calendar.google.com/calendar/ical/japanese__ja%40holiday.calendar.google.com/public/full.ics';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $ics = curl_exec($ch);
        curl_close($ch);

        $holidays = array();
        $day = null;
        foreach (explode("\n", $ics) as $line) {
            $line = trim($line);
            if (substr($line, 0, 8) == 'DTSTART;') {
                $array = explode(':', $line);
                $day = $array[1];
            }
            if (substr($line, 0, 8) == 'SUMMARY:') {
                $array = explode(':', $line);
                $holidays[$day] = $array[1];
            }
        }

        ksort($holidays);
        \Fuel\Core\Cache::set($identifier, $holidays, 86400 * 30);
        $holidays = $holidays + $holidays_database_ymd;

        return $holidays;
    }

    /**
     * get mail send time
     * @param $time
     * @param $holidays
     * @return mixed
     */
    public static function get_date_out_of_holiday($time, $holidays)
    {
        $time = $time + 24 * 60 * 60;
        $date = date('Ymd', $time);
        $day = date('N', $time);
        if (!in_array($date, $holidays) && $day != 6 && $day != 7) {
            return $time;
        }
        return self::get_date_out_of_holiday($time, $holidays);
    }

    /**
     * author thuanth6589
     * calculate age
     * @param $birthday (format Y-m-d)
     * @return bool|string
     */
    public static function calculate_age($birthday)
    {
        $date = explode("-", $birthday);
        if (date('md', strtotime($birthday)) > date("md")) {
            return date("Y") - $date[0] - 1;
        }
        return date("Y") - $date[0];
    }

    public static function addMonth($start, $add)
    {
        $time = strtotime($start);
        $year = (int)date('Y', $time);
        $month = (int)date('m', $time);
        $day = (int)date('d', $time);

        $month += $add;
        while ($month > 12) {
            $month -= 12;
            $year++;
        }

        if ($month == 4 || $month == 6 || $month == 9 || $month == 11) {
            if ($day > 30) { $day = 30; }
        }

        if ($month == 2) {
            if (($year % 100 != 0 && $year % 4 == 0) || $year % 400 == 0) {
                if ($day > 29) { $day = 29; }
            } else {
                if ($day > 28) { $day = 28; }
            }
        }

        return sprintf('%04d-%02d-%02d', $year, $month, $day);
    }
}
