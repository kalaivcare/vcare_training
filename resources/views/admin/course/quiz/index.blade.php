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
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('adminstaticword.Quiz') }} {{ __('adminstaticword.Question') }}</h3>
                </div>
                <div class="box-header">
                    <a data-toggle="modal" data-target="#myModalquiz" href="#" class="btn btn-info btn-sm">+ Add
                        Questions</a>

                </div>
                <div class="text-right">
                    <h4 class="admin-form-text"><a href="javascript:history.back()" data-toggle="tooltip"
                            data-original-title="Go back" class="btn-floating" style="margin:10px"><i
                                class="material-icons">
                                <button class="btn btn-xs btn-success abc">
                                    << {{ __('adminstaticword.Back') }}</button> </i></a></h4>
                </div>

                <br>


                <br>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="quizTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    {{-- <th>{{ __('adminstaticword.Course') }}</th> --}}
                                    <th>{{ __('adminstaticword.Modules') }}</th>
                                    <th>{{ __('adminstaticword.Question') }}</th>
                                    <th>{{ __('adminstaticword.A') }}</th>
                                    <th>{{ __('adminstaticword.B') }}</th>
                                    <th>{{ __('adminstaticword.C') }}</th>
                                    <th>{{ __('adminstaticword.D') }}</th>
                                    <th>{{ __('adminstaticword.Answer') }}</th>
                                    <th>{{ __('adminstaticword.Edit') }}</th>
                                    <th>{{ __('adminstaticword.Delete') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $quiz)
                                <tr>
                                    {{-- Pagination-safe serial number --}}
                                    <td>{{ $questions->firstItem() + $loop->index }}</td>

                                    {{-- Module name --}}
                                    <td>{{ $quiz->course->title ?? 'N/A' }}</td>

                                    <td>{{ $quiz->question }}</td>
                                    <td>{{ $quiz->a }}</td>
                                    <td>{{ $quiz->b }}</td>
                                    <td>{{ $quiz->c }}</td>
                                    <td>{{ $quiz->d }}</td>
                                    <td>{{ $quiz->answer }}</td>
                                    <td>
                                        <a data-toggle="modal" data-target="#myModaledit{{ $quiz->id }}" href="#"
                                            class="btn btn-success btn-sm"><i
                                                class="glyphicon glyphicon-pencil"></i></a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('{{ url('QuestionDelete', $quiz->id) }}')">
                                            <i class="fa fa-fw fa-trash-o"></i>
                                        </button>
                                    </td>

                                </tr>

                                <!--Model for edit question-->
                                <div class="modal fade" id="myModaledit{{ $quiz->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">
                                                    {{ __('adminstaticword.Edit') }}
                                                    {{ __('adminstaticword.Question') }}</h4>
                                            </div>
                                            <div class="box box-primary">
                                                <div class="panel panel-sum">
                                                    <div class="modal-body">
                                                        <form class="question-form" method="post"
                                                            action="{{ route('QuestionsEdit', $quiz->id) }}"
                                                            data-parsley-validate
                                                            class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PUT') }}

                                                            {{-- <input type="hidden" name="course_id" value="{{ $topics->course_id }}"
                                                            /> --}}

                                                            {{-- <input type="hidden" name="topic_id" value="{{ $topics->id }}"
                                                            /> --}}

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label
                                                                        for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                                                                    <textarea name="question" rows="6"
                                                                        class="form-control"
                                                                        placeholder="Enter Your Question">{{ $quiz->question }}</textarea>
                                                                    <br>

                                                                    <label
                                                                        for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup
                                                                            class="redstar">*</sup></label>
                                                                    <select style="width: 100%" name="answer"
                                                                        class="form-control js-example-basic-single">
                                                                        <option
                                                                            {{ $quiz->answer == 'A' ? 'selected' : '' }}
                                                                            value="A">
                                                                            {{ __('adminstaticword.A') }}</option>
                                                                        <option
                                                                            {{ $quiz->answer == 'B' ? 'selected' : '' }}
                                                                            value="B">
                                                                            {{ __('adminstaticword.B') }}</option>
                                                                        <option
                                                                            {{ $quiz->answer == 'C' ? 'selected' : '' }}
                                                                            value="C">
                                                                            {{ __('adminstaticword.C') }}</option>
                                                                        <option
                                                                            {{ $quiz->answer == 'D' ? 'selected' : '' }}
                                                                            value="D">
                                                                            {{ __('adminstaticword.D') }}</option>
                                                                    </select>

                                                                    <label
                                                                        for="chapter_id">{{ __('adminstaticword.Module') }}:<sup
                                                                            class="redstar">*</sup></label>
                                                                    @php

                                                                    $quizTopic = App\QuizTopic::find(
                                                                    $quiz->topic_id,
                                                                    );

                                                                    if ($quizTopic) {
                                                                    $chapterName = optional(
                                                                    $quizTopic->chapter,
                                                                    );
                                                                    }

                                                                    @endphp


                                                                    <select name="chapter_id" id="chapter_id"
                                                                        class="form-control" required>

                                                                        <option value="" disabled
                                                                            {{ $quiz->topic_id ? '' : 'selected' }}>
                                                                            {{ __('adminstaticword.SelectanOption') }}
                                                                        </option>
                                                                        @foreach ($topics as $topic)
                                                                        <option value="{{ $topic->id }}"
                                                                            {{ $chapterName->id == $topic->id ? 'selected' : '' }}>
                                                                            {{ $topic->chapter_name ?? '' }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>

                                                                </div>


                                                                <div class="col-md-6">

                                                                    <label
                                                                        for="exampleInputDetails">{{ __('adminstaticword.AOption') }}
                                                                        :<sup class="redstar">*</sup></label>
                                                                    <input type="text" name="a" value="{{ $quiz->a }}"
                                                                        class="form-control"
                                                                        placeholder="Enter Option A">
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label
                                                                        for="exampleInputDetails">{{ __('adminstaticword.BOption') }}
                                                                        :<sup class="redstar">*</sup></label>
                                                                    <input type="text" name="b" value="{{ $quiz->b }}"
                                                                        class="form-control"
                                                                        placeholder="Enter Option B" />
                                                                </div>

                                                                <div class="col-md-6">

                                                                    <label
                                                                        for="exampleInputDetails">{{ __('adminstaticword.COption') }}
                                                                        :<sup class="redstar">*</sup></label>
                                                                    <input type="text" name="c" value="{{ $quiz->c }}"
                                                                        class="form-control"
                                                                        placeholder="Enter Option C" />
                                                                </div>

                                                                <div class="col-md-6">

                                                                    <label
                                                                        for="exampleInputDetails">{{ __('adminstaticword.DOption') }}
                                                                        :<sup class="redstar">*</sup></label>
                                                                    <input type="text" name="d" value="{{ $quiz->d }}"
                                                                        class="form-control"
                                                                        placeholder="Enter Option D" />
                                                                </div>
                                                                <div class="col-md-6">

                                                                    <label
                                                                        for="exampleInputDetails">{{ __('adminstaticword.Questiontime') }}
                                                                        :<sup class="redstar">*</sup></label>
                                                                    <input type="text" name="question_time"
                                                                        class="form-control"
                                                                        value="{{ $quiz->question_time }}"
                                                                        placeholder="Enter Question Time in Minutes" />

                                                                    <span id="question_time_error" class="text-danger"
                                                                        style="display:none;"></span>

                                                                </div>



                                                            </div>

                                                    </div>
                                                    <br>


                                                    <div class="box-footer">
                                                        <button type="submit"
                                                            class="btn btn-md col-md-3 btn-primary btn-extra-styles">{{ __('adminstaticword.Submit') }}</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    <!--Model close -->


                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="deleteModalLabel">Confirm Delete</h4>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this question? This action cannot be undone.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <form id="deleteForm" method="post" action="{{ url('QuestionDelete', $quiz->id) }}"
                                        style="display:inline;">
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
                    {{ $questions->links() }}

                </div>
            </div>
        </div>
    </div>
    </div>
</section>


<!--Model for add question -->
{{-- <div class="modal fade" id="myModalquiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"> {{ __('adminstaticword.Add') }}
{{ __('adminstaticword.Question') }}</h4>
</div>
<div class="box box-primary">
    <div class="panel panel-sum">
        <div class="modal-body">
            <form class="question-form" method="post" action="{{ route('quiz.import') }}" data-parsley-validate
                enctype="multipart/form-data" class="form-horizontal form-label-left">


                {{ csrf_field() }}

                <input type="hidden" name="course_id" value="{{ $cor->id }}" />

                <div class="row">
                    <div class="col-md-6">




                        <label for="exampleInputDetails ">Select Module:<sup class="redstar">*</sup></label>
                        <select style="width: 100%" name="chapter_id" class="form-control js-example-basic-single"
                            required>
                            <option value="none" selected disabled hidden>
                                {{ __('adminstaticword.SelectanOption') }}
                            </option>
                            @foreach ($topics as $topic)
                            <option value="{{ $topic->id }}">{{ $topic->chapter_name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-topic_id" style="display:none;"></span>

                    </div>
                    <div class="col-md-6">

                        <input type="file" name="file" required>

                    </div>




                </div>

                <br>

                <div class="box-footer">
                    <button type="submit" id="submitBtn"
                        class="btn btn-md col-md-3 btn-primary">{{ __('adminstaticword.Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div> --}}


<!-- Modal -->
<div class="modal fade" id="myModalquiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">{{ __('adminstaticword.Add') }}
                    {{ __('adminstaticword.Question') }}</h4>
            </div>
            <div class="modal-body">
                <form id="questionForm" class="question-form" method="post" action="{{ route('quiz.import') }}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="row">

                        <!-- Course Select -->
                        <div class="col-md-6">
                            <label for="course_id">Select Course:<sup class="redstar">*</sup></label>
                            <select name="course_id" id="course_id" class="form-control js-example-basic-single">
                                <option value="" selected disabled hidden>Select a course</option>
                                @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-course_id" style="display:none;">
                                Please select a course
                            </span>
                        </div>

                        <!-- Module Select -->
                        <div class="col-md-6">
                            <label for="chapter_id">Select Module:<sup class="redstar">*</sup></label>
                            <select name="chapter_id" id="chapter_name" class="form-control js-example-basic-single"
                                disabled>
                                <option value="" selected disabled hidden>Select a module</option>
                            </select>
                            <span class="text-danger error-topic_id" style="display:none;">
                                Please select a module
                            </span>
                        </div>

                    </div>

                    <br>

                    <div class="row">
                        <!-- File Input -->
                        <div class="col-md-6">
                            <label for="file">Select File:<sup class="redstar">*</sup></label>
                            <input type="file" name="file" id="file" class="form-control">
                            <span class="text-danger error-file" style="display:none;">
                                Please select a file
                            </span>
                        </div>
                    </div>


                    <br>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary col-md-3">
                            {{ __('adminstaticword.Submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




</section>

<!-- Validation Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    $('#course_id').on('change', function() {
        const courseId = $(this).val();
        const chapterSelect = $('#chapter_name');
        chapterSelect.prop('disabled', true)
            .html('<option selected disabled>Loading...</option>');
        const chapterUrlTemplate = "{{ route('admin.ajax.chapters', ':id') }}";
        const chapterUrl = chapterUrlTemplate.replace(':id', courseId);

        $.get(chapterUrl, function(data) {
            let options = '<option value="" selected disabled hidden>Select a module</option>';
            data.forEach(chapter => {
                options +=
                    `<option value="${chapter.id}">${chapter.chapter_name}</option>`;
            });

            chapterSelect.html(options).prop('disabled', false);
        }).fail(function() {
            chapterSelect.html('<option selected disabled>Error loading modules</option>');
        });
    });


});
</script>

<script>
$(document).ready(function() {

    $('#questionForm').on('submit', function(e) {
        let valid = true;

        // Module validation
        if (!$('#chapter_id').val()) {
            $('.error-topic_id').show();
            valid = false;
        } else {
            $('.error-topic_id').hide();
        }

        // File validation
        if (!$('#file').val()) {
            $('.error-file').show();
            valid = false;
        } else {
            $('.error-file').hide();
        }

        // If any field is invalid, prevent form submission
        if (!valid) {
            e.preventDefault();
        }
    });
});
</script>



{{-- <script>
        $(document).ready(function() {

            function validateForm() {
                var moduleSelected = $('select[name="chapter_id"]').val() != null;
                var fileSelected = $('input[name="file"]').val() != '';

                if (moduleSelected && fileSelected) {
                    $('#submitBtn').prop('disabled', false);
                } else {
                    $('#submitBtn').prop('disabled', true);
                }
            }

            // Check on change
            $('select[name="chapter_id"], input[name="file"]').on('change keyup', function() {
                validateForm();
            });

            // Optional: show error messages
            $('form.question-form').on('submit', function(e) {
                var moduleSelected = $('select[name="chapter_id"]').val() != null;
                var fileSelected = $('input[name="file"]').val() != '';

                if (!moduleSelected) {
                    alert('Please select a module');
                    e.preventDefault();
                }
                if (!fileSelected) {
                    alert('Please upload a file');
                    e.preventDefault();
                }
            });

        });
    </script> --}}

<script>
function confirmDelete(url) {
    document.getElementById('deleteForm').action = url;
    // Show the modal
    $('#deleteModal').modal('show');
}
document.addEventListener("DOMContentLoaded", function() {

    const form = document.querySelector('.question-form');

    form.addEventListener('submit', function(e) {
        let valid = true;

        document.querySelector('.error-topic_id').style.display = 'none';
        document.querySelector('.error-file').style.display = 'none';

        const chapter = form.querySelector('select[name="chapter_id"]');
        if (!chapter.value || chapter.value === 'none') {
            const errorSpan = document.querySelector('.error-topic_id');
            errorSpan.textContent = 'Please select a module.';
            errorSpan.style.display = 'block';
            valid = false;
        }

        const fileInput = form.querySelector('input[name="file"]');
        if (!fileInput.value) {
            // Create error span if not exists
            let fileError = document.querySelector('.error-file');
            if (!fileError) {
                fileError = document.createElement('span');
                fileError.classList.add('text-danger', 'error-file');
                fileError.style.display = 'block';
                fileInput.parentNode.appendChild(fileError);
            }
            fileError.textContent = 'Please select a file to upload.';
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
            return false;
        }
    });
});
</script>



<script>
// document.addEventListener("DOMContentLoaded", function () {
//   document.querySelectorAll(".question-form").forEach(function (form) {

//     //  Submit validation
//     form.addEventListener("submit", function (e) {
//       let isValid = true;
//       const modal = form.closest('.modal');
//       const modalId = modal ? modal.id : null;

//       // Reset previous errors
//       form.querySelectorAll(".text-danger").forEach(el => {
//         el.textContent = "";
//         el.style.display = "none";
//       });

//       // Validate question
//       const question = form.querySelector("textarea[name='question']");
//       if (!question || !question.value.trim()) {
//         showError(form, ".error-question", "Question is required");
//         isValid = false;
//       }

//       // Validate options A–D
//       ['a', 'b', 'c', 'd'].forEach(option => {
//         const input = form.querySelector(`input[name='${option}']`);
//         if (!input || !input.value.trim()) {
//           showError(form, `.error-${option}`, `Option ${option.toUpperCase()} is required`);
//           isValid = false;
//         }
//       });

//       // Validate answer
//       const answer = form.querySelector("select[name='answer']");
//       if (!answer || !answer.value || answer.value === "none") {
//         showError(form, ".error-answer", "Correct answer is required");
//         isValid = false;
//       }

//       // Validate chapter/module
//       const topic = form.querySelector("select[name='chapter_id']");
//       if (!topic || !topic.value || topic.value === "none") {
//         showError(form, ".error-topic_id", "Please select a module");
//         isValid = false;
//       }

//       // Validate question time
//       const time = form.querySelector("input[name='question_time']");
//       const timeValue = time?.value?.trim();
//       const timeError = form.querySelector(".question_time_error");

//       if (!timeValue || isNaN(timeValue) || parseFloat(timeValue) <= 0.25 || parseFloat(timeValue) > 10000) {
//         timeError.textContent = "Enter more than 15 seconds";
//         timeError.style.display = "block";
//         isValid = false;
//       } else {
//         timeError.style.display = "none";
//       }

//       // Prevent submission and reopen modal if invalid
//       if (!isValid) {
//         e.preventDefault();
//         if (modalId) {
//           $('#' + modalId).modal({
//             backdrop: 'static',
//             keyboard: false
//           }).modal('show');
//         }
//       }
//     });

//     //  Live error removal
//     form.querySelectorAll("input, textarea, select").forEach(field => {
//       const type = field.tagName.toLowerCase();
//       const eventType = type === "select" ? "change" : "input";

//       field.addEventListener(eventType, function () {
//         const fieldName = field.name;
//         let errorSelector = "";

//         if (["a", "b", "c", "d"].includes(fieldName)) {
//           errorSelector = `.error-${fieldName}`;
//         } else if (fieldName === "question") {
//           errorSelector = ".error-question";
//         } else if (fieldName === "answer") {
//           errorSelector = ".error-answer";
//         } else if (fieldName === "chapter_id") {
//           errorSelector = ".error-topic_id";
//         } else if (fieldName === "question_time") {
//           errorSelector = ".question_time_error";
//         }

//         const errorEl = form.querySelector(errorSelector);
//         if (errorEl) {
//           if (fieldName === "question_time") {
//             const value = field.value.trim();
//             if (/^\d+(\.\d+)?$/.test(value) && parseFloat(value) > 0 && parseFloat(value) <= 10000) {
//               errorEl.style.display = "none";
//             }
//           } else if (fieldName === "answer" || fieldName === "chapter_id") {
//             if (field.value && field.value !== "none") {
//               errorEl.style.display = "none";
//             }
//           } else {
//             if (field.value.trim() !== "") {
//               errorEl.style.display = "none";
//             }
//           }
//         }
//       });
//     });

//   });

//   // Utility function to show error
//   function showError(form, selector, message) {
//     const el = form.querySelector(selector);
//     if (el) {
//       el.textContent = message;
//       el.style.display = "block";
//     }
//   }
// });

$(document).ready(function() {
    $('#quizTable').DataTable({
        "paging": false,
        "searching": true,  // Enables the search box
        "ordering": true,
        "info": true
    });
});
</script>



<style>
.btn-extra-styles {
    background-color: #06193a;
    border-color: #06193a;
    margin: 0px 0px 14px 14px;
}
</style>


@endsection