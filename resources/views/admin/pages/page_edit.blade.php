@extends('admin/layouts.master')
@section('title', 'Edit Page - Admin')
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
    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> {{ __('adminstaticword.Edit') }} - {!! $find->title !!}</h3>
        </div>
        <div class="box-body">
          <div class="form-group">              
            <form id="demo-form2" method="post" action="{{url('page/'.$find->id)}}" data-parsley-validate class="form-horizontal form-label-left"  enctype="multipart/form-data">
              {{ csrf_field() }}
              {{method_field('PATCH')}}

              <div class="row">
                <div class="col-md-5">
                  <label for="exampleInputName">{{ __('adminstaticword.Title') }}:</label>
                  <input type="text" class="form-control" name="title" id="exampleInputTitle"value="{{$find->title}}">
                </div>
                <div class="col-md-5">
                  <label for="exampleInputSlug">{{ __('adminstaticword.Slug') }}:</label>
                  <input type="text" class="form-control" name="slug" id="exampleInputPassword1" value="{{$find->slug}}">
                </div>
                <div class="col-md-2">
                   <label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}:</label>
                  <li class="tg-list-item">
                    <input class="tgl tgl-skewed" id="cb10" type="checkbox" {{ $find->status==1 ? 'checked' : '' }}>
                    <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="cb10"></label>
                  </li>
                  <input type="hidden" name="status" value="{{ $find->status }}" id="j">
                </div>
                
              </div>
              <br>

              <div class="row">
                <div class="col-md-12">
                   <label for="exampleInputDetails">{{ __('adminstaticword.Detail') }}:</label>
                  <textarea name="details" rows="5" id="editor2" class="form-control" >{{$find->details}}</textarea>
                </div>
              </div>
              <br>

              <div class="box-footer">
                <button type="submit" class="btn btn-md col-md-2 btn-primary">{{ __('adminstaticword.Save') }}</button>
              </div>
            </form>
          </div>
       
        </div>
        <!-- /.box -->
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (right) -->
  </div>
  <!-- /.row -->
</section> 
@endsection

@section('scripts')

<script>
    $(function () {
    //   CKEDITOR.replace('editor2');
          tinymce.init({
      selector:'textarea#editor2',
     
      plugins: [
        'advlist autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code help wordcount'
      ],      
      toolbar: 'insert | undo redo |  formatselect | bold italic link forecolor backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
      content_style:
    "@import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap'); body { font-family: Open Sans, sans-serif; }",
    browser_spellcheck: true,
      contextmenu: "link image inserttable forecolor | cell row column deletetable",
      fontsize_formats: "8px 10px 12px 14px 15px 16px 18px 24px 36px",
      font_formats:"Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago;Open Sans=Open Sans, sans-serif; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats;"

    });
    
    });
  </script>
@endsection
