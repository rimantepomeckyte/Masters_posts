@extends('main')

@section('content')
    <div class="mt-5 pt-5">
        @include('_partials/errors')
        <form method="post" action="/addingCompany" class="row d-flex justify-content-center">
            {{csrf_field()}}
            <label for="company" class="col-lg-2 col-md-3 align-self-center">Įmonės pavadinimas:</label>
            <input type="text" name="company" class="form-control col-lg-5 col-md-8 align-self-center" id="company"
                   placeholder="Įveskite pilna įmonės pavadinimą...">
            <button type="submit" class="btn btn-success btn-sm rounded col-lg-3 col-md-4 ml-2 p-0">Pridėti</button>
        </form>
    </div>
@endsection
