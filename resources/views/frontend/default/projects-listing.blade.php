@extends('frontend.default.layouts.app')

@section('content')
    <section class="py-4 py-lg-5">
        {{ googel("Projects","Top") }}
        <div class="container">
            @if($keyword != null)
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 text-center">
                        <h1 class="h5 mt-3 mt-lg-0 mb-5 fw-400">{{ translate('Total') }} <span class="fw-600">{{ $total }}</span> {{ translate('projects found for') }} <span class="fw-600">{{ $keyword }}</span></h1>
                    </div>
                </div>
            @endif
            <form id="project-filter-form" action="" method="GET">
                <div class="row gutters-10">
                    <div class="col-xl-3 col-lg-4">
                        <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-lg z-1035">
                            <div class="card rounded-0 rounded-lg collapse-sidebar c-scrollbar-light">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">{{ translate('Filter By') }}</h5>
                                    <button class="btn btn-sm p-2 d-lg-none filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" type="button">
                                        <i class="las la-times la-2x"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <h6 class="separator text-left mb-3 fs-12 text-uppercase text-secondary">
                                            <span class="bg-white pr-3">{{ translate('Categories') }}</span>
                                        </h6>
                                        <div class="category-filter fs-14">
                                            <ul class="list-unstyled mb-0">
                                                @if (!isset($category_id))
                                                    @foreach (\App\Models\ProjectCategory::where('parent_id', 0)->get() as $category)
                                                        <li><a  href="{{ route('projects.category', $category->slug) }}"><span style="
                                                            float: left;
                                                            background: #ecece4;
                                                            padding: 1%;
                                                            font-weight: 600;
                                                            border-radius: 10%;
                                                        "  class="label label-warning">{{ DB::table('projects')->where('project_category_id',$category->id)->count() }}</span>{{ $category->name }}</a></li>
                                                    @endforeach
                                                @else
                                                    <li class="go-back"><a href="{{ route('search') }}">All Categories</a></li>
                                                    @if (\App\Models\ProjectCategory::find($category_id)->parent_id != 0)
                                                        <li class="go-back"><a href="{{ route('projects.category', \App\Models\ProjectCategory::find(\App\Models\ProjectCategory::find($category_id)->parent_id)->slug) }}">{{ \App\Models\ProjectCategory::find(\App\Models\ProjectCategory::find($category_id)->parent_id)->name }}</a></li>
                                                    @endif
                                                    <li class="go-back"><a href="{{ route('projects.category', \App\Models\ProjectCategory::find($category_id)->slug) }}">{{ \App\Models\ProjectCategory::find($category_id)->name }}</a></li>
                                                    @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category_id) as $key => $id)
                                                        <li ><a href="{{ route('projects.category', \App\Models\ProjectCategory::find($id)->slug) }}">{{ \App\Models\ProjectCategory::find($id)->name }}</a></li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <h6 class="separator text-left mb-3 fs-12 text-uppercase text-secondary">
                                            <span class="bg-white pr-3">{{ translate('Project Type') }}</span>
                                        </h6>
                                        <div class="aiz-checkbox-list">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" name="projectType[]" value="Fixed" @if (in_array('Fixed', $projectType))
                                                    checked
                                                @endif onchange="applyFilter()"> {{ translate('Fixed Price') }}
                                                <span class="aiz-square-check"></span>
                                                <span class="float-right text-secondary fs-12" >({{ DB::table('projects')->where('type',"Fixed")->count() }})</span>
                                            </label>
                                            <label class="aiz-checkbox">
                                                <input type="checkbox"  name="projectType[]" value="Long Term" @if (in_array('Long Term', $projectType))
                                                    checked
                                                @endif onchange="applyFilter()"> {{ translate('Long Term') }}
                                                <span class="aiz-square-check"></span>
                                                <span class="float-right text-secondary fs-12">({{ DB::table('projects')->where('type',"long_term")->count() }})</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <h6 class="separator text-left mb-3 fs-12 text-uppercase text-secondary">
                                            <span class="bg-white pr-3">{{ translate('Numbers of Bids') }}</span>
                                        </h6>
                                        <div class="aiz-radio-list">
                                            <label class="aiz-radio">
                                                <input type="radio" name="bids" value="" onchange="applyFilter()" @if ($bids == "")
                                                    checked
                                                @endif> {{ translate('Any Number of bids') }}
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">({{ DB::table('projects')->where('bids',0)->count() }})</span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="bids" value="0-5" onchange="applyFilter()" @if ($bids == "0-5")
                                                    checked
                                                @endif> {{ translate('0 to 5') }}
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">({{ DB::table('projects')->whereBetween('bids', [0, 5])->count() }})</span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="bids" value="5-10" onchange="applyFilter()" @if ($bids == "5-10")
                                                    checked
                                                @endif> {{ translate('5 to 10') }}
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">({{ DB::table('projects')->whereBetween('bids', [5, 10])->count() }})</span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="bids" value="10-20" onchange="applyFilter()" @if ($bids == "10-20")
                                                    checked
                                                @endif> {{ translate('10 to 20') }}
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">({{ DB::table('projects')->whereBetween('bids', [10, 20])->count() }})</span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="bids" value="20-30" onchange="applyFilter()" @if ($bids == "20-30")
                                                    checked
                                                @endif> {{ translate('20 to 30') }}
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">({{ DB::table('projects')->whereBetween('bids', [20, 30])->count() }})</span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="bids" value="30+" onchange="applyFilter()" @if ($bids == "30+")
                                                    checked
                                                @endif> {{ translate('30+') }}
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">({{ DB::table('projects')->whereBetween('bids', [30, 3000])->count() }})</span>
                                            </label>
                                        </div>
                                    </div>
                                    {{-- <div class="">
                                        <h6 class="separator text-left mb-3 fs-12 text-uppercase text-secondary">
                                            <span class="bg-white pr-3">Client History</span>
                                        </h6>
                                        <div class="aiz-radio-list">
                                            <label class="aiz-radio">
                                                <input type="radio" name="radio3" checked="checked"> Any client history
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">(200)</span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="radio3"> No hires
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">(200)</span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="radio3"> 1 to 10 hires
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">(200)</span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="radio3"> 10+ hires
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">(200)</span>
                                            </label>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <div class="card mb-lg-0">
                            <input type="hidden" name="type" value="project">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm btn-icon btn-soft-secondary d-lg-none flex-shrink-0 mr-2" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" type="button">
                                        <i class="las la-filter"></i>
                                    </button>
                                    <input type="text" class="form-control form-control-sm" placeholder="Search Keyword" value="{{ $keyword }}" name="keyword">
                                </div>

                                <div class="w-200px">
                                    <select class="form-control form-control-sm aiz-selectpicker" name="sort" onchange="applyFilter()">
                                        <option value="1" @if($sort == '1') selected @endif>{{ translate('Newest first') }}</option>
                                        <option value="2" @if($sort == '2') selected @endif>{{ translate('Lowest budget first') }}</option>
                                        <option value="3" @if($sort == '3') selected @endif>{{ translate('Highest budget first') }}</option>
                                        <option value="4" @if($sort == '4') selected @endif>{{ translate('Lowest bids first') }}</option>
                                        <option value="5" @if($sort == '5') selected @endif>{{ translate('Highest bids first') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body p-0">

                                @foreach ($projects as $key => $project)
                                    <a href="{{ route('project.details', $project->slug) }}" class="d-block d-xl-flex card-project text-inherit px-3 py-4">
                                        <div class="flex-grow-1">
                                            <h5 class="h6 fw-600 lh-1-5">{{ $project->name }}</h5>
                                            <div class="text-muted lh-1-8">
                                                <p>{{ function_that_shortens_text_but_doesnt_cutoff_words($project->excerpt,150) }}</p>
                                            </div>
                                            <ul class="list-inline opacity-70 fs-12">
                                                <li class="list-inline-item">
                                                    <i class="las la-clock opacity-40"></i>
                                                    <span>{{ Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="las la-stream opacity-40"></i>
                                                    <span>{{ translate('Project Category') }}</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="las la-handshake"></i>
                                                    <span>@if ($project->project_category != null) {{ $project->project_category->name }} @else {{ translate('Removed Category') }} @endif</span>
                                                </li>
                                            </ul>
                                            <div>
                                                @foreach (json_decode($project->skills) as $key => $skill_id)
                                                    @php
                                                        $skill = \App\Models\Skill::find($skill_id);
                                                    @endphp
                                                    @if ($skill != null)
                                                        <span class="btn btn-light btn-xs mb-1">{{ $skill->name }}</span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 pt-4 pt-xl-0 pl-xl-4 d-flex flex-row-reverse flex-xl-column justify-content-between align-items-center">
                                            <div class="text-right">
                                                <span class="small text-secondary">{{ translate('Budget') }}</span>
                                                <h4 class="mb-0">{{ single_price($project->price) }}</h4>
                                                <div class="mb-0">
                                                    <span>مدة التنيفذ &nbsp;
                                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 480 480" style="enable-background:new 0 0 480 480;" xml:space="preserve">
<g>
	<g>
		<g>
			<path d="M472,432h-24V280c-0.003-4.418-3.588-7.997-8.006-7.994c-2.607,0.002-5.05,1.274-6.546,3.41l-112,160
				c-2.532,3.621-1.649,8.609,1.972,11.14c1.343,0.939,2.941,1.443,4.58,1.444h104v24c0,4.418,3.582,8,8,8s8-3.582,8-8v-24h24
				c4.418,0,8-3.582,8-8S476.418,432,472,432z M432,432h-88.64L432,305.376V432z"/>
			<path d="M328,464h-94.712l88.056-103.688c0.2-0.238,0.387-0.486,0.56-0.744c16.566-24.518,11.048-57.713-12.56-75.552
				c-28.705-20.625-68.695-14.074-89.319,14.631C212.204,309.532,207.998,322.597,208,336c0,4.418,3.582,8,8,8s8-3.582,8-8
				c-0.003-26.51,21.486-48.002,47.995-48.005c10.048-0.001,19.843,3.151,28.005,9.013c16.537,12.671,20.388,36.007,8.8,53.32
				l-98.896,116.496c-2.859,3.369-2.445,8.417,0.924,11.276c1.445,1.226,3.277,1.899,5.172,1.9h112c4.418,0,8-3.582,8-8
				S332.418,464,328,464z"/>
			<path d="M216.176,424.152c0.167-4.415-3.278-8.129-7.693-8.296c-0.001,0-0.002,0-0.003,0
				C104.11,411.982,20.341,328.363,16.28,224H48c4.418,0,8-3.582,8-8s-3.582-8-8-8H16.28C20.283,103.821,103.82,20.287,208,16.288
				V40c0,4.418,3.582,8,8,8s8-3.582,8-8V16.288c102.754,3.974,185.686,85.34,191.616,188l-31.2-31.2
				c-3.178-3.07-8.242-2.982-11.312,0.196c-2.994,3.1-2.994,8.015,0,11.116l44.656,44.656c0.841,1.018,1.925,1.807,3.152,2.296
				c0.313,0.094,0.631,0.172,0.952,0.232c0.549,0.198,1.117,0.335,1.696,0.408c0.08,0,0.152,0,0.232,0c0.08,0,0.152,0,0.224,0
				c0.609-0.046,1.211-0.164,1.792-0.352c0.329-0.04,0.655-0.101,0.976-0.184c1.083-0.385,2.069-1.002,2.888-1.808l45.264-45.248
				c3.069-3.178,2.982-8.242-0.196-11.312c-3.1-2.994-8.015-2.994-11.116,0l-31.976,31.952
				C425.933,90.37,331.38,0.281,216.568,0.112C216.368,0.104,216.2,0,216,0s-0.368,0.104-0.568,0.112
				C96.582,0.275,0.275,96.582,0.112,215.432C0.112,215.632,0,215.8,0,216s0.104,0.368,0.112,0.568
				c0.199,115.917,91.939,210.97,207.776,215.28h0.296C212.483,431.847,216.013,428.448,216.176,424.152z"/>
			<path d="M323.48,108.52c-3.124-3.123-8.188-3.123-11.312,0L226.2,194.48c-6.495-2.896-13.914-2.896-20.408,0l-40.704-40.704
				c-3.178-3.069-8.243-2.981-11.312,0.197c-2.994,3.1-2.994,8.015,0,11.115l40.624,40.624c-5.704,11.94-0.648,26.244,11.293,31.947
				c9.165,4.378,20.095,2.501,27.275-4.683c7.219-7.158,9.078-18.118,4.624-27.256l85.888-85.888
				C326.603,116.708,326.603,111.644,323.48,108.52z M221.658,221.654c-0.001,0.001-0.001,0.001-0.002,0.002
				c-3.164,3.025-8.148,3.025-11.312,0c-3.125-3.124-3.125-8.189-0.002-11.314c3.124-3.125,8.189-3.125,11.314-0.002
				C224.781,213.464,224.781,218.53,221.658,221.654z"/>
		</g>
	</g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
</span>

                                                   
                                                        <span class="text-body mr-1">يوم       &nbsp;{{ $project->execute }} </span>
                                     
                                                </div>                                             

                                                <div class="mt-xl-2 small text-secondary">
                                                    @if ($project->bids > 0)
                                                        <span class="text-body mr-1">{{ $project->bids }}+</span>
                                                    @else
                                                        <span class="text-body mr-1">{{ $project->bids }}</span>
                                                    @endif
                                                    <span >اجمالي العروض</span>
                                                </div>

                                           
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar avatar-xs">
                                                        @if($project->client->photo != null)
                                                            <img src="{{ custom_asset($project->client->photo) }}">
                                                        @else
                                                            <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                                        @endif
                                                    </span>
                                                    <div class="pl-2">
                                                        <h4 class="fs-14 mb-1">@if ( $project->client != null ) {{ $project->client->name }} @endif</h4>
                                                        <div class="text-secondary fs-10">
                                                            <i class="las la-star text-warning"></i>
                                                            <span class="fw-600">{{ formatRating(getAverageRating($project->client->id)) }}</span>
                                                            <span>({{ getNumberOfReview($project->client->id) }} {{ translate('reviews') }})</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                            <div class="card-footer">
                                <div class="aiz-pagination aiz-pagination-center flex-grow-1">
                                    <ul class="pagination">
                                        {{ $projects->links() }}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{ googel("Projects","Down") }}
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        function applyFilter(){
            $('#project-filter-form').submit();
        }
    </script>
@endsection
