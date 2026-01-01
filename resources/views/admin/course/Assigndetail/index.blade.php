@extends('admin.layouts.master')
@section('title', 'Add Question - Admin')
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
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <a data-toggle="modal" data-target="#myModalp" href="#" class="btn btn-info btn-sm">+
                            {{ __('adminstaticword.Add') }}</a>

                    </div>

                    <br>
                    <br>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                      
                                        <th>Assginment Description</th>
                                        {{-- <th>{{ __('adminstaticword.Status') }}</th> --}}
                                        <th>{{ __('adminstaticword.Edit') }}</th>
                                        <th>{{ __('adminstaticword.Delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($Assigndetail as $cat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cat->assignment }}</td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{ route('assigndetail.edit', $cat->id) }}">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                            </td>
                          <td>
                            <form action="{{ route('assigndetail.destroy', $cat->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this assignment?');">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>

                        </tr>
                        @endforeach

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Model start-->
        <div class="modal fade" id="myModalp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Assignment</h4>
                    </div>
                    <div class="box box-primary">
                        <div class="panel panel-sum">
                            <div class="modal-body">
                                <form id="demo-form2" method="post" action="{{ route('assigndetail.store') }}"
                                    data-parsley-validate class="form-horizontal form-label-left"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <select name="course_id" class="form-control display-none">
                                    </select>

                                   <div class="row">
                                            <div class="col-md-12">
                                                <label for="exampleInputTitle">Description:<span class="redstar">*</span></label>
                                                <textarea placeholder="Description"
                                                        class="form-control"
                                                        name="assignment"
                                                        id="exampleInputTitle"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                            </div>
                                        </div>

                                    <br>
                                    
                                    <div class="row" id="display-modules">
                                    </div>

                                    <br>

                                    <div class="box-footer">
                                        <button type="submit"
                                            class="btn btn-md col-md-3 btn-primary">{{ __('adminstaticword.Submit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Model close -->

    </section>


    <!--Model for add question -->
    <div class="modal fade" id="myModalquiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    </div>
    </div>
    <!--Model close -->


    </section>

@endsection

<script>
    

    function showError(input, message) {
        let errorSpan = input.parentElement.querySelector('.invalid-feedback');
        if (!errorSpan) {
            errorSpan = document.createElement('span');
            errorSpan.classList.add('text-danger', 'invalid-feedback');
            input.parentElement.appendChild(errorSpan);
        }
        errorSpan.textContent = message;
    }
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#demo-form2');



        form.addEventListener('submit', function(e) {
            let isValid = true;

            // Clear previous errors
            form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

            const chapterNameInput = form.querySelector('input[name="chapter_name"]');
            if (!chapterNameInput.value.trim()) {
                showError(chapterNameInput, "Chapter name is required.");
                isValid = false;
            }

            const fileInputs = form.querySelectorAll('input[type="file"]');
            fileInputs.forEach((fileInput, index) => {
                const titleInput = form.querySelectorAll('input[name="title[]"]')[index];
                if (fileInput.files.length > 0) {
                    const fileName = fileInput.files[0].name.toLowerCase();
                    if (!/\.(avi|mp4|pdf|ppt|pptx)$/.test(fileName)) {
                        showError(fileInput,
                            "Invalid file type. Allowed:avi,mp4, pdf, ppt, pptx.");
                        isValid = false;
                    }
                    if (!titleInput.value.trim()) {
                        showError(titleInput, "Title is required for this module.");
                        isValid = false;
                    }
                }
            });

            if (!isValid) e.preventDefault();
        });

    });
</script>
