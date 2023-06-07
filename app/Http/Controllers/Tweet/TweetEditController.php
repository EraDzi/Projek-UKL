<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TweetEditController extends Controller
{
    /**
     * Show the form for editing the specified tweet.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\View\View
     */
    public function edit(Tweet $tweet): View
    {
        return view('tweets.tweet-edit', compact('tweet'));
    }

    /**
     * Update the specified tweet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tweet $tweet): RedirectResponse
    {
        $tweet->content = $request->input('content');
        $tweet->save();
        return redirect()->route('dashboard');
    }
}
