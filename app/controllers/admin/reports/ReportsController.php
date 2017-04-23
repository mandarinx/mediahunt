<?php

namespace Controllers\Admin\Reports;

use Carbon\Carbon;
use DB;
use Mediavenue\Repository\FlagsRepositoryInterface;
use Report;
use View;

class ReportsController extends \BaseController {

    /**
     * @var \Mediavenue\Repository\FlagsRepositoryInterface
     */
    private $flags;

    /**
     * @param FlagsRepositoryInterface $flags
     */
    public function  __construct(FlagsRepositoryInterface $flags)
    {
        $this->flags = $flags;
    }

    /**
     * @return mixed
     */
    public function getReports()
    {
        $reports = $this->flags->getAll();

        return View::make('admin/reports/index')
            ->with('reports', $reports)
            ->with('title', 'Latest Reports');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getReadReport($id)
    {
        $report = $this->flags->getById($id);
        $report->checked_at = Carbon::now();
        $report->save();

        return View::make('admin/reports/read')
            ->with('title', 'Full Report')
            ->with('report', $report);
    }
}