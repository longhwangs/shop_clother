@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
	    <h1 class="h3 mb-2 text-gray-800">{{ trans('message.Category') }}</h1>
	    <div class="card shadow mb-4">
	        <div class="card-header py-3">
	            <h6 class="m-0 font-weight-bold text-primary">{{ trans('message.Category') }}/{{ trans('message.Add') }}</h6>
	        </div>
	        <div class="card-body">
	            <div class="row">
	            	<div class="col-md-6">
	            		<form action="{{ route('category-store') }}" method="POST">
	            			@csrf
	            			<div class="form-group">
	            				<label for="parent_id">{{ trans('message.Parent Category') }}</label>
	            				<select name="parent_id" class="form-control">
	            					<option value="0">{{ trans('message.chooce') }}</option>
	            					@foreach($cate_parent as $value)
	            					<option {{ old('parent_id') == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
	            					@endforeach
	            				</select>
	            			</div>
	            			<div class="form-group">
	            				<label for="name">{{ trans('message.Category Name') }} *</label>
	            				<input type="text" name="name" class="form-control" placeholder="{{ trans('message.enter category name') }}" value="{{ old('name') }}">
	            				@if ($errors->has('name'))
	            					<p class="danger">{{ $errors->first('name') }}</p>
	            				@endif
	            			</div>
	            			<button type="submit" class="btn btn-primary">{{ trans('message.Add') }}</button>
	            		</form>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
@endsection
