@extends('admin/layouts.master')
@section('title', 'All Message - Admin')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('adminstaticword.AllMessage') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              
              <thead>
              <?php $i=1; ?>
                <tr>
                  <th>#</th>
                  <th>{{ __('adminstaticword.Name') }}</th>
                  <th>{{ __('adminstaticword.Phone') }}</th>
                  <th>{{ __('adminstaticword.Email') }}</th>
                  <th>{{ __('adminstaticword.Subject') }}</th>
                  <th>{{ __('adminstaticword.Message') }}</th>
                  <th>{{ __('adminstaticword.View') }}</th>
                  <th>{{ __('adminstaticword.Delete') }}</th>
                </tr>
              </thead>
              <tbody> 
                @foreach($items as $item) 
                <tr>
                  <td>{{ $i }}</td>
                  <td>{{$item->fname}}</td>
                  <td>{{$item->mobile}}</td>
                  <td>{{$item->email}}</td>
                 <td>{{ str_limit($item->subject, $limit = 50, $end = '...') }}</td>
                  <td>{{ str_limit($item->message, $limit = 50, $end = '...') }}</td>
                  <td><a class="btn btn-primary btn-sm" href="{{route('usermessage.edit',$item->id)}}">{{ __('adminstaticword.View') }}</a></td>

                  <!-- <td>
                    <form  method="post" action="{{url('usermessage/'.$item->id)}}
                        "data-parsley-validate class="form-horizontal form-label-left">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                         <button  type="submit" class="btn btn-danger"><i class="fa fa-fw fa-trash-o"></i></button>
                    </form>
                  </td> -->
                  <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{url('usermessage/'.$item->id)}}')">
                      <i class="fa fa-fw fa-trash-o"   ></i>
                    </button>
                  </td>
                <?php $i++; ?>


                 <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="deleteModalLabel">Confirm Delete</h4>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to delete this contact? This action cannot be undone.
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form id="deleteForm" method="post" action=" " style="display:inline;">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                  @endforeach
               
                </tr>
              </tfoot>
            </table>
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
<script>
  // When delete button is clicked
  function confirmDelete(url) {
    // Set the form action to the URL of the delete operation
    document.getElementById('deleteForm').action = url;
    // Show the modal
    $('#deleteModal').modal('show');
  }
</script>
<style>
button.btn.btn-danger.btn-sm {
    padding: 5px 10px;
    font-size: 19px;
    line-height: 1.5;
    border-radius: 3px;
}
</style>