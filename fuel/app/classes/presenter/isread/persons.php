<?php

/**
 * @author HuyLV6635
 */
class Presenter_Isread_Persons extends Presenter
{
    /**
     * Prepare the view data, keeping this in here helps clean up
     * the controller.
     *
     * @return void
     */
    public function view()
    {
        $this->is_read = '';
        if ($login_info = \Fuel\Core\Session::get('login_info')) {
            $filters = [
                'customer_id' => $login_info['customer_id'],
                'is_read'     => Constants::$is_read['unread']
            ];
            $sale_person_obj = new Model_Saleperson();
            $this->is_read = $sale_person_obj->count_data($filters);
        }
    }
}
