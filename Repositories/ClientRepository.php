<?php

namespace App\Repositories;

use Yajra\DataTables\Facades\DataTables;
use App\Models\Client;

class ClientRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__constructor(new Client());
    }

     /**
     * @param bool $isTrashed
     * @param string $customColumns
     * @return mixed
     */
    public function datatable(bool $isTrashed = false,string $customColumns = null): mixed
    {
        $selectedColumns = $this->model->selectedColumns();
        $actions = "dashboard.modules.".strtolower(getClassName($this->model))."s.datatables.actions";
        if($isTrashed)
        {
            $data = $this->model->select($selectedColumns)->where('branch_id',activeBranchId())->whereNotNull('deleted_at')->orderBy('id','desc')->get();
        }else{
            $data = $this->model->select($selectedColumns)->where('branch_id',activeBranchId())->whereNull('deleted_at')->orderBy('id','desc')->get();
        }
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('status_trans', function ($row) {
            $route = route("clients.status-change",$row);
            $permission = "clients_edit";
            return view("dashboard.components.status_change", compact('route','row','permission'))->render();
        })
        ->addColumn('country', function ($row) {
            return $row->country->{langName('name')} ?? '';
        })
        ->addColumn('actions', function ($row) use($actions) {
            return view($actions, compact('row'))->render();
        })
        ->rawColumns(['actions','status_trans','country'])->toJson();
    }


}
