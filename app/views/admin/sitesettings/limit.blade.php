@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-wrench"></i></small>
            Limit Settings
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        {{ Form::open() }}
        <div class="form-group">
            <label for="addnew">Number Of Post in gallery</label>
            <select name="numberOfImages" class="form-control">
                <option value="{{ perPage() }}">{{ perPage() }}</option>
                <option>--------</option>
                @for($i=1;$i<=100;$i++)
                <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="addnew">Auto Approve Posts</label>
            <select name="autoApprove" class="form-control">
                @if(siteSettings('autoApprove') == 1)
                <option value="1">Yes</option>
                @else
                <option value="0">No</option>
                @endif
                <option>--------</option>
                <option value="1">Yes</option>
                <option value="0">No ( admin is approval required )</option>
            </select>
        </div>

<!--        <div class="form-group">-->
<!--            <label for="addnew">Limit Per Day image upload by each user</label>-->
<!--            <select name="limitPerDay" class="form-control">-->
<!--                <option value="{{ limitPerDay() }}">{{ limitPerDay() }}</option>-->
<!--                <option>--------</option>-->
<!--                @for ($l = 1; $l <= 500; $l++): ?>-->
<!--                    <option value="{{ $l }}">{{ $l }}</option>-->
<!--                @endfor-->
<!--            </select>-->
<!--        </div>-->

        <div class="form-group">
            {{ Form::submit('Update',array('class'=>'btn btn-success')) }}
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop
