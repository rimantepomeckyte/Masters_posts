<?php

namespace App\Http\Controllers;

use App\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addSpecialization(){
        return view('pages.add-specialization');
    }

    public function addingSpecialization(Request $request){
        $validation = $request->validate([
            'specialization'=> 'required|unique:specializations,specialization_name'
        ]);

        Specialization::create([
            'specialization_name'=>request('specialization')
        ]);

        return redirect('/add-master');

    }
}
