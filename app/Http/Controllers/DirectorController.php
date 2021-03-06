<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $total_assignments = Assignment::orderBy('created', 'desc')->where('submit', 1)->get();
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

    public function show_assignments($year = NULL)
    {
        $now = Carbon::now('GMT+7');
        $this_year = $now->year;
        if ($year === NULL) { // THIS YEAR
            $assignments = Assignment::whereYear('created', $this_year)->where('submit', 1)->orderBy('created', 'desc')->get();
        } else { // CERTAIN YEAR (PARAMETER)
            $assignments = Assignment::whereYear('created', $year)->where('submit', 1)->orderBy('created', 'desc')->get();
        }

        foreach ($assignments as $assignment) {
            // UBAH NOMINAL DAN MARKETING EXPENSE KE INTEGER
            if ($assignment->type == 'Berbayar') {
                $assignment->nominal = (int)$assignment->nominal;
                $assignment->marketing_expense = (int)$assignment->marketing_expense;
                // KURANGI
                $assignment->nominal_expense = $assignment->nominal - $assignment->marketing_expense;
            }
        }

        // UBAH FORMAT 'created' DATE (Y-m-d menjadi d-m-Y) dan Number Format untuk Nominal
        foreach ($assignments as $assignment) {
            // UBAH KE FORMAT CARBON
            $assignment->created = Carbon::createFromFormat('Y-m-d', $assignment->created);
            // UBAH FORMAT KE d-m-Y
            $assignment->created = $assignment->created->format('d-m-Y');
            if ($assignment->nominal_expense) {
                $assignment->nominal_expense = 'Rp. ' .  number_format($assignment->nominal_expense, 0, ",", ".");
            }
        }

        // ARRAY TAHUN DARI 2021 SAMPAI SAAT INI (DYNAMIC)
        $years = range(2021, $this_year);

        return view('director.assignments', [
            'title' => 'List Penugasan',
            'active' => 'assignment',
            'assignments' => $assignments,
            'approval' => NULL,
            'years' => $years,
            'target_year' => $year,
        ]);
    }

    public function show_assignments_filtered($approval, $year = NULL)
    {
        $now = Carbon::now('GMT+7');
        $this_year = $now->year;
        $today = Carbon::today('GMT+7');
        if ($year === NULL) { // THIS YEAR
            if ($approval == 1 || $approval == 'responded') {
                $assignments = Assignment::orderBy('created', 'desc')->where('submit', 1)->whereNotNull('approval')->get();
            } elseif ($approval == 0 || $approval == 'unresponded') {
                $assignments = Assignment::orderBy('created', 'desc')->where('submit', 1)->whereNull('approval')->get();
            } elseif ($approval == 'today') {
                $assignments = Assignment::orderBy('created', 'desc')->where('submit', 1)->where('created', $today)->get();
            }
        } else { // CERTAIN YEAR (PARAMETER)
            if ($approval == 1 || $approval == 'responded') {
                $assignments = Assignment::orderBy('created', 'desc')->whereYear('created', $year)->where('submit', 1)->whereNotNull('approval')->get();
            } elseif ($approval == 0 || $approval == 'unresponded') {
                $assignments = Assignment::orderBy('created', 'desc')->whereYear('created', $year)->where('submit', 1)->whereNull('approval')->get();
            } elseif ($approval == 'today') {
                $assignments = Assignment::orderBy('created', 'desc')->whereYear('created', $year)->where('submit', 1)->where('created', $today)->get();
            }
        }

        foreach ($assignments as $assignment) {
            // UBAH NOMINAL DAN MARKETING EXPENSE KE INTEGER
            if ($assignment->type == 'Berbayar') {
                $assignment->nominal = (int)$assignment->nominal;
                $assignment->marketing_expense = (int)$assignment->marketing_expense;
                // KURANGI
                $assignment->nominal_expense = $assignment->nominal - $assignment->marketing_expense;
            }
        }

        // UBAH FORMAT 'created' DATE (Y-m-d menjadi d-m-Y) dan Number Format untuk Nominal
        foreach ($assignments as $assignment) {
            // UBAH KE FORMAT CARBON
            $assignment->created = Carbon::createFromFormat('Y-m-d', $assignment->created);
            // UBAH FORMAT KE d-m-Y
            $assignment->created = $assignment->created->format('d-m-Y');
            if ($assignment->nominal_expense) {
                $assignment->nominal_expense = 'Rp. ' .  number_format($assignment->nominal_expense, 0, ",", ".");
            }
        }

        // ARRAY TAHUN DARI 2021 SAMPAI SAAT INI (DYNAMIC)
        $years = range(2021, $this_year);

        return view('director.assignments', [
            'title' => 'List Penugasan',
            'active' => 'assignment',
            'assignments' => $assignments,
            'approval' => $approval,
            'years' => $years,
            'target_year' => $year,
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

        // GENERATE AND SAVE QR CODE TO LOCAL DIRECTORY (ONLY IF APPROVED)
        if ($request->approval == '1' || $request->approve == TRUE) {
            $this->generate($assignment->id);
        }

        if ($request->approve == TRUE) {
            return redirect(route('director-show-assignments'))->with('message', 'success-approve-assignment');
        } elseif ($request->approve == FALSE) {
            return redirect(route('director-show-assignments'))->with('message', 'success-decline-assignment');
        } else {
            return redirect(route('director-show-assignments'))->with('message', 'unknown-approve-assignment');
        }
    }

    public function generate($id)
    {
        $assignment = Assignment::findOrFail($id);

        $base_url = env('URL_LOCAL', '130.30.1.14:7085');
        $route_url = '/validate/spp/';
        // GENERATE AND SAVE GENERATED QR CODE TO LOCAL DIRECTORY (.svg FORMAT)
        $qrcode = QrCode::size(200)->generate($base_url . $route_url  . $assignment->unique_id, '../public/qrcodes/spp_validation_' . $assignment->id . '.svg');
    }
}
