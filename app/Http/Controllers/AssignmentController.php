<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Assignment;
use Illuminate\Support\Str;
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

        // UBAH FORMAT 'created' DATE (Y-m-d menjadi d-m-Y) dan Number Format untuk Nominal
        foreach ($assignments as $assignment) {
            // UBAH KE FORMAT CARBON
            $assignment->created = Carbon::createFromFormat('Y-m-d', $assignment->created);
            // UBAH FORMAT KE d-m-Y
            $assignment->created = $assignment->created->format('d-m-Y');
            if ($assignment->nominal) {
                $assignment->nominal = 'Rp. ' .  number_format($assignment->nominal, 0, ",", ".");
            }
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
        } elseif ($type == 'Berbayar') {
            $request->validate([
                'nspk' => 'required|string',
                'nominal' => 'required',
                'client' => 'required|string',
                'description' => 'required|string',
            ]);
        } else { // BERBAYAR DAN BARTER ADA NSPK
            $request->validate([
                'nspk' => 'required|string',
                'client' => 'required|string',
                'description' => 'required|string',
            ]);
        }
        $request->validate([
            'created' => 'required|date',
            'nspp' => 'required',
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
                'unique_id' => Str::random(32),
            ]);
        } elseif ($type == 'Berbayar') {
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
                'nominal' => $request->nominal,
                'unique_id' => Str::random(32),
            ]);
        } else { // BARTER
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
                'unique_id' => Str::random(32),
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

        // VALIDASI INPUT
        if ($type == 'Free') { // FREE TIDAK ADA NSPK
        } elseif ($type == 'Berbayar') {
            $request->validate([
                'nspk' => 'required|string',
                'nominal' => 'required',
                'client' => 'required|string',
                'description' => 'required|string',
            ]);
        } else { // BERBAYAR DAN BARTER ADA NSPK
            $request->validate([
                'nspk' => 'required|string',
                'client' => 'required|string',
                'description' => 'required|string',
            ]);
        }
        $request->validate([
            'created' => 'required|date',
            'nspp' => 'required',
            'deadline' => 'required|string',
            'info' => 'required|string'
        ]);

        if ($type != 'Free') { // BERBAYAR ATAU BARTER ADA NSPK
            $assignment->nspk = $request->nspk;
            $assignment->client = $request->client;
            $assignment->description = $request->description;
        }

        if ($type == 'Berbayar') {
            $assignment->nominal = $request->nominal;
        }

        // SAVE ALL TYPE
        $assignment->client = $request->client;
        $assignment->description = $request->description;
        $assignment->created = $request->created;
        $assignment->nspp = $request->nspp;
        $assignment->deadline = $request->deadline;
        $assignment->info = $request->info;
        $assignment->save();

        return back()->with('message', 'success-edit-assignment');
    }
}
