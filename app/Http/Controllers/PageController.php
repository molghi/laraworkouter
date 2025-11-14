<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show_form () {
        $data = [
            'saved_workouts' => Workout::whereNotNull('finished_at')->get()
        ];
        return view('form', $data);
    }

    // ==================================================

    public function preview_workout (Request $request) {
        // persist old form data
        $old_form_data = $request->except('_token');
        session(['old_form_data' => $old_form_data, 'last_set' => date('Y-m-d')]);

        // validate
        $data = $request->validate([
            'workout' => 'required|string|min:10|max:10000',
            'work' => 'required|numeric',
            'rest' => 'required|numeric',
            'rounds' => 'required|numeric',
            'name' => 'required|string|min:2|max:255',
        ]);

        $data['exercises'] = explode("\n", $request['workout']);
        $data['total_duration'] = ((int) $data['work'] + (int) $data['rest']) * count($data['exercises']) * (int) $data['rounds']; // in secs

        session(['workout_data' => $data]);

        return view('preview', $data);
    }

    // ==================================================

    public function begin_workout () {
        $workout_data_for_db = session('workout_data');
        $workout_data_for_db['exercises'] = json_encode($workout_data_for_db['exercises']);
        // checking not to store duplicates
        if (!Workout::where('work', $workout_data_for_db['work'])
            ->where('rest', $workout_data_for_db['rest'])
            ->where('rounds', $workout_data_for_db['rounds'])
            ->where('workout', $workout_data_for_db['workout'])
            ->exists()
            ) {
                $workout = Workout::create($workout_data_for_db);
                session(['current_workout_id' => $workout['id']]);
            }
        return view('workout');
    }

    // ==================================================

    public function show_saved () {
        $data = [
            'finished_workouts' => Workout::whereNotNull('finished_at')->get()
        ];
        return view('saved', $data);
    }

    // ==================================================

    public function show_stats () {
        $data = [
            'finished_workouts' => Workout::whereNotNull('finished_at')->get()
        ];
        return view('stats', $data);
    }

    // ==================================================

    public function finish_workout (Request $request) {
        $data = [
            'real_total_duration' => $request['real_total_duration'],
            'finished_at' => $request['finished_at'],
        ];
        return view('finish', $data);
    }

    // ==================================================

    public function register_workout (Request $request) {
        // take all data and update workout entry: upd only 3 fields there
        $note = $request['note']; 
        $real_total_duration = $request['real_total_duration']; 
        $finished_at = $request['finished_at']; 
        Workout::where('id', session('current_workout_id'))->update([
            'finished_at' => $finished_at,
            'real_total_duration' => $real_total_duration,
            'note' => trim($note),
        ]);
        session(['current_workout_id' => 0]);
        $finished_workouts = Workout::whereNotNull('finished_at')->get();
        session(['finished_workouts' => $finished_workouts]);
        return redirect('/stats');
    }

    // ==================================================

    public function fillout_workout (Request $request) {
        // $workout = ;
        $data = [
            'workout' => Workout::find($request['id'])
        ];
        return view('form', $data);
    }

    // ==================================================
}
