@layout('layouts.default')
@section('title')
Watching {{$data->quest->name}}
@endsection
@section('content')
<h2>{{$data->quest->name}}</h2>
	{{$data->quest->instructions}}
	
<hr>
<?php echo Form::open('quest/watch', 'POST', array('class' => '')); ?>

<!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
    <div id="player" class="col-md-8"></div>
    <div id="player" class="col-md-2">
		<h4>@foreach($data->skills as $skill)</h4>
		{{$skill['name']}}
  		    <div class="progress skill-{{$skill['id']}}">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="{{$skill['rewards']['Maximum']}}" style="width: 0%;">
                </div>
            </div>
        <?php echo Form::hidden('skill['.$skill["id"].']', 0, array('id' => 'skill-'.$skill['id'])); ?>

		@endforeach
	</ul>    	

    <div class="form-group">
      {{ Form::submit('Claim Points', array('class' => 'btn btn-primary btn-block btn-submit btn-md', 'data-loading-text' => 'Submitting', 'disabled' => '')); }}
    </div>

    </div>

    <script>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');
        
      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          width: '100%',
          videoId: '{{$data->quest->youtube_id}}',
          playerVars: {'controls': 0, 'autoplay': 0},
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
//        event.target.playVideo();
        var checkinTime = player.getDuration();
        setInterval(checkin, checkinTime);

      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      function checkin() {
          var pct = (player.getCurrentTime()/player.getDuration());

          @foreach($data->skills as $skill)
            var amount = pct * {{$skill['rewards']['Maximum']}};
            $('#skill-{{$skill["id"]}}').val(amount);
          @endforeach
          $('.progress-bar').attr('style', 'width: '+(pct*100)+'%');
          if (pct >= .99) {
            $('.btn-submit').prop('disabled', false);
            @foreach($data->skills as $skill)
                $('#skill-{{$skill["id"]}}').val({{$skill['rewards']['Maximum']}});
            @endforeach
          }
      }

      var done = false;

      function onPlayerStateChange(event) {

      }

      function stopVideo() {
        player.stopVideo();
      }
    </script>


	
		<?php echo Form::hidden('quest_id', $data->quest->id); ?>
		<?php echo Form::hidden('group_id', $data->quest->group_id); ?>
<?php echo Form::close(); ?>

@endsection