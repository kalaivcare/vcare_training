<section class="content">
  <div class="row">
    <div class="col-md-12">
      <br>
      <br>
      <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ __('adminstaticword.Course') }}</th>
                <th>{{ __('adminstaticword.User') }}</th>
                <th>Question 1</th>
                <th>Question 2</th>
                <th>Question 3</th>
                <th >Question 4</th>
                <th >Question 5</th>
                <th >Question 6</th>
                <th>{{ __('adminstaticword.Delete') }}</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=0;?>
              @foreach($module as $jp)
                <tr>
                  <?php $i++;?>
                <td><?php echo $i;?></td>
                  <td>{{$jp->courses->title}}</td>

                  @php
                  $chn = App\User::where('id','=',$jp->user_id)->first();
                  @endphp
                  <td>
                
                  {{ $chn['fname'] }} {{ $chn['lname'] }}
                 
                  </td>

                  <td>{{$jp->qn1}}</td>
                  <td>{{$jp->qn2}}</td>
                  <td>{{$jp->qn3}}</td>
                  <td>{{$jp->qn4}}</td>
                  <td>{{$jp->qn5}}</td>
                  <td>{{$jp->qn6}}</td>
                  <td>
                    <form  method="post" action="{{url('modulerating/'.$jp->id)}}"data-parsley-validate class="form-horizontal form-label-left">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                    <button  type="submit" class="btn btn-danger"><i class="fa fa-fw fa-trash-o"></i></button>
                    </form>
                  </td>
               
                 
                </tr>
              @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
</section> 
