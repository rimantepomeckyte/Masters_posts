@extends('main')

@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="alert {{session('alert') ?? 'alert-info'}}">
                {{ session('message') }}
            </div>
        @endif
        @include('_partials/errors')
        <a href="{{URL::previous()}}" class="btn btn-info font-weight-bold text-white">Atgal</a>
            @if(Auth::check())
                <div class="row d-flex justify-content-end">
                    <a href="/edit/master/{{$master->id}}" class="mr-3 btn btn-info">Redaguoti</a>
                    <a onclick="return confirm('Ar tikrai norite ištrinti šį skelbimą?')"
                       href="/delete/master/{{$master->id}}" class="btn btn-danger">Ištrinti</a>
                </div>
            @endif
            <div class="row mx-auto mt-4">
                <div class="col-lg-3 col-md-5">
                    @if($master->img)
                        <img src="/{{$master->img}}" alt="profile image" style="width: 250px"/>
                    @elseif($master->gender == 'vyras')
                        <img src="https://www.searchpng.com/wp-content/uploads/2019/02/Men-Profile-Image-715x657.png"
                             alt="profile image"
                             style="width: 250px"/>
                    @else
                        <img src="https://www.pngkey.com/png/full/176-1765817_business-woman-member-icon-female.png"
                             alt="profile image"
                             style="width: 250px"/>
                    @endif
                </div>
                <div class="ml-2 col align-self-center">
                    <div class="row"><h3>{{ucfirst($master->first_name)}} {{ucfirst($master->last_name)}}</h3></div>
                    <div class="row"><h5>{{ucfirst($master->specialization->specialization_name)}}</h5></div>
                    <div class="row"><h5>{{ucfirst($master->company->company_name)}}</h5></div>
                    <div class="row"><h5>{{ucfirst($master->city)}}</h5></div>
                </div>
            </div>

            <div class="row mt-1 mb-2 ml-3"><p>
                    <strong> Reitingas:</strong>
                    @if(!empty($master->reviews))
                        @for ($i = 0; $i < 5; $i++)
                            @if (floor($master->reviews->avg('rating')) - $i >= 1)
                                <i class="fas fa-star text-warning"> </i>
                            @elseif ($master->reviews->avg('rating') - $i > 0)
                                <i class="fas fa-star-half-alt text-warning"> </i>
                            @else
                                <i class="far fa-star text-warning"> </i>
                            @endif
                        @endfor
                        <span>({{$master->reviews->count('rating')}})</span></p>
                @else
                    @for ($i = 0; $i < 5; $i++)
                        <i class="far fa-star text-warning"> </i>
                    @endfor
                @endif
            </div>
            <div class="row mx-3">
                <p>{{$master->description}}</p>
            </div>
            <div class="row mx-3 mb-2">
                <h5 class="text-secondary">Sukūrė <span class="font-italic text-white">{{$master->user->name}} </span>
                    {{Carbon\Carbon::parse($master->created_at)->diffForHumans()}}</h5>
            </div>
            <div class="border p-4">
                <div class="font-weight-bold mb-0 pb-0 text-white">Įvertink ir palik atsiliepimą:</div>
                <form method="post" id="" action="/review">
                    {{csrf_field()}}
                    <div class="stars">
                        <input type="radio" id="r1" name="rating" value="5">
                        <label for="r1">&#9733;</label>
                        <input type="radio" id="r2" name="rating" value="4">
                        <label for="r2">&#9733;</label>
                        <input type="radio" id="r3" name="rating" value="3">
                        <label for="r3">&#9733;</label>
                        <input type="radio" id="r4" name="rating" value="2">
                        <label for="r4">&#9733;</label>
                        <input type="radio" id="r5" name="rating" value="1">
                        <label for="r5">&#9733;</label>
                    </div>
                    <div class="form-group">
                        <label>Komentaras:</label>
                        <textarea type="text" name="comment" rows="3" class="form-control"></textarea>
                    </div>
                    <input type="text" name="master_id" value="{{$master->id}}" hidden>
                    <input type="submit" value="Pateikti" id="submit"
                           class="btn btn-sm btn-outline-danger py-0" style="font-size: 1.2em;">
                </form>
            </div>
        <div class="mt-3">
            <h4 class="font-weight-bolder">Atsiliepimai:</h4>
            <hr class="mt-0"/>
            <div class="bg-white p-2">
                @foreach($master->reviews as $review)
                    @if($review->comment)
                        <div>
                            <p class="text-secondary font-italic">{{Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</p>
                            <p>{{$review->comment}}</p></div>
                        <hr/>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
