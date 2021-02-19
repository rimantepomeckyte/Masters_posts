@extends('main')

@section('content')
    <div class="mt-5 pt-5">
        @include('_partials/errors')
        <form method="post" action="/addingSpecialization" class="row d-flex justify-content-center">
            {{csrf_field()}}
            <label for="specialization" class="col-lg-2 col-md-3 align-self-center" >Specializacija:</label>
            <input type="text" name="specialization" class="form-control col-lg-5 col-md-8 align-self-center" id="specialization" placeholder="Įveskite specializacijos pavadinimą...">
            <button type="submit" class="btn btn-success btn-sm rounded col-lg-3 col-md-4 ml-2 p-0">Pridėti</button>
        </form>
    </div>
@endsection
