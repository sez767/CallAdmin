<!-- Header Start -->
<header id="header">
	<div class="container">
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
				<div class="cs-logo">
					<div class="cs-media">
						<figure><a href="{{ route('home') }}"><img src="{{ asset('images/AYug_white.svg') }}" alt="" /></a></figure>
					</div>
				</div>
			</div>
			<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
				<div class="cs-main-nav pull-right">
					<nav class="main-navigation">
						<ul>
							<li><a href="{{ route('home') }}">{{__('common.page.main.name')}}</a></li>
							<li><a href="about-us.html">About Us</a></li>
							<li><a href="{{ route('products.list') }}">{{__('common.products.menu_item')}}</a></li>
							<!-- <li><a href="#">Dealers</a>
								<ul>
									<li><a href="agent-listing.html">List View</a></li>
									<li><a href="agent-detail.html">Detail Page</a></li>
								</ul>
							</li>
							<li><a href="#">Compare</a>
								<ul>
									<li><a href="compare.html">Listing</a></li>
								</ul>
							</li>
							<li><a href="#">pages</a>
								<ul>
									<li><a href="services.html">Our Services</a></li>
									<li><a href="user-post-new-vehicles.html">Post a Vehicle</a></li>
									<li><a href="price-plane.html">Listing Packages</a></li>
									<li><a href="faq.html">FAQ's & Help</a></li>
									<li><a href="404.html">404 Page</a></li>
									<li><a href="search-result.html">Search Result</a></li>
									<li><a href="underconstruction.html">Under Construction</a></li>
                                    <li><a href="underconstruction-2.html">Under Construction 2</a></li>
									<li><a href="signin-page.html">Signup/Sign in</a></li>
									<li><a href="contact-us.html">Contact us</a></li>
									
								</ul>
							</li>
							<li><a href="#">News</a>
								<ul>
									<li><a href="blog-listing-large.html">Large View</a></li>
									<li><a href="blog-listing-medium.html">Medium View</a></li>
									<li><a href="blog-listing-grid.html">Grid View</a></li>
									<li class="menu-item-has-children"><a href="#">Detail View</a>
										<ul>
											<li><a href="blog-detail-sound.html">With Audio</a></li>
											<li><a href="blog-detail-video.html">With Video</a></li>
											<li><a href="blog-detail-sound.html">With Soundcloud</a></li>
											<li><a href="blog-detail-slider.html">With Slider</a></li>
											<li><a href="blog-detail-post.html">Featured Image</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Shop</a>
								<ul>
									<li><a href="shop-listing.html">Products</a></li>
									<li><a href="shop-detail.html">Detail View</a></li>
									<li><a href="shop-cart.html">Cart</a></li>
									<li><a href="shop-checkout.html">Checkout</a></li>
								</ul>
							</li> -->
							<x-language />
							<li class="cs-user-option">
								<div class="cs-login">
									@if (Auth::user())
									<div class="cs-login-dropdown"> <a href="#"><i class="icon-user2"></i> {{Auth::user()->nick}} <i class="icon-chevron-down2"></i></a>
										<div class="cs-user-dropdown"> <strong>{{ __('common.user.nav.name') }}</strong>
											<ul>
												<li><a href="{{ route('adminboard') }}">{{ __('common.user.nav.managing_page') }}</a></li>
											</ul>
											<form action="{{ route('logout') }}" method="POST">
											    @csrf
											    <input
											    	type="submit"
											    	class="btn-submit-sign-out btn-sign-out"
											    	value="{{__('auth.logout')}}"
											    >
											</form>
										</div>
									</div>
									@endif
									@if (Auth::guest())
									<a class="cs-bgcolor btn-form" data-toggle="modal" href="remote.html" data-target="#user-sign-in" aria-hidden="true"><i class="icon-plus"></i> {{ __('common.btn.account') }}</a> 
									<!-- Modal -->
									<div class="modal fade" id="user-sign-up" tabindex="-1" role="dialog">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												</div>
												<div class="modal-body">
													<h4>{{ __('common.page.sign_in.name') }}</h4>
													<div class="cs-login-form">
														<form method="POST" action="{{ route('register') }}">
															@csrf
															<div class="input-holder">
																<label for="cs-username"> <strong>{{ __('common.user.name') }}</strong> <i class="icon-user-plus2"></i>
																	<input
																		id="cs-username"
																		class="form-control @error('name') is-invalid @enderror"
																		name="name"
																		type="text"
																		value="{{ old('name') }}"
																		required
																		placeholder="{{__('auth.placeholders.username')}}"
																	>
																</label>
															</div>
															<div class="input-holder">
																<label for="cs-email"> <strong>{{ __('common.user.email') }}</strong> <i class="icon-envelope"></i>
																	<input
																		type="email"
																		class="form-control @error('email') is-invalid @enderror"
																		name="email"
																		value="{{ old('email') }}"
																		required
																		id="cs-email"
																		placeholder="{{__('auth.placeholders.email')}}"
																	>
																</label>
															</div>
															<div class="input-holder">
																<label for="cs-login-password">
																	<strong>{{ __('common.user.password') }}</strong>
																	 <i class="icon-unlock40"></i>
																	<input
																		type="password"
																		id="cs-login-password"
																		placeholder="********"
																		class="form-control @error('password') is-invalid @enderror"
																		name="password"
																		required
																	>
																</label>
															</div>
															<div class="input-holder">
																<label for="cs-confirm-password">
																	<strong>{{ __('common.user.confirm_password') }}</strong>
																	 <i class="icon-unlock40"></i>
																	<input
																		type="password"
																		id="cs-confirm-password"
																		placeholder="********"
																		name="password_confirmation"
																		required
																	>
																</label>
															</div>
															<div class="input-holder">
																<input
																	class="cs-color csborder-color"
																	type="submit"
																	value="{{ __('common.btn.register') }}"
																>
															</div>
														</form>
													</div>
												</div>
												<x-social-network :mainClass="'modal-footer'" :isSignUp="true" />
											</div>
										</div>
									</div>
									<div class="modal fade" id="user-sign-in" tabindex="-1" role="dialog">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header justify-content-end">
													<button type="button" class="d-flex justify-content-center align-items-center close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												</div>
												<div class="modal-body">
													<h4>{{__('auth.sign_in')}}</h4>
													<div class="cs-login-form">
														<form method="post" action="{{ route('login') }}">
															@csrf
															<div class="input-holder">
																<label for="cs-username-1"> <strong>{{ __('common.user.email') }}</strong> <i class="icon-user-plus2"></i>
																	<input
																		type="email"
																		name="email"
																		class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
																		id="cs-username-1"
																		placeholder="{{__('auth.placeholders.email')}}"
																	>
																</label>
															</div>
															<div class="input-holder">
																<label for="cs-login-password-1"> <strong>{{ __('common.user.password') }}</strong> <i class="icon-unlock40"></i>
																	<input
																		type="password"
																		id="cs-login-password-1"
																		placeholder="********"
																		name="password"
																		class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
																	>
																</label>
															</div>
															<!-- <div class="input-holder"> <a class="btn-forgot-pass" data-dismiss="modal" data-target="#user-forgot-pass" data-toggle="modal" href="javascript:;" aria-hidden="true"><i class=" icon-question-circle"></i> {{__('auth.password_forgot')}}</a> </div> -->
															<div class="input-holder">
																<input
																	class="cs-color csborder-color"
																	type="submit"
																	value="{{__('auth.sign_in')}}"
																>
															</div>
														</form>
													</div>
												</div>
												<!-- <x-social-network :mainClass="'modal-footer'" /> -->
											</div>
										</div>
									</div>
									<div class="modal fade" id="user-forgot-pass" tabindex="-1" role="dialog">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												</div>
												<div class="modal-body">
													<h4>Password Recovery</h4>
													<div class="cs-login-form">
														<form>
															<div class="input-holder">
																<label for="cs-email-1"> <strong>Email</strong> <i class="icon-envelope"></i>
																	<input type="email" class="" id="cs-email-1" placeholder="Type desired username">
																</label>
															</div>
															<div class="input-holder">
																<input class="cs-color csborder-color" type="submit" value="Send">
															</div>
														</form>
													</div>
												</div>
												<div class="modal-footer">
													<div class="cs-user-signup"> <i class="icon-user-plus2"></i> <strong>Not a Member yet? </strong> <a href="javascript:;" data-toggle="modal" data-target="#user-sign-up" data-dismiss="modal" class="cs-color" aria-hidden="true">Signup Now</a> </div>
												</div>
											</div>
										</div>
									</div>
									@endif
								</div>
								<!--<div class="cs-wish-list"><a href="#"><i class=" icon-heart4"></i><span>0</span></a>
                                    <div class="wish-list-dropdown">
                                        <strong>Post a new Ad</strong>
                                        <ul>
                                            <li class="alert alert-dismissible  fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <div class="cs-media">
                                                    <a href="#">
                                                        <img src="assets/extra-images/single-banner-img-1.jpg" alt="" />
                                                    </a>
                                                </div>
                                                <div class="cs-info">
                                                    <h6><a href="#">Desktop Application Developer Support</a></h6>
                                                    Added <span>Feb 8, 2016</span>
                                                </div>
                                            </li>
                                            <li class="alert alert-dismissible  fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <div class="cs-media">
                                                    <a href="#">
                                                        <img src="assets/extra-images/single-banner-img-2.jpg" alt="" />
                                                    </a>
                                                </div>
                                                <div class="cs-info">
                                                    <h6><a href="#">Desktop Application Developer Support</a></h6>
                                                    Added <span>Feb 8, 2016</span>
                                                </div>
                                            </li>
                                            <li class="alert alert-dismissible  fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <div class="cs-media">
                                                    <a href="#">
                                                        <img src="assets/extra-images/single-banner-img-3.jpg" alt="" />
                                                    </a>
                                                </div>
                                                <div class="cs-info">
                                                    <h6><a href="#">Desktop Application Developer Support</a></h6>
                                                    Added <span>Feb 8, 2016</span>
                                                </div>
                                            </li>
                                            <li class="alert alert-dismissible  fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <div class="cs-media">
                                                    <a href="#">
                                                        <img src="assets/extra-images/single-banner-img-1.jpg" alt="" />
                                                    </a>
                                                </div>
                                                <div class="cs-info">
                                                    <h6><a href="#">Desktop Application Developer Support</a></h6>
                                                    Added <span>Feb 8, 2016</span>
                                                </div>
                                            </li>
                                            <li class="alert alert-dismissible  fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <div class="cs-media">
                                                    <a href="#">
                                                        <img src="assets/extra-images/single-banner-img-2.jpg" alt="" />
                                                    </a>
                                                </div>
                                                <div class="cs-info">
                                                    <h6><a href="#">Desktop Application Developer Support</a></h6>
                                                    Added <span>Feb 8, 2016</span>
                                                </div>
                                            </li>
                                            <li class="alert alert-dismissible  fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <div class="cs-media">
                                                    <a href="#">
                                                        <img src="assets/extra-images/single-banner-img-3.jpg" alt="" />
                                                    </a>
                                                </div>
                                                <div class="cs-info">
                                                    <h6><a href="#">Desktop Application Developer Support</a></h6>
                                                    Added <span>Feb 8, 2016</span>
                                                </div>
                                            </li>
                                        </ul>
                                        <a class="btn-view-all" href="#">View All</a>
                                    </div>
                                </div>--> 
							</li>
						</ul>
					</nav>
                    <div class="cs-user-option hidden-lg visible-sm visible-xs">
						<div class="cs-login">
							<div class="cs-login-dropdown"> <a href="#"><i class="icon-user2"></i> Kaiser <i class="icon-chevron-down2"></i></a>
								<div class="cs-user-dropdown"> <strong>Post a new Ad</strong>
									<ul>
										<li><a href="user-genral-setting.html">General Setting<span class="cs-bgcolor">3</span></a></li>
										<li><a href="user-car-listing.html">My Posted Cars <span class="cs-bgcolor">23</span></a></li>
										<li><a href="user-post-new-vehicles.html">Post New Car</a></li>
										<li><a href="user-car-shortlist.html">Shortlisted</a></li>
										<li><a href="user-payments.html">Payment</a></li>
										<li><a href="user-packages.html">Packages</a></li>
									</ul>
									<a class="btn-sign-out" href="#">Logout</a> </div>
							</div>
							<a class="cs-bgcolor btn-form" data-toggle="modal" href="remote.html" data-target="#user-sign-up-sm" aria-hidden="true"><i class="icon-plus"></i> Sell Car</a> 
							<!-- Modal -->
							<div class="modal fade" id="user-sign-up-sm" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										</div>
										<div class="modal-body">
											<h4>Create Account</h4>
											<div class="cs-login-form">
												<form>
													<div class="input-holder">
														<label for="cs-username11"> <strong>USERNAME</strong> <i class="icon-user-plus2"></i>
															<input type="text" class="" id="cs-username11" placeholder="Type desired username">
														</label>
													</div>
													<div class="input-holder">
														<label for="cs-email11"> <strong>Email</strong> <i class="icon-envelope"></i>
															<input type="email" class="" id="cs-email11" placeholder="Type desired username">
														</label>
													</div>
													<div class="input-holder">
														<label for="cs-login-password11"> <strong>Password</strong> <i class="icon-unlock40"></i>
															<input type="password" id="cs-login-password11" placeholder="******">
														</label>
													</div>
													<div class="input-holder">
														<label for="cs-confirm-password11"> <strong>confirm password</strong> <i class="icon-unlock40"></i>
															<input type="password" id="cs-confirm-password11" placeholder="******">
														</label>
													</div>
													<div class="input-holder">
														<input class="cs-color csborder-color" type="submit" value="Create Account">
													</div>
												</form>
											</div>
										</div>
										<div class="modal-footer"> <a data-dismiss="modal" data-target="#user-sign-in-sm" data-toggle="modal" href="javascript:;" aria-hidden="true">Already have account</a>
											<div class="cs-separator"><span>or</span></div>
											<div class="cs-user-social"> <em>Signin with your Social Networks</em>
												<ul>
													<li><a href="#" data-original-title="facebook"><i class="icon-facebook-f"></i>facebook</a></li>
													<li><a href="#" data-original-title="twitter"><i class="icon-twitter4"></i>twitter</a></li>
													<li><a href="#" data-original-title="google-plus"><i class="icon-google4"></i>google</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="user-sign-in-sm" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										</div>
										<div class="modal-body">
											<h4>User Sign in</h4>
											<div class="cs-login-form">
												<form>
													<div class="input-holder">
														<label for="cs-username-111"> <strong>USERNAME</strong> <i class="icon-user-plus2"></i>
															<input type="text" class="" id="cs-username-111" placeholder="Type desired username">
														</label>
													</div>
													<div class="input-holder">
														<label for="cs-login-password-111"> <strong>Password</strong> <i class="icon-unlock40"></i>
															<input type="password" id="cs-login-password-111" placeholder="******">
														</label>
													</div>
													<div class="input-holder"> <a class="btn-forgot-pass" data-dismiss="modal" data-target="#user-forgot-pass-sm" data-toggle="modal" href="javascript:;" aria-hidden="true"><i class=" icon-question-circle"></i> Forgot password?</a> </div>
													<div class="input-holder">
														<input class="cs-color csborder-color" type="submit" value="SIGN IN">
													</div>
												</form>
											</div>
										</div>
										<div class="modal-footer">
											<div class="cs-separator"><span>or</span></div>
											<div class="cs-user-social"> <em>Signin with your Social Networks</em>
												<ul>
													<li><a href="#" data-original-title="facebook"><i class="icon-facebook-f"></i>facebook</a></li>
													<li><a href="#" data-original-title="twitter"><i class="icon-twitter4"></i>twitter</a></li>
													<li><a href="#" data-original-title="google-plus"><i class="icon-google4"></i>google</a></li>
												</ul>
											</div>
											<div class="cs-user-signup"> <i class="icon-user-plus2"></i> <strong>Not a Member yet? </strong> <a class="cs-color" data-dismiss="modal" data-target="#user-sign-up-sm" data-toggle="modal" href="javascript:;" aria-hidden="true">Signup Now</a> </div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="user-forgot-pass-sm" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										</div>
										<div class="modal-body">
											<h4>Password Recovery</h4>
											<div class="cs-login-form">
												<form>
													<div class="input-holder">
														<label for="cs-email-111"> <strong>Email</strong> <i class="icon-envelope"></i>
															<input type="email" class="" id="cs-email-111" placeholder="Type desired username">
														</label>
													</div>
													<div class="input-holder">
														<input class="cs-color csborder-color" type="submit" value="Send">
													</div>
												</form>
											</div>
										</div>
										<div class="modal-footer">
											<div class="cs-user-signup"> <i class="icon-user-plus2"></i> <strong>Not a Member yet? </strong> <a href="javascript:;" data-toggle="modal" data-target="#user-sign-up-sm" data-dismiss="modal" class="cs-color" aria-hidden="true">Signup Now</a> </div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--<div class="cs-wish-list"><a href="#"><i class=" icon-heart4"></i><span>0</span></a>
                        <div class="wish-list-dropdown">
                            <strong>Post a new Ad</strong>
                            <ul>
                                <li class="alert alert-dismissible  fade in" role="alert">

                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="cs-media">
                                        <a href="#">
                                            <img src="assets/extra-images/single-banner-img-1.jpg" alt="" />
                                        </a>
                                    </div>
                                    <div class="cs-info">
                                        <h6><a href="#">Desktop Application Developer Support</a></h6>
                                        Added <span>Feb 8, 2016</span>
                                    </div>
                                </li>
                                <li class="alert alert-dismissible  fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="cs-media">
                                        <a href="#">
                                            <img src="assets/extra-images/single-banner-img-2.jpg" alt="" />
                                        </a>
                                    </div>
                                    <div class="cs-info">
                                        <h6><a href="#">Desktop Application Developer Support</a></h6>
                                        Added <span>Feb 8, 2016</span>
                                    </div>
                                </li>
                                <li class="alert alert-dismissible  fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="cs-media">
                                        <a href="#">
                                            <img src="assets/extra-images/single-banner-img-3.jpg" alt="" />
                                        </a>
                                    </div>
                                    <div class="cs-info">
                                        <h6><a href="#">Desktop Application Developer Support</a></h6>
                                        Added <span>Feb 8, 2016</span>
                                    </div>
                                </li>
                                <li class="alert alert-dismissible  fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="cs-media">
                                        <a href="#">
                                            <img src="assets/extra-images/single-banner-img-1.jpg" alt="" />
                                        </a>
                                    </div>
                                    <div class="cs-info">
                                        <h6><a href="#">Desktop Application Developer Support</a></h6>
                                        Added <span>Feb 8, 2016</span>
                                    </div>
                                </li>
                                <li class="alert alert-dismissible  fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="cs-media">
                                        <a href="#">
                                            <img src="assets/extra-images/single-banner-img-2.jpg" alt="" />
                                        </a>
                                    </div>
                                    <div class="cs-info">
                                        <h6><a href="#">Desktop Application Developer Support</a></h6>
                                        Added <span>Feb 8, 2016</span>
                                    </div>
                                </li>
                                <li class="alert alert-dismissible  fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="cs-media">
                                        <a href="#">
                                            <img src="assets/extra-images/single-banner-img-3.jpg" alt="" />
                                        </a>
                                    </div>
                                    <div class="cs-info">
                                        <h6><a href="#">Desktop Application Developer Support</a></h6>
                                        Added <span>Feb 8, 2016</span>
                                    </div>
                                </li>
                            </ul>
                            <a class="btn-view-all" href="#">View All</a>
                        </div>
                    </div>--> 
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- Header End --> 