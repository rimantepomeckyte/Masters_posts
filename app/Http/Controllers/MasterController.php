<?php

namespace App\Http\Controllers;

use App\Company;
use App\Master;
use App\Review;
use App\Specialization;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use Gate;
use Illuminate\Support\Facades\DB;


class MasterController extends Controller
{
    public function __construct()
    {//
        $this->middleware('auth', ['except' => ['index', 'showFull']]);//pasako kad visi metodai kurie yra cia pasiekiami tik prisijungusiam vartotojui isskyrus:...
    }

    public function index()
    {
            $masters = DB::table('masters')
            ->join('companies', 'masters.company_id', '=', 'companies.id')
            ->join('specializations', 'masters.specialization_id', '=', 'specializations.id')
            ->join('users', 'masters.user_id', '=', 'users.id')
            ->leftJoin('reviews as reviews', 'masters.id', '=', 'reviews.master_id')
            ->select('masters.*', 'companies.company_name', 'specializations.specialization_name',
                'users.name', DB::raw('AVG(reviews.rating) as ratings_average'),
                DB::raw('COUNT(reviews.rating) AS no_of_reviews'))
             ->groupBy('masters.id', 'companies.company_name', 'specializations.specialization_name', 'users.name', 'reviews.master_id')
             ->orderBy('no_of_reviews', 'DESC')
            ->paginate(8);

        $uniqueCompanies  = Company::all();
        $uniqueSpecializations  = Specialization::all();
        $uniqueCities = DB::table('masters')->select('masters.city')->distinct()->get();
        $uniqueGender = DB::table('masters')->select('masters.gender')->distinct()->get();

        return view('pages.home', compact('masters', 'uniqueSpecializations', 'uniqueCompanies',
            'uniqueCities', 'uniqueGender'));
    }

    public function addMaster()
    {
        $companies = Company::all();
        $specializations = Specialization::all();
        return view('pages.add-master', compact('companies', 'specializations'));
    }

    public function store(Master $master, Request $request)
    {

        $validation = $request->validate([
            'company' => 'required',
            'specialization' => 'required',
            'first-name' => 'required',
            'last-name' => 'required',
            'gender' => 'required',
            'city' => 'required',
            'master-description'=>'required|max:500',
            //'img' => 'nullable|sometimes|image|mimes:jpeg, jpg, png, gif|max:10000'
        ]);

        if (request()->hasFile('img')) {
            $path = $request->file('img')->store('public/images');
            $filename = str_replace('public/', "", $path);
            Master::create([
                'first_name' => request('first-name'),
                'last_name' => request('last-name'),
                'gender' => request('gender'),
                'specialization_id' => request('specialization'),
                'company_id' => request('company'),
                'city' => request('city'),
                'description' => request('master-description'),
                'img' => $filename,
                'user_id' => Auth::id()
            ]);
        } else {
            Master::create([
                'first_name' => request('first-name'),
                'last_name' => request('last-name'),
                'gender' => request('gender'),
                'specialization_id' => request('specialization'),
                'company_id' => request('company'),
                'city' => request('city'),
                'description' => request('master-description'),
                'user_id' => Auth::id()
            ]);
        }

        return redirect('/')->with(['message' => "Skelbimas sėkmingai pridėtas!", 'alert' => 'alert-success']);
        //padaryti kad i posta numestu
    }

    public function showFull(Master $master)
    {
        $masters = DB::table('masters')
            ->join('companies', 'masters.company_id', '=', 'companies.id')
            ->join('specializations', 'masters.specialization_id', '=', 'specializations.id')
            ->join('users', 'masters.user_id', '=', 'users.id')
            ->select('masters.*', 'companies.company_name', 'specializations.specialization_name', 'users.name')
            ->where('masters.id', $master->id)
            ->get();

        $comments = DB::table('reviews')
            ->join('masters', 'masters.id', '=', 'reviews.master_id')
            ->select('reviews.rating', 'reviews.comment', 'reviews.created_at')
            ->where('masters.id', $master->id)
            ->get();

        $rating = DB::table('reviews')
            ->join('masters', 'masters.id', '=', 'reviews.master_id')
            ->select([DB::raw('AVG(reviews.rating) as ratings_average'), DB::raw('COUNT(reviews.rating) AS no_of_reviews')])
            ->where('masters.id', $master->id)
            ->orderBy('no_of_reviews', 'DESC')
            ->groupBy('master_id', 'reviews.master_id')
            ->get();

        return view('pages.master', compact('masters', 'comments', 'rating'));
    }


    public function editMaster(Master $master, Request $request)
    {
        if (Gate::allows('update', $master)) {
            $companies = Company::all();
            $specializations = Specialization::all();
            return view('pages.edit-master', compact('companies', 'specializations', 'master'));
        }
        return redirect()->back()->with(['message' => "Negalite redaguoti kito vartotojo skelbimo!", 'alert' => 'alert-danger']);
    }

    public function storeUpdate(Request $request, Master $master)
    {
        if ($request->file()) {
            File::delete(storage_path('app/public/', $master->img));
            $path = $request->file('img')->store('public/images');
            $filename = str_replace('public/', "", $path);
            Master::where('id', $master->id)->update(['img' => $filename]);
        }

        Master::where('id', $master->id)->update($request->only(['first_name', 'last_name', 'gender', 'specialization_id',
            'company_id', 'city', 'description']));

        return redirect('/master/' . $master->id)->with(['message' => 'Skelbimas sėkmingai redaguotas!',
            'alert' => 'alert-success']);
    }

    public function delete(Master $master)
    {
        if (Gate::allows('delete', $master)) {
            $master->delete();
            return redirect('/')->with(['message' => "Skelbimas buvo pašalintas!", 'alert' => 'alert-danger']);
        }
        return redirect()->back()->with(['message' => "Negalite ištrinti kito vartotojo skelbimo!", 'alert' => 'alert-danger']);
    }

    public function showByUser(User $user)
    {
        $masters = DB::table('masters')
            ->join('companies', 'masters.company_id', '=', 'companies.id')
            ->join('specializations', 'masters.specialization_id', '=', 'specializations.id')
            ->join('users', 'masters.user_id', '=', 'users.id')
            ->leftJoin('reviews as reviews', 'masters.id', '=', 'reviews.master_id')
            ->select('masters.*', 'companies.company_name', 'specializations.specialization_name', 'users.name',
                DB::raw('AVG(reviews.rating) as ratings_average'), DB::raw('COUNT(reviews.rating) AS no_of_reviews'))
            ->where('users.id', $user->id)
            ->groupBy('masters.id','companies.company_name', 'specializations.specialization_name', 'users.name', 'reviews.master_id' )
            ->orderBy('no_of_reviews', 'DESC')
            ->paginate(8);

        return view('pages.byuser', compact('masters'));
    }
}
