
{{-- Outputs all messages using format string --}}
{{-- Shows all general app messages using Twitter Bootstrap styles --}}
@foreach ($messages->all() as $message)
  <div class="alert {{ $message->type ? 'alert-'.$message->type : '' }}">
	 <button type="button" class="close" data-dismiss="alert">&times;</button>
  		{{ $message }}
  </div>
@endforeach