@layout('layouts.default')
@section('content')
<h2>{{ $quest->name }}</h2> 
<script type="text/javascript" src="{{ URL::to('js/plugins/qr/jsqrcode-combined.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::to('js/plugins/qr/html5-qrcode.js')}}"></script>


<p class="lead">{{ $quest->instructions }}</p>

		<?php echo Form::open('quest/redeem', 'POST', array('class' => 'form-inline', 'id' => 'redeem-form')); ?>
		<p id="qr_instructions">You can hold the QR code up to your webcam to scan it, or enter the redemption code manually if you prefer.</p>

		<div id="reader" style="width:250px;height:250px">
		 </div>
		  <div class="form-group">
		    <input class="form-control" type="text" id="code" name="code" placeholder="Redemption Code">
		  </div>
			{{ Form::submit('Redeem', array('class' => 'btn-default btn', 'data-loading-text' => 'Redeeming')); }}
			<?php echo Form::hidden('quest_id', $quest->id); ?>
		
			<?php echo Form::close(); ?>
					
		</form>
<script>
$('#reader').html5_qrcode(function(data){
        $('#code').val(data);
        $('#reader').html5_qrcode_stop();
        $('#redeem-form').submit();
    },
    function(error){
        //show read errors 
    }, function(videoError){
    	$('#qr_instructions').hide();
    	$('#reader').hide();
        //the video stream could be opened
    }
);
</script>

@endsection