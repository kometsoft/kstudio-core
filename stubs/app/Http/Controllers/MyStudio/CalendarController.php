<?php

namespace App\Http\Controllers\MyStudio;

use App\Http\Controllers\Controller;
use App\Models\MyStudio\Calendar;
use App\Models\MyStudio\MyStudio;
use DB;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mystudio.calendar.index', [
            'calendars' => Calendar::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mystudio.calendar.create', [
            'forms'             => MyStudio::where('type', 'form')->get(),
            'dasboard_calendar' => Calendar::where('dashboard_enable', true)->exists(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        foreach ($request->setting as $value) {

            $count = count($value);
            if ($count === 6) {
                $data[$value['form']] = $value;
            }
        }

        $calendar = Calendar::create([
            'name'             => $request->name,
            'description'      => $request->description,
            'dashboard_enable' => $request->dashboard_enable,
            'settings'         => $data,
        ]);

        return redirect()->route('calendar.index')->with('success', 'Calendar create successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($calendar_id)
    {

        return view('mystudio.calendar.show', [
            'calendar' => Calendar::find($calendar_id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($calendar_id)
    {
        $data = Calendar::find($calendar_id);
        $data = $data->settings;
        foreach ($data as $form) {
            $dataArray[] = $form['form'];
        }

        return view('mystudio.calendar.edit', [
            'calendar'          => Calendar::find($calendar_id),
            'forms'             => MyStudio::where('type', 'form')->get(),
            'dataArray'         => $dataArray,
            'dasboard_calendar' => Calendar::where('dashboard_enable', true)->exists(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $calendar_id)
    {
        foreach ($request->setting as $value) {
            $count = count($value);
            if ($count === 6) {
                $data[$value['form']] = $value;
            }
        }

        $calendar = Calendar::find($calendar_id);
        $calendar->update([
            'name'             => $request->name,
            'description'      => $request->description,
            'dashboard_enable' => $request->dashboard_enable,
            'settings'         => $data,
        ]);

        return redirect()->route('calendar.show', $calendar_id)->with('success', 'Calendar updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function calendar($calendar_id)
    {
        $calendar = Calendar::find($calendar_id);
        $calendar = $calendar->settings;

        foreach ($calendar as $cal) {
            $name  = $cal['table'];
            $query = DB::table($name)->select($cal['title_column'], $cal['date_column'])->get();
            foreach ($query as $data) {
                $event[] = [
                    'title' => $data->{$cal['title_column']},
                    'date'  => $data->{$cal['date_column']},
                    'icon'  => $cal['icon'],
                    'color' => $cal['color'],
                ];
            }
        }

        return view('mystudio.calendar.calendar', [
            'calendar' => Calendar::find($calendar_id),
            'event'    => $event,
        ]);
    }
}
