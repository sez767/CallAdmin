<li>
	<a href="#">{{$active}}</a>
	<ul>
		@foreach ($languages as $language)
			<li>
				@if($language !== $active)
					<a href="{{ route('lang.switch', $language) }}">{{$language}}</a>
				@endif
			</li>
		@endforeach
	</ul>
</li>