@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
	    <!-- Page Heading -->
	    <h1 class="h3 mb-2 text-gray-800">{{ trans('message.Category') }}</h1>
	    <!-- DataTales Example -->
	    <div class="card shadow mb-4">
	        <div class="card-header py-3">
	        	<div class="row">
	        		<div class="col-md-5">
	        			<h6 class="m-0 font-weight-bold text-primary">{{ trans('message.Category') }}/ {{ trans('message.List') }}</h6>
	        		</div>
	        		<div class="col-md-7">
	        			<form>
	        				<div class="input-group">
					            <input type="text" class="form-control bg-light small" placeholder="{{ trans('message.Search') }}..." name="search" value="{{ \Request::get('search') }}">
					            <div class="input-group-append">
					                <button class="btn btn-primary" type="submit">
					                    <i class="fas fa-search fa-sm"></i>
					                </button>
					            </div>
					        </div>
	        			</form>
	        		</div>
	        	</div>
	        </div>
	        <div class="card-header py-3">
	        	@if (Session::has('flash_message'))
	        		<div class="alert alert-{{ Session::get('type_message') }}">
	        			{{ Session::get('flash_message') }}
	        		</div>
	        	@endif
	        </div>
	        <div class="card-body">
	            <div class="table-responsive">
	                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
	                    <thead>
	                        <tr>
	                            <th>ID</th>
	                            <th>{{ trans('message.Category Name') }}</th>
	                            <th>{{ trans('message.Parent Category') }}</th>
	                            <th>{{ trans('message.Created At') }}</th>
	                            <th>{{ trans('message.Updated At') }}</th>
	                            <th colspan="2" class="align">{{ trans('message.Action') }}</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	@foreach($categories as $key => $category)
	                        <tr>
	                            <td>{{ $category->id }}</td>
	                            <td>{{ $category->name }}</td>
	                            <td>
	                            	@foreach ($parent_id as $key => $value)
		                            	@if ($category->parent_id == 0)
		                            	    {{ " " }}
		                            	@elseif ($value->id == $category->parent_id)
		                            	    {{ $value->name }}
		                            	@endif
	                            	@endforeach
	                            </td>
	                            <td>
	                            	<?php
	                            		echo \Carbon\Carbon::createFromTimeStamp(strtotime($category->created_at))->diffForHumans();
	                            	?>
	                            </td>
	                            <td>
	                            	<?php
	                            		echo \Carbon\Carbon::createFromTimeStamp(strtotime($category->updated_at))->diffForHumans();
	                            	?>
	                            </td>
	                            <td>
	                            	<a href="{{ route('category-edit', $category->id) }}">
	                            		<button class="btn btn-primary">
	                            			<i class="fa fa-pencil" aria-hidden="true"> {{ trans('message.Edit') }}</i>
	                            		</button>
	                            	</a>
	                            </td>
	                            <td>
	                            	<form action="{{ route('category-delete', $category->id) }}" method="POST">
	                            		@csrf
	                            		@method('delete')
	                            		<button type="submit" class="btn btn-danger" onclick="return accessDelete('Bạn có chắc là muốn xóa không ?')">
	                            			<i class="fa fa-trash"> {{ trans('message.Delete') }}</i>
	                            		</button>
	                            	</form>
	                            </td>
	                        </tr>
	                        @endforeach
	                    </tbody>
	                </table>
	                <div class="row">
	                	<div class="col-md-4 offset-md-4">{{ $categories->links() }}</div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@endsection
