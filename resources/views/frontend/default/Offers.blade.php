@if (Auth::check())





<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<style>
    body {
        margin-top: 20px;
        background-color: #e9ebee;
    }

    .be-comment-block {
        margin-bottom: 50px !important;
        border: 1px solid #edeff2;
        border-radius: 2px;
        padding: 50px 70px;
        border: 1px solid #ffffff;
    }

    .comments-title {
        font-size: 16px;
        color: #262626;
        margin-bottom: 15px;
        font-family: 'Conv_helveticaneuecyr-bold';
    }

    .be-img-comment {
        width: 60px;
        height: 60px;
        float: left;
        margin-bottom: 15px;
    }

    .be-ava-comment {
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }

    .be-comment-content {
        margin-left: 80px;
    }

    .be-comment-content span {
        display: inline-block;
        width: 49%;
        margin-bottom: 15px;
    }

    .be-comment-name {
        font-size: 13px;
        font-family: 'Conv_helveticaneuecyr-bold';
    }

    .be-comment-content a {
        color: #383b43;
    }

    .be-comment-content span {
        display: inline-block;
        width: 49%;
        margin-bottom: 15px;
    }

    .be-comment-time {
        text-align: right;
    }

    .be-comment-time {
        font-size: 11px;
        color: #b4b7c1;
    }

    .be-comment-text {
        font-size: 13px;
        line-height: 18px;
        color: #7a8192;
        display: block;
        background: #f6f6f7;
        border: 1px solid #edeff2;
        padding: 15px 20px 20px 20px;
    }

    .form-group.fl_icon .icon {
        position: absolute;
        top: 1px;
        left: 16px;
        width: 48px;
        height: 48px;
        background: #f6f6f7;
        color: #b5b8c2;
        text-align: center;
        line-height: 50px;
        -webkit-border-top-left-radius: 2px;
        -webkit-border-bottom-left-radius: 2px;
        -moz-border-radius-topleft: 2px;
        -moz-border-radius-bottomleft: 2px;
        border-top-left-radius: 2px;
        border-bottom-left-radius: 2px;
    }

    .form-group .form-input {
        font-size: 13px;
        line-height: 50px;
        font-weight: 400;
        color: #b4b7c1;
        width: 100%;
        height: 50px;
        padding-left: 20px;
        padding-right: 20px;
        border: 1px solid #edeff2;
        border-radius: 3px;
    }

    .form-group.fl_icon .form-input {
        padding-left: 70px;
    }

    .form-group textarea.form-input {
        height: 150px;
    }

    .be-ava-comment {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-top: 58%;
    }
</style>
<hr>
<div class="container">
    <div class="be-comment-block">
        <h1 class="comments-title">اجمالي العروض المقدمة
            ({{  DB::table('project_bids')->where('project_id',$project->id)->count()}})</h1>
        @foreach(DB::table('project_bids')->where('project_id', $project->id)->orderBy('id','desc')->get() as
        $item_project_bids)
        <div class="be-comment">
            <div class="be-img-comment">
                <a href="#">
                    @if (get_current_user__($item_project_bids->bid_by_user_id,"photo") != null)
                    <img src="{{ custom_asset(get_current_user__($item_project_bids->bid_by_user_id,"photo")) }}" alt=""
                        class="be-ava-comment">

                    @else
                    <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}" class="be-ava-comment">

                    @endif
                </a>
            </div>
            <div class="be-comment-content">
                <span class="be-comment-name">
                    <a href="#">{{ get_current_user__($item_project_bids->bid_by_user_id,"name") }}</a>
                </span>
                <p style="background: #f3f3f3;border: 1px solid #dfe0e0;padding: 1%;">
                    <span style="
                    font-size: 20px;
                "><svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="square" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg> العرض المقدم&nbsp;:&nbsp;&nbsp;{{ $item_project_bids->amount}}</span>   
                    <span style="
                    font-size: 20px;
                "><svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="square" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg> مدة التنفيذ&nbsp;:&nbsp;&nbsp;{{ $item_project_bids->execute}} يوم</span>   

                       {{--  <button type="button" class="btn btn-success btn-sm btn-block"> العرض المقدم &nbsp; &nbsp;
                           &nbsp; <span class="label label-default">{{ $item_project_bids->amount}}</span></button>  --}}
                   </p>
                <p class="be-comment-text">
                    {{ $item_project_bids->message}}
                  
                </p>
                {{-- <a href="{{ route('all.messages.user', ['id'=>$item_project_bids->bid_by_user_id]) }}" class="btn btn-warning ">ارسال الرسالة</a> --}}
                <form class="mt-2" action="{{ route('call_for_interview') }}" method="post">
                    @csrf
                    <input type="hidden" id="project_id" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" id="user_name" name="user_name" value="{{ get_current_user__($item_project_bids->bid_by_user_id,"user_name") }}">
                    <button type="submit" class="btn btn-primary btn-sm btn-block">{{ translate('Call for Interview') }}</button>
                </form>
                <a href="#" class="btn btn-success "  onclick="hiring_modal({{ $project->id }}, {{ $item_project_bids->bid_by_user_id }})" type="button"  >قبول العرض</a>
            </div>

           
        </div>
        <hr>
        @endforeach
    </div>
</div>

@endif