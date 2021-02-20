@extends('main')

@section('content')

    <div class="container my-4">
        <form method="get" action="/search" class="row rounded pb-2 pt-4 px-2 d-flex justify-content-between mb-3"
              style="background-color: #00aa90" enctype="multipart/form-data">
            <div class="form-group col-lg-2 col-md-4">
                <input type="text" name="search" id="search" class="form-control" placeholder="Paieška..."/>
            </div>
            <div class="form-group col-lg-2 col-md-3">
                <select class="form-control" name="specialization_name">
                    <option value="" disabled selected>Specializacija</option>
                    @foreach($uniqueSpecializations as $specialization)
                        <option
                            value="{{$specialization->specialization_name}}">{{ucfirst($specialization->specialization_name)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-2 col-md-3">
                <select class="form-control" name="company_name">
                    <option value="" disabled selected>Įmonė</option>
                    @foreach($uniqueCompanies as $company)
                        <option value="{{$company->company_name}}">{{ucfirst($company->company_name)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-2 col-md-4">
                <select class="form-control" name="city">
                    <option value="" disabled selected>Miestas</option>
                    @foreach($uniqueCities as $city)
                        <option value="{{$city->city}}">{{ucfirst($city->city)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg col-md-3">
                <select class="form-control" name="gender">
                    <option value="" disabled selected>Lytis</option>
                    @foreach($uniqueGender as $gender)
                        <option value="{{$gender->gender}}">{{ucfirst($gender->gender)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-2 col-md-3">
                <select class="form-control" name="rating">
                    <option value="" class="" disabled selected>Reitingas</option>
                    <option value="5" class="text-warning">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
                    <option value="4" class="text-warning">&#9733;&#9733;&#9733;&#9733;</option>
                    <option value="3" class="text-warning">&#9733;&#9733;&#9733;</option>
                    <option value="2" class="text-warning">&#9733;&#9733;</option>
                    <option value="1" class="text-warning">&#9733;</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-info rounded font-weight-bold text-white">Ieškoti</button>
            </div>
        </form>


        @if(session()->has('message'))
            <div class="alert {{session('alert') ?? 'alert-info'}}">
                {{ session('message') }}
            </div>
        @endif

        @foreach($masters as $master)
            <div class="bg-white col-md-7 mx-auto border col-11 mb-2">
                <div class="row p-3">
                    <div class="col-lg-3 col-md-4 col-5">
                        @if($master->img)
                            <img src="{{$master->img}}" class="home-img" alt="profile image"/>
                        @elseif($master->gender == 'vyras')
                            <img src="https://www.searchpng.com/wp-content/uploads/2019/02/Men-Profile-Image-715x657.png"
                                 alt="profile image"
                                 class="home-img" />
                        @else
                            <img src="https://www.pngkey.com/png/full/176-1765817_business-woman-member-icon-female.png"
                                 alt="profile image"
                                 class="home-img" />
                        @endif
                    </div>
                    <div class="col-md-4 col-6 ml-md-3">
                        <div class="row font-weight-bolder"><a
                                href="/master/{{$master->id}}">{{ucfirst($master->first_name)}} {{ucfirst($master->last_name)}}</a>
                        </div>
                        <div class="row font-weight-bolder">{{ucfirst($master->specialization_name)}}</div>
                        <div class="row font-weight-bolder">{{ucfirst($master->company_name)}}</div>
                        <div class="row font-weight-bolder">{{ucfirst($master->city)}}</div>
                    </div>
                    <div class="col-lg col-12">
                        <div class="row d-flex justify-content-end mt-3">Reitingas:
                            <div class="align-self-center ml-2">
                                @for ($i = 0; $i < 5; $i++)
                                    @if (floor($master->ratings_average) - $i >= 1)
                                        <i class="fas fa-star text-warning"> </i>
                                    @elseif ($master->ratings_average - $i > 0)
                                        <i class="fas fa-star-half-alt text-warning"> </i>
                                    @else
                                        <i class="far fa-star text-warning"> </i>
                                    @endif
                                @endfor
                                <span>({{$master->no_of_reviews}})</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pl-3 mb-2">
                    <p class="col text-secondary ">
                        Sukūrė: <a href="/user/{{$master->user_id}}" class="font-italic">{{$master->name}} </a>
                        {{Carbon\Carbon::parse($master->created_at)->diffForHumans()}}</p>
                    <div class="col-2 d-flex justify-content-end ">
                        <a href="/master/{{$master->id}}" class="btn btn-secondary btn-more">Daugiau</a>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center mt-3">
            {{$masters->links()}}
        </div>
    </div>
@endsection
