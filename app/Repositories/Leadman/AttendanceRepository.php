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

    public function attendanceByQr($params) {
        date_default_timezone_set('Asia/Manila');

        $date_now = carbon::now()->format('Y-m-d');
        $time_now = Carbon::now()->format('H:i:s');

        $attendance = $this->model()->where('date', $date_now)->where('employee_id', $params->employee->id)->first();

        if(empty($attendance)) {
            $newAttendance = new $this->model();
            $newAttendance->date = $date_now;
            $newAttendance->employee_id = $params->employee->id;
            $newAttendance->time_in = $time_now;
            if($newAttendance->save()) {
                return 'success_in';
            }
        }
        else {

            if(!$attendance->time_in) {

                $attendance->time_in = $time_now;

                if($attendance->save()) {
                    return 'success_in';
                }
            }
            else if(!$attendance->time_out) {

                $attendance->time_out = $time_now;

                if($attendance->save()) {
                    return 'success_out';
                }

            }
            else {

                return 'already_time_in_out';

            }

        }

    }
}
