@extends('backend.layouts.app')

@section('content')
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li class="active">List</li>
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
                        <h3 class="panel-title">School List</h3>
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
                                    @foreach ($schoolList as $sl)
                                        <tr>
                                            <td class="text-center">{{ $sl->id }}</td>
                                            <td>
                                                @if (!empty($sl->profile_pic))
                                                    <img 
                                                        src="{{ $sl->profile_pic }}" 
                                                        alt="School Image" 
                                                        width="50"
                                                        style="object-fit: cover; border-radius: 6px;"
                                                    >
                                                @endif
                                            </td>
                                            <td><strong>{{ $sl->name }}</strong></td>
                                            <td>{{ $sl->email }}</td>
                                            <td>
                                                @if ($sl->status == 1)
                                                    <span class="label label-success">active</span>
                                                @else
                                                    <span class="label label-danger">inactive</span>
                                                @endif
                                            </td>

                                            <td>{{ $sl->address }}</td>
                                            <td>{{ date('d-m-y H:i A', strtotime($sl->created_at)) }}</td>
                                            <td>
                                                <button class="btn btn-default btn-rounded btn-sm"><span
                                                        class="fa fa-pencil"></span></button>
                                                <button class="btn btn-danger btn-rounded btn-sm"
                                                    onClick="delete_row('trow_1');"><span
                                                        class="fa fa-times"></span></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
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
