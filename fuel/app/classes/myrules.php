<?php

/**
 * Created by PhpStorm.
 * User: Huy
 * Date: 4/26/2017
 * Time: 8:39 AM
 */
class MyRules
{
    // validation input must number and letter
    public static function _validation_check_password($val)
    {
        if ($val == '') {
            return true;
        }
        return preg_match('/^(?=[a-z]*[0-9])(?=[0-9]*[a-z])([a-z0-9]+)$/i', $val) > 0;
    }

    // validation unique email
    public static function _validation_unique($val, $options)
    {
        list($table, $field) = explode('.', $options);

        $result = DB::select(DB::expr("LOWER (\"$field\")"))
            ->where($field, '=', Str::lower($val))
            ->from($table)->execute();

        return !($result->count() > 0);
    }

    // validation kana
    public static function _validation_kana($val)
    {
        return preg_match('/^([ぁ-ん　]|\s)+$/', $val) ? true : false;
    }

    // validation required with other data
    public static function _validation_required_fax($val, $option)
    {
        if ($val !== '') {
            return true;
        }
        if ($option[0] !== '' || $option[1] != '') {
            return false;
        }
        return true;
    }

    /**
     * @param $val
     * @param $option
     * @return bool
     */
    public static function _validation_required_tel($val, $option)
    {
        if ($val !== '') {
            return true;
        }

        return empty(array_filter($option)) ? true : false;
    }
    /**
     * @param $val
     * @param $option
     * @return bool
     */
    public static function _validation_required_zipcode($val, $option)
    {
        if ($val) {
            return true;
        }

        return empty(array_filter($option)) ? true : false;
    }

    /**
     * @param $val
     * @param $option
     * @return bool
     */
    public static function _validation_required_mobile($val, $option)
    {
        if ($val) {
            return true;
        }

        return empty(array_filter($option)) ? true : false;
    }

    /**
     * start date <= end date
     * @param $val
     * @param $option
     * @return bool
     */
    public static function _validation_after_or_equal($val, $option)
    {
        return strtotime($val) >= strtotime($option);
    }

    /**
     * end date >= start date
     * @param $val
     * @param $option
     * @return bool
     */
    public static function _validation_before_or_equal($val, $option)
    {
        return strtotime($val) <= strtotime($option);
    }

    public static function _validation_required_salary_min($val, $option)
    {
        if ($val || $option != '1') {
            return true;
        }
        return false;
    }

    /**
     * require emloyment people num on employment_people
     * @param $val
     * @param $option
     * @return bool
     */
    public static function _validation_required_employment_people_num($val, $option)
    {
        if ($val || $option != '7') {
            return true;
        }
        return false;
    }

    /**
     * check over 6 months
     * @param $val
     * @param $option
     * @return bool
     */
    public static function _validation_over6months($val, $option)
    {
        return $val <= Utility::addMonth($option, 6);
    }

    // validation required with other data
    public static function _validation_data_other($val, $option)
    {
        if ($val != '') {
            return true;
        }

        // check all == ''. If all == '' then required
        foreach ($option as $k => $v) {
            if ($v != '') {
                return true;
            }
        }

        return false;
    }

    public static function _validation_requiredSelection($val)
    {
        return $val != 0;
    }

    public static function _validation_duplication($val, $option)
    {
        if (!$val) {
            return true;
        }

        return $val != $option;
    }
}
