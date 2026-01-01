@extends('theme.master')

@section('title', 'Start Quiz')

@section('content')

    <section id="quiz-nav-bar" class="quiz-nav-bar-block">
        <div class="nav-bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="navbar-header">
                            <!-- Branding Image -->

                            @if (isset($topic))
                                <h4 class="heading">{{ $topic->title }}</h4>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="collapse navbar-collapse" id="app-navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="quiz-main-block quiz-main-block-two">
        <div class="container">
            @if (Auth::check())
                <div class="">
                    <?php
                    // $users = App\QuizAnswer::where('topic_id', $topic->id)
                    //     ->where('user_id', Auth::user()->id)
                    //     ->first();
                    // $que = App\Quiz::where('topic_id', $topic->id)->get();
                    // // dd($que);
                    // $que_count = App\Quiz::where('topic_id', $topic->id)->count();
                    
                    //  dd($que_count);
                    
                    ?>

                    @if ($que->isEmpty())
                        <div class="alert alert-danger">
                            No Questions in this quiz
                        </div>
                    @else
                        @if (!empty($users))
                            <div class="alert alert-danger">
                                You have already Given the test ! Try to give other Quizes
                            </div>
                        @else
                            <div id="question_block" class="question-block">
                                <div class="question" id="question-div">

                                 <form action="{{ route('start.quiz.store',['type'=>$type]) }}" method="POST" id="question-form">
    {{ csrf_field() }}
    <?php $count = 1; ?>

    @foreach ($que as $key => $equestion)
        <div style="{{ $key > 0 ? 'display:none;' : '' }}" id="more_quiz{{ $key }}">
            <span id="quizNumber">{{ $count }}</span>/<span>{{ $que_count }}</span>
            <div class="jumbotron" id="quiz{{ $key + 1 }}">
                <div class="circle-timer" style="margin-right: 20px;">
                    <svg viewBox="0 0 36 36" class="circular-chart" width="0" height="0">
                        <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="circle" stroke-dasharray="100, 100"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <text x="18" y="20.35" class="timer-text" text-anchor="middle"
                              id="timer_value_{{ $key }}">{{ $equestion['question_time'] * 60 }}</text>
                    </svg>
                </div>

                <h4 style="color:black;">
                    Q{{ $count }}.&emsp;{{ $equestion['question'] }}
                </h4>

                <!-- Hidden inputs for question, topic, and course -->
                <input type="hidden" name="question_id[{{ $count }}]" value="{{ $equestion['id'] }}">
                <input type="hidden" name="topic_id[{{ $count }}]" value="{{ $equestion->topic_id }}">
                <input type="hidden" name="course_id[{{ $count }}]" value="{{ $equestion->course_id ?? '' }}">
                <input type="hidden" name="canswer[{{ $count }}]" value="{{ $equestion['answer'] }}">

                <label class="radio">
                    <input type="radio" required name="answer[{{ $count }}]" value="A">{{ $equestion['a'] }}
                </label>
                <label class="radio">
                    <input type="radio" required name="answer[{{ $count }}]" value="B">{{ $equestion['b'] }}
                </label>
                @if (isset($equestion['c']))
                    <label class="radio">
                        <input type="radio" required name="answer[{{ $count }}]" value="C">{{ $equestion['c'] }}
                    </label>
                @endif
                @if (isset($equestion['d']))
                    <label class="radio">
                        <input type="radio" required name="answer[{{ $count }}]" value="D">{{ $equestion['d'] }}
                    </label>
                @endif
                <br>
            </div>
        </div>
        <?php $count++; ?>
    @endforeach

    {{-- Next Button --}}
    @if ($que_count > 1)
        <button title="Click to see next question" id="next" class="pull-right btn btn-md btn-primary">
            {{ __('frontstaticword.Next') }} >>
        </button>
    @endif

    {{-- Finish Button --}}
    <button id="finish" type="submit" class="pull-right btn btn-md btn-primary" style="display: none;">
        {{ __('frontstaticword.Finish') }}
    </button>
</form>



                                </div>
                            </div>
                        @endif

                    @endif
                </div>
            @endif
        </div>
    </section>
    <!-- jQuery 3 -->

@endsection

@section('custom-script')



    <script>
        $(document).ready(function() {
            // console.log("Started quiz");

            let currentQuestionIndex = 0;
            const totalQuestions = {{ $que_count }};
            let timerInterval = null;

            function showQuestion(index) {
                $(`[id^=more_quiz]`).hide();
                $(`#more_quiz${index}`).show();

                $('#quizNumber').text(index + 1);
                $('#next').toggle(index < totalQuestions - 1);
                $('#finish').toggle(index === totalQuestions - 1);

                resetTimer(index);
            }

            function resetTimer(index) {
                clearInterval(timerInterval);

                const timerElement = document.getElementById(`timer_value_${index}`) || document.getElementById(
                    'timer_value');
                const circle = document.querySelector(`#more_quiz${index} .circle`);
                if (!timerElement || !circle) return;

                let timeLeft = parseInt(timerElement.textContent);
                const totalTime = timeLeft;

                if (isNaN(timeLeft)) return;

                updateCircleProgress(circle, timeLeft, totalTime); // Set initial

                timerInterval = setInterval(() => {
                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);

                        const currentQuestion = $('.question:visible');
                        const requiredInputs = currentQuestion.find('input[required], textarea[required]');
                        let isAnswered = false;

                        requiredInputs.each(function() {
                            const type = $(this).attr('type');
                            const name = $(this).attr('name');

                            if ((type === 'radio' || type === 'checkbox') && $(
                                    `input[name="${name}"]:checked`).length > 0) {
                                isAnswered = true;
                                return false;
                            } else if (type !== 'radio' && type !== 'checkbox' && $(this).val()) {
                                isAnswered = true;
                                return false;
                            }
                        });

                        if (!isAnswered && requiredInputs.length > 0) {
                            const name = requiredInputs.first().attr('name');
                            if (!$(`input[type="hidden"][name="${name}"]`).length) {
                                $('#question-form').append(`<input type="hidden" name="${name}" value="">`);
                            }
                        }

                        if (currentQuestionIndex >= totalQuestions - 1) {
                            $('#question-form').submit();
                        } else {
                            currentQuestionIndex++;
                            showQuestion(currentQuestionIndex);
                        }
                        return;
                    }

                    timeLeft--;
                    timerElement.textContent = timeLeft;
                    updateCircleProgress(circle, timeLeft, totalTime);
                }, 1000);
            }


            // $('#next').on('click', function(e) {
            //     e.preventDefault();
            //     const currentQuestion = $('.question:visible');
            //     let isAnswered = false;

            //     // Clear any existing error message
            //     currentQuestion.find('.error-message').remove();

            //     // Get all required inputs within the visible question
            //     const requiredInputs = currentQuestion.find('input[required], textarea[required]');

            //     if (requiredInputs.length > 0) {
            //         requiredInputs.each(function() {
            //             const $input = $(this);
            //             const type = $input.attr('type');
            //             const name = $input.attr('name');

            //             if ((type === 'radio' || type === 'checkbox')) {
            //                 // Only check radios/checkboxes once per name
            //                 if ($(`input[name="${name}"]:visible:checked`).length > 0) {
            //                     isAnswered = true;
            //                     return false;
            //                 }
            //             } else {
            //                 if ($input.val().trim() !== '') {
            //                     isAnswered = true;
            //                     return false;
            //                 }
            //             }
            //         });

            //         // If not answered, show error and block navigation
            //         if (!isAnswered) {
            //             const errorHTML =
            //                 `<div class="error-message text-danger mt-2"⚠️ Please select one of these options.></div>`;
            //             currentQuestion.append(errorHTML); // Show at bottom of question block
            //             return; // ✅ Don't go to next question
            //         }
            //     }

            //     // ✅ Move to next question only if valid
            //     if (currentQuestionIndex < totalQuestions - 1) {
            //         currentQuestionIndex++;
            //         showQuestion(currentQuestionIndex);
            //     }
            // });

            $('#next').on('click', function(e) {
                e.preventDefault();

                const currentQuestion = $('.question:visible');
                let isAnswered = false;

                // Clear any existing error message
                currentQuestion.find('.error-message').remove();

                // Get all required inputs within the visible question
                const requiredInputs = currentQuestion.find('input[required], textarea[required]');

                if (requiredInputs.length > 0) {
                    requiredInputs.each(function() {
                        const $input = $(this);
                        const type = $input.attr('type');
                        const name = $input.attr('name');

                        if (type === 'radio' || type === 'checkbox') {
                            // Check if any visible radio/checkbox of this name is checked
                            if ($(`input[name="${name}"]:visible:checked`).length > 0) {
                                isAnswered = true;
                                return false; // break loop
                            }
                        } else {
                            if ($input.val().trim() !== '') {
                                isAnswered = true;
                                return false; // break loop
                            }
                        }
                    });

                    if (!isAnswered) {
                        const errorHTML =
                            `<div class="error-message text-danger mt-2">⚠️ Please select one of these options.</div>`;
                        currentQuestion.append(errorHTML);
                        return; // Stop navigation
                    }
                }

                // Move to next question only if valid
                if (currentQuestionIndex < totalQuestions - 1) {
                    currentQuestionIndex++;
                    showQuestion(currentQuestionIndex);
                }
            });



            $('#finish').on('click', function(e) {
                e.preventDefault();

                const currentQuestion = $('.question:visible');
                let isAnswered = false;

                // Remove previous error
                currentQuestion.find('.error-message').remove();

                const requiredInputs = currentQuestion.find('input[required], textarea[required]');
                if (requiredInputs.length > 0) {
                    requiredInputs.each(function() {
                        const $input = $(this);
                        const type = $input.attr('type');
                        const name = $input.attr('name');

                        if ((type === 'radio' || type === 'checkbox')) {
                            if ($(`input[name="${name}"]:visible:checked`).length > 0) {
                                isAnswered = true;
                                return false;
                            }
                        } else {
                            if ($input.val().trim() !== '') {
                                isAnswered = true;
                                return false;
                            }
                        }
                    });

                    if (!isAnswered) {
                        const errorHTML =
                            `<div class="error-message text-danger mt-2">⚠️ Please select one of these options.</div>`;
                        currentQuestion.append(errorHTML);
                        return; // ✅ Don't submit
                    }
                }

                // ✅ If everything is valid, submit
                $('#question-form').submit();
            });


            // Initial load
            showQuestion(currentQuestionIndex);
        });
    </script>

    <script>
        function updateCircleProgress(circle, timeLeft, totalTime) {
            const percent = (timeLeft / totalTime) * 100;
            const offset = 100 - percent;
            circle.setAttribute('stroke-dasharray', `${percent}, 100`);
        }
    </script>



    <style>
        .text-danger {
            font-size: 14px;
        }

        .circle-timer {
            width: 80px;

            margin: 0 auto 10px;
        }

        .circular-chart {
            display: block;
            width: 60px;
            height: 60px;
        }

        .circle-bg {
            fill: none;
            stroke: #eee;
            stroke-width: 3.8;
        }

        .circle {
            fill: none;
            stroke: #06193a;
            stroke-width: 3.8;
            stroke-linecap: round;
            transition: stroke-dasharray 1s linear;
        }

        .timer-text {
            font-size: 0.5em;
            fill: #333;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Disable all links except inside quiz form
            $('a').not('#question-form a').on('click', function(e) {
                e.preventDefault();
                alert("You cannot leave while quiz is in progress!");
            });

            // Disable all buttons except Next / Finish
            $('button').not('#next, #finish, #question-form button').prop('disabled', true).addClass(
                'disabled-btn');

            // Also hide footer (optional)
            $('footer').hide();
        });
    </script>

    <style>
        /* Optional style to show disabled state */
        .disabled-btn {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>

    <script>
        // Disable F5 and Ctrl+R
        document.addEventListener("keydown", function(e) {
            if (e.key === "F5" || (e.ctrlKey && e.key === "r")) {
                e.preventDefault();
                alert("Reload is disabled during the quiz!");
            }
        });

        // Disable right-click
        document.addEventListener("contextmenu", function(e) {
            e.preventDefault();
        });
    </script>




@endsection
