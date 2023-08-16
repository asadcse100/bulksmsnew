<header class="header">
    <div class="container">
        <div class="header-wrap">
            <a href="{{route('home')}}" class="site-logo">
                <img src="{{showImage(filePath()['site_logo']['path'].'/'.$general->site_logo)}}"
                     alt="{{translate('Site Logo')}}">
            </a>

            <div class="main-nav">
                <div class="nav-menu-wrap">
                    <div class="d-flex align-items-center justify-content-between w-100 d-lg-none">
                        <div class="mobile-site-logo">
                            <img src="{{showImage(filePath()['site_logo']['path'].'/'.$general->site_logo)}}"
                                 alt="{{translate('Site Logo')}}">
                        </div>
                        <div class="close-sidebar d-lg-none">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </div>

                    <nav class="nav-menu">
                        <ul>
                            <li class="nav-menu-item"><a href="#home">{{translate('Home')}}</a></li>
                            <li class="nav-menu-item"><a href="#about">{{translate('About')}}</a></li>
                            <li class="nav-menu-item"><a href="#features">{{translate('Features')}}</a></li>
                            <li class="nav-menu-item"><a href="#pricing">{{translate('Pricing')}}</a></li>
                            <li class="nav-menu-item"><a href="#faq">{{translate("Faq's")}}</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="main-nav-overlay d-lg-none"></div>
            </div>

            <div class="d-lg-flex d-none align-items-center gap-3 head-action">
                <a href="{{route('login')}}" class="ig-btn btn--primary btn--md btn--capsule btn-nowrap">{{translate('Sign In')}}</a>
                <a href="{{route('register')}}" class="ig-btn btn--md btn--primary-outline btn--capsule fs-14 btn-nowrap">{{translate('Sign Up!')}}</a>
            </div>

            <div class="d-lg-none">
                <span class="bars"><i class="fa-solid fa-bars"></i></span>
            </div>
        </div>

    </div>
</header>
