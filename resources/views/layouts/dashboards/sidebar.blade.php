<!-- NAV LEFT --
<nav id="sidebar" class="sidebar" role="navigation">
    <div class="js-sidebar-content">
        <header class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ url('/images/logo.svg') }}">
            </a>
        </header>
        <div class="sidebar-status visible-xs">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="thumb-sm avatar pull-right"><img class="img-circle" src="{{ Auth::user()->getAvatar() }}" alt="..."></span>
                <span class="circle bg-warning fw-bold text-gray-dark">
                    13
                </span>
                &nbsp;
                {{ Auth::user()->getFirstName() }} <strong>{{ Auth::user()->getLastName() }}</strong>
                <b class="caret"></b>
            </a>
        </div>
        <ul class="sidebar-nav">
            <li class="active">
                <a href="#sidebar-dashboard" data-toggle="collapse" data-parent="#sidebar">
                      <span class="icon">
                          <i class="fa fa-desktop"></i>
                      </span>
                    Ma bibliothèque
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-dashboard" class="collapse in">
                    <li class="active"><a href="{{ route('dashboard.books') }}">Mes livres<span class="label label-danger">9</span></a></li>
                    <li><a href="#favorites.html">Favoris</a></li>
                    <li><a href="#encore.html">Lecture en cours</a></li>
                    <li><a href="#lire.html">A lire</a></li>
                    <li><a href="#dejalus.html">Déjà  lus</a></li>
                </ul>
            </li>
            <li>
                <a class="collapsed" href="#sidebar-history" data-toggle="collapse" data-parent="#sidebar">
                      <span class="icon">
                          <i class="fa fa-history"></i>
                      </span>
                    Historique
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-history" class="collapse in">
                    <li class="active"><a href="{{ route('dashboard.viewed') }}">Consultés</a></li>
                    <li><a href="{{ route('dashboard.history') }}">Navigation<span class="label label-danger">3</span></a></li>
                </ul>
            </li>
        </ul>
        <h5 class="sidebar-nav-title">Activité récente<a class="action-link" href="#"><i class="glyphicon glyphicon-refresh"></i></a></h5>
        <ul class="sidebar-nav">
            <li>
                <a class="collapsed" href="#sidebar-forms" data-toggle="collapse" data-parent="#sidebar">
                      <span class="icon">
                          <i class="glyphicon glyphicon-align-right"></i>
                      </span>
                    Recherge
                    <i class="toggle fa fa-angle-down"></i>
                </a>
                <ul id="sidebar-forms" class="collapse">
                    <li><a href="#form_elements.html">Aujourd'hui</a></li>
                    <li><a href="#form_validation.html">Cette semaine</a></li>
                    <li><a href="#form_wizard.html">Ce mois-ci</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- AND NAV LEFT -->