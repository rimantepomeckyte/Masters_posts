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
    public function index(Request $request)
    {

        $masters = Master::with(['specialization', 'company', 'user', 'reviews'])
            ->groupBy('masters.id');

        if ($request->filled('company_name')){
            $masters->where('company_id', $request->company_name);
        }
        if ($request->filled('specialization_name')){
            $masters->where('specialization_id', $request->specialization_name);
        }
        if ($request->filled('city')){
            $masters->where('city', $request->city);
        }
        if ($request->filled('gender')){
            $masters->where('gender', $request->gender);
        }
        if ($request->filled('search')) {
            $masters->where('first_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('last_name','LIKE', '%' . $request->search . '%');
        }
      /*  if ($request->filled('rating')) {
            $masters->having("ROUND(AVG('rating'))", $request->rating);//negerai cia dar
            // dd($masters);
        }*/
        if ($request->filled('raiting')) {
    $masters->whereHas('reviews', function ($query){
        return $query->where('rating', request('raiting'));
    });
}

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
