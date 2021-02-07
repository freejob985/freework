@extends('admin.default.layouts.app')

@section('content')
<div class="row">
    <style>
        .img-thumbnail {
            padding: .25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            max-width: 62%;
            height: auto;
        }
    </style>
@php
@endphp



    <div class="container">
        <img class="img-responsive img-thumbnail" src="https://img4.goodfon.com/wallpaper/nbig/b/c7/construction-design-architecture-engineering-plans-project-1.jpg" alt="Chania">
        <form action=" {{ route('Reasons.rejection.send') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- ##########################(from bg)################################### --}}
            <input type="hidden" placeholder="عنوان " class="form-control" name="id" id="Title"
            placeholder="" value="{{ $id }}">
            <input type="hidden" placeholder="عنوان " class="form-control" name="prog" id="prog"
            placeholder="" value="{{ $prog }}">
            <input type="hidden" placeholder="عنوان " class="form-control" name="services" id="services"
            placeholder="" value="{{ $services }}">
            {{-- ############################################################# --}}
            <div class="form-group">
                <textarea placeholder="الرسالة" name="Code"
                    style="resize: none;font-size: 18px;font-weight: 600;color: white !important;background: #0e1726;"
                    class="form-control" rows="5" id="comment"></textarea>
                @if ($errors->has('Code'))
                <span class="helper-text" data-error="wrong" data-success="right">{{ $errors->first('Code') }}</span>
                @endif
            </div>
            {{-- ############################################################# --}}
            {{-- ##########################(end bg)################################### --}}
            <input type="submit" style="background: #011a25;" class="btn btn-primary btn-large btn-block"
                value="ارسال" />
        </form>
        <br>
        @if(session()->has('alert-success'))
        <input type="submit" style="background: #011a25;background: #20a049;padding: 1%;font-size: 16px;"
            class="btn btn-success save btn-large btn-block" value="  {{ session()->get('alert-success') }}" />
        @endif
    </div>
</div>
@endsection