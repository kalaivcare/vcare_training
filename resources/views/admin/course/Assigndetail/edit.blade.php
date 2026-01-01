@extends('admin.layouts.master')
@section('title', 'Edit Assignment - Admin')
@section('body')

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">EditAssignment</h3>
          <div class="text-right" style="margin-top: -35px;">
            <a href="{{ route('assignmentindex') }}" class="btn btn-xs btn-success" data-toggle="tooltip" title="Go back">
              << {{ __('adminstaticword.Back') }}
            </a>
          </div>
        </div>

        <div class="box-body">
          <form id="demo-form" method="POST" action="{{ route('assigndetail.update', $assignment->id) }}" 
                data-parsley-validate class="form-horizontal form-label-left" 
                enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
              <div class="col-md-12">
                <label for="assignment">Description:<span class="redstar">*</span></label>
                <textarea name="assignment" id="assignment" class="form-control" placeholder="Enter Assignment Description">{{ old('assignment', $assignment->assignment) }}</textarea>
              </div>
            </div>

            <br>

            <div class="box-footer">
              <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('adminstaticword.Save') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
