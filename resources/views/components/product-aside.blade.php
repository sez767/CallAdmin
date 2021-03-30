<aside class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="widget woocommerce widget_product_categories">
        <h6>{{__('common.products.categories')}}</h6>
        <ul>
            @foreach ($categories as $category)
            <!-- <li class="cat-item cat-item-3 cat-parent"> -->
                <li><a href="#">{{$category->name}} <span>({{$category->products->count()}})</span></a></li>
            <!-- </li> -->
            @endforeach
        </ul>
    </div>
    <div class="widget woocommerce widget_top_rated_products">
    	<h6>latest Products</h6>
    	<ul class="product_list_widget">
        	<li>
            	<a href="#">
                	<img src="{{URL::asset('/extra-images/Shop-widget1.jpg')}}" alt="shop" />
                    <span class="product-title">USB Air Compressor</span>
                </a>
@if (Auth::user())
                <span class="amount cs-color">$500.00</span>
                @endif
            </li>
            <li>
            	<a href="#">
                	<img src="{{URL::asset('/extra-images/Shop-widget2.jpg')}}" alt="shop" />
                    <span class="product-title">Ninja Sound</span>
                </a>
@if (Auth::user())
                <span class="amount cs-color">$800.00</span>
                @endif
            </li>
            <li>
            	<a href="#">
                	<img src="{{URL::asset('/extra-images/Shop-widget3.jpg')}}" alt="shop" />
                    <span class="product-title">Car mats for BMW</span>
                </a>
@if (Auth::user())
                <span class="amount cs-color">$900.00</span>
                @endif
            </li>
        </ul>
    </div>
    <div class="widget woocommerce widget_shopping_cart">
    	<h6>Top Rated Products</h6>
    	<div class="widget_shopping_cart_content">
            <ul class="cart_list product_list_widget">
            	<li class="mini_cart_item">
                	<a href="#">
                    	<img src="{{URL::asset('/extra-images/Shop-widget4.jpg')}}" alt="shop" />
                        Brembo Sport Brakes
                    </a>
@if (Auth::user())
                    <span class="amount">$500.00</span>
                    @endif
                    <div title="Rated 5 out of 5" class="star-rating">
                        <span style="width:66%"><strong class="rating">5</strong> out of 5</span>
                    </div>
                </li>
                <li class="mini_cart_item">
                	<a href="#">
                    	<img src="{{URL::asset('/extra-images/Shop-widget5.jpg')}}" alt="shop" />
                        Custom spark-plug
                    </a>
@if (Auth::user())
                    <span class="amount">$800.00</span>
                    @endif
                    <div title="Rated 5 out of 5" class="star-rating">
                        <span style="width:66%"><strong class="rating">5</strong> out of 5</span>
                    </div>
                </li>
                <li class="mini_cart_item">
                	<a href="#">
                    	<img src="{{URL::asset('/extra-images/Shop-widget6.jpg')}}" alt="shop" />
                        Air Filter
                    </a>
@if (Auth::user())
                    <span class="amount">$900.00</span>
                    @endif
                    <div title="Rated 5 out of 5" class="star-rating">
                        <span style="width:66%"><strong class="rating">5</strong> out of 5</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</aside>