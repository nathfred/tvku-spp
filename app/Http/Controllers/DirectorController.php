<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignments = Assignment::whereNull('approval')->where('submit', 1)->orderBy('created', 'desc')->get();

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
        $responed_assignments = Assignment::whereNotNull('approval')->where('submit', 1)->get();
        $unresponed_assignments = Assignment::whereNull('approval')->where('submit', 1)->get();
        $today_assignments = Assignment::where('created', $today)->where('submit', 1)->get();
        $recent_assignments = Assignment::where('submit', 1)->orderBy('created', 'desc')->take(3)->get();

        // UBAH FORMAT 'created' DATE (Y-m-d menjadi d-m-Y)
        foreach ($recent_assignments as $assignment) {
            // UBAH KE FORMAT CARBON
            $assignment->created = Carbon::createFromFormat('Y-m-d', $assignment->created);
            // UBAH FORMAT KE d-m-Y
            $assignment->created = $assignment->created->format('d-m-Y');
        }

        return view('director.index', [
            'title' => 'List Penugasan',
            'active' => 'index',
            'user' => $user,
            'assignments' => $assignments,
            'total_assignment' => $assignments->count(),
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

    public function show_assignments()
    {
        $assignments = Assignment::orderBy('created', 'desc')->where('submit', 1)->get();

        // UBAH FORMAT 'created' DATE (Y-m-d menjadi d-m-Y)
        foreach ($assignments as $assignment) {
            // UBAH KE FORMAT CARBON
            $assignment->created = Carbon::createFromFormat('Y-m-d', $assignment->created);
            // UBAH FORMAT KE d-m-Y
            $assignment->created = $assignment->created->format('d-m-Y');
        }

        return view('director.assignments', [
            'title' => 'List Penugasan',
            'active' => 'assignment',
            'assignments' => $assignments,
        ]);
    }

    public function detail_assignment($type, $id)
    {
        $assignment = Assignment::where('id', $id)->first();

        // VALIDASI APAKAH ASSIGNMENT ADA
        if ($assignment === NULL) {
            return back()->with('message', 'assignment-not-found');
        }

        return view('director.detail', [
            'title' => 'Detail Penugasan',
            'active' => 'assignment',
            'type' => $type,
            'assignment' => $assignment,
        ]);
    }

    public function save_assignment(Request $request, $type, $id)
    {
        $assignment = Assignment::find($id);

        // VALIDASI APAKAH ASSIGNMENT ADA
        if ($assignment === NULL) {
            return back()->with('message', 'assignment-not-found');
        }

        $request->approve = FALSE;
        if ($request->approval == '1') {
            $request->approve = TRUE;
        } else {
            $request->approve = FALSE;
        }

        $request->validate([
            'priority' => 'required|string',
            'approval' => 'required|integer',
        ]);

        $today = Carbon::today('GMT+7');
        $assignment->priority = $request->priority;
        $assignment->approval = $request->approve;
        $assignment->approval_date = $today;
        $assignment->save();

        return redirect(route('director-show-assignments'))->with('message', 'success-approve-assignment');
    }
}
