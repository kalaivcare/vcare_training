@extends('admin/layouts.master')
@section('title', 'All Announcement - Instructor')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> Assignment</h3>
        </div>
        {{-- <div class="box-header">
           <a class="btn btn-info btn-sm" href="{{ url('instructor/announcement/create') }}">+ {{ __('adminstaticword.Add') }} {{ __('adminstaticword.Announcement') }}</a>
      </div> --}}
      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table id="example1" class="table table-bordered table-striped">

            <thead>
              <br>
              <th>S.NO</th>
              <th>Employee Id</th>
              <th>Course</th>
              <th>Title</th>
              <th>Files</th>
              {{-- <th>{{ __('adminstaticword.Edit') }}</th>
              <th>{{ __('adminstaticword.Delete') }}</th> --}}
              </tr>
            </thead>
            <tbody>
              <?php $i = 0; ?>
              @foreach($Announcement as $announ)
              <tr>
                <?php $i++; ?>
                <td><?php echo $i;  ?></td>
                <td>{{$announ->user->emp_id ?? ''}}</td>
                <td>{{ $announ->courses->title
                  }} </td>
                <td>{{$announ->title}}</td>
                <td>
                  <a href="{{ asset('files/assignment/' . $announ->assignment) }}" target="_blank">
                    📁 {{ $announ->user->emp_id ?? ''}}
                  </a>
                </td>
                

                <td>
                  <form method="post" action="{{url('assignmentdest/'.$announ->id)}}
                    " data-parsley-validate class="form-horizontal form-label-left">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger"><i class="fa fa-fw fa-trash-o"></i></button>
                  </form>
                </td> 
              </tr>
              @endforeach

          </table>
          {{$Announcement->links()}}
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
@endsection