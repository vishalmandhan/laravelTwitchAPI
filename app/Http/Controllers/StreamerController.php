<?php

namespace App\Http\Controllers;

use App\Events\TwitchEvents;
use Illuminate\Http\Request;
use App\Services\TwitchApi;

class StreamerController extends Controller
{
    //
    public function favoriteStreamer(Request $request) {

        $name = $request->twitch_streamer;

        $twitchObj = new TwitchApi();

        $streamer_data = $twitchObj->getStreamerInfo($name);

        if(!empty($streamer_data->error) ) {
            return response()->json(['error_message'=> $streamer_data->message]);
        }
        if(empty($streamer_data->_id) ) {
            return response()->json(['error_message'=> 'API error']);
        }

//        $events_data = $twitchObj->getTwitchEvents($streamer_data->_id);

//        if(!empty($events_data->error)) {
//            return response()->json(['error_message'=> $events_data->message]);
//        }

        event(new TwitchEvents($streamer_data->_id));

        return view('stream', [
            'streamer_id' => $streamer_data->_id,
            'streamer_name' => $name
        ]);
    }

    public function streamPageEvents(Request $request) {
        $streamId = $request->stream_id;

        event(new TwitchEvents($streamId));
    }
}
