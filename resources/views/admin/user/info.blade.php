@extends('admin.layouts.master')
@section('title', 'View User - Admin')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
      
       
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped table-responsive display nowrap">
                <thead>
                  <th>S.NO</th>
                 
                  <th>{{ __('adminstaticword.Name') }}</th>
               
                  <th>{{ __('adminstaticword.Email') }}</th>
                 
                  <th>{{ __('adminstaticword.CompletedModules') }}</th>
                    <th>{{ __('adminstaticword.CurrentModule') }}</th>
                </thead> 

                <tbody>
                  <?php $i=0;?>

                    @foreach ($courseProgress as $user)
                      @if($user->id != Auth::User()->id)
                        <?php $i++;?>

                      <tr>
                        <td><?php echo $i;?></td>
                       
                        <td>{{ $user->user->fname ." ". $user->user->lname}}</td>
                       
                        <td>{{ $user->user->email }}</td>
                     <td>{{ implode(', ', array_filter($user->mark_chapter_id, fn($v) => $v != 0)) }}</td>
                                        
                      <td>
                        @php
                            $statusArray = json_decode($user->status, true);

                            // Filter out null and "0" values
                            $filtered = array_filter((array) $statusArray, fn($v) => trim((string)$v) !== '0' && !is_null($v));

                            if (empty($filtered)) {
                                echo 'All Modules Completed';
                            } else {
                                echo implode(', ', $filtered);
                            }
                        @endphp
                    </td>

                                                                        
                       
                      
                        <td>
                      
                        </td>
                        
                       
                              
                      
                    </tr>
                    @endif
                    @endforeach

                </tbody>
              </table>
            </div>
          </div>
        <!-- /.box-body -->
      </div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

@endsection


