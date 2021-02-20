@extends('main')

@section('content')

    <div class="row justify-content-center mt-3 mb-4">
        <h1>Naujas meistro skelbimas</h1>
    </div>
    @include('_partials/errors')
    <form method="post" action="/store" enctype="multipart/form-data" class="mt-2">
        <!--encytype kad moketu atskirti faila-->
        {{csrf_field()}}
        <div class="form-group row d-flex justify-content-center align-items-center ml-5">
            <label for="company" class="col-lg-2 col-md-3 align-self-center font-weight-bold">Įmonės
                pavadinimas:</label>
            <select class="form-control col-lg-4 col-md-5" id="company" name="company">
                <option value="" disabled selected>Pasirinkite įmonę</option>
                @foreach($companies as $company)
                    <option value="{{$company->id}}">{{ucfirst($company->company_name)}}</option>
                @endforeach
            </select>
            <div class="col-lg-3 col-md-4 ml-md-2 mt-2 mt-md-0">
                <p class="my-0 py-0">Neradai savo įmonės?</p>
                <a href="/add-company" class="btn btn-info p-1 my-0 py-0">Pridėti čia naują</a>
            </div>
        </div>
        <div class="form-group row d-flex justify-content-center align-items-center ml-5">
            <label for="specialization"
                   class="col-lg-2 col-md-3 align-self-center font-weight-bold">Specializacija:</label>
            <select class="form-control col-lg-4 col-md-5" id="specialization" name="specialization">
                <option value="" disabled selected>Pasirinkite specializaciją</option>
                @foreach($specializations as $specialization)
                    <option value="{{$specialization->id}}">{{ucfirst($specialization->specialization_name)}}</option>
                @endforeach
            </select>
            <div class="col-lg-3 col-md-4 ml-md-2 mt-2 mt-md-0">
                <p class="my-0 py-0">Neradai savo specializacjos?</p>
                <a href="/add-specialization" class="btn btn-info p-1 my-0 py-0">Pridėti čia naują</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="form-group col-4">
                <label for="first-name" class="font-weight-bold">Vardas:</label>
                <input type="text" name="first-name" class="form-control" id="first-name" placeholder="Vardas"
                       value="{{old('first-name')}}">
            </div>
            <div class="form-group col-4">
                <label for="last-name" class="font-weight-bold">Pavardė:</label>
                <input type="text" name="last-name" class="form-control" id="last-name" placeholder="Pavardė"
                       value="{{old('last-name')}}">
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="form-group col-4">
                <label for="gender" class="align-self-center font-weight-bold">Lytis:</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="" disabled selected>Pasirinkite lytį</option>
                    <option value="moteris" {{ old('gender') == 'moteris' ? 'selected' : '' }}>Moteris</option>
                    <option value="vyras" {{ old('gender') == 'vyras' ? 'selected' : '' }}>Vyras</option>
                </select>
            </div>
            <div class="form-group col-4">
                <label for="city" class="align-self-center font-weight-bold">Miestas:</label>
                <input type="text" name="city" class="form-control" id="city" placeholder="Miesto pavadinimas"
                       value="{{old('city')}}">
            </div>

        </div>
        <div class="form-group row d-flex justify-content-center">
            <div class="col-8">
                <label for="master-description" class="font-weight-bold align-self-center">Jūsų skelbimo žinutė:</label>
                <textarea name="master-description" class="form-control" id="master-description"
                          rows="3">{{ old('master-description') }}</textarea>
            </div>
        </div>
        <div class="form-group row d-flex justify-content-center">
            <div class="col-8">
                <label for="upload" class="font-weight-bold">Pridėti nuotrauką:</label>
                <input type="file" class="form-control" id="upload" name="img">
            </div>
        </div>
        <div class="form-group d-flex justify-content-center mt-2 mb-5">
            <button type="submit" class="btn btn-success rounded p-2 font-weight-bold">Paskelbti</button>
        </div>
    </form>

@endsection
