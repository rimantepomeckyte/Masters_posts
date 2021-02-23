<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\Master;
use App\Specialization;

class SearchController extends Controller
{
    public function index(Request $request, Master $master, Review $review)
    {

        $masters = Master::with(['specialization', 'company', 'user'])
            ->groupBy('masters.id')
            ->where('company_id', $request->company_name)
            ->orWhere('specialization_id', $request->specialization_name)
            ->orWhere('city', $request->city)
            ->orWhere('gender', $request->gender)
            ->orWhere('first_name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('last_name', 'LIKE', '%' . $request->search . '%');

        /*if ($request->filled('rating')) {
          $masters = Master::whereHas('reviews', function ($q) {
              return $q->where('rating', request('rating'));
          })->get();}*/

        // dd($review);
        // dd($masters);
        $uniqueCompanies = Company::all();
        $uniqueSpecializations = Specialization::all();
        $uniqueCities = DB::table('masters')->select('masters.city')->distinct()->get();
        $uniqueGender = DB::table('masters')->select('masters.gender')->distinct()->get();

        return view('pages.searched-results', ['masters' => $masters->paginate(8)], compact('uniqueSpecializations', 'uniqueCompanies',
            'uniqueCities', 'uniqueGender', 'reviews'));
    }
}
