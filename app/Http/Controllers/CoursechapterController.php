<?php

namespace App\Http\Controllers;

use DB;
use Image;
use Session;
use App\Quiz;
use App\Course;
use App\Module;
use App\QuizTopic;
use App\CourseClass;
use App\CourseChapter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoursechapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coursechapter = CourseChapter::with('courses')->paginate(10);
        $courses = Course::where('status', 1)->get(); // active courses

        return view(
            'admin.course.coursechapter.index',
            compact('coursechapter', 'courses')
        );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coursechapter = Course::all();
        return view('admin.course.coursechapter.insert', compact('coursechapter'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    {
        
        $data = $request->validate([
            'chapter_name' => 'required|string|max:191',
            'module_type'  => 'required|string|in:Skin,Hair',
            'file.*'       => 'nullable|file|mimes:mp4,avif,mov,mkv,ppt,pptx,pdf',
            'title.*'      => 'nullable|string|max:191',
        ],[
            'file.*.mimes' => 'Only MP4 videos, PPT, and PDF files are allowed. Word documents are not allowed.',

        ]);

        // Get active course
        $course = Course::where('status', 1)->firstOrFail();

        // Create course chapter
        $chapter = CourseChapter::create([
            'course_id'    => $course->id,
            'chapter_name' => $request->chapter_name,
            'module_type'  => $request->module_type,
        ]);

        // Create quiz topic for this chapter
        QuizTopic::create([
            'course_id'          => $course->id,
            'coursechapter_id'   => $chapter->id,
            'title'              => $request->chapter_name,
        ]);

        // Update course progress
        $progresses = \App\CourseProgress::where('course_id', $course->id)->get();
        foreach ($progresses as $progress) {
            $allChapterIds = is_array($progress->all_chapter_id) ? $progress->all_chapter_id : [];
            if (!in_array($chapter->id, $allChapterIds)) {
                $allChapterIds[] = $chapter->id;
                sort($allChapterIds, SORT_NUMERIC);
                $progress->all_chapter_id = $allChapterIds;
                $progress->save();
            }
        }

        // Handle uploaded files
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $index => $uploadedFile) {
                $title = $request->input('title')[$index] ?? $chapter->chapter_name;
                $ext = strtolower($uploadedFile->getClientOriginalExtension());
                $originalName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = time() . '-' . Str::slug($originalName, '_') . '.' . $ext;

                // Determine type
                if (in_array($ext, ['mp4', 'avif', 'mov', 'mkv'])) {
                    $type = 'video';
                    $uploadedFile->move(public_path('video/class/'), $fileName);
                    CourseClass::create([
                        'course_id'          => $course->id,
                        'coursechapter_id'   => $chapter->id,
                        'type'               => 'video',
                        'video'              => $fileName,
                        'title'              => $title,
                        'status'             => 1,
                    ]);
                } elseif (in_array($ext, ['ppt', 'pptx'])) {
                    $type = 'ppt';
                    $path = $uploadedFile->storeAs('ppt', $fileName, 's3'); // S3 storage
                    CourseClass::create([
                        'course_id'          => $course->id,
                        'coursechapter_id'   => $chapter->id,
                        'type'               => 'ppt',
                        'ppt'                => $fileName,
                        'title'              => $title,
                        'status'             => 1,
                    ]);
                } else {
                    $type = 'pdf';
                    $uploadedFile->move(public_path('files/pdf/'), $fileName);
                    CourseClass::create([
                        'course_id'          => $course->id,
                        'coursechapter_id'   => $chapter->id,
                        'type'               => 'pdf',
                        'pdf'                => $fileName,
                        'title'              => $title,
                        'status'             => 1,
                    ]);
                }
            }
        }

        Session::flash('success', 'Chapter added successfully!');
        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\coursechapter  $coursechapter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cate = CourseChapter::find($id);
        $courses = Course::all();
        $currentcourse = Course::where('status', '1')->first();
        $CourseClass = $cate->courseclass;
        $modules=Module::all();
        // dd($CourseClass);
        return view('admin.course.coursechapter.edit', compact('cate', 'courses', 'CourseClass','modules', 'currentcourse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\coursechapter  $coursechapter
     * @return \Illuminate\Http\Response
     */
    public function edit(coursechapter $coursechapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\coursechapter  $coursechapter
     * @return \Illuminate\Http\Response
     */


    

public function update(Request $request, $id)
{
    $request->validate([
        'chapter_name' => 'required',
    ]);

    DB::beginTransaction();

    try {
        // Update chapter
        $chapter = CourseChapter::findOrFail($id);
        $chapter->update($request->all());

        // Update existing class materials
        $courseClasses = CourseClass::where('coursechapter_id', $id)->get();

        foreach ($courseClasses as $class) {

            $title = $request->input('title_' . $class->id);

            // PDF update
            if ($class->type === 'pdf' && $request->hasFile('pdf_' . $class->id)) {
                $pdf = $request->file('pdf_' . $class->id);
                $name = time() . '-' . Str::slug(pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME), '_')
                        . '.' . $pdf->getClientOriginalExtension();
                $pdf->move(public_path('files/material/'), $name);
                $class->pdf = $name;
            }

            // Video update
            if ($class->type === 'video' && $request->hasFile('video_' . $class->id)) {
                $video = $request->file('video_' . $class->id);
                $name = time() . '-' . Str::slug(pathinfo($video->getClientOriginalName(), PATHINFO_FILENAME), '_')
                        . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('video/class/'), $name);
                $class->video = $name;
            }

            $class->title = $title;
            $class->status = 1;
            $class->save();
        }

        // Add new materials
        if ($request->hasFile('extra_files')) {

            foreach ($request->file('extra_files') as $index => $file) {

                $title = $request->input('title_')[$index];
                $ext = strtolower($file->getClientOriginalExtension());
                $type = in_array($ext, ['mp4', 'avi', 'mov', 'mkv']) ? 'video' : 'pdf';

                $name = time() . '-' . Str::slug(
                    pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    '_'
                ) . '.' . $ext;

                if ($type === 'pdf') {
                    $file->move(public_path('files/pdf/'), $name);
                    CourseClass::create([
                        'course_id' => $request->course_id,
                        'coursechapter_id' => $id,
                        'type' => 'pdf',
                        'pdf' => $name,
                        'title' => $title,
                        'status' => 1
                    ]);
                } else {
                    $file->move(public_path('video/class/'), $name);
                    CourseClass::create([
                        'course_id' => $request->course_id,
                        'coursechapter_id' => $id,
                        'type' => 'video',
                        'video' => $name,
                        'title' => $title,
                        'status' => 1
                    ]);
                }
            }
        }

        DB::commit();
        $coursechapter = CourseChapter::latest()->paginate(10);

        return back()->with('message', 'updated');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}

    // public function update(Request $request, $id)
    // {
        
    //    $request->validate([
    //     'course_id'      => 'required|exists:courses,id',
    //     'chapter_name'   => 'required|string|max:191',
    //     'module_type'    => 'required|string|max:191',
    //     // Optional validation for extra files if submitted
    //     'extra_files.*'  => 'nullable|file|mimes:pdf,ppt,pptx,mp4,mkv,avi|max:10240', // max 10MB
    //     'title_.*'       => 'nullable|string|max:191', // extra material titles
    // ], [
    //     'course_id.required' => 'Please select a course',
    //     'chapter_name.required' => 'Please enter chapter title',
    //     'module_type.required' => 'Please enter module type',
    //     'extra_files.*.mimes' => 'Only PDF, PPT, PPTX, or Video files are allowed',
    //     'extra_files.*.max' => 'File size must not exceed 10MB',
    // ]);
    //     $data = CourseChapter::findOrFail($id);
    //     $input = $request->all();
    //     $data->update($input);

    //     $Course = Course::where('status', '=', '1')->first();
    //     $CourseClass = CourseClass::where('coursechapter_id', $id)->get();

    //     foreach ($CourseClass as $index => $file) {
    //         $title_name = $request->input('title_' . $file->id);

    //         if ($file->type === 'pdf' && $request->hasFile('pdf_' . $file->id)) {
    //             $uploadedPdf = $request->file('pdf_' . $file->id);
    //             $pdfOriginalName = $uploadedPdf->getClientOriginalName();
    //             $pdfExtension = $uploadedPdf->getClientOriginalExtension();
    //             $pdfBaseName = pathinfo($pdfOriginalName, PATHINFO_FILENAME);
    //             $pdfName = time() . '-' . Str::slug($pdfBaseName, '_') . '.' . $pdfExtension;
    //             $uploadedPdf->move(public_path('files/pdf/'), $pdfName);
    //             $file->pdf = $pdfName;
    //         }

    //         if ($file->type === 'video' && $request->hasFile('video_' . $file->id)) {
    //             $uploadedVideo = $request->file('video_' . $file->id);
    //             $videoOriginalName = $uploadedVideo->getClientOriginalName();
    //             $videoExtension = $uploadedVideo->getClientOriginalExtension();
    //             $videoBaseName = pathinfo($videoOriginalName, PATHINFO_FILENAME);
    //             $videoName = time() . '-' . Str::slug($videoBaseName, '_') . '.' . $videoExtension;
    //             $uploadedVideo->move(public_path('video/class/'), $videoName);
    //             $file->video = $videoName;
    //         }

    //         if ($file->type === 'ppt' && $request->hasFile('ppt_' . $file->id)) {
    //             $uploadedPpt = $request->file('ppt_' . $file->id);
    //             $pptOriginalName = $uploadedPpt->getClientOriginalName();
    //             $pptExtension = $uploadedPpt->getClientOriginalExtension();
    //             $pptBaseName = pathinfo($pptOriginalName, PATHINFO_FILENAME);
    //             $pptName = time() . '-' . Str::slug($pptBaseName, '_') . '.' . $pptExtension;
    //             // $uploadedPpt->move(public_path('files/ppt/'), $pptName);
    //             $path = $uploadedPpt->storeAs('ppt', $pptName, 's3');
    //             // dd($path);
    //             $file->ppt = $pptName;
    //         }

    //         $file->status = 1;
    //         $file->title = $title_name;
    //         $file->save();
    //     }

    //     // Handle new additional uploads (extra_files)
    //     if ($request->hasFile('extra_files')) {
    //         $titles = $request->input('title_');
    //         foreach ($request->file('extra_files') as $index => $material) {
    //             $title = $titles[$index];
    //             $ext = strtolower($material->getClientOriginalExtension());

    //             if (in_array($ext, ['mp4', 'avi', 'mov', 'mkv'])) {
    //                 $type = 'video';
    //             } elseif (in_array($ext, ['ppt', 'pptx'])) {
    //                 $type = 'ppt';
    //             } else {
    //                 $type = 'pdf';
    //             }

    //             $originalName = $material->getClientOriginalName();
    //             $extension = $material->getClientOriginalExtension();
    //             $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
    //             $fileName = time() . '-' . Str::slug($nameWithoutExtension, '_') . '.' . $extension;

    //             if ($type == 'video') {
    //                 $material->move(public_path('video/class/'), $fileName);
    //                 CourseClass::create([
    //                     'course_id' => $Course->id,
    //                     'coursechapter_id' => $id,
    //                     'type' => 'video',
    //                     'video' => $fileName,
    //                     'title' => $title,
    //                     'status' => 1
    //                 ]);
    //             } elseif ($type == 'ppt') {
    //                 // $material->move(public_path('files/ppt/'), $fileName);
    //                 $path = $material->storeAs('ppt', $fileName, 's3');

    //                 CourseClass::create([
    //                     'course_id' => $Course->id,
    //                     'coursechapter_id' => $id,
    //                     'type' => 'ppt',
    //                     'ppt' => $fileName,
    //                     'title' => $title,
    //                     'status' => 1
    //                 ]);
    //             } else {
    //                 $material->move(public_path('files/pdf/'), $fileName);
    //                 CourseClass::create([
    //                     'course_id' => $Course->id,
    //                     'coursechapter_id' => $id,
    //                     'type' => 'pdf',
    //                     'pdf' => $fileName,
    //                     'title' => $title,
    //                     'status' => 1
    //                 ]);
    //             }
    //         }
    //     }

    //     $coursechapter = CourseChapter::latest()->get();
    //     return view('admin.course.coursechapter.index', compact("coursechapter"));
    //     // return back(); // this will not execute since view() is returned above
    // }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\coursechapter  $coursechapter
     * @return \Illuminate\Http\Response
     */
    public function getByCourse($courseId)
    {
        // dd("test");
        return CourseChapter::where('course_id', $courseId)
            ->select('id', 'chapter_name')
            ->get();
    }

    public function destroy($id)
    {
        $chapter = CourseChapter::findOrFail($id);

        $topicIds = $chapter->quizTopics()->pluck('id');
        Quiz::whereIn('topic_id', $topicIds)->delete();

        $chapter->quizTopics()->delete();

        $chapter->courseclass()->delete();

        $chapter->delete();
        // DB::table('course_chapters')->where('id', $id)->delete();
        // $topicIds = DB::table('quiz_topics')
        //     ->where('coursechapter_id', $id)
        //     ->pluck('id');
        // DB::table('quiz_topics')->where('coursechapter_id', $id)->delete();
        $Course = Course::where('status', '=', '1')->first();
        // DB::tabel('quiz_questions')->where('topic_id', $topicIds)->delete();
        $progresses = \App\CourseProgress::where('course_id', $Course->id)->get();
        // dd($progresses);

        foreach ($progresses as $progress) {
            $allChapterIds = $progress->all_chapter_id;

            if (!is_array($allChapterIds)) {
                $allChapterIds = [];
            }

            if (in_array($id, $allChapterIds)) {

                $allChapterIds = array_filter($allChapterIds, function ($chapterId) use ($id) {
                    return $chapterId != $id;
                });

                $allChapterIds = array_values($allChapterIds);

                sort($allChapterIds, SORT_NUMERIC);

                $progress->all_chapter_id = $allChapterIds;
                $progress->save();
            }
        }
        DB::table('course_classes')->where('coursechapter_id', $id)->delete();
        return back();
    }
}