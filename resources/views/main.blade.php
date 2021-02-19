<!DOCTYPE html>
<html lang="en">

@include('_partials/head')

<body>

<!-- Navigation -->
@include('_partials/nav')
@include('_partials/header')
<!-- Main Content -->
<div class="container">
    @yield('content')
</div>

<hr>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts for this template
<script src="{{URL::asset('js/app.js')}}"></script>-->
<script src="js/app.js"></script>
<script src="https://kit.fontawesome.com/8305e96607.js" crossorigin="anonymous"></script>


</body>

</html>

