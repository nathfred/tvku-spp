<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignments = Assignment::whereNull('approval')->orderBy('created', 'desc')->get();

        // UBAH FORMAT 'created' DATE (Y-m-d menjadi d-m-Y)
        foreach ($assignments as $assignment) {
            // UBAH KE FORMAT CARBON
            $assignment->created = Carbon::createFromFormat('Y-m-d', $assignment->created);
            // UBAH FORMAT KE d-m-Y
            $assignment->created = $assignment->created->format('d-m-Y');
        }

        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();

        $today = Carbon::today('GMT+7');
        $total_assignments = Assignment::orderBy('created', 'desc')->get();
        $responed_assignments = Assignment::whereNotNull('approval')->get();
        $unresponed_assignments = Assignment::whereNull('approval')->get();
        $today_assignments = Assignment::where('created', $today)->get();
        $recent_assignments = Assignment::orderBy('created', 'desc')->take(3)->get();

        // UBAH FORMAT 'created' DATE (Y-m-d menjadi d-m-Y)
        foreach ($recent_assignments as $assignment) {
            // UBAH KE FORMAT CARBON
            $assignment->created = Carbon::createFromFormat('Y-m-d', $assignment->created);
            // UBAH FORMAT KE d-m-Y
            $assignment->created = $assignment->created->format('d-m-Y');
        }

        return view('employee.index', [
            'title' => 'List Penugasan',
            'active' => 'index',
            'user' => $user,
            'assignments' => $assignments,
            'total_assignment' => $total_assignments->count(),
            'responded_assignment' => $responed_assignments->count(),
            'unresponded_assignment' => $unresponed_assignments->count(),
            'today_assignment' => $today_assignments->count(),
            'recent_assignments' => $recent_assignments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function submit_assignment($submit, $id)
    {
        $assignment = Assignment::find($id);

        // VALIDASI APAKAH ASSIGNMENT ADA
        if ($assignment === NULL) {
            return back()->with('message', 'assignment-not-found');
        }

        if ($submit == 1) {
            $status = TRUE;
        } else {
            $status = FALSE;
        }
        $assignment->submit = $status;
        $assignment->save();

        return back()->with('message', 'success-submit-assignment');
    }
}
