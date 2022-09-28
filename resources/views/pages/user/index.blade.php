@extends('layouts.master')

@section('content')
    <div id="content-table">
        <div class="container-fluid p-5 bg-primary text-white text-center">
            <h1>{{ $pageName }}</h1>
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="col-sm-12">
                    <a href="javascript:void(0)" class="btn btn-success open-form float-end mb-5 w-20"
                        data-create-href={{ $create }}>New User</a>
                </div>

                <div class="col-sm-12">
                    <table id="dataTable" class="table table-responsive" style="width:100%" data-table-ajax="true"
                        data-table-href="{{ $dataTables }}" data-delete-href="{{ $delete }}"
                        data-edit-href="{{ $edit }}">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <div id="content-form" style="display: none">
    </div>
@endsection
