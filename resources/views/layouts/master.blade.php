<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('css/wp.css')}}" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <header class="mainHeader">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary" id="mainNav">
            <div class="container-fluid">
                <a href="{{ url("/") }}" id="logo"><img id="headerLogo" src="{{asset('images/8427070.png')}}" alt="Internship App Logo">INTERNSHIP NETWORK</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="{{ url("/") }}">PROJECTS</a>
                        </li>        
                        <li class="nav-item">
                            <a href="{{ url("add_project") }}">ADVERTISE</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url("student_list") }}">STUDENTS</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url("partners_list") }}">TOP 3</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url("documentation") }}">DOCS</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit" id="searchButton">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <div class="formSection">
        @yield('content')
    </div>
    <footer>
        <div class="footerSection">
            <hr>
            <a href="{{ url("/") }}" id="footerLogo"><img id="headerLogo" src="{{asset('images/8427070.png')}}" alt="Internship App Logo">INTERNSHIP NETWORK</a>
            <p>This website is brought to you by WIL Inc.</p>
        </div>
    </footer>
    <!-- Bootstrap Bundle with Popper (JavaScript Plugin) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>