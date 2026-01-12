@extends('backend.layouts.app')

@section('content')
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="{{ route('cpanel.dashboard') }}">Home</a></li>
        <li class="active"><a href="{{ route('cpanel.admin') }}">List</a></li>
    </ul>
    <!-- END BREADCRUMB -->

    <!-- PAGE TITLE -->
    <div class="page-title">
        <h2><span class="fa fa-arrow-circle-o-left"></span> School</h2>
    </div>
    <!-- END PAGE TITLE -->

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">

        <!-- START RESPONSIVE TABLES -->
        <div class="row">
            <div class="col-md-12">
                @include('_massage')
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h3 class="panel-title">Admin Search</h3>
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('cpanel.admin') }}" method="GET">

                            <div class="col-md-2">
                                <label>ID</label>
                                <input type="text" class="form-control" name="id" value="{{ request('id') }}"
                                    placeholder="ID">
                            </div>

                            <div class="col-md-2">
                                <label>Admin Name</label>
                                <input type="text" class="form-control" name="name" value="{{ request('name') }}"
                                    placeholder="SCHOOL NAME">
                            </div>

                            <div class="col-md-2">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" value="{{ request('email') }}"
                                    placeholder="EMAIL">
                            </div>

                            <div class="col-md-2">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" value="{{ request('address') }}"
                                    placeholder="ADDRESS">
                            </div>

                            <div class="col-md-2">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>

                            <div style="clear: both;">
                                <br>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ route('cpanel.admin') }}" class="btn btn-success">Reset</a>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h3 class="panel-title">Admin List</h3>
                        <a class="btn btn-primary pull-right" href="{{ route('cpanel.school.add') }}">Create School</a>
                    </div>

                    <div class="panel-body panel-body-table">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-actions">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Profile</th>
                                        <th>School Name</th>
                                        <th>Email</th>
                                        <th>status</th>
                                        <th>Address</th>
                                        <th>Created Date</th>
                                        <th>actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($adminList as $al)
                                        <tr>
                                            <td class="text-center">{{ $al->id }}</td>
                                            <td>
                                                @if (!empty($al->profile_pic))
                                                    <img src="{{ $al->profile_pic }}" alt="School Image" width="50"
                                                        style="object-fit: cover; border-radius: 6px;">
                                                @endif
                                            </td>
                                            <td><strong>{{ $al->name }}</strong></td>
                                            <td>{{ $al->email }}</td>
                                            {{-- <td>
                                                @if (auth()->user()->is_admin === 1)
                                                    <a href="{{ route('cpanel.school.toggleStatus', $al->id) }}">
                                                        @if ($al->status)
                                                            <span class="label label-success">Active</span>
                                                        @else
                                                            <span class="label label-danger">Inactive</span>
                                                        @endif
                                                    </a>
                                                @else
                                                    @if ($al->status)
                                                        <span class="label label-success">Active</span>
                                                    @else
                                                        <span class="label label-danger">Inactive</span>
                                                    @endif
                                                @endif
                                            </td> --}}
                                            <td>{{ $al->address }}</td>
                                            <td>{{ $al->created_at->format('d-m-Y H:i') }}</td>
                                            {{-- <td>
                                                <a href="{{ route('cpanel.school.edit', $al->alug) }}"
                                                    class="btn btn-default btn-rounded btn-sm">
                                                    <span class="fa fa-pencil"></span>
                                                </a>

                                                <form action="{{ route('cpanel.school.delete', $al->alug) }}"
                                                    method="POST" style="display:inline-block"
                                                    onsubmit="return confirm('Are you sure you want to delete this school?');">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-danger btn-rounded btn-sm">
                                                        <span class="fa fa-times"></span>
                                                    </button>
                                                </form>

                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="pull-right">
                    {{ $adminList->links() }}
                </div>
            </div>
        </div>
        <!-- END RESPONSIVE TABLES -->

        <!-- END PAGE CONTENT WRAPPER -->
    </div>

    <!-- END PAGE CONTENT WRAPPER -->
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/demo_tables.js') }}"></script>
@endsection
