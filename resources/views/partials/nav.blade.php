<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="javascript:void(0);">{{ config('app.name') }}</a>
        </div>
        <ul class="nav navbar-nav">
            <li class=""><a href="{!! route('home') !!}">Home</a></li>
            <li class=""><a href="{!! route('transaction.create') !!}">Money Transfer</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="{!! route('user.create') !!}"><span class="glyphicon glyphicon-user"></span> Register</a></li>
            @if( auth()->check() )
                <li>
                    <a href="{!! route('login.doLogout') !!}" onclick="return confirm('Are you sure?')">
                        <span class="glyphicon glyphicon-log-out"></span> Logout
                    </a>
                </li>
            @else
                <li>
                    <a href="{!! route('login.create') !!}">
                        <span class="glyphicon glyphicon-log-in"></span> Login
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>