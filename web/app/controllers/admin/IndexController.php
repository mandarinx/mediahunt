<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */

namespace Controllers\Admin;

use Carbon;
use DB;
use Post;
use User;
use View;

class IndexController extends \BaseController {

    public function getIndex()
    {
        $startDate = Carbon\Carbon::now()->subDays(30);
        $signup = User::where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get([
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as value')
            ]);


        $signup = $this->graphGenerator($signup);

        $videos = Post::approved()->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get([
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as value')
            ]);
        $videos = $this->graphGenerator($videos);


        return View::make('admin/sitedetails/index', compact('signup', 'videos'));
    }

    private function graphGenerator($input)
    {
        $startDate = Carbon\Carbon::now()->subDays(30);
        $endDate = Carbon\Carbon::now();
        $date = $startDate->toDateString();
        $end_date = $endDate->toDateString();

        $firstArray = [];
        foreach ($input as $s)
        {
            $firstArray[$s->date] = [
                'date'  => $s->date,
                'value' => $s->value
            ];
        }
        $i = 0;
        $w = null;
        while (strtotime($date) <= strtotime($end_date))
        {
            if (array_key_exists($startDate->toDateString(), $firstArray))
            {
                $w[$i] = $firstArray[$startDate->toDateString()];
            }
            else
            {
                $w[$i] = [
                    'date'  => $startDate->toDateString(),
                    'value' => 0
                ];
            }
            $date = $startDate->addDays(1);
            $i++;
        }

        return json_encode($w);
    }
}