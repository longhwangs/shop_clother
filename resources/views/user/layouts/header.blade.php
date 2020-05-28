<header>
	<!-- Header desktop -->
	<div class="container-menu-desktop">
		<!-- Topbar -->
		<div class="top-bar">
			<div class="content-topbar flex-sb-m h-full container">
				<div class="left-top-bar">
					Free shipping for standard order over $100
				</div>

				<div class="right-top-bar flex-w h-full">
			        <a href="{{ route('language', ['lang' => 'en']) }}" class="flex-c-m trans-04 p-lr-25">
						EN
					</a>
					<a href="{{ route('language', ['lang' => 'vi']) }}" class="flex-c-m trans-04 p-lr-25">
						VI
					</a>
				@if (Auth::check())
					<a href="#" class="flex-c-m trans-04 p-lr-25">
						{{ Auth::user()->name }}
					</a>
					<a href="{{ route('product-list') }}" class="flex-c-m trans-04 p-lr-25">
						{{ trans('message.administration') }}
					</a>
					<a href="{{ route('edit-profile') }}" class="flex-c-m trans-04 p-lr-25">
						{{ trans('message.profile') }}
					</a>
					<a href="{{ route('get-logout') }}" class="flex-c-m trans-04 p-lr-25">
						{{ trans('message.logout') }}
					</a>
				@else
					<a href="{{ route('get-register') }}" class="flex-c-m trans-04 p-lr-25">
						{{ trans('message.register') }}
					</a>
					<a href="{{ route('get-login') }}" class="flex-c-m trans-04 p-lr-25">
						{{ trans('message.login') }}
					</a>
				@endif
				</div>
			</div>
		</div>

		<div class="wrap-menu-desktop">
			<nav class="limiter-menu-desktop container">
				
				<!-- Logo desktop -->		
				<a href="#" class="logo">
					<img src="assets/user/images/icons/logo-01.png" alt="IMG-LOGO">
				</a>

				<!-- Menu desktop -->
				<div class="menu-desktop">
					<ul class="main-menu">
						<li class="active-menu">
							<a href="{{ route('home') }}">{{ trans('message.home') }}</a>
						</li>
						@if (isset($menu))
							@foreach($menu as $mn)
								<li>
									<a href="{{ route('product.type', $mn->id) }}">{{ $mn->name }}</a>
								</li>
							@endforeach
						@endif
						<li>
							<a href="{{ route('get.suggest') }}">Gợi ý sản phẩm</a>
						</li>
					</ul>
				</div>	

				<!-- Icon header -->
				<div class="wrap-icon-header flex-w flex-r-m">
					<form action="#" method="POST" id="form-search">
                        <div class="bor17 of-hidden pos-relative">
                            <input class="stext-103 cl2 plh4 size-116 p-l-28 p-r-55" type="text" name="search" placeholder="Nhập từ khóa..." id="search" style="overflow: auto;">

                            <button class="flex-c-m size-122 ab-t-r fs-18 cl4 hov-cl1 trans-04">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                        </div>
                        <div id="result_search"></div>
                        {{ csrf_field() }}
                    </form>

					<div id="count_item_cart" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="{{ \Cart::count() }}">
						<input id="count_cart" type="hidden" value="{{ \Cart::count() }}">
						<i class="zmdi zmdi-shopping-cart"></i>
					</div>

					{{-- <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="0">
						<i class="zmdi zmdi-favorite-outline"></i>
					</a> --}}
				</div>
			</nav>
		</div>	
	</div>

	<!-- Modal Search -->
	{{-- <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
		<div class="container-search-header">
			<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
				<img src="assets/user/images/icons/icon-close2.png" alt="CLOSE">
			</button>

			<form class="wrap-search-header flex-w p-l-15">
				<button class="flex-c-m trans-04">
					<i class="zmdi zmdi-search"></i>
				</button>
				<input class="plh3" type="text" name="search" placeholder="Search...">
			</form>
		</div>
	</div> --}}
</header>
<!-- Cart -->
<div class="wrap-header-cart js-panel-cart">
	<div class="s-full js-hide-cart"></div>

	<div class="header-cart flex-col-l p-l-65 p-r-25">
		<div class="header-cart-title flex-w flex-sb-m p-b-8">
			<span class="mtext-103 cl2">
				Your Cart
			</span>

			<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
				<i class="zmdi zmdi-close"></i>
			</div>
		</div>
		
		<div class="header-cart-content flex-w js-pscroll">
			<ul class="header-cart-wrapitem w-full">
				@foreach (Cart::content() as $cart)
				<li class="header-cart-item flex-w flex-t m-b-12">
					<div class="header-cart-item-img">
						<img src="upload/{{ $cart->options->image }}" alt="IMG" height="80">
					</div>

					<div class="header-cart-item-txt p-t-8">
						<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
							{{ $cart->name }}
						</a>

						<span class="header-cart-item-info">
							{{ $cart->qty }} x {{ number_format($cart->price) }} VND
						</span>
						<a style="float: right; margin-right: 50px; margin-top: -65px" href="{{ route('cart.delete', $cart->rowId) }}"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
					</div>
				</li>
				<hr>
				@endforeach
			</ul>
			
			<div class="w-full">
				<div class="header-cart-total w-full p-tb-40">
					Total: {{ Cart::total() }} VND
				</div>

				<div class="header-cart-buttons flex-w w-full">
					<a href="{{ route('cart.list') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
						View Cart
					</a>

					<a href="{{ route('checkout') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
						Check Out
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
