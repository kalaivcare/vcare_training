@extends('admin/layouts.master')
@section('title', 'Course Review - Admin')
@section('body')

    <section class="content">

        @include('admin.message')
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __('adminstaticword.Course') }} {{ __('adminstaticword.Review') }}</h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">

                                <thead>

                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Support</th>
                                        <th>Quality</th>
                                        <th>Accessibility</th>
                                        <th>Review</th>
                                        <th>{{ __('adminstaticword.Delete') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 0; ?>
                                    {{-- @dd($ReviewRating) --}}
                                    @foreach ($ReviewRating as $cat)
                                        <?php $i++; ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>
                                                {{ $cat->user->fname ?? '' }}
                                            </td>
                                            <td>{{ $cat->value }}</td>
                                            <td>{{ $cat->price }}</td>
                                            <td>{{ $cat->learn }}</td>
                                            <td>{{ $cat->review }}</td>

                                            <td>
                                                <form method="post"
                                                    action="{{ url('delete_review/' . $cat->id) }}
                            "data-parsley-validate
                                                    class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button onclick="return confirm('Are you sure you want to delete?')"
                                                        type="submit" class="btn btn-danger"><i
                                                            class="fa fa-fw fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection
