

<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{csrf_token()}}" />

    <title>Favourite Streamer {{$streamer_name}}</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css"/>
</head>
<body>

<div id="app">

    <div class="media" style="margin-top:20px;" v-for="event in events">
        <div class="media-body">
            <h4 class="media-heading">@{{event.title}}</h4>
            <p>
                @{{event.description}}
            </p>
            <span style="color: #aaa;">From @{{event.start_time}} To @{{event.end_time}}</span>
        </div>
    </div>

</div>


<iframe
        src="https://player.twitch.tv/?channel={{$streamer_id}}&muted=true"
        height="350"
        width="700"
        frameborder="0"
        scrolling="no"
        allowfullscreen="true">
</iframe>

<iframe frameborder="0"
        scrolling="yes"
        id="{{$streamer_id}}"
        src="https://www.twitch.tv/embed/{{$streamer_name}}/chat"
        height="350"
        width="400">
</iframe>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

<script>
    const app = new Vue({
        el: '#app',
        data: {
            events: {},
        },
        mounted() {
            this.getEvents();
            this.listen();
        },
        methods: {
            getEvents() {
                // trigger event
                axios.post('/streamer/getLatestEvents',{
                    stream_id: '{{$streamer_id}}'
                })
                    .then((response) => {

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            listen() {
                window.Echo.channel('channel{{$streamer_id}}').listen(".TwitchEvents", (e) => {
                    // console.log(e.events);
                    this.events = e.events.slice(0,10);

                })
            }
        }

    });

</script>

</body>
</html>