<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show_form () {
        return view('form');
    }

    // ==================================================

    public function preview_workout (Request $request) {
        // persist old form data
        $old_form_data = $request->except('_token');
        session(['old_form_data' => $old_form_data]);

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
        return view('workout');
    }

    // ==================================================
}
