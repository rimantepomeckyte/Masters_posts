<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
public function addingReview(Request $request){
    $validation = $request->validate([
        'rating'=> 'required'
    ]);

    Review::create([
        'rating'=>request('rating'),
        'comment'=>request('comment'),
        'master_id'=>request('master_id')
    ]);
    //dd($request);
    return redirect()->back()->with(['message' => "Jūsų atsiliepimas įrašytas!", 'alert' => 'alert-warning']);
}
}

