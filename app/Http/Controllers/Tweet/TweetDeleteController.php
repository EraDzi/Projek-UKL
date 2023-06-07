<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class TweetDeleteController extends Controller
{
    /**
     * Remove the specified tweet from storage.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Tweet $tweet): RedirectResponse
    {
        $tweet->delete();
        return Redirect::back();
    }
}
