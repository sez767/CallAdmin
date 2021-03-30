<div class="row flex-row-center">
	<div class="section-fullwidtht col-lg-8 col-md-8 col-sm-8 col-xs-8">
		@switch($type)
			@case('success')
		        <div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>	
					<strong>{!! $message !!}</strong>
				</div>
		        @break
			@case('error')
		        <div class="alert alert-danger alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>	
					<strong>{!! $message !!}</strong>
				</div>
		        @break
		    @case('errors')
		        <div class="alert alert-danger alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>	
					<ul>
			            @foreach ($errors as $error)
			                <li><strong>{{ $error }}</strong></li>
			            @endforeach
			        </ul>
				</div>
		        @break
			@case('info')
		        <div class="alert alert-info alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>	
					<strong>{!! $message !!}</strong>
				</div>
		        @break
			@case('warning')
		        <div class="alert alert-warning alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>	
					<strong>{!! $message !!}</strong>
				</div>
		        @break
			@default
				@isset($errors)
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">×</button>	
						Please check the form below for errors
					</div>
				@endisset
		@endswitch
		</div>
</div>