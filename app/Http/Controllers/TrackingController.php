<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Mpdf\Mpdf;





class TrackingController extends Controller
{
    public function generate()
{
    // Generate a unique tracking code
    $code = strtoupper(Str::random(10));

    // Save to database
    Tracking::create([
        'code' => $code,
    ]);

    // Redirect to tracking page with code
    return redirect()->route('tracking.show', ['code' => $code]);



}
public function show($code): View
{
    $tracking = Tracking::where('code', $code)->firstOrFail();

    // Generate the full tracking URL
    $trackingUrl = route('tracking.show', ['code' => $tracking->code]);

    return view('tracking.show', compact('tracking', 'trackingUrl'));
}

public function updateStatus1($id)
{
    $tracking = Tracking::findOrFail($id);
    $tracking->status1 = 'dalam pengiriman'; // You can customize this value
    $tracking->time2 = now();
    $tracking->courier = Auth::user()->name; // assuming you want to store the courier's name
    $tracking->save();

    return redirect()->back()->with('success', 'Tracking status updated.');
}

public function updateStatus2($id)
{
    $tracking = Tracking::findOrFail($id);
    $tracking->status1 = 'gudang tujuan'; // You can customize this value
    $tracking->time3 = now();
    $tracking->receiver = Auth::user()->name; // assuming you want to store the receiver's name
    $tracking->save();

    return redirect()->back()->with('success', 'Tracking status updated.');
}

public function dashboard(Request $request): View
{
    $user = auth::user();

    // Only apply tracking logic for user1
    if ($user->role === 'sender') {
       // Get all pending tracking records (status1 is NULL)
        $trackings = Tracking::where('status1','gudang asal')->get();

        $hasPendingTracking = $trackings->isNotEmpty();

        return view('dashboard', compact('trackings', 'hasPendingTracking'));
    }

    if ($user->role === 'manager') {
       // Get all pending tracking records (status1 is NULL)
        $trackings = Tracking::all();


        return view('dashboard', compact('trackings'));
    }

    // For other users, just show the dashboard without tracking logic
    return view('dashboard');
}

public function create()
{
    return view('tracking.create'); // or return view('dashboard') if embedded
}

public function store(Request $request)
{
    $request->validate([
        'description_1' => 'required|string',
        'description_2' => 'required|string',
        'description_3' => 'required|string',
    ]);

    $tracking = new Tracking();
    $tracking->code = Str::random(10); // or your logic for generating code
    $tracking->description_1 = $request->description_1;
    $tracking->description_2 = $request->description_2;
    $tracking->description_3 = $request->description_3;
    $tracking->sender = Auth::user()->name; // assuming you want to store the sender's name
    $tracking->status1 = 'gudang asal';
    $tracking->time1 = now();

    $tracking->save();

    return redirect()->route('tracking.show', ['code' => $tracking->code])
    ->with('success', 'Tracking code generated!');

}

public function downloadPDF($code)
{
    $qrSvg = QrCode::format('svg')->size(400)->generate(url("/tracking/$code"));

    // Remove XML declaration
    $qrSvgClean = preg_replace('/<\?xml.*?\?>/', '', $qrSvg);

    // Wrap in HTML
    $html = "
        <html>
            <body>
                <div style='text-align: center;'>
                    $qrSvgClean
                </div>
            </body>
        </html>
    ";

    $pdf = new Mpdf();
    $pdf->WriteHTML($html);
    return response($pdf->Output('', 'S'))->header('Content-Type', 'application/pdf');
}




}
