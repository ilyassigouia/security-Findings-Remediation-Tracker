<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Finding;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index(Request $request)
    {
        // 1. Dashboard Statistics (Count findings based on their severity/status)
        $totalFindings = Finding::count();
        $openFindings = Finding::where('status', 'Open')->count();
        $criticalFindings = Finding::where('severity', 'Critical')->count();
        $fixedFindings = Finding::where('status', 'Fixed')->count();

        // 2. Search and Filtering (Start a database query)
        $query = Finding::query();

        // If the user typed something in the search box
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // If the user selected a specific status from the dropdown
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Pagination (Get the results, but only 5 per page so we can see it working)
        $findings = $query->paginate(5);

        // Send all this new data to your dashboard view
        return view('home', compact(
            'findings',
            'totalFindings',
            'openFindings',
            'criticalFindings',
            'fixedFindings'
        ));
    }
    // 1. Show the form page
    public function create()
    {
        return view('create_finding');
    }

    // 2. Save the new finding to the database
   // Save the new finding to the database
    public function store(Request $request)
    {
        // 1. Add the 'image' rule to your validation
        $request->validate([
            'name' => 'required', // or 'title', depending on your setup
            'severity' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // ADD THIS LINE
        ]);

        // 2. Catch the uploaded file and save it
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('proofs', 'public');
        }
        // 3. Include 'image_path' and 'user_id' when saving to the database
        Finding::create([
            'name' => $request->name,
            'description' => $request->description, // <-- ADD THIS NEW LINE!
            'severity' => $request->severity,
            'status' => $request->status,
            'image_path' => $path,
            'user_id' => auth()->id(), // <-- ADD THIS EXACT LINE HERE

        ]);




        return redirect()->route('home')->with('success', 'Finding reported successfully!');
    }   // Show the details of a specific finding
    public function show($id)
    {
        $finding = Finding::findOrFail($id); // Grab the specific vulnerability

        // Send it to a new view file (we will create this next!)
        return view('show_finding', compact('finding'));
    }
    // Show the Edit Form
    public function edit($id)
    {
        // Grab the specific vulnerability we want to edit
        $finding = Finding::findOrFail($id);

        // Send it to the edit view (which we will create next)
        return view('edit_finding', compact('finding'));
    }

    // Save the Updated Data
    public function update(Request $request, $id)
    {
        // 1. Validate the incoming data (just like we did for creating a new one)
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => 'required|string',
            'status' => 'required|string',
        ]);

        // 2. Find the exact record in the database
        $finding = Finding::findOrFail($id);

        // 3. Update the fields with the new data from the form
        $finding->title = $request->name;
        $finding->description = $request->description;
        $finding->severity = $request->severity;
        $finding->status = $request->status;

        // 4. Save the changes to the database
        $finding->save();

        // 5. Send the user back to the details page to see their updates
        return redirect()->route('findings.show', $id);
    }

    // Delete a finding from the database
    public function destroy($id)
    {
        $finding = Finding::findOrFail($id); // Find the specific vulnerability
        $finding->delete(); // Delete it!

        // Send us back to the dashboard
        return redirect()->route('home');
    }
    public function exportCsv()
    {
        $findings = Finding::all();
        $csvData = "ID,Name,Severity,Status,Date Reported\n";

        foreach ($findings as $finding) {
            $safeTitle = '"' . str_replace('"', '""', $finding->title) . '"';
            $date = $finding->created_at->format('Y-m-d');
            $csvData .= "{$finding->id},{$safeTitle},{$finding->severity},{$finding->status},{$date}\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="vulnerability_report.csv"');
    }

    public function exportPdf()
    {
        $findings = Finding::all();
        $pdf = Pdf::loadView('pdf.report', compact('findings'));
        return $pdf->download('vulnerability_report.pdf');
    }
    public function resolve($id)
    {
        // Find the specific vulnerability
        $finding = \App\Models\Finding::findOrFail($id);

        // Update the status to 'Fixed'
        $finding->status = 'Fixed';
        $finding->save();

        // Send the user back to the dashboard
        return redirect()->back();
    }
}
