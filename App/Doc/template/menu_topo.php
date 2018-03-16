<nav class="navbar navbar-toggleable-md fixed-top">
    <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">{{ locale.menu_top.docs }}</a>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">{{ locale.menu_top.home }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">{{ locale.menu_top.download }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">{{ locale.menu_top.docs }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">{{ locale.menu_top.about }}</a>
            </li>
        </ul>
        <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="{{ locale.menu_top.search }}">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{ locale.menu_top.search }}</button>
        </form>
    </div>
</nav>