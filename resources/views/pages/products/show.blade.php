@extends('layouts.app', ['page' => __('Product Show'), 'pageSlug' => 'product_show'])


@section('css')
<link href="{{ asset('css/woocommerce.css') }}" rel="stylesheet">
<link href="{{ asset('css/lightslider.css')}}" rel="stylesheet">

@stop

@section('content')
@isset($message)
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{!! $message !!}</strong>
    </div>
@endisset
<div class="page-section">
    <div class="container">
        <div class="row">
            <div class="section-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="page-content col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="site-main">
                            <div class="product type-product has-post-thumbnail product-type-simple">
                                <div class="images car">
                                    <ul id="lightSlider">
                                        @foreach ($product->images as $key => $image)
                                            <li data-thumb="{{'/storage/productImages/'.$image->image}}" class="product-slide">
                                                <img src="{{'/storage/productImages/'.$image->image}}" />
                                                <a
                                                    href="{{route('products.poster', ['imageId' => $image->id])}}"
                                                    class="product-slide-poster-download"
                                                >
                                                    <img src="{{asset('images/download_file.svg')}}" />
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="summary entry-summary">
                                    <div class="star-rating" title="Rated 5 out of 5">
                                        <span style="width:66%"><strong class="rating">5</strong> out of 5</span>
                                    </div>
                                    <h3>{{$product->name}}</h3>
                                    @if (Auth::user())
                                        <span class="price">
                                            <ins><span class="amount cs-color">{{$product->price}}</span></ins>
                                            <del><span class="amount">{{$product->price + ($product->price)*0.05}}</span></del>
                                        </span>
                                    @endif
                                    <p>{{$product->manufacturer}}  {{$product->country}}</p>

                                    <div class="description">
                                        <p>{!! \Illuminate\Support\Str::limit(strip_tags($product->description), $limit = 250, $end = '......') !!}</p>
                                    </div>
                                    <div class="product_meta">
                                    	<span class="posted_in">
                                            {{__('common.products.category')}}: 
                                            @foreach ($product->categories as $category)
                                            <a rel="tag" href="#">{{$category->name}}</a>,   
                                            @endforeach
                                        </span>
                                    </div>
                                </div>
                                <div class="woocommerce-tabs wc-tabs-wrapper">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs wc-tabs" role="tablist">
                                    	<li role="presentation" class="active">
                                        	<a href="#home" aria-controls="home" role="tab" data-toggle="tab">{{__('common.products.description')}}</a>
                                        </li>                                    	
                                    	<li role="presentation">
                                        	<a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Reviews</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home">
                                        	<h5>{{__('common.products.description')}}</h5>
                                            <p>{{$product->description}}</p>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="messages">
                                            <div id="reviews">
                                                <div id="comments">
                                                    <h5>Product Reviews</h5>
                                                    <ol class="commentlist">
                                                        <li class="comment even thread-even depth-1">
                                                            <div class="comment_container">
                                                                <img src="{{URL::asset('extra-images/Shop-comment1.jpg ')}}" alt="#" />
                                                                <div class="comment-text">
                                                                    <p class="meta">
                                                                        <em>James Warson</em>
                                                                        September 6, 2015, 05:32PM
                                                                    </p>
                                                                    <div class="star-rating">
                                                                        <span style="width:60%"><strong itemprop="ratingValue">3</strong> out of 5</span>
                                                                    </div>
                                                                    <div class="description">
                                                                        <p> Sed id magna tellus. Ut eget dictum magna. Proin pharetra, elit nec accumsan posuere, massa tellus lobortis mi, a viverra nisi metus et risus. Praesent efficitur neque nibh, non maximus ante suscipit non.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="comment even thread-even depth-1">
                                                            <div class="comment_container">
                                                                <img src="{{URL::asset('extra-images/Shop-comment2.jpg ')}}" alt="#" />
                                                                <div class="comment-text">
                                                                    <p class="meta">
                                                                        <em>Brian Adamas</em>
                                                                        September 6, 2015, 05:32PM
                                                                    </p>
                                                                    <div class="star-rating">
                                                                        <span style="width:60%"><strong itemprop="ratingValue">3</strong> out of 5</span>
                                                                    </div>
                                                                    <div class="description">
                                                                        <p> Sed id magna tellus. Ut eget dictum magna. Proin pharetra, elit nec accumsan posuere, massa tellus lobortis mi, a viverra nisi metus et risus. Praesent efficitur neque nibh, non maximus ante suscipit non.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ol>
                                                </div>
                                                <div id="review_form_wrapper">
                                                    <div id="review_form">
								                        <div class="comment-respond" id="respond">
                                                            <h5 class="comment-reply-title" id="reply-title">
                                                                Add a Review  <small><a style="display:none;" href="#" id="cancel-comment-reply-link" rel="nofollow">Cancel reply</a></small>
                                                            </h5>
                                                            <form novalidate class="comment-form" id="commentform" method="post" action="http://motors.stylemixthemes.com/wp-comments-post.php">
                                                                <p class="comment-form-rating">
                                                                        <p class="stars"><span><a href="#" class="star-1">1</a><a href="#" class="star-2">2</a><a href="#" class="star-3">3</a><a href="#" class="star-4">4</a><a href="#" class="star-5">5</a></span></p>
                                                                    <select id="rating" name="rating" style="display: none;" tabindex="-1" class="select2-hidden-accessible" aria-hidden="true">
                                    									<option value="">Rate…</option>
                                    									<option value="5">Perfect</option>
                                    									<option value="4">Good</option>
                                    									<option value="3">Average</option>
                                    									<option value="2">Not that bad</option>
                                    									<option value="1">Very Poor</option>
                                    								</select>
                                                                    <span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;">
                                                                        <span class="selection">
                                                                            <span aria-expanded="false" aria-haspopup="true" aria-autocomplete="list" role="combobox" class="select2-selection select2-selection--single" tabindex="0" aria-labelledby="select2-rating-container">
                                                                                <span class="select2-selection__rendered" id="select2-rating-container" title="Rate…">Give Rating</span>
                                                                                <span role="presentation" class="select2-selection__arrow"><b role="presentation"></b></span>
                                                                        </span>
                                                                    </span>
                                                                    <span aria-hidden="true" class="dropdown-wrapper"></span></span>
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                        <p class="comment-form-author">
                                                                            <input type="text" placeholder="Name" />
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                        <p class="comment-form-author">
                                                                            <input type="text" placeholder="Phone Number" />
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                        <p class="comment-form-author">
                                                                            <input type="text" placeholder="Subject" />
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                        <p class="comment-form-email">
                                                                            <input type="text" placeholder="Email Address">
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <p class="comment-form-comment">
                                                                    <textarea placeholder="Your Review"></textarea>
                                                                </p>
                                                                <p class="form-submit">
                                                                	<input type="submit" value="Submit Message" class="submit cs-bgcolor"> 
                                                                	<input type="hidden" />
                                                                	<input type="hidden" />
                                                                </p>
                                                                <p style="display: none;">
                                                                	<input type="hidden" />
                                                                </p>
                                                                <p style="display: none;" class="stm-hidden"></p>				
                                                                <input type="hidden" />
                                                            </form>
                                                        </div>
                                                        <!-- #respond -->
				                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="columns-3">
                                    <div class="shop-sec-title">
                                        <h3>Related Products</h3>
                                    </div>
                                    <ul class="products">
                                        <li class="product">
                                            <a href="#">
                                                <img alt="shop" src="{{URL::asset('/extra-images/shop4.jpg')}}">
                                                <h5>Air Filter</h5>
                                                @if (Auth::user())
                                                <span class="price">
                                                    <span class="amount">$2,000.00</span>
                                                </span>
                                                @endif
                                                <div class="star-rating" title="Rated 5 out of 5">
                                                    <span style="width:66%"><strong class="rating">5</strong> out of 5</span>
                                                </div>
                                            </a>
                                            <div class="product-action-button">
                                                <a class="cs-color btn btn-flat button product_type_simple add_to_cart_button ajax_add_to_cart" href="#">
                                                    <i class="icon-shopping-cart2 cs-bgcolor"></i>
                                                    Add to cart
                                                </a>
                                            </div>
                                        </li>
                                        <li class="product">
                                            <a href="#">
                                                <img alt="shop" src="{{URL::asset('/extra-images/shop5.jpg')}}">
                                                <h5>Car brush</h5>
                                                @if (Auth::user())
                                                <span class="price">
                                                    <span class="amount">$2,000.00</span>
                                                </span>
                                                @endif
                                                                                                        <div class="star-rating" title="Rated 5 out of 5">
                                                    <span style="width:66%"><strong class="rating">5</strong> out of 5</span>
                                                </div>
                                            </a>
                                            <div class="product-action-button">
                                                <a class="cs-color btn btn-flat button product_type_simple add_to_cart_button ajax_add_to_cart" href="#">
                                                    <i class="icon-shopping-cart2 cs-bgcolor"></i>
                                                    Add to cart
                                                </a>
                                            </div>
                                        </li>
                                        <li class="product">
                                            <a href="#">
                                                <img alt="shop" src="{{URL::asset('/extra-images/shop6.jpg')}}">
                                                <h5>Car mats for BMW F10</h5>
                                                @if (Auth::user())
                                                <span class="price">
                                                    <ins><span class="amount">$99.00</span></ins>
                                                    <del><span class="amount">$150.00</span></del>
                                                </span>
                                                @endif
                                                <div class="star-rating" title="Rated 5 out of 5">
                                                    <span style="width:66%"><strong class="rating">5</strong> out of 5</span>
                                                </div>
                                            </a>
                                            <div class="product-action-button">
                                                <a class="cs-color btn btn-flat button product_type_simple add_to_cart_button ajax_add_to_cart" href="#">
                                                    <i class="icon-shopping-cart2 cs-bgcolor"></i>
                                                    Add to cart
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- call back form -->
                                <div class="page-section" style="padding-top:40px; padding-bottom:60px;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="section-fullwidtht col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="row">
                                                <!--Element Section Start-->
                                                    <div class="cs-contact-form">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
                                                            <div class="cs-section-title">
                                                                <h3 style="text-transform:uppercase !important;">{{__('common.page.order.header')}}</h3>
                                                                <p style="text-transform:uppercase;font-size:11px;color:#999999 !important;">{{__('common.page.order.description')}}</p>
                                                            </div>
                                                        </div>
                                                        <form action="{{ route('add_order') }}" method="POST">
                                                            @csrf
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="cs-form-holder">
                                                                            <div class="input-holder">
                                                                                <input
                                                                                    type="text"
                                                                                    placeholder="{{__('common.page.order.placeholder.name')}}"
                                                                                    name="name"
                                                                                    required
                                                                                ><i class=" icon-user"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="cs-form-holder">
                                                                            <div class="input-holder">
                                                                                <input
                                                                                    type="email"
                                                                                    placeholder="{{__('common.page.order.placeholder.email')}}"
                                                                                    required
                                                                                    name="email"
                                                                                ><i class=" icon-envelope"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="cs-form-holder">
                                                                            <div class="input-holder">
                                                                                <input
                                                                                    type="text"
                                                                                    placeholder="{{__('common.page.order.placeholder.phone')}}"
                                                                                    required
                                                                                    name="phone"
                                                                                ><i class="icon-mobile2"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="cs-form-holder">
                                                                            <div class="input-holder" id="data-toggle">
                                                                                <input
                                                                                    type="checkbox"
                                                                                    id="cbox2"
                                                                                    name="is_subscribe"
                                                                                > <label for="cbox2">{{__('common.page.order.placeholder.is_subscribe')}}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="cs-form-holder">
                                                                            <div class="input-holder">
                                                                            <textarea
                                                                                placeholder="{{__('common.page.order.placeholder.message')}}"
                                                                                name="message"
                                                                                required
                                                                                ></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="cs-btn-submit cs-color">    
                                                                            <input type="submit" value="{{__('common.page.order.submit')}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>  
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>  
                                            <!--Element Section End-->
                                        </div>
                                    </div>
                                </div>
                                <!-- end call back form -->
                            </div>
                        </div>
                    </div>
                    <x-product-aside :categories="$categories" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/responsive.menu.js') }}"></script> 
    <script src="{{ asset('js/chosen.select.js') }}"></script> 
    <script src="{{ asset('js/slick.js') }}"></script> 
    <script src="{{ asset('js/echo.js') }}"></script>
    <script src="{{ asset('js/lightslider.js ')}}"></script>
    <script>
      $('#lightSlider').lightSlider({
        gallery: true,
        item: 1,
        loop:true,
        slideMargin: 0,
        thumbItem: 4,
        galleryMargin: 15,
        thumbMargin: 2,
        });
    </script>
    <style>
    .car ul {
    list-style: none outside none;
    padding-left: 0;
    margin-bottom:0;
    }
    .car li {
        display: block;
        float: left;
        margin-right: 6px;
        cursor:pointer;
    }
    </style>
@stop