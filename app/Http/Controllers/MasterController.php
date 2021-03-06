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
    {
        $this->middleware('auth', ['except' => ['index', 'showFull']]);//pasako kad visi metodai kurie yra cia pasiekiami tik prisijungusiam vartotojui isskyrus:...
    }

    public function index()
    {
        $masters =Master::with(['specialization', 'company', 'reviews', 'user'])->paginate(8);

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

    public function store(Request $request)
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
        return view('pages.master', compact('master'));
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
        $masters =Master::with(['specialization', 'company', 'reviews', 'user'])
            ->where('user_id', $user->id)
            ->paginate(8);

        return view('pages.byuser', compact('masters'));
    }
}
