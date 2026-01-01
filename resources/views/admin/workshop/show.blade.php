@extends('admin/layouts.master')
@section('title', 'Edit Course - Admin')
@section('body')

<div class="box">
  <div class="box-header">
    <h3 >{{$cor->title }}</h3>
  </div>
  <div class="box-body">
  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  </div>    
</div>

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">

        <div class="content-header">
        </div>
        <div class="box-body">
          <div class="nav-tabs-custom">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="nav-tab" role="tablist">
              <li role="presentation" class="active"><a href="#a" aria-controls="home" role="tab" data-toggle="tab">Workshops</a></li>
              <li class=""  role="presentation"><a href="#b" aria-controls="profile" role="tab" data-toggle="tab">Workshop Includes</a></li>
              <li  class=""  role="presentation"><a href="#c" aria-controls="messages" role="tab" data-toggle="tab">{{ __('adminstaticword.WhatLearns') }}</a></li>
                 
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="a">
                @include('admin.workshop.editcor')
              </div>
              <div role="tabpanel" class="tab-pane fade" id="b">
                @include('admin.workshop.workshopinclude.index')
              </div>
              <div role="tabpanel" class="fade tab-pane" id="c">
                @include('admin.workshop.workwhatlearn.index')
              </div>
                          
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection


@section('script')

<script>
(function($) {
"use strict";
  $(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#nav-tab a[href="' + activeTab + '"]').tab('show');
    }
  });
})(jQuery);
</script>

@endsection
  