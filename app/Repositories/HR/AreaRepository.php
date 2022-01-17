<?php

namespace App\Repositories\HR;

use App\Models\HR\Area;
use App\Repositories\Repository;

class AreaRepository extends Repository {

    public function __construct(Area $model) {

        parent::__construct($model);

    }

    public function getAreas($params) {

        $areas = $this->model();

        if($params->search) {

            $areas = $areas
                ->where(function($query) use ($params) {
                    $query->where('name', 'LIKE', "%$params->search%");
                })
                ->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $areas;
        }

        $areas = $areas->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $areas;

    }

    public function storeArea($request) {

        $data = new $this->model();

        $data->name = $request->name;
        $data->lat = $request->coordinates->lat;
        $data->lng = $request->coordinates->lng;
        if($data->save()) {
            return $data;
        }

    }

    public function updateArea($id, $request) {

        $data = $this->model()->find($id);
        $data->name = $request->name;
        if($data->save()) {
            return $data;
        }

    }

    public function deleteArea($id) {

        $data = $this->model()->find($id);
        if($data) {
            $data->delete();
        }

    }

    public function searchArea($params) {

        $areas = $this->model();

        if($params->search) {

            $areas = $areas->where(function($query) use ($params) {
                $query->where('name', 'LIKE', "%$params->search%");
            })->limit(20)->get();

            return $areas;
        }

    }

}
