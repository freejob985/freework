@extends('frontend.default.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.default.user.freelancer.inc.sidebar')

            <div class="aiz-user-panel">
                <div class="aiz-titlebar mt-2 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="h3">{{ translate('Bidded Projects') }}</h1>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    @forelse ($bidded_projects as $key => $bidded_project)
                        @if ($bidded_project->project != null)
                            <div class="card project-card">
                                <div class="card-header border-bottom-0">
                                    <div>
                                        <span class="badge badge-primary badge-inline badge-md">{{ single_price($bidded_project->project->price) }}</span>
                                    </div>
                                    <div>
                                        @if (\App\Models\ProjectUser::where('project_id', $bidded_project->project_id)->where('user_id', Auth::user()->id)->first() != null)
                                            <span class="badge badge-success badge-inline badge-md">{{ translate('Hired You') }}</span>
                                        @elseif(\App\Models\ProjectUser::where('project_id', $bidded_project->project_id)->first() != null)
                                            <span class="badge badge-secondary badge-inline badge-md">{{ translate('Someone Else Hired') }}</span>
                                        @else
                                            <span class="badge badge-secondary badge-inline badge-md">{{ translate('Not Hired Yet') }}</span>
                                        @endif
                                    </div>
                                   
                                </div>
                                <div class="card-body pt-1">
                                    <h5 class="h6 fw-600 lh-1-5">
                                        <a href="{{ route('project.details', $bidded_project->project->slug) }}" class="text-inherit" target="_blank">{{ $bidded_project->project->name }}</a>
                                    </h5>
                                    <ul class="list-inline opacity-70 fs-12">
                                        <li class="list-inline-item">
                                            <i class="las la-clock opacity-40"></i>
                                            <span>{{ Carbon\Carbon::parse($bidded_project->project->created_at)->diffForHumans() }}</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class="text-inherit">
                                                <i class="las la-stream opacity-40"></i>
                                                <span>@if ($bidded_project->project->project_category != null) {{ $bidded_project->project->project_category->name }} @else {{ translate('Removed Category') }} @endif</span>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <i class="las la-handshake"></i>
                                            <span>{{ $bidded_project->project->type }}</span>
                                        </li>
                                    </ul>

                                    <div class="text-muted lh-1-8">
                                        <p>{{ $bidded_project->project->excerpt }}</p>
                                    </div>
                                    <div>
                                        @foreach (json_decode($bidded_project->project->skills) as $key => $skill_id)
                                            @php
                                                $skill = \App\Models\Skill::find($skill_id);
                                            @endphp
                                            @if ($skill != null)
                                                <span class="btn btn-light btn-xs mb-1">{{ $skill->name }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('client.details', $bidded_project->project->client->user_name)}}" class="d-flex mr-3 align-items-center text-reset">
    	                                    <span class="avatar avatar-xs overflow-hidden">
    	                                        <img class="img-fluid rounded-circle" src="{{ custom_asset($bidded_project->project->client->photo) }}">
    	                                    </span>
                                            <div class="pl-2">
                                                <h4 class="fs-14 mb-1">{{ $bidded_project->project->client->name }}</h4>
                                                <div class="">
                                                    <span class="bg-rating rounded text-white px-1 mr-1 fs-10">
                                                        {{ getAverageRating($bidded_project->project->client->id) }}
                                                    </span>
                                                    <span class="opacity-50">
                                                        ({{ getNumberOfReview($bidded_project->project->client->id) }} {{ translate('Reviews') }})
                                                    </span>
                                                </div>
                                            </div>
    	                                </a>
                                    </div>
    								<div>
                                        <ul class="d-flex list-inline mb-0">
                                            <li class="border-right mr-2 pr-2">
                                                <span class="small text-secondary">{{ translate('Total bids') }}</span>
                                                <h4 class="mb-0 h6 fs-13">{{ $bidded_project->project->bids }}</h4>
                                            </li>
                                            <li class="border-right mr-2 pr-2">
                                                <span class="small text-secondary">{{ translate('My bid') }}</span>
                                                <h4 class="mb-0 h6 fs-13">{{ single_price($bidded_project->amount) }}</h4>
                                            </li>
                                            <li class="border-right mr-2 pr-2">
                                                <button type="button" class="btn btn-info btn-xs bidded_project" data-toggle="modal" data-target="#myModal" id_pro="{{ $bidded_project->id }}">تعديل</button>
                                            </li>
                                        </ul>
    								</div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="las la-frown la-4x mb-4 opacity-40"></i>
                                <h4>{{ translate('Nothing Found') }}</h4>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $bidded_projects->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label class="form-label">
                {{translate('Place Bid Price')}}
                <span class="text-danger">*</span>
            </label>
            <div class="form-group">
                <input type="number" min="0" step="0.01" class="form-control form-control-sm" name="amount" placeholder="السعر" required>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">
                مدة التنفيذ
                <span class="text-danger">*</span>
            </label>
            <div class="form-group">
                <input type="number" min="0" step="0.01" class="form-control form-control-sm" name="execute" placeholder="مدة التنفيذ" required>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">
                {{translate('Cover Letter')}}
                <span class="text-danger">*</span>
            </label>
            <div class="form-group">
                <textarea class="form-control" rows="3" name="message" required></textarea>
            </div>
        </div>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1">{{ translate('Submit') }}</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
          $(".bidded_project").click(function(){
          var day=  this.attr('id_pro');
          alert(day);



          });
        });
</script>



@endsection
