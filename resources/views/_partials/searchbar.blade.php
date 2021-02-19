<div class="container" style="background-color: #00aa90">
    <form method="get">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Paieška..."/>
        </div>
        <div class="form-group">
            <select class="form-control" name="search-by-specialization">
                <option value="" disabled selected>Specializacija</option>
                @foreach($specializations as $specialization)
                    <option value="{{$specialization->id}}" >{{ucfirst($specialization->specialization_name)}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="search-by-company">
                <option value="" disabled selected>Įmonė</option>
                @foreach($companies as $company)
                    <option value="{{$company->id}}" >{{ucfirst($company->company_name)}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="search-by-city">
                <option value="" disabled selected>Miestas</option>
                @foreach($masters as $master)
                    <option value="{{$master->city}}" >{{ucfirst($master->city)}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="search-by-gender">
                <option value="" disabled selected>Lytis</option>
                <option value="moteris" >Moteris</option>
                <option value="vyras" >Vyras</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="search-by-rating">
                <option value="" disabled selected>Reitingas</option>
            </select>
        </div>

    </form>

</div>
