<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function addCompany()
    {
        return view('pages.add-company');
    }

    public function addingCompany(Request $request)
    {
        $validation = $request->validate([
            'company' => 'required|unique:companies,company_name'
        ]);

        Company::create([
            'company_name' => request('company')
        ]);

        return redirect('/add-master');
    }
}
