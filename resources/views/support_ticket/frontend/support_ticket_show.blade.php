
@extends('frontend.default.layouts.app')

@section('content')


<style>
    .rating-lg i {
        font-size: 2.125rem;
    } 
</style>
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @if (\App\Models\Role::find(Session::get('role_id'))->name == 'Client')
                    @include('frontend.default.user.client.inc.sidebar')
                @elseif (\App\Models\Role::find(Session::get('role_id'))->name == 'Freelancer')
                    @include('frontend.default.user.freelancer.inc.sidebar')
                @endif

                <div class="aiz-user-panel">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="h6">{{ $support_ticket->subject }}</h4>
                            <ul class="list-inline small text-muted mb-0">
                                <li class="list-inline-item">{{ $support_ticket->ticket_id }}</li>
                                <li class="list-inline-item text-muted">•</li>
                                <li class="list-inline-item">{{ $support_ticket->created_at }}</li>
                                <li class="list-inline-item text-muted">•</li>
                                <li class="list-inline-item">
                                    @if ($support_ticket->status == '1')
                                        <span class="badge badge-inline badge-success">{{translate('Solved')}}</span>
                                    @else
                                        <span class="badge badge-inline badge-danger">{{translate('Pending')}}</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="bg-soft-secondary p-3">
                                <form  class="form-horizontal" action="{{ route('support-ticket.user_reply') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="support_ticket_id" value="{{ $support_ticket->id }}">
                                    <div class="">
                                        <textarea class="aiz-text-editor" name="reply" required></textarea>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <div class="form-group d-flex">
                                                <div class="align-self-baseline input-group-sm" data-toggle="aizuploader" data-multiple="true">
                                                    <button type="button" class="btn btn-secondary btn-sm">
                                                        <i class="la la-paperclip"></i>
                                                    </button>
                                                    <input type="hidden" name="attachments" class="selected-files">
                                                </div>
                                                <div class="file-preview box sm flex-grow-1 ml-3"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <button type="submit" class="btn btn-sm btn-primary"><i class="lab la-telegram-plane" title="{{ translate('Send Reply') }}"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <ul class="list-group list-group-flush mb-0 px-4">
                                @foreach ($support_replies as $key => $support_reply)
                                    @php
                                        $user = \App\User::where('id', $support_reply->replied_user_id)->first();
                                    @endphp
                                    <li class="list-group-item py-5">
                                        <div class="media">
                                            <span class="avatar avatar-sm mr-3 flex-shrink-0">
                                                @if ($user->photo != null)
                                                    <img src="{{ custom_asset($user->photo) }}">
                                                @else
                                                    <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                                @endif
                                            </span>
                                            <div class="media-body">
                                                <div class="mb-3 mb-sm-0">
                                                    <div class="mb-2">
                                                        <h4 class="d-inline-block mb-0">
                                                            <a class="d-block h6 mb-0">{{ $user->name }}</a>
                                                        </h4>
                                                        <small class="d-block text-muted">{{ Carbon\Carbon::parse($support_reply->created_at)->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                                <div>@php echo $support_reply->reply @endphp</div>
                                                <div class="file-preview box clearfix">
                                                    @foreach (explode(",",$support_reply->attachments) as $attachment_id)
                                                        @php
                                                            $attachment = \App\Upload::find($attachment_id);
                                                        @endphp
                                                         @if ($attachment != null)
                                                            <div class="mt-2 file-preview-item" title="{{ $attachment->file_name }}">
                                                                <a href="{{ route('download_attachment', $attachment->id) }}" target="_blank" class="d-block">
                                                                    <div class="thumb">
                                                                        @if($attachment->type == 'image')
                                                                            <img src="{{ custom_asset($attachment_id) }}" class="img-fit">
                                                                        @else
                                                                            <i class="la la-file-text"></i>
                                                                        @endif
                                                                    </div>
                                                                    <div class="body">
                                                                        <h6 class="d-flex">
                                                                            <span class="text-truncate title">{{ $attachment->file_original_name }}</span>
                                                                            <span class="ext">.{{ $attachment->extension }}</span>
                                                                        </h6>
                                                                        <p>{{formatBytes($attachment->file_size)}}</p>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                         @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                @php
                                    $sender = \App\User::where('id', $support_ticket->sender_user_id)->first();
                                @endphp
                                <li class="list-group-item py-5">
                                    <div class="media">
                                        <span class="avatar avatar-sm mr-3 flex-shrink-0">
                                            @if ($sender->photo != null)
                                                <img src="{{ custom_asset($sender->photo) }}">
                                            @else
                                                <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                            @endif
                                        </span>

                                        <div class="media-body">
                                            <div class="mb-3 mb-sm-0">
                                                <div class="mb-2">
                                                    <h4 class="d-inline-block mb-0">
                                                        <a class="d-block h6 mb-0">{{$sender->name}}</a>
                                                    </h4>

                                                    <small class="d-block text-muted">{{ Carbon\Carbon::parse($support_ticket->created_at)->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            <div>@php echo $support_ticket->description  @endphp</div>

                                            <div class="file-preview box clearfix">
                                              @foreach (explode(",",$support_ticket->attachments) as $attachment_id)
                                                  @php
                                                      $attachment = \App\Upload::find($attachment_id);
                                                  @endphp
                                                  @if ($attachment != null)
                                                    <div class="mt-2 file-preview-item" title="{{ $attachment->file_name }}">
                                                      <a href="{{ route('download_attachment', $attachment->id) }}" target="_blank" class="d-block">
                                                          <div class="thumb">
                                                              @if($attachment->type == 'image')
                                                                  <img src="{{ custom_asset($attachment_id) }}" class="img-fit">
                                                              @else
                                                                  <i class="la la-file-text"></i>
                                                              @endif
                                                              </div>
                                                              <div class="body">
                                                                  <h6 class="d-flex">
                                                                      <span class="text-truncate title">{{ $attachment->file_original_name }}</span>
                                                                      <span class="ext">.{{ $attachment->extension }}</span>
                                                                  </h6>
                                                                  <p>{{formatBytes($attachment->file_size)}}</p>
                                                              </div>
                                                          </a>
                                                      </div>
                                                  @endif
                                              @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            @if ($support_ticket->status=="1" and $support_ticket->st=="0" )
                                
                       
                            <form action="{{ route('support-ticket.reviews') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="h6 mb-0">تقيم الدعم</h4>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="{{ $support_ticket->id }}">
                                    <div class="form-group">
                                        <div class="rating rating-input rating-lg">
                                            <label>
                                                <input type="radio" name="rating" value="1">
                                                <i class="las la-star active"></i>
                                            </label>
                                            <label>
                                                <input type="radio" name="rating" value="2">
                                                <i class="las la-star active"></i>
                                            </label>
                                            <label>
                                                <input type="radio" name="rating" value="3" >
                                                <i class="las la-star active"></i>
                                            </label>
                                            <label>
                                                <input type="radio" name="rating" value="4">
                                                <i class="las la-star"></i>
                                            </label>
                                            <label>
                                                <input type="radio" name="rating" value="5" checked="">
                                                <i class="las la-star"></i>
                                            </label>


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ translate('Comment') }}</label>
                                        <textarea class="form-control" rows="5" name="review" required style="
                                        background: #e4b7a5;
                                        color: white;
                                        font-size: 25px;
                                        resize: none;
                                    "></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">تأكيد التقيم</button>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>

                

            </div>


        </div>




    </section>

@endsection
