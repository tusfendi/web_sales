<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Sales\StoreRequest;
use App\Http\Requests\Sales\ReportRequest;
use Illuminate\Support\Facades\Redirect;
use App\Models\Sales;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('sales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {

        $request->validated();
    
        $sales = new Sales;
        $sales->type = $request->type;
        $sales->transaction_date = $request->transaction_date;
        $sales->nominal = $request->nominal;
        $sales->user_id = $request->user()->id;
        $sales->save();
        if ($sales) {
            return Redirect::route('sales.create')->with('status', 'data-created');
        }

        return abort(500);
    }


        /**
     * Store a newly created resource in storage.
     */
    public function report(ReportRequest $request)
    {
        $request->validated();
        $user = $request->user();
        $requestor = $user->name . ' (' . $user->email . ')';
        $file = "sales-report-" . date('Y-m-d_H:i:s') . ".xlsx";
    
        return Excel::download(new SalesExport($requestor, $request->start_date, $request->end_date), $file);
    }

    
}
