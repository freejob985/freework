@extends('admin.default.layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="project_payments" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Service Payments')}}</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search by project name" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset>
                            <div class="input-group-append">
                                <button class="btn btn-light" type="submit">
                                    <i class="las la-search la-rotate-270"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>


                            <th>#</th>
                            <th>{{ translate('Service Title') }}</th>
                            <th>{{ translate('Service Owner') }}</th>
                            <th>{{ translate('Starts At') }}</th>
                            <th>{{ translate('Service Created At') }}</th>
                            <th>اسباب الرفض</th>
                            <th data-breakpoints="md">قبول الخدمة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $key => $service)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td><a target="_blank" href="{{ route('service.show', $service->slug) }}">{{ $service->title }}</a></td>                                
                                <td><a target="_blank" href="{{ route('freelancer.details', $service->user->user_name) }}">{{ $service->user->name }}</a></td>   
                                <td>{{ single_price($service->service_packages[0]->service_price) }}</td>
                                <td>{{ $service->created_at }}</td>
                                <td>
                                    <a href="{{ route('Reasons.rejection', [$service->user->id,$service->id,"services"]) }}" class="btn btn-warning"> ارسال رسالة</a>
                                 </td> 
                                 <td>
                                    
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox"  id="project_approval.{{ $key }}" onchange="project_approval(this)" value="{{ $service->id }}" @if($service->project_approval == 1) checked @endif>
                                        <span></span>
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="aiz-pagination aiz-pagination-center">
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection
@section('script')
<script type="text/javascript">
    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    function sort_projects(el){
        $('#sort_projects').submit();
    }
    function project_approval(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
       
        $.post('{{ route('project_approval.services') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                AIZ.plugins.notify('success', 'Project has been approved successfully.');
            }
            else{
                AIZ.plugins.notify('danger', 'Something went wrong');
            }
          });
  
    
    }
</script>
@endsection
