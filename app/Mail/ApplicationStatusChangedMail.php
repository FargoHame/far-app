<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Application;

class ApplicationStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $application_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application_id = $application->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $application = Application::find($this->application_id);

        return $this->from(config('mail.from.address'),config('mail.from.name'))
            ->subject('Application status changed')
            ->view('mail.application-status-html')
            ->text('mail.application-status-text')
            ->with([
                'application' => $application
                ]);
    }
}
