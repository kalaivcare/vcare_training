<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DailyLearningProgress;
use Carbon\Carbon;
use Auth;

class LearningProgressController extends Controller
{
    public function index()
    {
        $entries = DailyLearningProgress::where('user_id', Auth::id())
                    ->orderBy('learning_date', 'desc')
                    ->get();

        return view('learning.index', compact('entries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'learning_date' => 'required|date',
            'content' => 'required|min:100',
        ], [
            'content.min' => 'Your entry must be at least 100 words.',
        ]);

        $existing = DailyLearningProgress::where('user_id', Auth::id())
                    ->where('learning_date', $request->learning_date)
                    ->first();

        if ($existing) {
            return back()->with('error', 'You have already submitted for this date.');
        }

        $today = Carbon::today();
        if (Carbon::parse($request->learning_date)->gt($today)) {
            return back()->with('error', 'You cannot add a future date.');
        }

        DailyLearningProgress::create([
            'user_id' => Auth::id(),
            'learning_date' => $request->learning_date,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Learning progress saved successfully.');
    }
    public function update(Request $request, $id)
    {
        $entry = DailyLearningProgress::findOrFail($id);

        
        if ($entry->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }

        
        $request->validate([
            'learning_date' => 'required|date',
            'content' => 'required|string|min:10',
        ]);

        $entry->learning_date = $request->learning_date;
        $entry->content = $request->content;
        $entry->save();

        return back()->with('success', 'Entry updated successfully!');
    }

}
