<?php

namespace App\Services;

use App\Http\Helpers\DateUtility;

class getOrderGraphData
{

    private $orderModel;
    public function __construct()
    {
        $this->orderModel = new \App\Models\Order;

    }



    public function get($period)
    {
        // $data = [];
        $labels = [];
        $datas = [];
        if ($period == 'Daily') {

            $dates = DateUtility::get_date_between_dates(date('Y-m-d', strtotime('-15 days')), date('Y-m-d'));

            foreach ($dates as $i) {
                $labels[] = date('M d', strtotime($i));
                $datas[] = $this->orderModel->get_order_count(['from_date' => $i, 'to_date' => $i]);

            }


        } elseif ($period == 'Weekly') {
            $dates = DateUtility::get_month_weekly_dates();
            $i = 0;
            foreach ($dates as $p) {
                $labels[] = $this->count_week_label(++$i);
                $datas[] = $this->orderModel->get_order_count(['from_date' => $p['from_date'], 'to_date' => $p['end_date']]);
            }

        } elseif ($period == 'Monthly') {
            $dates = DateUtility::get_year_monthly_period();
            $i = 0;
            foreach ($dates as $p) {
                $labels[] = date('M Y',strtotime($p['start_date']));
                $datas[] = $this->orderModel->get_order_count(['from_date' => $p['start_date'], 'to_date' => $p['end_date']]);
            }
            

        }
        return compact('datas', 'labels');

    }
    public function count_week_label($i = 1)
    {
        if ($i == 1) {
            return "1st Week";
        } else if ($i == 2) {
            return "2nd Week";
        } else if ($i == 3) {
            return "3rd Week";
        } else {
            return $i . "th Week";
        }
    }


}