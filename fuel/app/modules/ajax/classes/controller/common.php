<?php

namespace Ajax;

use Fuel\Core\Input;
use Fuel\Core\Session;

/**
 * author ThuanTH6589
 * Class Controller_Common
 * @package Ajax
 */
class Controller_Common extends \Controller_CustomerBase
{

    /**
     * author thuanth6589
     * get sale shop
     * @return \Response
     */
    public function action_searchSaleShop()
    {
        if (Input::method() == 'POST') {
            $login_info = Session::get('login_info');
            $filters = Input::all();
            $filters['customer_id'] = $login_info['customer_id'];
            $sale_shop = new \Model_Saleshop();
            $result = $sale_shop->get_data($filters);
            $arr_data = array();
            if (count($result)) {
                $k = 0;
                foreach ($result as $row) {
                    $arr_data[$k]['shop_id'] = $row['shop_id'];
                    $arr_data[$k]['shop_name'] = htmlspecialchars($row['shop_name']);
                    $arr_data[$k]['access'] = htmlspecialchars($row['access']);
                    $arr_data[$k]['application_price'] = $row['application_price'];
                    $arr_data[$k]['employment_price'] = $row['employment_price'];
                    ++$k;
                }
            }
            return new \Response(json_encode($arr_data), 200, array());
        }
    }
}
