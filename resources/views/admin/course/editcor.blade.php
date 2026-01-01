
@extends('admin/layouts.master')
@section('title', 'Edit Course - Admin')
@section('body')
<section class="content">
  @include('admin.message')
  <div class="row">
    <!-- left column -->
    <div class="col-xs-12 box box-primary">
      @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

      <!-- general form elements -->
        <div class="box-header with-border">
          <h3 class="box-title"> {{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Course') }}</h3>
        </div>
         <div class="text-right"><h4 class="admin-form-text"><a href="javascript:history.back()" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">
                    <button class="btn btn-xs btn-success abc"> << {{ __('adminstaticword.Back') }}</button> </i></a></h4></div>
        
        <br>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            <form action="{{route('courseup.update',$cor->id)}}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}  
              {{ method_field('PUT') }}
             
              
              
              <br>

              <div class="row">
                <div class="col-md-6"> 
                  @php
                      $languages = App\CourseLanguage::all();
                  @endphp
                  <label for="exampleInputSlug">{{ __('adminstaticword.SelectLanguage') }}</label>
                  <select name="language_id" class="form-control js-example-basic-single col-md-7 col-xs-12">
                    @foreach($languages as $cat)
                      <option {{ $cor->language_id == $cat->id ? 'selected' : "" }} value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                  </select>
                  @error('language_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
              </div>
              <br>

              <div class="row">

                <div class="col-md-6"> 
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Title') }}:<sup class="redstar">*</sup></label>
                  <input type="text" class="form-control" name="title" id="exampleInputTitle" value="{{ $cor->title }}">
                  @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-6">
                  <label for="exampleInputSlug">{{ __('adminstaticword.Slug') }}: <sup class="redstar">*</sup></label>
                  <input pattern="[/^\S*$/]+" type="text" class="form-control" name="slug" id="exampleInputPassword1" value="{{ $cor->slug}}" >
                  @error('slug')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-6">
                  <label for="exampleInputDetails">{{ __('adminstaticword.ShortDetail') }}:<sup class="redstar">*</sup></label>
                  <textarea name="short_detail" rows="3" class="form-control" maxlength="300">{{ old('short_detail', $cor->short_detail) }}</textarea>
                  @error('short_detail')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                  <label for="exampleInputDetails">{{ __('adminstaticword.Eligible') }}:<sup class="redstar">*</sup></label>
                  <textarea name="requirement" id="requirement" rows="3" class="form-control"  >{{ old('requirement', $cor->requirement) }}</textarea>
                  @error('requirement')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
              </div>
              <br>
              
               <div class="row">
                <div class="col-md-6">
                  <label for="exampleInputDetails">Course requirements:<sup class="redstar">*</sup></label>
                  <textarea name="course_require" id="course_require" rows="3" class="form-control" maxlength="300">{!! $cor->course_require !!}</textarea>
                  @error('course_require')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-12">
                  <label for="exampleInputDetails">{{ __('adminstaticword.Detail') }}:<sup class="redstar">*</sup></label>
                  <textarea id="detail" name="detail" rows="3" class="form-control"  >{!! $cor->detail !!}</textarea>
                  @error('detail')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
              </div>
              <br>

              <div class="row">
               
                
                <div class="col-md-3"> 
                  @if(Auth::User()->role == "admin")
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Featured') }}:</label>
                  <li class="tg-list-item">
                    <input class="tgl tgl-skewed" id="cb1" type="checkbox"{{ $cor->featured==1 ? 'checked' : '' }}>
                    <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="cb1"></label>
                  </li>
                  <input type="hidden" name="featured" value="{{ $cor->featured }}" id="f">
                  @endif
                </div>
                <div class="col-md-3">
                  @if(Auth::User()->role == "admin")
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}:</label>
                    <li class="tg-list-item">
                    <input class="tgl tgl-skewed" id="cb333" type="checkbox" {{ $cor->status==1 ? 'checked' : '' }}>
                    <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="cb333"></label>
                    </li>
                    <input type="hidden" name="status" value="{{ $cor->status }}" id="c33">
                  @endif
                </div>
              </div>
              <br>
           
              <div class="row">
                <div class="col-md-4">
                  <label for="exampleInputDetails">{{ __('adminstaticword.PreviewVideo') }}:</label>  
                  <li class="tg-list-item"> 
                    <input name="preview_type"  class="tgl tgl-skewed" id="preview" type="checkbox" {{ $cor->preview_type=="video" ? 'checked' : '' }}>

                    <label class="tgl-btn" data-tg-off="URL" data-tg-on="Upload" for="preview" ></label>
                  </li>
                  <input type="hidden" name="free" value="0" id="to">

                  <div @if($cor->preview_type =="url" ) class="display-none" @endif id="document1">
                    <label for="exampleInputSlug">{{ __('adminstaticword.UploadVideo') }}: <sup class="redstar">*</sup></label>
                    <input  type="file" class="form-control" name="video" id="video" value="{{ $cor->video }}">
                    @if($cor->video !="")
                      <video src="{{ asset('video/preview/'.$cor->video) }}" width="200" height="150" controls muted>
                      </video>
                    @endif 
                  </div>

                  <div @if($cor->preview_type =="video") class="display-none" @endif id="document2">
                    <br>
                    <label for="exampleInputSlug">{{ __('adminstaticword.URL') }}: <sup class="redstar">*</sup></label>
                    <input  class="form-control" placeholder="Enter Your URL" name="url" id="url" value="{{ $cor->url }}">
                  </div>
                </div>
                <div class="col-md-3">
                  <label>{{ __('adminstaticword.PreviewImage') }}:</label> 
                  <br> 
                  <input type="file" name="image" id="image" class="inputfile inputfile-1"  />
                  <label for="image"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="7" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>{{ __('adminstaticword.Chooseafile') }}&hellip;</span>
                  </label>
                  <br>
                  @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
                      <img src="{{ url('/images/course/'.$cor->preview_image) }}" height="70px;" width="70px;"/>
                  @else
                      <img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course" class="img-fluid">
                  @endif
                </div>
                 <div class="col-md-3">
                  <label>Audio Player Image:</label> 
                  <br> 
                  <input type="file" name="player_image" id="player_image" class="inputfile inputfile-1"  />
                  <label for="player_image"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="7" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>{{ __('adminstaticword.Chooseafile') }}&hellip;</span>
                  </label>
                  <br>
                  @if($cor['player_image'] !== NULL && $cor['player_image'] !== '')
                      <img src="{{ url('/images/class/player_image/'.$cor->player_image) }}" height="70px;" width="70px;"/>
                  @else
                      <img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course" class="img-fluid">
                  @endif
                </div>
               
                
               
              </div>
              
              
              
            </div>
              <br>
              <br>

              <div class="box-footer">
                <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('adminstaticword.Save') }}</button>
              </div>
         
            </form>
        </div>
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
(function($) {
  "use strict";
    // tinymce.init({selector:'textarea#detail', browser_spellcheck: true,   contextmenu: false});
    tinymce.init({
      selector:'textarea#detail',
     
      plugins: [
        'advlist autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code help wordcount'
      ],      
      toolbar: 'insert | undo redo |  formatselect | bold italic forecolor  backcolor underline link| alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
      content_style:
    "@import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap'); body { font-family: Open Sans, sans-serif; }",
    browser_spellcheck: true,
      contextmenu: false,
      fontsize_formats: "8px 10px 12px 14px 15px 16px 18px 24px 36px",
      font_formats:"Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago;Open Sans=Open Sans, sans-serif; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats;"


    });
    tinymce.init({
      selector:'textarea#requirement',
     
      plugins: [
        'advlist autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code help wordcount'
      ],      
      toolbar: 'insert | undo redo |  formatselect | bold italic forecolor  backcolor underline link| alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
      content_style:
    "@import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap'); body { font-family: Open Sans, sans-serif; }",
    browser_spellcheck: true,
      contextmenu: false,
      fontsize_formats: "8px 10px 12px 14px 15px 16px 18px 24px 36px",
      font_formats:"Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago;Open Sans=Open Sans, sans-serif; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats;"


    });
    tinymce.init({
      selector:'textarea#course_require',
     
      plugins: [
        'advlist autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code help wordcount'
      ],      
      toolbar: 'insert | undo redo |  formatselect | bold italic forecolor  backcolor underline link | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
      content_style:
    "@import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap'); body { font-family: Open Sans, sans-serif; }",
    browser_spellcheck: true,
      contextmenu: false,
      fontsize_formats: "8px 10px 12px 14px 15px 16px 18px 24px 36px",
      font_formats:"Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago;Open Sans=Open Sans, sans-serif; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats;"

    });
    
    // tinymce.init({selector:'textarea#requirement', browser_spellcheck: true,   contextmenu: false});

    // tinymce.init({selector:'textarea#course_require', browser_spellcheck: true,   contextmenu: false});

})(jQuery);
</script>

<script>
(function($) {
  "use strict";

  $(function() {
    $('.js-example-basic-single').select2();
  });

  $(function() {
    $('#cb1').change(function() {
      $('#f').val(+ $(this).prop('checked'))
    })
  })

  $(function() {
    $('#cb3').change(function() {
      $('#test').val(+ $(this).prop('checked'))
    })
  })

  $(function(){

      $('#murl').change(function(){
        if($('#murl').val()=='yes')
        {
            $('#doab').show();
        }
        else
        {
            $('#doab').hide();
        }
      });

  });

  $(function(){

      $('#murll').change(function(){
        if($('#murll').val()=='yes')
        {
            $('#doabb').show();
        }
        else
        {
            $('#doab').hide();
        }
      });

  });

  $('#preview').on('change',function(){

    if($('#preview').is(':checked')){
      $('#document1').show('fast');
      $('#document2').hide('fast');    

    }else{
      $('#document2').show('fast');
      $('#document1').hide('fast');    
    }

  });
  
  $(function() {
    $('#cb111').change(function() {
      $('#j111').val(+ $(this).prop('checked'))

      if($('#j111').val() == 0)
      {
        $('#doabox').hide();
          $('#doaboxx').hide();
          $('#doabox2').hide();
          $('#doaboxx2').hide();

          
      }
      else
      {
        $('#doabox').show();
        $('#doaboxx').show();
        $('#doabox2').show();
        $('#doaboxx2').show();

      }

    })
  })
  
  $(function(){
  if($('#accred').is(':checked')){
  $('#cpdcma').show('fast');
 
}
  $('#accred').on('change',function(){
if($('#accred').is(':checked')){
  $('#cpdcma').show('fast');
 
}else{
  $('#cpdcma').hide('fast');

}
 });
 })


  $(function() {
    var urlLike = '{{ url('admin/dropdown') }}';
    $('#category_id').change(function() {
      var up = $('#upload_id').empty();
      var cat_id = $(this).val();    
      if(cat_id){
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:"GET",
          url: urlLike,
          data: {catId: cat_id},
          success:function(data){   
            console.log(data);
            up.append('<option value="0">Please Choose</option>');
            $.each(data, function(id, title) {
              up.append($('<option>', {value:id, text:title}));
            });
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        });
      }
    });
  });

  $(function() {
    var urlLike = '{{ url('admin/gcat') }}';
    $('#upload_id').change(function() {
      var up = $('#grand').empty();
      var cat_id = $(this).val();    
      if(cat_id){
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:"GET",
          url: urlLike,
          data: {catId: cat_id},
          success:function(data){   
            console.log(data);
            up.append('<option value="0">Please Choose</option>');
            $.each(data, function(id, title) {
              up.append($('<option>', {value:id, text:title}));
            });
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        });
      }
    });
  });

})(jQuery);



</script>
  
@endsection
