<?php

namespace App\Http\Controllers\Admin;

use App\Models\Donatur;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DonationController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $donaturs   = Donatur::all();
        return view('admin.donation.index', [
            'donaturs' => $donaturs
        ]);
    }

    /**
     * filter
     *
     * @param  mixed $request
     * @return void
     */
    public function filter(Request $request)
    {
        $this->validate($request, [
            'date_from'  => 'required',
            'date_to'    => 'required',
        ]);

        $date_from  = $request->date_from;
        $date_to    = $request->date_to;
        $donatur    = $request->donatur;
        $donaturs   = Donatur::all();

        if ($request->donatur_id == "none") {
            $donations = Donation::where('status', 'success')->whereDate('created_at', '>=', $request->date_from)->whereDate('created_at', '<=', $request->date_to)->get();
            $total = Donation::where('status', 'success')->whereDate('created_at', '>=', $request->date_from)->whereDate('created_at', '<=', $request->date_to)->sum('amount');

            return view('admin.donation.index', compact('donations', 'total', 'donaturs'));
        } else {


            //get data donation by range date
            $donations = Donation::where('status', 'success')->where('donatur_id', $request->donatur_id)->whereDate('created_at', '>=', $request->date_from)->whereDate('created_at', '<=', $request->date_to)->get();

            //get data by donatur
            //$donaturs = Donatur::where('status', 'success')->whereDate('created_at', '>=', $request->date_from)->whereDate('created_at', '<=', $request->date_to)->get();

            //get total donation by range date    
            $total = Donation::where('status', 'success')->where('donatur_id', $request->donatur_id)->whereDate('created_at', '>=', $request->date_from)->whereDate('created_at', '<=', $request->date_to)->sum('amount');

            return view('admin.donation.index', compact('donations', 'total', 'donaturs'));
        }
    }
}
