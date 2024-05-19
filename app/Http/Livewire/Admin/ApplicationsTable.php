<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

use App\Models\Application;
use Illuminate\Support\Facades\Gate;

class ApplicationsTable extends DataTable
{
    protected $filter_options = [
        'status' => [
            'name' => 'Status',
            'options' => ['pending' => 'Pending','accepted' => 'Accepted','paid' => 'Paid', 'rejected' => 'Rejected', 'withdrawn' => 'Withdrawn'],
            'field' => 'status',
            'filters' => [
                'pending' => 'pending',
                'accepted' => 'accepted',
                'paid' => 'paid',
                'rejected' => 'rejected',
                'withdrawn' => 'withdrawn',
            ]
        ],
        'student' => [
            'name' => 'Student',
            'field' => 'student_user_id',
            'type' => 'autocomplete',
            'route' => 'admin-students-autocomplete'
        ],
        'rotation' => [
            'name' => 'Rotation',
            'field' => 'rotation_id',
            'type' => 'autocomplete',
            'route' => 'admin-rotations-autocomplete'
        ]
    ];

    public function render()
    {
        $this->emit('selection-reset');
        $this->selected = [];

        $query = Application::query();

        $filtering = $this->addFilters($query);
        $this->addOrderBy($query);

        if ($this->sort == "" || $this->sort == "default") {
            $query->orderBy("created_at","desc");
        }

        $applications = $query->paginate(config("rotation.pagination_size"));

        return view('admin.livewire.applications',
                [
                    'applications' => $applications,
                    'sort_options' => $this->sort_options,
                    'filter_options' => $this->filter_options,
                    'filtering' => $filtering
                ]
            )->layout('layouts.admin');;
    }

    private function setApplicationStatuses($status) {
        $applications = $this->getSelected(Application::class);
        foreach($applications as $application) {
            $application->status = $status;
            $application->save();
        }
    }

    public function markAsPending() {
        $this->setApplicationStatuses('pending');
    }

    public function markAsAccepted() {
        $this->setApplicationStatuses('accepted');
    }

    public function markAsPaid() {
        $this->setApplicationStatuses('paid');
    }

    public function markAsRejected() {
        $this->setApplicationStatuses('rejected');
    }

    public function markAsWithdrawn() {
        $this->setApplicationStatuses('withdrawn');
    }
}
