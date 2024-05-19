<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class PreceptorsTable extends DataTable
{
    protected $sort_options = ['last_login_at' => 'Last login','first_name' => 'First name','last_name' => 'Last name','email' => 'Email','status' => 'Status',];
    protected $sort_values = [
        'last_login_at' => ['field' => 'last_login_at','direction' => 'desc'],
        'first_name' => ['field' => 'first_name','direction' => 'asc'],
        'last_name' => ['field' => 'last_name','direction' => 'asc'],
        'email' => ['field' => 'email','direction' => 'asc'],
        'status' => ['field' => 'status','direction' => 'asc']
    ];
    protected $filter_options = [
        'status' => [
            'name' => 'Status',
            'options' => ['active' => 'Active','inactive' => 'Inactive','suspended' => 'Suspended'],
            'field' => 'status',
            'filters' => [
                'active' => 'active',
                'inactive' => 'inactive',
                'suspended' => 'suspended'
            ],
            'default' => 'active'
        ]
    ];

    public function render()
    {
        $this->emit('selection-reset');
        $this->selected = [];

        $query = User::where(['role' => 'preceptor']);

        $filtering = $this->addFilters($query);
        $this->addOrderBy($query);
        $filtering |= $this->addSearch($query);

        if ($this->sort == "" || $this->sort == "default") {
            $query->orderBy("created_at","desc");
        }

        $preceptors = $query->paginate(config("rotation.pagination_size"));

        return view('admin.livewire.preceptors',
                [
                    'preceptors' => $preceptors,
                    'sort_options' => $this->sort_options,
                    'filter_options' => $this->filter_options,
                    'filtering' => $filtering
                ]
            )->layout('layouts.admin');;
    }

    private function addSearch($query) {
        if ($this->search_query == null) return false;
        $search_query = $this->search_query;
        $query->where(function($query) use($search_query) {
            $query->where('email','like','%'.$search_query.'%');
            $query->orWhere('first_name','like','%'.$search_query.'%');
            $query->orWhere('last_name','like','%'.$search_query.'%');
        });
        return true;
    }

    private function setUserStatuses($status) {
        $users = $this->getSelected(User::class);
        foreach($users as $user) {
            $user->status = $status;
            $user->save();
        }
    }

    public function activate() {
        $this->setUserStatuses('active');
    }

    public function inactivate() {
        $this->setUserStatuses('inactive');
    }

    public function suspend() {
        $this->setUserStatuses('suspended');
    }

}
