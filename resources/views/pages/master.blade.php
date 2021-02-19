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
        @foreach($masters as $master)
            @if(Auth::check())
                <div class="row d-flex justify-content-end">
                    <a href="/edit/master/{{$master->id}}" class="mr-3 btn btn-info">Redaguoti</a>
                    <a href="/delete/master/{{$master->id}}" class="btn btn-danger">Ištrinti</a>
                </div>
            @endif
            <div class="row mx-auto mt-4">
                <div class="col-lg-3 col-md-5">
                    @if($master->img)
                        <img src="/{{$master->img}}"alt="profile image" style="width: 250px"/>
                    @else
                        <img src="https://www.searchpng.com/wp-content/uploads/2019/02/Men-Profile-Image-715x657.png"
                             alt="profile image"
                             style="width: 250px"/>
                    @endif
                </div>
                <div class="ml-2 col align-self-center">
                    <div class="row"><h3>{{ucfirst($master->first_name)}} {{ucfirst($master->last_name)}}</h3></div>
                    <div class="row"><h5>{{ucfirst($master->specialization_name)}}</h5></div>
                    <div class="row"><h5>{{ucfirst($master->company_name)}}</h5></div>
                    <div class="row"><h5>{{ucfirst($master->city)}}</h5></div>
                </div>
            </div>

            <div class="row mt-1 mb-2 ml-3"><p>
                   <strong> Reitingas:</strong>
                    @foreach($rating as $value)
                        @for ($i = 0; $i < 5; $i++)
                            @if (floor($value->ratings_average) - $i >= 1)
                                {{--Full Start--}}
                                <i class="fas fa-star text-warning"> </i>
                            @elseif ($value->ratings_average - $i > 0)
                                {{--Half Start--}}
                                <i class="fas fa-star-half-alt text-warning"> </i>
                            @else
                                {{--Empty Start--}}
                                <i class="far fa-star text-warning"> </i>
                            @endif
                        @endfor
                        <span>({{$value->no_of_reviews}})</span></p>
                @endforeach

            </div>
            <div class="row mx-3">
                <p>{{$master->description}}</p>
            </div>
            <div class="row mx-3 mb-2">
                <h5 class="text-secondary">Sukūrė <span class="font-italic text-white">{{$master->name}} </span>
                    {{Carbon\Carbon::parse($master->created_at)->diffForHumans()}}</h5>
            </div>

            <a href="" class="btn btn-info text-white font-weight-bolder" id="" data-toggle="modal"
               data-target='#review_modal'>Įvertink!</a>

            <div class="modal" id="review_modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="post" id="" action="/review" class="p-3">
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
                                <div class="form-group pt-0 mt-0">
                                    <label>Komentaras:</label>
                                    <textarea type="text" name="comment" rows="3" class="form-control"></textarea>
                                </div>
                                <input type="text" name="master_id" value="{{$master->id}}" hidden>
                                <hr/>
                                <input type="submit" value="Pateikti" id="submit"
                                       class="btn btn-sm btn-outline-danger py-0" style="font-size: 1.2em;">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="mt-3">
            <h4 class="font-weight-bolder">Atsiliepimai:</h4>
            <hr class="mt-0"/>
            <div class="bg-white p-2">
                @foreach($comments as $comment)
                    @if($comment->comment)
                    <div><p class="text-secondary font-italic">{{Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</p>
                        <p>{{$comment->comment}}</p></div>
                    <hr/>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
