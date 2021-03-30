@extends('layouts.app', ['page' => __('Product Show'), 'pageSlug' => 'product_show'])


@section('css')
<link href="{{ asset('css/woocommerce.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="main-section"> 
		<div class="page-section">
        	<div class="container">
            	<div class="row">
                	<div class="section-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<div class="row">
                            <div class="page-content col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                <div class="row">
                                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                     	<div class="site-main">
                                            <div class="columns-3">
                                                <ul class="products">
                                                    @foreach ($products as $product)
                                                    <li class="product">
                                                        <a href="{{route('public_product_show', ['product' => $product->id])}}" >
                                                            <img src="{{'/storage/productImages/'.$product->images->first()->image}}" alt="shop" />
                                                            <h5>{{$product->name}}</h5>
															@if (Auth::user())
	                                                            <span class="price">
	                                                                <span class="amount">{{$product->price}}</span>
	                                                            </span>
                                                            @endif
                                                            <div title="Rated 5 out of 5" class="star-rating">
                                                            	<span style="width:66%"><strong class="rating">5</strong> out of 5</span>
                                                            </div>
                                                        </a>
                                                        <!-- <div class="product-action-button">
                                                            <a class="cs-color btn btn-flat button product_type_simple add_to_cart_button ajax_add_to_cart" href="#">
                                                                <i class="icon-shopping-cart2 cs-bgcolor"></i>
                                                                Add to cart
                                                            </a>
                                                        </div> -->
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            {{ $products->links('layouts._pagination', ['paginator' => $products]) }}
                                        </div>
                                     </div>
                                </div>
                            </div>
                            <x-product-aside :categories="$categories" />
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-section" style="background:#19171a;;">
    	<div class="container">
        	<div class="row">
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	      <div class="cs-ad" style="text-align:center; padding:55px 0 25px;">
        	     <div class="cs-media">
            	   <figure>
                	 <a href="#"><img alt="" src="{{URL::asset('/extra-images/cs-ad-img.jpg ')}}"></a>
                  </figure>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/responsive.menu.js') }}"></script> 
    <script src="{{ asset('js/chosen.select.js') }}"></script> 
    <script src="{{ asset('js/slick.js') }}"></script> 
    <script src="{{ asset('js/echo.js') }}"></script>
    <!-- Put all Functions in functions.js --> 
    <script src="{{ asset('js/functions.js') }}"></script>

@stop