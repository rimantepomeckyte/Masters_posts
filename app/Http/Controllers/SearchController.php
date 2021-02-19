<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\Master;
use App\Specialization;

class SearchController extends Controller
{
    public function index(Request $request){

        $masters = DB::table('masters')
            ->join('companies', 'masters.company_id', '=', 'companies.id')
            ->join('specializations', 'masters.specialization_id', '=', 'specializations.id')
            ->join('users', 'masters.user_id', '=', 'users.id')
            ->leftJoin('reviews as reviews', 'masters.id', '=', 'reviews.master_id')
            ->select('masters.*', 'companies.company_name', 'specializations.specialization_name', 'users.name',
                DB::raw('ROUND(AVG(reviews.rating)) as ratings_average'), DB::raw('COUNT(reviews.rating) AS no_of_reviews'));
        $uniqueCompanies  = Company::all();
        $uniqueSpecializations  = Specialization::all();
        $uniqueCities = DB::table('masters')->select('masters.city')->distinct()->get();
        $uniqueGender = DB::table('masters')->select('masters.gender')->distinct()->get();

        if ($request->filled('company_name')){
            $masters->where('company_name', $request->company_name);
        }
        if ($request->filled('specialization_name')){
            $masters->where('specialization_name', $request->specialization_name);
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
        if ($request->filled('rating')) {
            $masters->having('ratings_average', $request->rating);//negerai cia dar
           // dd($masters);
        }
//dd($masters);
        return view('pages.searched-results', ['masters' => $masters->paginate(2)], compact( 'uniqueSpecializations', 'uniqueCompanies',
            'uniqueCities', 'uniqueGender'));
    }
}
