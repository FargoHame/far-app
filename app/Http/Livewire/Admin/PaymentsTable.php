<?php

namespace App\Http\Livewire\Admin;

use App\Http\Controllers\ApplicationsController;
use Livewire\Component;

use App\Models\Payment;
use Illuminate\Support\Facades\Gate;

class PaymentsTable extends DataTable
{
    protected $filter_options = [
        'status' => [
            'name' => 'Status',
            'options' => ['draft' => 'Draft','success' => 'Success','processing' => 'Processing', 'failed' => 'Failed', 'canceled' => 'Canceled'],
            'field' => 'status',
            'filters' => [
                'draft' => 'draft',
                'success' => 'success',
                'processing' => 'processing',
                'failed' => 'failed',
                'canceled' => 'canceled'
            ]
        ],
        'distribution' => [
            'name' => 'Distribution',
            'options' => ['paid' => 'Paid','pending' => 'Pending'],
            'field' => 'status',
            'filters' => [
                'paid' => 'paid',
                'pending' => 'pending',
            ]
        ],
    ];

    public function render()
    {
        $this->emit('selection-reset');
        $this->selected = [];

        $query = Payment::query();
        $filtering = $this->addFilters($query);
        $this->addOrderBy($query);

        if ($this->sort == "" || $this->sort == "default") {
            $query->orderBy("created_at","desc");
        }

        $payments = $query->paginate(config("rotation.pagination_size"));

        return view('admin.livewire.payments',
                [
                    'payments' => $payments,
                    'sort_options' => $this->sort_options,
                    'filter_options' => $this->filter_options,
                    'filtering' => $filtering
                ]
            )->layout('layouts.admin');;
    }

    public function markDistributed() {
        $payments = $this->getSelected(Payment::class);
        foreach($payments as $payment) {
            $payment->distribution_status = 'paid';
            $payment->save();
        }

    }
    public function sendPayment()
    {
        $payments = $this->getSelected(Payment::class);
        foreach ($payments as $value) {
            if ($value->status == 'success' && $value->distribution_status == 'pending') {
                (new ApplicationsController)->rewardEstudent($value);
                (new ApplicationsController)->rewardPreceptor($value);
                (new ApplicationsController)->sendPaymentPreceptor($value);
                $value->distribution_status = 'paid';
                $value->save();
            }
        }
    }
}

