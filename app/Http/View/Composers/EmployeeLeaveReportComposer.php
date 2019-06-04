<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class EmployeeLeaveReportComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $viewData = $view->getData();

        $view->with('yearlyPtoCredits', $this->getYearlyPTO($viewData));
        $view->with('leaveTypeUsed', $this->getLeaveTypesUsed($viewData));
        $view->with('leaveRequestHistory', $this->getLeaveRequestHistory($viewData));
    }

    private function getYearlyPTO($data)
    {
        $ptoId      = 1;
        $dayCount   = $this->getDayCount();

        // check PTO base leave request
        $total = $data['leaveRequests']
            ->where('status', 'Approved')
            ->where('is_paid', 1)
            ->where('leaveType.leave_credit_type_id', $ptoId)
            ->filter(function ($request) {
                return \Carbon\Carbon::now()->year == \Carbon\Carbon::parse($request->start_date)->year;
            })
            ->sum(function ($request) use ($dayCount) {
                return $dayCount($request->duration);
            });

        // Employee leave credit balance
        $leaveCreditBalance = $data['employee']
            ->leaveCredits
            ->firstWhere('leave_credit_type_id', $ptoId);
        $available = $leaveCreditBalance ? $leaveCreditBalance->balance : 0;

        return [
            'total'     => number_format($total, 2),
            'available' => number_format($available, 2),
        ];
    }

    private function getLeaveTypesUsed($data)
    {
        $dayCount = $this->getDayCount();

        return $data['leaveRequests']
            ->groupBy('leaveType.name')
            ->map(function ($requests) use ($dayCount) {
                $approved = $requests->where('status', 'Approved');

                // Calculations
                $daysUsed   = $approved->sum(function ($request) use ($dayCount) {
                    return $dayCount($request->duration);
                });
                $paidLeaves = $approved->where('is_paid', 1)->sum(function ($request) use ($dayCount) {
                    return $dayCount($request->duration);
                });

                return [
                    'daysUsed'   => number_format($daysUsed, 2),
                    'paidLeaves' => number_format($paidLeaves, 2),
                ];
            })
            ->toArray();
    }

    private function getDayCount()
    {
        return function ($duration) {
            return $duration === 'Half Day' ? 0.5 : 1;
        };
    }

    private function getLeaveRequestHistory($data)
    {
        return $data['leaveRequests']
            ->sortByDesc('start_date')
            ->groupBy('batch')
            ->map(function ($requests) {
                $sortedData = $requests->sortBy('start_date');
                $first      = $sortedData->first();
                $last       = $sortedData->last();
                $dataList   = $sortedData->map(function ($data) {
                    $date     = \Carbon\Carbon::parse($data->start_date)->format('M d, Y');
                    $status   = $data->status;
                    $approver = 'No Approver';
                    $remarks  = '';

                    if ($appr = $data->approver) {
                        $approver = $appr->last_name . ', ' . $appr->first_name . ' ' . $appr->middle_name;
                        $remarks  = $data->approver_comment;
                    }

                    return compact('date', 'status', 'approver', 'remarks');
                })->toArray();

                return [
                    'leaveType'    => $first->leaveType->name,
                    'datePeriod'   => $this->formatDatetime($first->start_date, $last->end_date),
                    'dateFiled'    => \Carbon\Carbon::parse($first->created_at)->format('M d, Y h:i:s A'),
                    'reason'       => $first->reason,
                    'leaveTime'    => $this->formatDatetime($first->start_time, $last->end_time, 'h:i A'),
                    'duration'     => $sortedData->count(),
                    'dayStatus'    => $first->duration,
                    'paidStatus'   => $first->is_paid ? 'Paid' : 'Unpaid',
                    'requestsData' => $dataList,
                ];
            })
            ->toArray();
    }

    private function formatDatetime($start, $end, $format = 'M d, Y')
    {
        return
            \Carbon\Carbon::parse($start)->format($format)
            . ' to ' .
            \Carbon\Carbon::parse($end)->format($format);
    }
}
