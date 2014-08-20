@layout('layouts.notloggedin')
@section('content')
     <div class="page-header">
         <div class="container">
<!--         <img src="img/logo.png" style="width: 250px;" class="pull-right">-->
            <h1>Credits</h1>
            <p class="lead">Queso would not be possible without a number of contributions to the open source community.</p>
			<ul class="list-unstyled">
				<li><a href="http://getbootstrap.com/">Twitter Bootstrap</a></li>
				<li><a href="http://www.laravel.com">Laravel</a></li>
				<li><a href="http://glyphicons.com/">Glyphicons</a></li>
			</ul>            
         </div>
	  </div>

      <footer>
				<div class="col-md-12">
					<div class="col-md-6">&copy; Clay Ewing 2013</div>
					<div class="col-md-6">
						<div class="pull-right"><a href="{{URL::to('credits')}}">Credit where credit is due</a></div>
					</div>
					
				</div>

      </footer>
    </div>
@endsection