<div class="sidebar-menu">
    <div class="sidebar-menu-inner">
        <div class="logo-env">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}"
                            alt="logo"></a>
                </a>
            </div>
            <div class="sidebar-collapse">
                <a href="#" class="sidebar-collapse-icon">
                    <i class="las la-bars"></i>
                </a>
            </div>
            <div class="sidebar-mobile-menu">
                <a href="#" class="with-animation">
                    <i class="las la-bars"></i>
                </a>
            </div>
        </div>
        <ul id="sidebar-main-menu" class="sidebar-main-menu">
            <li class="sidebar-single-menu nav-item {{ menuActive('employer.dashboard') }}">
                <a href="{{ route('employer.dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span class="title">@lang('Dashboard')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{ menuActive('employer.jobs.index') }}">
                <a href="{{ route('employer.jobs.index') }}">
                    <i class="las la-briefcase"></i>
                    <span class="title">@lang('Job Post')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{ menuActive('employer.logout') }}">
                <a href="{{ route('employer.logout') }}">
                    <i class="las la-sign-out-alt"></i>
                    <span class="title">@lang('Logout')</span>
                </a>
            </li>
        </ul>
    </div>
</div>
