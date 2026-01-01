<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseProgress;
use App\CourseChapter;
use App\ClassProgress;
use App\CourseClass;
use DB;
use Auth;

class CourseProgressController extends Controller
{
	public function checked(Request $request, $id)
	{
		$data = $this->validate($request, [
			'checked' => 'required',
		]);

		$progress = CourseProgress::where('course_id', '=', $id)->where('user_id', Auth::User()->id)->first();

		if (isset($progress)) {
			CourseProgress::where('course_id', $id)->where('user_id', '=', Auth::user()
				->id)
				->update(['mark_chapter_id' => $request->checked]);
		} else {

			$chapter = CourseChapter::where('course_id', $id)->get();

			$chapter_id = array();

			foreach ($chapter as $c) {
				array_push($chapter_id, "$c->id");
			}

			$created_progress = CourseProgress::create(
				[
					'course_id' => $id,
					'user_id' => Auth::User()->id,
					'mark_chapter_id' => $request->checked,
					'all_chapter_id' => $chapter_id,
					'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
					'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
				]
			);
		}

		return back();
	}

	
	
	public function classprogress_test(Request $request)
	{
		// Case 1: Onload → return completed chapters
		if ($request->flag_onload) {
			$user_id   = $request->user_id;
			$course_id = $request->course_id;

			$completedChapters = ClassProgress::where('user_id', $user_id)
				->where('course_id', $course_id)
				->pluck('chapter_id');

			return response()->json([
				'status' => true,
				'allchapter_id' => [
					'mark_chapter_id' => $completedChapters
				]
			]);
		}

		
		$user_id    = Auth::id();
		$course_id  = $request->course_id;
		$chapter_id = $request->chapter_id;
		$class_id   = $request->class_id;

		
		$totalClassCount = CourseClass::where('course_id', $course_id)
			->where('coursechapter_id', $chapter_id)
			->count();

			
		$classprogress = ClassProgress::where('user_id', $user_id)
			->where('course_id', $course_id)
			->where('chapter_id', $chapter_id)
			->where('class_id', $class_id)
			->first();

		if (!$classprogress) {
			ClassProgress::create([
				'user_id'    => $user_id,
				'course_id'  => $course_id,
				'chapter_id' => $chapter_id,
				'class_id'   => $class_id,
				'status'     => 1
			]);
		}

		
		$completedClassCount = ClassProgress::where('user_id', $user_id)
			->where('course_id', $course_id)
			->where('chapter_id', $chapter_id)
			->count();

		$assessment_view = false;
		
		if ($totalClassCount == $completedClassCount && $completedClassCount > 0) {
			$chapter = CourseChapter::with('quizTopics.questions')->find($chapter_id);

			
			$quizcount = 0;
			if ($chapter && $chapter->quizTopics) {
				foreach ($chapter->quizTopics as $topic) {
					$quizcount += $topic->questions->count();
				}
			}

			
			if ($quizcount == 0) {
				$progress = CourseProgress::where('course_id', $course_id)
					->where('user_id', $user_id)
					->first();

				if ($progress) {
					
					$status          = $progress->status;
					$allchapter      = $progress->all_chapter_id;
					$mark_chapter_id = $progress->mark_chapter_id;

					
					$status = is_array($status) ? $status : (empty($status) ? [] : (array) json_decode($status, true));
					$allchapter = is_array($allchapter) ? $allchapter : (empty($allchapter) ? [] : (array) json_decode($allchapter, true));
					$mark_chapter_id = is_array($mark_chapter_id) ? $mark_chapter_id : (empty($mark_chapter_id) ? [] : (array) json_decode($mark_chapter_id, true));

					
					$status = array_unique($status);
					$mark_chapter_id = array_unique($mark_chapter_id);
					
					if (in_array($chapter_id, $mark_chapter_id)) {
						
						return response()->json([
							
									'allchapter_id' => $allchapter_id ?? null
								]);
					}

					// Find the last marked chapter
					$lastIndex = -1;
					foreach ($allchapter as $index => $cid) {
						if (in_array($cid, $status)) {
							$lastIndex = $index;
						}
					}

					// Calculate the next chapter index
					$nextIndex = $lastIndex + 1;
					$nextChapter = $allchapter[$nextIndex] ?? null;

					// Add the current chapter ID to the mark_chapter_id list
					$mark_chapter_id[] = $chapter_id;
					$mark_chapter_id = array_unique($mark_chapter_id);

					// Update the progress record
					$progress->update([
						'status'          => $nextChapter ? [$nextChapter] : ["0"],
						'mark_chapter_id' => $mark_chapter_id,
						'next_module'     => count($mark_chapter_id),
					]);
				}
			}


			$assessment_view = true;
		}

		return response()->json([
			'status'        => $assessment_view,
			'allchapter_id' => $allchapter_id ?? null,
			'next_module'   => isset($mark_chapter_id) ? count($mark_chapter_id) : 0,
		]);
	}
	public function classprogressrg(Request $request){
		$course_completed= false;
		
		if ($request->flag_onload) {
			$user_id   = $request->user_id;
			$course_id = $request->course_id;

			$completedChapters = ClassProgress::where('user_id', $user_id)
				->where('course_id', $course_id)
				->pluck('chapter_id');
			

			return response()->json([
				'status' => true,
				'allchapter_id' => [
					'mark_chapter_id' => $completedChapters
				]
			]);
		}

	
		        $user_id = Auth::user()->id;
				$course_id = $request->course_id;
				$chapter_id = $request->chapter_id;
				$class_id = $request->class_id;

				$classprogress = ClassProgress::where('user_id',Auth::user()->id)->where('course_id',$course_id)->where('chapter_id',$chapter_id)->where('class_id',$class_id)->first();
						$progress = CourseProgress::where('course_id', '=', $course_id)->where('user_id', Auth::User()->id)->first();
						if( count($progress['all_chapter_id']) == (count($progress['mark_chapter_id'])-1))
						{
							$course_completed= true;

						}


			

        if (isset($classprogress)) {
		   return 'Already saved';
        }
		else{
            $newprogress = ClassProgress::create([
            'user_id' => Auth::user()->id,
            'course_id' => $course_id,
            'chapter_id' => $chapter_id,
            'class_id' => $class_id,
            'status' => 1
        ]);
		$completedClassCount = ClassProgress::where('user_id', $user_id)
			->where('course_id', $course_id)
			->where('chapter_id', $chapter_id)
			->count();
		$totalClassCount = CourseClass::where('course_id', $course_id)
			->where('coursechapter_id', $chapter_id)
			->count();

			
		if ($totalClassCount == $completedClassCount && $completedClassCount > 0) {
			$assessment_view=true;
			return response()->json([
			'status'        => $assessment_view,
			'course_completed'=>$course_completed
		]);
		

		}
		return response()->json([
			'status'        => false,
			'course_completed'=> $course_completed
			
		]);

		

        }

		


	}
// 	public function classprogress(Request $request)
// {
//     $user_id   = Auth::id();
//     $course_id = $request->course_id;
//     $chapter_id = $request->chapter_id;
//     $class_id  = $request->class_id;

//     // save class progress only once
//     ClassProgress::firstOrCreate([
//         'user_id'    => $user_id,
//         'course_id'  => $course_id,
//         'chapter_id' => $chapter_id,
//         'class_id'   => $class_id,
//     ], [
//         'status' => 1
//     ]);

//     // total classes in chapter
//     $totalClasses = CourseClass::where('coursechapter_id', $chapter_id)->count();

//     // viewed classes by user
//     $viewedClasses = ClassProgress::where('user_id', $user_id)
//         ->where('course_id', $course_id)
//         ->where('chapter_id', $chapter_id)
//         ->count();

//     // decide chapter status
//     if ($viewedClasses == 0) {
//         $chapterStatus = 'not_started';
//     } elseif ($viewedClasses < $totalClasses) {
//         $chapterStatus = 'in_progress';
//     } else {
//         $chapterStatus = 'completed';
//     }

//     return response()->json([
//         'chapter_id' => $chapter_id,
//         'total'      => $totalClasses,
//         'viewed'     => $viewedClasses,
//         'status'     => $chapterStatus
//     ]);
// }
public function classprogress(Request $request)
{
    $userId    = Auth::id();
    $chapterId = (int) $request->chapter_id;

    // Mark class as completed
    ClassProgress::firstOrCreate(
        [
            'user_id'    => $userId,
            'course_id'  => $request->course_id,
            'chapter_id' => $chapterId,
            'class_id'   => $request->class_id,
        ],
        ['status' => 1]
    );

    //  Count classes in chapter
    $totalClasses = CourseClass::where('coursechapter_id', $chapterId)->count();

    $doneClasses = ClassProgress::where('user_id', $userId)
        ->where('chapter_id', $chapterId)
        ->count();

    // Get or create course_progress
    $courseProgress = CourseProgress::firstOrCreate(
        [
            'user_id'   => $userId,
            'course_id' => $request->course_id,
        ],
        [
            'all_chapter_id' => CourseChapter::where('course_id', $request->course_id)
                ->pluck('id')
                ->toArray(),
            'mark_chapter_id' => [],
            'status' => [],
        ]
    );

    $markedChapters = $courseProgress->mark_chapter_id ?? [];

    //  If chapter fully completed → mark completed
    if ($doneClasses === $totalClasses && $totalClasses > 0) {
        if (!in_array($chapterId, $markedChapters)) {
            $markedChapters[] = $chapterId;
        }
    }

    //  Find next chapter
    $nextChapter = CourseChapter::where('course_id', $request->course_id)
        ->whereNotIn('id', $markedChapters)
        ->orderBy('id', 'asc')
        ->value('id');

    //  UPDATE course_progress
    $courseProgress->update([
        'mark_chapter_id' => $markedChapters,
        'status' => $nextChapter ? [$nextChapter] : [],
    ]);

	
    $courseCompleted = count($markedChapters) === count($courseProgress->all_chapter_id);

    return response()->json([
        'status'           => ($doneClasses === $totalClasses && $totalClasses > 0) ? 'completed' : 'progress',
        'current_chapter'  => $chapterId,
        'next_module'      => $nextChapter,
        'allchapter_id'    => ['mark_chapter_id' => $markedChapters],
        'course_completed' => $courseCompleted,
    ]);
}





}
