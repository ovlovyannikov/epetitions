<nav class="navbar navbar-default" role="navigation">
        <div class="container">
                <div class="navbar-header">
                        <a href="{{ route('home') }}" class="navbar-brand">Е-петиції</a>
                </div>

                <div class="collapse navbar-collapse">

                        <form action="{{ route('search.results') }}" role="search" class="navbar-form navbar-left">
                                <div class="form-group">
                                        <input type="text" name="query" class="form-control"
                                        placeholder="Знайти петицію"/>
                                </div>
                                <button type="submit" class="btn btn-default">Пошук</button>
                        </form>

                        <ul class="nav navbar-nav navbar-right">
                                <li><a href="{{ route('petition.petrules') }}">Правила</a></li>
                                @if(Auth::check())
                                <!--{{ route('profile.index', ['username' => Auth::user()->username] ) }}-->
                                <li><a href="{{ route('profile.edit') }}">{{ Auth::user()->getNameOrUsername() }}</a></li>
                                <li><a href="{{ route('petition.add') }}">Створити петицію</a></li>
                                <!--<li><a href="{{ route('profile.edit') }}">Оновити профіль</a></li>-->
                                <li><a href="{{ route('auth.signout') }}">Вийти</a></li>
                                @else
                                <li><a href="{{ route('auth.signup') }}">Зареєструватися</a></li>
                                <li><a href="{{ route('auth.signin') }}">Вхід</a></li>
                                @endif
                        </ul>
                </div>
        </div>
</nav>
