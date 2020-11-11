<?php

namespace App\Models;

use App\Notifications\ReplyMarkedAsBestReply;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discussion extends Model {
    use HasFactory;

    /**
     * When doing route model binding use the slug to find the model instead of the id
     *
     * @return string
     */
    public function getRouteKeyName() {
        return 'slug';
    }

    /**
     * The discussion is made by an author
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author() {
        /* Send also the foreignKey param because the name of the method is not user */
        return $this->belongsTo( User::class, 'user_id' );
    }

    /**
     * A discussion has many replies
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies() {
        return $this->hasMany( Reply::class );
    }

    /**
     * Mark a reply as best reply
     *
     * @param Reply $reply
     */
    public function markAsBestReply( Reply $reply ) {
        $this->update( [
            'reply_id' => $reply->id,
        ] );

        /* If the owner of the reply is the same as the discussion's author, do not send the notification */
        if ( $reply->owner->id === $this->author->id ) {
            return;
        }

        $reply->owner->notify( new ReplyMarkedAsBestReply( $reply->discussion ) );
    }

    /**
     * A discussion has a single best reply
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bestReply() {
        return $this->belongsTo( Reply::class, 'reply_id' );
    }

    /**
     * Filter reply by channels
     *
     * @param $builder
     *
     * @return mixed
     */
    public function scopeFilterByChannels( $builder )
    {
        if ( request()->query('channel') ) {
            $channel = Channel::where('slug', request()->query('channel'))->first();

            if ( $channel ) {
                return $builder->where('channel_id', $channel->id );
            }
        }

        return $builder;
    }
}
