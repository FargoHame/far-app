<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Message;
use App\Models\User;

class NewMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $message_id;
    protected $send_to_user_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Message $message, User $send_to_user)
    {
        $this->message_id = $message->id;
        $this->send_to_user_id = $send_to_user->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = Message::find($this->message_id);
        $send_to_user = User::find($this->send_to_user_id);

        return $this->from(config('mail.from.address'),config('mail.from.name'))
            ->subject('New message received')
            ->view('mail.new-message-html')
            ->text('mail.new-nessage-text')
            ->with([
                'm' => $message,
                'send_to_user' => $send_to_user
                ]);
    }
}
