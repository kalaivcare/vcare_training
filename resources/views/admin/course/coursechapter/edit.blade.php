@extends('admin/layouts.master')
@section('title', 'Edit Chapter - Admin')
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

@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif


<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-xs-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('adminstaticword.EditCourseChapter') }}</h3>
        </div>
        <div class="text-right"><h4 class="admin-form-text"><a href="{{route('chapterindex')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating" style="margin:10px"><i class="material-icons">
                    <button class="btn btn-xs btn-success abc"> << {{ __('adminstaticword.Back') }}</button> </i></a></h4></div>

        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
          <div class="form-group">
            <form id="demo-form" method="post" action="{{url('updatechapter/'.$cate->id)}}"data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
              {{ csrf_field() }}
              {{ method_field('PUT') }}

              <label class="display-none" for="exampleInputSlug">{{ __('adminstaticword.SelectCourse') }}</label>
          


              <div class="row">
    <!-- Select Course -->
    <div class="col-md-6">
        <label for="course_id">{{ __('adminstaticword.Course') }}:<span class="redstar">*</span></label>
        <select name="course_id" id="course_id" class="form-control js-example-basic-single" required>
            <option value="" selected disabled>Select a course</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ $cate->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->title }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Chapter Title -->
    <div class="col-md-6">
        <label for="chapter_name">{{ __('adminstaticword.Title') }}:<span class="redstar">*</span></label>
        <input type="text" class="form-control" name="chapter_name" id="chapter_name" value="{{ $cate->chapter_name }}">
    </div>

    <!-- Module Type -->
<div class="col-md-6 mt-2">
    <label for="module_type">
        Chapter Type:<span class="redstar">*</span>
    </label>

    <select class="form-control" name="module_type" id="module_type" required>
    <option value="">-- Select Chapter Type --</option>

    @foreach($modules as $module)
        <option value="{{ $module->name }}"
            {{ $cate->module_type == $module->name ? 'selected' : '' }}>
            {{ $module->name }}
        </option>
    @endforeach
</select>

</div>

</div>

<div class="row mt-3">
    <div class="col-md-12">
        <h5>Chapter Materials</h5>
       @forelse($CourseClass as $index => $file)
    <div class="material-block mb-2">
        <input type="text"
               class="form-control mb-1"
               name="title_{{ $file->id }}"
               placeholder="Enter title for this file"
               value="{{ $file->title ?? '' }}">

        @if($file->type == 'pdf')
            <a href="{{ asset('files/pdf/' . $file->pdf) }}" target="_blank">
                📁 {{ basename($file->pdf) }}
            </a>
            <input type="file" name="pdf_{{ $file->id }}" accept=".pdf">

        @elseif($file->type == 'video')
            <a href="{{ asset('video/class/' . $file->video) }}" target="_blank">
                📁 {{ basename($file->video) }}
            </a>
            <input type="file" name="video_{{ $file->id }}" accept="video/*">

        @elseif($file->type == 'ppt')
            @php
                $pptUrl = Storage::disk('s3')->url('ppt/' . $file->ppt);
            @endphp

            <a href="{{ route('viewppt', ['url' => $pptUrl]) }}" target="_blank">
                📁 {{ basename($file->ppt) }}
            </a>

            <input type="file" name="ppt_{{ $file->id }}" accept=".ppt,.pptx">
        @endif
    </div>
@empty
    <p>No materials found for this chapter.</p>
@endforelse


        <div id="extra-materials" class="mt-2"></div>
        <button type="button" id="add-material" class="btn btn-secondary mt-2">+ Add Material</button>
    </div>
</div>

              <br>
              
              <div class="box-footer">
                <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('adminstaticword.Save') }}</button>
              </div>
            </form>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (right) -->
  </div>
  <!-- /.row -->
</section> 

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {

    // Existing add material JS
    const addMaterialButton = document.getElementById('add-material');
    const extraMaterialContainer = document.getElementById('extra-materials');

    if (addMaterialButton) {
        addMaterialButton.addEventListener('click', function() {
            const newFileInput = document.createElement('div');
            newFileInput.classList.add('col-md-6', 'mb-2');
            newFileInput.innerHTML = `
                <label>Extra Material (PDF, PPT, or Video)</label><br>
                <input type="text" class="form-control title-input" name="title_[]" placeholder="Enter title" value=""><br>
                <input type="file" class="file-input" name="extra_files[]" accept=".pdf,.ppt,.pptx,video/*">
                <button type="button" class="remove-material-btn btn btn-danger btn-sm mt-1">Remove</button>
            `;
            extraMaterialContainer.appendChild(newFileInput);

            newFileInput.querySelector('.remove-material-btn').addEventListener('click', function() {
                extraMaterialContainer.removeChild(newFileInput);
            });
        });
    }

    const form = document.getElementById('demo-form');
    form.addEventListener('submit', function(e) {
        let valid = true;

        document.querySelectorAll('.material-block input[type="text"]').forEach(input => {
            if (input.value.trim() === '') {
                valid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        document.querySelectorAll('.title-input').forEach(input => {
            if (input.value.trim() === '') {
                valid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        
        document.querySelectorAll('.file-input').forEach(fileInput => {
            const allowedExtensions = ['pdf', 'ppt', 'pptx', 'mp4', 'avi', 'mov', 'mkv'];
            if (fileInput.files.length > 0) {
                const fileName = fileInput.files[0].name;
                const ext = fileName.split('.').pop().toLowerCase();
                if (!allowedExtensions.includes(ext)) {
                    valid = false;
                    fileInput.classList.add('is-invalid');
                    alert(`Invalid file type: ${fileName}`);
                } else {
                    fileInput.classList.remove('is-invalid');
                }
            }
        });

        if (!valid) {
            e.preventDefault(); 
            alert('Please fill all required titles and upload valid file types.');
        }
    });
});
</script>
