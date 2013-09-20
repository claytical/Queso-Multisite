@layout('layouts.default')
@section('content')

<h2>Setup</h2>
<div class="container">
    <div class="row">
        <ul id="settingsTab" class="nav nav-tabs">
          <li><a href="#general">General</a></li>
          <li><a href="#skills">Skills</a></li>
          <li><a href="#levels">Levels</a></li>
          <li><a href="#share">Share</a></li>
        </ul>
    </div>
    <div class="tab-content">
       
        <div class="tab-pane" id="general">
        @include('courses.setup')
        </div>
        
        <div class="tab-pane" id="skills">
        @include('skills.panel')
        </div>
        
        <div class="tab-pane" id="levels">
        @include ('levels.panel')
        </div>
        
        <div class="tab-pane" id="share">
        @include ('courses.sharing')
        </div>
    </div>
</div>
<script>
$('#settingsTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});
if(window.location.hash.length == 0)  {
    $('#settingsTab a[href="#general"]').tab('show');    
}
else {
    $('#settingsTab a[href="'+window.location.hash+'"]').tab('show');
}
</script>
@endsection