@extends('main')

@section('content')

    <div class="container my-5">

        @foreach($masters as $master)
            <div class="bg-white col-md-7 mx-auto border col-11 mb-2">
                <div class="row p-3">
                    <div class="col-lg-3 col-md-4 col-5">
                        @if($master->img)
                            <img src="/{{$master->img}}" class="home-img" alt="profile image"/>
                        @else
                            <img
                                src="https://www.searchpng.com/wp-content/uploads/2019/02/Men-Profile-Image-715x657.png"
                                class="home-img" alt="profile image"/>
                        @endif
                    </div>
                    <div class="col-md-4 col-6">
                        <div
                            class="row font-weight-bolder">{{ucfirst($master->first_name)}} {{ucfirst($master->last_name)}}</div>
                        <div class="row font-weight-bolder">{{ucfirst($master->specialization_name)}}</div>
                        <div class="row font-weight-bolder">{{ucfirst($master->company_name)}}</div>
                        <div class="row font-weight-bolder">{{ucfirst($master->city)}}</div>
                    </div>
                    <div class="col-lg col-12">
                        <div class="row d-flex justify-content-end mt-3">Reitingas:
                            <div class="align-self-center ml-2">
                                @for ($i = 0; $i < 5; $i++)
                                    @if (floor($master->ratings_average) - $i >= 1)
                                        {{--Full Start--}}
                                        <i class="fas fa-star text-warning"> </i>
                                    @elseif ($master->ratings_average - $i > 0)
                                        {{--Half Start--}}
                                        <i class="fas fa-star-half-alt text-warning"> </i>
                                    @else
                                        {{--Empty Start--}}
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
