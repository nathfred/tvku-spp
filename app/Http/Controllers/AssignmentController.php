<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        //
    }

    public function show_assignments()
    {
        $assignments = Assignment::orderBy('created', 'desc')->get();

        // UBAH FORMAT 'created' DATE (Y-m-d menjadi d-m-Y)
        foreach ($assignments as $assignment) {
            // UBAH KE FORMAT CARBON
            $assignment->created = Carbon::createFromFormat('Y-m-d', $assignment->created);
            // UBAH FORMAT KE d-m-Y
            $assignment->created = $assignment->created->format('d-m-Y');
        }

        return view('employee.assignments', [
            'title' => 'List Penugasan',
            'active' => 'assignment',
            'assignments' => $assignments,
        ]);
    }

    public function pre_create_assignment()
    {
        return view('employee.pre_create', [
            'title' => 'Buat Penugasan',
            'active' => 'assignment',
        ]);
    }

    public function create_assignment($type)
    {
        if ($type == 'Free') {
        } elseif ($type == 'Berbayar') {
        } elseif ($type == 'Barter') {
        } else {
            return back()->with('message', 'unknown-type');
        }

        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();

        return view('employee.create', [
            'title' => 'Buat Penugasan (' . $type . ')',
            'active' => 'assignment',
            'type' => $type,
            'user' => $user,
        ]);
    }

    public function store_assignment(Request $request, $type)
    {
        $user_id = Auth::id();

        // VALIDASI INPUT
        if ($type == 'Free') { // FREE TIDAK ADA NSPK
        } else { // BERBAYAR DAN BARTER ADA NSPK
            $request->validate([
                'nspk' => 'required|string',
            ]);
        }
        $request->validate([
            'created' => 'required|date',
            'client' => 'required|string',
            'nspp' => 'required',
            'description' => 'required|string',
            'deadline' => 'required|string',
            'info' => 'required|string'
        ]);

        if ($type == 'Free') {
            Assignment::create([
                'user_id' => $user_id,
                'created' => $request->created,
                'client' => $request->client,
                'nspp' => $request->nspp,
                'description' => $request->description,
                'deadline' => $request->deadline,
                'info' => $request->info,
                'type' => $type,
            ]);
        } else {
            Assignment::create([
                'user_id' => $user_id,
                'created' => $request->created,
                'client' => $request->client,
                'nspp' => $request->nspp,
                'nspk' => $request->nspk,
                'description' => $request->description,
                'deadline' => $request->deadline,
                'info' => $request->info,
                'type' => $type,
            ]);
        }

        return redirect(route('employee-show-assignments'))->with('message', 'success-create-assignment');
    }

    public function delete_assignment($id)
    {
        $assignment = Assignment::find($id);

        // VALIDASI APAKAH ASSIGNMENT ADA
        if ($assignment === NULL) {
            return back()->with('message', 'assignment-not-found');
        }

        $assignment->delete();
        return back()->with('message', 'success-delete-assignment');
    }

    public function edit_assignment($type, $id)
    {
        $assignment = Assignment::where('id', $id)->first();

        // VALIDASI APAKAH ASSIGNMENT ADA
        if ($assignment === NULL) {
            return back()->with('message', 'assignment-not-found');
        }

        return view('employee.edit', [
            'title' => 'Edit Penugasan',
            'active' => 'assignment',
            'assignment' => $assignment,
            'type' => $type
        ]);
    }

    public function save_assignment(Request $request, $type, $id)
    {
        $assignment = Assignment::find($id);

        // VALIDASI APAKAH ASSIGNMENT ADA
        if ($assignment === NULL) {
            return back()->with('message', 'assignment-not-found');
        }

        if ($type == 'Free') {
            // TANPA VALIDASI NSPK
        } else {
            $request->validate([
                'nspk' => 'required|string',
            ]);
        }
        $request->validate([
            'created' => 'required|date',
            'client' => 'required|string',
            'nspp' => 'required',
            'description' => 'required|string',
            'deadline' => 'required|string',
            'info' => 'required|string'
        ]);

        if ($type != 'Free') { // BERBAYAR ATAU BARTER ADA NSPK
            $assignment->nspk = $request->nspk;
        }
        $assignment->created = $request->created;
        $assignment->client = $request->client;
        $assignment->nspp = $request->nspp;
        $assignment->description = $request->description;
        $assignment->deadline = $request->deadline;
        $assignment->info = $request->info;
        $assignment->save();

        return back()->with('message', 'success-edit-assignment');
    }
}
