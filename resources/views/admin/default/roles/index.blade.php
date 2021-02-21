@extends('admin.default.layouts.app')

@section('content')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style>
    .form-group input[type="checkbox"] {
        display: none;
    }
    
    .form-group input[type="checkbox"] + .btn-group > label span {
        width: 20px;
    }
    
    .form-group input[type="checkbox"] + .btn-group > label span:first-child {
        display: none;
    }
    .form-group input[type="checkbox"] + .btn-group > label span:last-child {
        display: inline-block;   
    }
    
    .form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
        display: inline-block;
    }
    .form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
        display: none;   
    } 
</style>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{translate('All Roles')}}</h1>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th data-breakpoints="">#</th>
                                <th data-breakpoints="">{{ translate('Name') }}</th>
                                <th data-breakpoints="" class="text-right">{{ translate('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $key => $role)
                            <tr>
                                <td>{{ ($key+1) + ($roles->currentPage() - 1)*$roles->perPage() }}</td>
                                <td>{{$role->name}}</td>
                                <td class="text-right">
                                    @if ($role->id == "1" || $role->id == "2" || $role->id == "3")
                                        <span class="badge badge-inline fw-400 badge-warning">{{translate('This is not editable or deletable')}}</span>
                                    @else
                                        <a href="{{ route('roles.edit', encrypt($role->id)) }}" class="btn btn-soft-primary btn-icon btn-circle btn-sm btn icon" title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" data-href="{{route('roles.destroy', $role->id)}}" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Create new Role')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Name')}}</label>
                            <input type="text" id="name" name="name" class="form-control" required placeholder="Eg. Support Agent">
                        </div>
                        @foreach(DB::table('pag')->orderBy('id','desc')->get() as $item_pag)
                        <div class="[ form-group ]">
                            <input type="checkbox" name="pag[]" id="fancy-checkbox-default-custom-icons" autocomplete="off" />
                            <div class="[ btn-group ]">
                                <label for="fancy-checkbox-default-custom-icons" class="[ btn btn-default ]">
                                    <span class="[ glyphicon glyphicon-plus ]"></span>
                                    <span class="[ glyphicon glyphicon-minus ]"></span>
                                </label>
                                <label for="fancy-checkbox-default-custom-icons" class="[ btn btn-default active ]">
                                    {{ $item_pag->pag}}
                                </label>
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Add New Role')}}</button>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div>
    </div>
    <div class="row">
        {{ $roles->links() }}
    </div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection
