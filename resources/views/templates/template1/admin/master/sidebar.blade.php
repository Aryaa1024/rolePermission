<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="index.html" class="header-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                @can('admin.index')
                    <li class="slide">
                        <a href="{{ route('admin.index') }}" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em"
                                viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" color="currentColor">
                                    <path
                                        d="M3 10.987v4.506c0 2.833 0 4.249.879 5.129c.878.88 2.293.88 5.121.88h6c2.828 0 4.243 0 5.121-.88S21 18.326 21 15.493v-4.506M7 17.974h4" />
                                    <path
                                        d="M17.796 2.5L6.15 2.53c-1.738-.09-2.184 1.249-2.184 1.903c0 .585-.075 1.438-1.14 3.042c-1.066 1.603-.986 2.08-.385 3.19c.498.92 1.766 1.28 2.428 1.341c2.1.048 3.122-1.766 3.122-3.041c1.042 3.203 4.005 3.203 5.325 2.837c1.322-.367 2.456-1.68 2.723-2.837c.156 1.437.63 2.276 2.027 2.852c1.449.597 2.694-.315 3.319-.9s1.026-1.883-.088-3.31c-.768-.984-1.089-1.912-1.194-2.872c-.06-.557-.114-1.155-.506-1.536c-.572-.556-1.394-.725-1.801-.699" />
                                </g>
                            </svg>
                            <span class="side-menu__label">Dashboard</span>
                        </a>
                    </li>
                @endcan
                @can('admin.rolepermissions.index')
                    <li class="slide">
                        <a href="{{ route('admin.rolepermissions.index') }}" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em"
                                viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" color="currentColor">
                                    <path
                                        d="M3 10.987v4.506c0 2.833 0 4.249.879 5.129c.878.88 2.293.88 5.121.88h6c2.828 0 4.243 0 5.121-.88S21 18.326 21 15.493v-4.506M7 17.974h4" />
                                    <path
                                        d="M17.796 2.5L6.15 2.53c-1.738-.09-2.184 1.249-2.184 1.903c0 .585-.075 1.438-1.14 3.042c-1.066 1.603-.986 2.08-.385 3.19c.498.92 1.766 1.28 2.428 1.341c2.1.048 3.122-1.766 3.122-3.041c1.042 3.203 4.005 3.203 5.325 2.837c1.322-.367 2.456-1.68 2.723-2.837c.156 1.437.63 2.276 2.027 2.852c1.449.597 2.694-.315 3.319-.9s1.026-1.883-.088-3.31c-.768-.984-1.089-1.912-1.194-2.872c-.06-.557-.114-1.155-.506-1.536c-.572-.556-1.394-.725-1.801-.699" />
                                </g>
                            </svg>
                            <span class="side-menu__label">Roles & Permissions</span>
                        </a>
                    </li>
                @endcan
                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em" height="1em"
                            viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5" color="currentColor">
                                <path d="m9 22l-.251-3.509a3.259 3.259 0 1 1 6.501 0L15 22" />
                                <path
                                    d="M2.352 13.214c-.354-2.298-.53-3.446-.096-4.465s1.398-1.715 3.325-3.108L7.021 4.6C9.418 2.867 10.617 2 12.001 2c1.382 0 2.58.867 4.978 2.6l1.44 1.041c1.927 1.393 2.89 2.09 3.325 3.108c.434 1.019.258 2.167-.095 4.464l-.301 1.96c-.5 3.256-.751 4.884-1.919 5.856S16.554 22 13.14 22h-2.28c-3.415 0-5.122 0-6.29-.971c-1.168-.972-1.418-2.6-1.918-5.857z" />
                            </g>
                        </svg>
                        <span class="side-menu__label">Academics</span>
                        <i class="ri-arrow-down-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Academic Sessions</a>
                        </li>
                        {{-- <li class="slide">
                            <a href="index.html" class="side-menu__item">Classes</a>
                        </li>
                        <li class="slide">
                            <a href="index.html" class="side-menu__item">Sections</a>
                        </li>
                        <li class="slide">
                            <a href="index.html" class="side-menu__item">Subjects</a>
                        </li>
                        <li class="slide">
                            <a href="index.html" class="side-menu__item">Subjects</a>
                        </li>
                        <li class="slide">
                            <a href="index.html" class="side-menu__item">Assign Subjects</a>
                        </li>
                        <li class="slide">
                            <a href="index.html" class="side-menu__item">Assign Class Teachers</a>
                        </li>
                        <li class="slide">
                            <a href="index.html" class="side-menu__item">Manage Periods</a>
                        </li>
                        <li class="slide">
                            <a href="index.html" class="side-menu__item">Class Timetable</a>
                        </li>
                        <li class="slide">
                            <a href="index.html" class="side-menu__item">Promote Students</a>
                        </li> --}}
                    </ul>
                </li>
                <!-- End::slide -->

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->
