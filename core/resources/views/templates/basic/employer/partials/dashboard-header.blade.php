<div class="body-header-area d-flex flex-wrap align-items-center justify-content-between mb-10-none">
    <div class="body-header-left">
        <h3 class="title">{{ __($pageTitle) }}</h3>
    </div>
    <div class="body-header-right dropdown">
        <button type="button" class="" data-toggle="dropdown" data-display="static" aria-haspopup="true"
            aria-expanded="false">
            <div class="header-user-area d-flex flex-wrap align-items-center justify-content-between">
                <div class="header-user-content me-4">
                    <span>@lang('Balance : '){{ getAmount(auth()->user()->balance) }} {{ gs()->cur_text }}</span>
                </div>

                <div class="header-user-thumb">
                    <a href="#0"><img
                            src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()->image, getFileSize('userProfile'), avatar: true) }}"
                            alt="user"></a>

                </div>

                <div class="header-user-content">
                    <span>{{ auth()->user()->username }}</span>
                </div>
                <span class="header-user-icon"><i class="las la-chevron-circle-down"></i></span>
            </div>
        </button>
        <div class="dropdown-menu dropdown-menu--sm p-0 border-0 dashboard-header dropdown-menu-right">
            <a href="{{ route('employer.change.password') }}"
                class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                <i class="dropdown-menu__icon las la-key"></i>
                <span class="dropdown-menu__caption">@lang('Change Password')</span>
            </a>
            <a href="{{ route('employer.profile.setting') }}"
                class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                <i class="dropdown-menu__icon las la-user-circle"></i>
                <span class="dropdown-menu__caption">@lang('Profile Settings')</span>
            </a>
            <a href="{{ route('employer.logout') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                <i class="dropdown-menu__icon las la-sign-out-alt"></i>
                <span class="dropdown-menu__caption">@lang('Logout')</span>
            </a>
        </div>
    </div>
</div>
