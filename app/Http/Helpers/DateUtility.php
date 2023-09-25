<?php
namespace App\Http\Helpers;

class DateUtility
{
    static function get_date_between_dates($start_date, $end_date)
    {

        $data = array();
        $periods = new \DatePeriod(
            new \DateTime($start_date),
            new \DateInterval('P1D'),
            new \DateTime($end_date)
        );

        foreach ($periods as $item) {
            $data[] = $item->format('Y-m-d');

        }
        $data[] = date('Y-m-d', strtotime($end_date));

        return $data;

    }


    static function get_month_weekly_dates()
    {
        $from_date = date('Y-m-1');
        $week_count = 4;
        $date_arr = [];

        for ($i = 0; $i < $week_count; $i++) {
            $end_date = date('Y-m-d', strtotime('+6 days', strtotime($from_date))); //adding 6 days from first date of this month
            $date_arr[] = compact('from_date', 'end_date');

            $from_date = date('Y-m-d', strtotime('+1 days', strtotime($end_date))); // adding 1 day from end_date

        }


        if ($from_date < date('Y-m-t', strtotime($end_date))) { //checking from date less than last day of this month
            $date_arr[] = ['from_date' => $from_date, 'end_date' => date('Y-m-t', strtotime($end_date))];

        }

        return $date_arr;



    }


    static function get_year_monthly_period(){

        $end_year = date('Y-m-d');
        $start_year = date('Y-m-d', strtotime('-1 year'));//2022/09/3
        $start_date = date('Y-m-1', strtotime($start_year));//2022/09/1
        $end_date = date('Y-m-t', strtotime($end_year));//2023/09/31

        $start = new \DateTime($start_date);
        $start->modify('first day of this month');
        $end = new \DateTime($end_date);
        $end->modify('first day of next month');

        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($start, $interval, $end);
        $data = [];
        foreach ($period as $dt) {

            $temp_date = $dt->format("Y-m-d");//2022/09/1 ....

            $data[] = [
                'start_date' => date('Y-m-1', strtotime($temp_date)),
                'end_date' => date('Y-m-t', strtotime($temp_date))
            ];
        }
        return $data;



    }












}