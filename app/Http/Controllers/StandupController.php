<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maknz\Slack\Message;

class StandupController extends Controller
{
    public function send(Request $request)
    {
        $yesterday = $request->input('yesterday');
        $today = $request->input('today');
        $challenges = $request->input('challenges');
        $who = $request->input('who');
        $url = config('services.slack.webhook_url');

        $settings = [
            'channel'    => config('services.slack.channel'),
            'link_names' => true,
        ];

        $client = new \Maknz\Slack\Client($url, $settings);
        $message = new Message($client);

        $message->send("

*$who*
_Yesterday I accomplished_
$yesterday

_Today I will accomplish:_
$today

_Challenges stopping me today_
$challenges

");

        return redirect('/thanks');
    }

    public function thanks()
    {
        return view('thanks');
    }
}
