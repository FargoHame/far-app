<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Application;

class NewApplicationMail extends Mailable
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
            ->subject('New application received')
            ->view('mail.new-application-html')
            ->text('mail.new-application-text')
            ->with([
                'preceptor' => $application->rotation->preceptor,
                'student' => $application->student,
                'application' => $application
                ]);
    }
}
