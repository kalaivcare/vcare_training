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
@if(session('message'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('message') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

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
                                    <th>{{ __('adminstaticword.Course') }}</th>
                                    <th>{{ __('adminstaticword.ChapterName') }}</th>
                                    <th>Module Type</th>
                                    <th>{{ __('adminstaticword.Status') }}</th>
                                    <th>{{ __('adminstaticword.Edit') }}</th>
                                    <th>{{ __('adminstaticword.Delete') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($coursechapter as $cat)
                                <tr>
                                    <?php $i++; ?>
                                    <td><?php echo $i; ?></td>
                                    <td>{{$cat->courses->title}}</td>
                                    <td>{{ $cat->chapter_name }}</td>
                                    <td>{{ $cat->module_type  }}</td>
                                    <td>
                                        <form action="{{ route('Chapter.quick',$cat->id) }}" method="POST">
                                            {{ csrf_field() }}

                                            <button type="Submit"
                                                class="btn btn-xs {{ $cat->status ==1 ? 'btn-success' : 'btn-danger' }}">
                                                @if ($cat->status == 1)
                                                {{ __('adminstaticword.Active') }}
                                                @else
                                                {{ __('adminstaticword.Deactive') }}
                                                @endif
                                            </button>
                                        </form>

                                    </td>
                                    <td>
                                        <a class="btn btn-success btn-sm" href="{{ url('chapter/' . $cat->id) }}"><i
                                                class="glyphicon glyphicon-pencil"></i></a>
                                    </td>

                                    <td>
                                        <form method="post" action="{{ route('chapter.destroy', $cat->id) }}"
                                            data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fa fa-fw fa-trash-o"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('{{ url('chapter.destroy', $cat->id) }}')">
                                            <i class="fa fa-fw fa-trash-o"></i>
                                        </button>
                                    </td>

                                </tr>
                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="deleteModalLabel">Confirm Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this Module? This action cannot be
                                                undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
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
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="text-center">
                    {{ $coursechapter->links() }}
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
                    <h4 class="modal-title" id="myModalLabel">Add Module</h4>
                </div>
                <div class="box box-primary">
                    <div class="panel panel-sum">
                        <div class="modal-body">
                            <form id="demo-form2" method="post" action="{{ route('chapter.store') }}"
                                data-parsley-validate class="form-horizontal form-label-left"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>{{ __('adminstaticword.Course') }} <span class="redstar">*</span></label>
                                        <select name="course_id" class="form-control" required>
                                            <option value="">-- Select Course --</option>
                                            @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">
                                                {{ $course->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>{{ __('adminstaticword.Course') }} <span class="redstar">*</span></label>
                                        <select name="module_type" class="form-control" required>
                                            <option value="">-- Select Type-</option>

                                            <option value="Skin">
                                                Skin
                                            </option>
                                            <option value="Hair">
                                                Hair
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <br>




                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="exampleInputTit1e">{{ __('adminstaticword.ChapterName') }}:<span
                                                class="redstar">*</span> </label>
                                        <input type="text" placeholder="Enter Your Chapter Name" class="form-control "
                                            name="chapter_name" id="exampleInputTitle" value="">
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button id="AddModules" type="button"
                                            class="btn btn-md col-md-3 btn-primary">{{ __('adminstaticword.AddModules') }}</button>

                                    </div>
                                </div>
                                <!-- Changed the button type to "button" to prevent form submission -->
                                {{-- <button id="AddModules" type="button" class="btn btn-md col-md-3 btn-primary">{{ __('adminstaticword.AddModules') }}</button>
                                --}}
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
// When delete button is clicked
function confirmDelete(url) {
    // Set the form action to the URL of the delete operation
    document.getElementById('deleteForm').action = url;
    // Show the modal
    $('#deleteModal').modal('show');
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const AddModules = document.getElementById('AddModules');

    if (AddModules) {
        AddModules.addEventListener('click', function() {
            const displaymodules = document.getElementById('display-modules');
            const newmodules = document.createElement('div');
            newmodules.classList.add('col-md-6', 'mb-2');


            const fileId = 'file_' + Date.now();

            newmodules.innerHTML = `
        <label for="exampleInputDetails">{{ __('adminstaticword.LearningMaterial') }}</label>
        <p class="inline info">eg:  pdf files</p><br>
        <input type="text" class="form-control" name="title[]" placeholder="Enter title for this file" ><br>

        <input type="file" name="file[]" id="${fileId}" accept=".pdf,.ppt,.pptx" />
        <label for="${fileId}" class="file-label">
          <svg xmlns="http://www.w3.org/2000/svg" width="50" height="30" viewBox="0 0 20 17">
            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
          </svg>
          <span class="file-name">Choose a file</span>
        </label>
        <span class="text-danger invalid-feedback" role="alert"></span>
        <div class="col-lg-12">
                  <button type="button" class="remove-module-btn btn btn-sm btn-danger mt-2">Remove</button>

          </div>
      `;

            displaymodules.appendChild(newmodules);

            const fileInput = newmodules.querySelector('input[type="file"]');
            const fileNameSpan = newmodules.querySelector('.file-name');

            fileInput.addEventListener('change', function() {
                const fileName = this.files[0] ? this.files[0].name : 'Choose a file';
                fileNameSpan.textContent = fileName;
            });

            newmodules.querySelector('.remove-module-btn').addEventListener('click', function() {
                displaymodules.removeChild(newmodules);
            });
        });
    }
});

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
        const course_id = form.querySelector('input[name="course_id');
        const chapterNameInput = form.querySelector('input[name="chapter_name"]');
        if (!chapterNameInput.value.trim()) {
            showError(chapterNameInput, "Chapter name is required.");
            isValid = false;
        }
        if (!course_id.value.trim()) {
            showError(course_id, "Select course ");
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