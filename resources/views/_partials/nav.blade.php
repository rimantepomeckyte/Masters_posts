<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <div class="container">
        @if(Auth::check())
            <p class="text-dark mt-1">Prisijungęs kaip: <span ><a href="/user/{{Auth::user()->id}}" class="text-white font-weight-bold" style="text-decoration: none">{{Auth::user()->name}}</a></span></p>
        @endif
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="/">Skelbimai</a>
                </li>
                @if(Auth::check())
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold " href="/add-master/">Naujas skelbimas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" href="/user/{{Auth::user()->id}}">Mano skelbimai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" href="/logout">Atsijungti</a>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link font-weight-bold" href="/login">Prisijungti</a></li>
                    <li class="nav-item"><a class="nav-link font-weight-bold" href="/register">Registruotis</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
