<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDiscussionRequest;
use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiscussionsController extends Controller {

    /**
     * DiscussionsController constructor.
     */
    public function __construct() {
        /* Check if the user is authenticated and if his email is verified for this two actions */
        $this->middleware( [ 'auth', 'verified' ] )->only( [ 'create', 'store' ] );
    }

    /**
     * Show the discussions page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        return view( 'discussions.index', [
            'discussions' => Discussion::filterByChannels()->paginate( 5 ),
        ] );
    }

    /**
     * Create a discussion form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create() {
        return view( 'discussions.create' );
    }

    /**
     * Save discussion
     *
     * @param CreateDiscussionRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( CreateDiscussionRequest $request ) {

        /* automatically assign the discussion to the authenticated user */
        auth()->user()->discussions()->create( [
            'title'      => $request->title,
            'slug'       => Str::slug( $request->title ),
            'content'    => $request->content,
            'channel_id' => $request->channel,
        ] );

        session()->flash( 'success', 'Discussion posted.' );

        return redirect()->route( 'discussions.index' );
    }

    /**
     * Display a single discussion
     *
     * @param Discussion $discussion
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show( Discussion $discussion ) {

        return view( 'discussions.show', [
            'discussion' => $discussion,
        ] );
    }

    /**
     * Mark a reply from the discussion as best reply
     *
     * @param Discussion $discussion
     * @param Reply $reply
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reply( Discussion $discussion, Reply $reply ) {
        $discussion->markAsBestReply( $reply );

        session()->flash( 'success', 'Marked as best reply' );

        return redirect()->back();
    }
}
