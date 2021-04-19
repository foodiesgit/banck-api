<div class="sidebar" data-color="orange" data-background-color="white"
    data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo">
        <a href="/" class="simple-text logo-normal">
            PeachTel
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="/">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li class="nav-item {{ $activePage == 'payliance' || $activePage == 'plaid' || $activePage == 'bbva-api' || $activePage == 'api-wyre' || $activePage == 'visa-api' ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#apitester"
                    aria-expanded="{{ $activePage == 'payliance' || $activePage == 'plaid' || $activePage == 'bbva-api' || $activePage == 'api-wyre' || $activePage == 'visa-api' ? 'true' : 'false' }}">
                    <i class="material-icons">list</i>
                    <p>API Tester
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $activePage == 'payliance' || $activePage == 'plaid' || $activePage == 'bbva-api' ||  $activePage == 'api-wyre' || $activePage == 'visa-api' ? ' show' : '' }}"
                    id="apitester">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'plaid' ? ' active' : '' }}">
                            <a class="nav-link" href="/api-tester/plaid">
                                <i class="material-icons">api  </i>
                                <span class="sidebar-normal">Plaid</span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'payliance' ? ' active' : '' }}">
                            <a class="nav-link" href="/api-tester/payliance">
                                <i class="material-icons">api  </i>
                                <span class="sidebar-normal">Payliance </span>
                            </a>
                        </li>

                        <li class="nav-item{{ $activePage == 'bbva-api' ? ' active' : '' }}">
                            <a class="nav-link" href="/api-tester/bbva">
                                <i class="material-icons">api</i>
                                <span class="sidebar-normal"> BBVA</span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'api-wyre' ? ' active' : '' }}">
                            <a class="nav-link" href="/api-wyre">
                                <i class="material-icons">api</i>
                                <span class="sidebar-normal">Wyre</span>
                            </a>
                        </li>

                        <li class="nav-item{{ $activePage == 'visa-api' ? ' active' : '' }}">
                            <a class="nav-link" href="/api-tester/visa">
                                <i class="material-icons">api</i>
                                <span class="sidebar-normal">Visa</span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'calculator' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('calculator') }}">
                                <i class="material-icons">calculate</i>
                                <p>{{ __('Calculator') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ $activePage == 'profile' || $activePage == 'user-management' ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#laravelExample"
                    aria-expanded="{{ $activePage == 'profile' || $activePage == 'user-management' ? 'true' : 'false' }}">
                    <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
                    <p>{{ __('Laravel Examples') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse{{ $activePage == 'profile' || $activePage == 'user-management' ? ' show' : '' }}"
                    id="laravelExample">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('profile.edit') }}">
                                <span class="sidebar-mini"> UP </span>
                                <span class="sidebar-normal">{{ __('User profile') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('user.index') }}">
                                <span class="sidebar-mini"> UM </span>
                                <span class="sidebar-normal"> {{ __('User Management') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('table') }}">
                    <i class="material-icons">content_paste</i>
                    <p>{{ __('Table List') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('typography') }}">
                    <i class="material-icons">library_books</i>
                    <p>{{ __('Typography') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('icons') }}">
                    <i class="material-icons">bubble_chart</i>
                    <p>{{ __('Icons') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('map') }}">
                    <i class="material-icons">location_ons</i>
                    <p>{{ __('Maps') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('notifications') }}">
                    <i class="material-icons">notifications</i>
                    <p>{{ __('Notifications') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('language') }}">
                    <i class="material-icons">language</i>
                    <p>{{ __('RTL Support') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
