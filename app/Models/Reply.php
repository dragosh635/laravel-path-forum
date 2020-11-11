<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model {
    use HasFactory;

    /**
     * A reply is made by an user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner() {
        /* Send also the foreign key because the name of the method is not user */
        return $this->belongsTo( User::class, 'user_id' );
    }

    /**
     * A reply belongs to a discussion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discussion() {
        return $this->belongsTo( Discussion::class );
    }
}
