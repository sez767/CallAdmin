@extends('layouts.app', ['page' => __('Products Search'), 'pageSlug' => 'products_search'])


@section('css')
	
@stop

@section('content')
    <div class="page-section" style="padding-top:15px;">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<div class="cs-search-result">
						@if(!$products->count())
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="section-title">
								<h2 style="letter-spacing:0 !important; margin-bottom:15px;">No Pages Were Found Containing "your added text"</h2>
							</div>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
							<div class="cs-seggetions">
								<div class="cs-heading">
									<h4>Suggestions:</h4>
								</div>
								<ul>
									<li><i class="icon-check cs-color"></i>Make sure all words are spelled correctly</li>
									<li><i class="icon-check cs-color"></i>Wildcard searches (using the asterisk *) are not supported</li>
									<li><i class="icon-check cs-color"></i>Try more general keywords, especially if you are attempting a name</li>
								</ul>
								<div class="cs-form">
									<form>
										<div class="input-holder">
											<input type="text" placeholder="Search by Keyword">
											<input type="submit" value="">
											<i class="icon-search"></i>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="section-title">
								<h2 style="letter-spacing:0 !important; margin-bottom:30px;">Most Relevent Links</h2>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="cs-relevent-links">
								<ul>
									<li>
										<div class="cs-media">
											<figure><a href="#"><img src="assets/extra-images/auto-search-01.jpg" alt=""></a></figure>
										</div>
										<div class="cs-text">
											<span>On January 15, 2015.</span>
											<h4><a href="#">Speed Dual-Clutch Featured Special New ReLease</a></h4>
											<p>Tempor eleifend augue vulputate posuere ante posuere pharetra augue iaculis proin, platea curae mattis quam donec vivamus mattis sagittis nam vivamus vulputate nullam sodales semper.</p>
											<a href="#" class="cs-color">http://www.sant.ox.ac.uk/mec/MEClectures/20Constitution.pdf</a>
										</div>
									</li>
									<li>
										<div class="cs-media">
											<figure><a href="#"><img src="assets/extra-images/auto-search-02.jpg" alt=""></a></figure>
										</div>
										<div class="cs-text">
											<span>On January 15, 2015.</span>
											<h4><a href="#">Speed Dual-Clutch Featured Special New ReLease</a></h4>
											<p>Tempor eleifend augue vulputate posuere ante posuere pharetra augue iaculis proin, platea curae mattis quam donec vivamus mattis sagittis nam vivamus vulputate nullam sodales semper.</p>
											<a href="#" class="cs-color">http://www.sant.ox.ac.uk/mec/MEClectures/20Constitution.pdf</a>
										</div>
									</li>
								</ul>
							</div>
						</div>
						@else
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="section-title">
								<h2 style="letter-spacing:0 !important; margin-bottom:30px;">{{ __('common.page.search.result', ['amount' => $products->count(), 'request' => request()->product_name]) }}</h2>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="cs-relevent-links">
								<ul>
									@foreach($products as $product)
										<li>
											<div class="cs-media">
												@if($product->images->count())
													<figure>
														<a href="{{route('products.show', ['product' => $product->id])}}">
															<img
																src="{{'/storage/productImages/'.$product->images[0]->image}}"
																alt="{{$product->images[0]->image_alt}}"
																class="search-prod-img"
															>
														</a>
													</figure>
												@endif
											</div>
											<div class="cs-text">
												<span>{{$product->created_at}}</span>
												<h4><a href="{{route('products.show', ['product' => $product->id])}}"
															>{{$product->name}}</a></h4>
												<p>{{$product->description}}</p>
											</div>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	{{ $products->links() }}
@endsection

@section('scripts')

@stop