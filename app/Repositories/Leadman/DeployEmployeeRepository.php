<?php

namespace App\Repositories\Leadman;

use App\Models\Leadman\DeployEmployee;
use App\Repositories\Repository;
use Carbon\Carbon;

class DeployEmployeeRepository extends Repository {

    public function __construct(DeployEmployee $model) {

        parent::__construct($model);

    }

    public function getDeploy($params) {

        $employee =$this->model()->with(['area', 'employee'])
        ->where(\DB::raw("(DATE_FORMAT(date,'%d-%m-%Y'))"), (new Carbon($params->date))->format('d-m-Y'));

        if($params->search) {

            $employee = $employee->where(function ($query) use ($params) {
                $query->whereHas('employee', function ($query) use ($params) {
                    $query->where(function ($query) use ($params) {
                        $query->orWhere('firstname', 'LIKE', "%$params->search%");
                        $query->orWhere('lastname', 'LIKE', "%$params->search%");
                        $query->orWhere('middlename', 'LIKE', "%$params->search%");
                    });
                    $query->whereHas('area', function ($query) use ($params) {
                        $query->where(function ($query) use ($params) {
                            $query->where('name', 'LIKE', "%$params->search%");
                        });
                    });
                });
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $employee;

        }

        $employee = $employee->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $employee;

    }

    public function storeDeploy($request) {
        $check = $this->model()
            ->where(\DB::raw("(DATE_FORMAT(date,'%d-%m-%Y'))"), (new Carbon($request->date))->format('d-m-Y'))
            ->where('employee_id', $request->employee_id)->first();

            if(!empty($check)) {

                return 'already_deploy';

            }

        $data = new $this->model();
        $data->employee_id = $request->employee_id;
        $data->area_id = $request->area_id;
        $data->date = $request->date;

        if($data->save()) {
            return $this->model()->with(['area', 'employee'])->find($data->id);
        }

    }

    public function updateDeploy($id, $request) {

        $data = $this->model()->find($id);
        $employee_id = $request->employee_id_id ? $request->employee_id_id : $request->employee_id;
        $area_id = $request->area_id_id ? $request->area_id_id : $request->area_id;

        $data->employee_id = $employee_id;
        $data->area_id = $area_id;
        $data->date = $request->date;

        if($data->save()) {
            return $this->model()->with(['area', 'employee'])->find($id);
        }
    }

    public function deleteDeploy($id) {

        $data = $this->model()->find($id);

        if($data->delete()) {
            return ' delete';
        }

    }

}
