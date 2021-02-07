@extends('frontend.default.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.default.user.freelancer.inc.sidebar')

            <div class="aiz-user-panel">
                <div class="aiz-titlebar mt-2 mb-4">
                    <div class="row align-items-center">
                        <div class="col d-flex justify-content-between">
                            <h1 class="h3">{{ translate('Purchased Services') }}</h1>                            
                        </div>
                    </div>
                </div>
                
                <div class="row gutters-10">
                    <div class="card w-100">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('List of service sold') }}</h5>
                        </div>
                        <div class="card-body">

                            <table class="table aiz-table mb-0">
                                <thead>
                                    <tr>
                                        <th data-breakpoints="">#</th>
                                        <th data-breakpoints="">{{ translate('Service Title') }}</th>
                                        <th data-breakpoints="md">{{ translate('Client Name') }}</th>
                                        <th data-breakpoints="md">{{ translate('Service Type') }}</th>
                                        <th data-breakpoints="md">{{ translate('Amount') }}</th>
                                        <th data-breakpoints="md">{{ translate('My Earning') }}</th>
                                        <th data-breakpoints="md">{{ translate('Purchased At') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchasedServices as $purchasedService)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a target="_blank" href="{{ route('service.show', $purchasedService->servicePackage->service->slug) }}">{{ \Illuminate\Support\Str::limit($purchasedService->servicePackage->service->title, 15, $end='...') }}</a></td>
                                        <td>{{ $purchasedService->user->name }}</td>
                                        <td>{{ ucfirst($purchasedService->servicePackage->service_type) }}</td>
                                        <td>{{ single_price($purchasedService->amount) }}</td>
                                        <td>{{ single_price($purchasedService->freelancer_profit) }}</td>
                                        <td>{{ $purchasedService->created_at }}</td>
                                    @endforeach                 
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>               
                </div>
                
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $purchasedServices->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection