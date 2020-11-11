<?php

namespace App\Notifications;

use App\Models\Discussion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReplyMarkedAsBestReply extends Notification implements ShouldQueue {
    use Queueable;

    /**
     * The discussion where the reply was made
     *
     * @var Discussion
     */
    public $discussion;

    /**
     * Create a new notification instance.
     *
     * @param Discussion $discussion
     */
    public function __construct( $discussion ) {
        $this->discussion = $discussion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via( $notifiable ) {
        return [ 'mail', 'database' ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail( $notifiable ) {
        return ( new MailMessage )
            ->line( 'Your reply was marked as best reply' )
            ->action( 'View Discussions', route( 'discussions.show', $this->discussion->slug ) )
            ->line( 'Thank you for using our application!' );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray( $notifiable ) {
        return [
            'discussion' => $this->discussion,
        ];
    }
}
