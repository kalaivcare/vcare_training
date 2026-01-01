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
                  <th>E-Signature</th>

                  
                 
                  <th>{{ __('adminstaticword.CompletedModules') }}</th>
                    <th>{{ __('adminstaticword.CurrentModule') }}</th>
                    <th>{{ __('adminstaticword.ShowDetails') }}</th>

                </thead> 

                <tbody>
                  <?php $i=0;
                  // dd($courseProgress[0]->id);
                  ?>

                    @foreach ($courseProgress as $user)
                      @if($user->id)
                        <?php $i++;?>

                      <tr>
                        <td><?php echo $i;?></td>
                       
                        <td>{{ $user->user->fname ." ". $user->user->lname}}</td>
                       
                        <td>{{ $user->user->email }}</td>
                         @php
                            $CourseCompletion = App\CourseCompletion::where('user_id', $user->user->id)->first();
                        @endphp
                        <td>
                            @if (isset($CourseCompletion['e_signature']))
                                {{-- <img src="{{ asset($CourseCompletion['e_signature']) }}" class="img-fluid object-fit-none border rounded" alt="E-Signature" > --}}
                                {{ $CourseCompletion['e_signature']}}
                            @else
                                No signature available (Course not Completed)
                            @endif
                        </td>


                 @php
                        $validChapters = array_filter($user->mark_chapter_id ?? [], fn($v) => $v != 0);
                    @endphp

                  <td>
                      {{ count($validChapters) }} Module(s) 
                  </td>

                                        
                      <td>
                        @php
                            $statusArray = json_decode($user->status, true);

                            $filtered = array_filter((array) $statusArray, fn($v) => trim((string)$v) !== '0' && !is_null($v));

                            if (empty($filtered)) {
                                echo 'All Modules Completed';
                            } else {
                             $chapters = App\CourseChapter::find($filtered);

                          $chapterNames = $chapters->pluck('chapter_name')->toArray();

                          echo implode(', ', $chapterNames);
                            }
                        @endphp
                    </td>

                                                                        
                       
                      
                        <td>
                     
                         <a class="btn btn-info btn-sm" href="{{ route('Userprogress.show',$user->user_id) }}"> <i class="	glyphicon glyphicon-eye-open"></i> Show</a>
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


