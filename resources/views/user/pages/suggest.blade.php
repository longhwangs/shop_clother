@extends('user.layouts.master')
@section('content')
	<div class="container-wrap" style="margin-top: 50px">
		<div class="container-wrap">
		<!-- breadcrumb -->
		<div class="container">
			<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
				<a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
					{{ trans('message.home') }}
					<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
				</a>

				<span class="stext-109 cl4">
					{{ trans('message.register') }}
				</span>
			</div>
		</div>
		@if (Session::has('flash_message'))
    		<div class="alert alert-{{ Session::get('type_message') }}">
    			{{ Session::get('flash_message') }}
    		</div>
    	@endif
		<section class="bg0 p-t-104 p-b-116">
			<div class="container">
				<div class="flex-w flex-tr">
					<div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
						<form action="{{ route('post.suggest') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<h4 class="mtext-105 cl2 txt-center p-b-30">
								{{ strtoupper(trans('message.register')) }}
							</h4>

							<div class="form-group">
	            				<label for="cate_parent">{{ trans('message.parent_category') }} *</label>
	            				<select name="cate_parent" class="form-control" id="cate_parent">
	            					<option value="">{{ trans('message.chooce') }}</option>
	            					@foreach($cate_parent as $value)
	            					<option {{ old('cate_parent') == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
	            					@endforeach
	            				</select>
	            				@if ($errors->has('cate_parent'))
	            					<p class="danger">{{ $errors->first('cate_parent') }}</p>
	            				@endif
	            			</div>
	            			<div class="form-group">
	            				<label for="category_id">{{ trans('message.category_name') }} *</label>
	            				<select name="category_id" class="form-control" id="category_id">
	            					<option value="">{{ trans('message.chooce') }}</option>
	            					@foreach($category_id as $value)
	            					<option {{ old('category_id') == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
	            					@endforeach
	            				</select>
	            				@if ($errors->has('category_id'))
	            					<p class="danger">{{ $errors->first('category_id') }}</p>
	            				@endif
	            			</div>
	            			<div class="form-group">
	            				<label for="">{{ trans('message.product_name') }} *</label>
	            				<input type="text" name="name" class="form-control" placeholder="{{ trans('message.enter_product') }}" value="{{ old('name') }}">
	            				@if ($errors->has('name'))
	            					<p class="danger">{{ $errors->first('name') }}</p>
	            				@endif
	            			</div>
	            			<div class="form-group">
	            				<label for="">{{ trans('message.price') }} *</label>
	            				<input type="text" name="price" class="form-control" placeholder="{{ trans('message.enter_price') }}" value="{{ old('price') }}">
	            				@if ($errors->has('price'))
	            					<p class="danger">{{ $errors->first('price') }}</p>
	            				@endif
	            			</div>
	            			<div class="form-group">
	            				<label for="">{{ trans('message.description') }}</label>
	            				<textarea name="description" class="form-control" placeholder="{{ trans('message.enter_description') }}" value="{{ old('description') }}"></textarea>
	            			</div>
	            			<div class="form-group">
	            				<label for="">{{ trans('message.image') }} *</label>
	            				<input type="file" name="image" class="form-control">
	            				@if ($errors->has('image'))
	            					<p class="danger">{{ $errors->first('image') }}</p>
	            				@endif
	            			</div>
	            			<input type="hidden" name="status" value="New">
	            			<input type="hidden" name="user_id" value="{{ Auth::check() ? Auth::user()->id : '' }}">

							<button type="submit" class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer margin-top">
								{{ trans('message.add') }}
							</button>
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection
