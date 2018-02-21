<?php

use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Response;

class Controller_Beacon extends Controller_Template
{

    public function get_salejob()
    {
        $sql = "INSERT INTO sale_job_pv (job_id, pv_time) VALUES (:job_id, NOW())";
        DB::query($sql)->parameters(['job_id' => Input::get('job_id')])->execute();

        return new Response(
            pack('H*', '474946383761010001008000000000000000002c00000000010001000002024401003b'),
            200,
            [ 'Content-Type' => 'image/gif' ]
        );
    }

}
