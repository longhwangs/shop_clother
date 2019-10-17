@extends('admin.layouts.master')
@section('content')
    
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 text-center">Danh sách người dùng</h1>
    <!-- DataTales Example -->

    <div class="col-lg-12">
        @if (Session::has('flash_message'))
            <div class="alert alert-{{ Session::get('type_message') }}">
                {{ Session::get('flash_message') }}
            </div>
        @endif
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Search  -->
            <div class="col-md-6">
                <form action="" class="form-inline" style="margin-top: 20px; margin-left: 20px">
                    
                    <div class="form-group mb-2">
                        <input class="form-control" type="text" placeholder="Nhập từ khóa..." aria-label="Search" name="search" value="{{ \Request::get('name') }}">
                    </div>
                    <div class="form-group mb-2" style="margin:0 20px; padding: 5px">
                        <select name="role" id="" class="form-control">
                            <option value="" disabled selected>Level</option>
                            @if(isset($roles))
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ \Request::get('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <button class="btn btn-info" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Tên người dùng</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Giới tính</th>
                            <th>Level</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>        
                    @foreach($listUser as $key => $user)
                        <tr class="text-center">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->tel }}</td>
                            <td>{{ $user->address }}</td>
                            <td>
                                @if ($user->gender == 1)
                                    Nam
                                @else
                                    Nữ
                                @endif
                            </td>
                            <td>
                                 <?php $role = DB::table('roles')->where('id', $user->role_id)->first(); echo $role->name; ?>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('user.edit', $user->id) }}">Sửa</a>
                            </td>
                            <td>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" onclick="return accessDelete('Bạn có chắc là muốn xóa không ?')"class="btn btn-danger">Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
