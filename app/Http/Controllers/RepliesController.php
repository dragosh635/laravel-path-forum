<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReplyRequest;
use App\Models\Discussion;
use App\Notifications\NewReplyAdded;

class RepliesController extends Controller {
    /**
     * Save a reply
     *
     * @param CreateReplyRequest $request
     * @param Discussion $discussion
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( CreateReplyRequest $request, Discussion $discussion ) {
        /* Automatically assign this reply to the authenticated user */
        auth()->user()->replies()->create( [
            'discussion_id' => $discussion->id,
            'content'       => $request->content,
        ] );

        /* If the user making the reply is in fact the author of the discussion, do not send him the notification */
        if ( $discussion->author->id === auth()->user()->id ) {
            $discussion->author->notify( new NewReplyAdded( $discussion ) );
        }

        session()->flash( 'success', 'Reply Added' );

        return redirect()->back();
    }
}
