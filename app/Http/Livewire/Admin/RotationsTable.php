<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

use App\Models\Rotation;
use Illuminate\Support\Facades\Gate;

class RotationsTable extends DataTable
{
    protected $filter_options = [
        'status' => [
            'name' => 'Status',
            'options' => ['draft' => 'Draft','published' => 'Published','disabled' => 'Disabled', 'archived' => 'Archived'],
            'field' => 'status',
            'filters' => [
                'draft' => 'draft',
                'published' => 'published',
                'disabled' => 'disabled',
                'archived' => 'archived'
            ]
        ],
        'preceptor' => [
            'name' => 'Preceptor',
            'field' => 'preceptor_user_id',
            'type' => 'autocomplete',
            'route' => 'admin-preceptors-autocomplete'
        ],
        'city' => [
            'name' => 'City',
            'field' => 'city',
            'type' => 'text',
        ],
        'state' => [
            'name' => 'State',
            'field' => 'state',
            'type' => 'text',
        ],
        'zipcode' => [
            'name' => 'Zip',
            'field' => 'zipcode',
            'type' => 'text',
        ],
    ];

    public function render()
    {
        $this->emit('selection-reset');
        $this->selected = [];

        $query = Rotation::query();

        $filtering = $this->addFilters($query);
        $this->addOrderBy($query);

        if ($this->sort == "" || $this->sort == "default") {
            $query->orderBy("created_at","desc");
        }

        $rotations = $query->paginate(config("rotation.pagination_size"));

        return view('admin.livewire.rotations',
                [
                    'rotations' => $rotations,
                    'sort_options' => $this->sort_options,
                    'filter_options' => $this->filter_options,
                    'filtering' => $filtering
                ]
            )->layout('layouts.admin');;
    }

    private function setRotationStatuses($status) {
        $rotations = $this->getSelected(Rotation::class);
        foreach($rotations as $rotation) {
            $rotation->status = $status;
            $rotation->save();
        }
    }

    public function makeDraft() {
        $this->setRotationStatuses('draft');
    }

    public function publish() {
        $this->setRotationStatuses('published');
    }

    public function disable() {
        $this->setRotationStatuses('disabled');
    }

    public function archive() {
        $this->setRotationStatuses('archived');
    }
}

