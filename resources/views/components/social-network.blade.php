<div class="{{$mainClass}}">
	@if($isSignUp)
		<a data-dismiss="modal" data-target="#user-sign-in" data-toggle="modal" href="javascript:;" aria-hidden="true">{{ __('common.user.has_account') }}</a>
	@endif
    <div class="cs-separator"><span>{{ __('common.or') }}</span></div>
	<div class="cs-user-social"> <em>{{ __('auth.network_sign_in') }}</em>
		<ul>
			<li><a href="#" data-original-title="facebook"><i class="icon-facebook-f"></i>facebook</a></li>
			<li><a href="#" data-original-title="twitter"><i class="icon-twitter4"></i>twitter</a></li>
			<li><a href="#" data-original-title="google-plus"><i class="icon-google4"></i>google</a></li>
		</ul>
	</div>
	@if(!$isSignUp)
		<div class="cs-user-signup"> 
			<i class="icon-user-plus2"></i> 
			<strong>{{__('auth.hasnt_account')}} </strong> 
			<a
				class="cs-color"
				data-dismiss="modal"
				data-target="#user-sign-up"
				data-toggle="modal"
				href="javascript:;"
				aria-hidden="true"
			>{{__('auth.sign_up')}}</a> 
		</div>
	@endif
</div>