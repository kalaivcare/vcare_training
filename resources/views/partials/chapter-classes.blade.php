@php
    $totalClasses = App\CourseClass::where('coursechapter_id', $coursechapter->id)->count();

    $viewedClasses = App\ClassProgress::where('user_id', Auth::id())
        ->where('course_id', $course->id)
        ->where('chapter_id', $coursechapter->id)
        ->count();

    if ($totalClasses > 0 && $totalClasses == $viewedClasses) {
        $badgeClass = 'badge-success';
        $badgeText  = 'Completed';
    } elseif ($viewedClasses > 0) {
        $badgeClass = 'badge-warning';
        $badgeText  = 'In Progress';
    } else {
        $badgeClass = 'badge-danger';
        $badgeText  = 'Not Started';
    }

    $classes = App\CourseClass::where('coursechapter_id', $coursechapter->id)
        ->orderBy('position', 'ASC')
        ->get();
@endphp

<div class="card btm-10">
    <div class="card-header" id="heading{{ $coursechapter->id }}">
        <button class="btn btn-link" data-toggle="collapse"
            data-target="#collapse{{ $coursechapter->id }}"
            aria-expanded="false">

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    {{ $coursechapter->chapter_name }}
                    <span class="badge {{ $badgeClass }}" id="module-status-{{ $coursechapter->id }}">
                        {{ $badgeText }}
                    </span>
                </div>
                <div>{{ $totalClasses }} Contents</div>
            </div>
        </button>
    </div>

    <div id="collapse{{ $coursechapter->id }}"
        class="collapse"
        data-parent="#accordion">

        <div class="card-body p-0">
            <table class="table mb-0">
                <tbody>
                @foreach ($classes as $class)
                    @php
                        $classprog = App\ClassProgress::where('user_id', Auth::id())
                            ->where('class_id', $class->id)
                            ->first();
                    @endphp

                    <tr>
                        <td>
                            <a href="{{ route('watchcourseclass', $class->id) }}"
                               onclick="classprogress('{{ $class->id }}','{{ $coursechapter->id }}', this)"
                               target="_blank"
                               style="{{ $classprog ? 'color:green' : '' }}">
                                <i class="fa fa-play-circle"></i>
                                {{ $class->title }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
