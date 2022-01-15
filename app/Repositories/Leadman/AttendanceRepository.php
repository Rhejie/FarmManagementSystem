<?php

namespace App\Repositories\Leadman;

use App\Models\Leadman\Attendance;
use App\Repositories\Repository;
use Carbon\Carbon;

class AttendanceRepository extends Repository {

    public function __construct(Attendance $model) {

        parent::__construct($model);

    }

    public function getAttendance($params) {

        $attendance = $this->model()->with(['employee']);

        if($params->search) {

            $attendance = $attendance->where(function($query) use ($params) {
                $query->where('date', 'LIKE', "$params->date");
                $query->whereHas('employee', function ($query) use ($params) {
                    $query->where(function ($query) use ($params) {
                        $query->orWhere('firstname', 'LIKE', "%$params->search%");
                        $query->orWhere('middlename', 'LIKE', "%$params->search%");
                        $query->orWhere('lastname', 'LIKE', "%$params->search%");
                    });
                });
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $attendance;

        }

        $attendance = $attendance->where('date', 'LIKE', "$params->date")
                ->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $attendance;

    }

    public function storeAttendance($request) {

        $check = $this->model()->where('date', $request->date)->where('employee_id', $request->employee_id)->first();

        if(!empty($check)) {

            return 'already_time_in';

        }

        $data = new $this->model();

        $data->employee_id = $request->employee_id;
        $data->date = $request->date;
        $data->time_in = $request->time_in;

        if($data->save()) {

            return $this->model()->with(['employee'])->find($data->id);

        }

    }

    public function updateAttendance($id, $request) {

        date_default_timezone_set('Asia/Manila');

        $data = $this->model()->find($id);

        if($request->time_out) {
            $time = $request->time_out;
        }
        else {

            $time = Carbon::now()->format('H:i:s');

        }

        $data->time_out = $time;

        if($data->save()) {

            return $this->model()->with(['employee'])->find($id);

        }

    }
}
