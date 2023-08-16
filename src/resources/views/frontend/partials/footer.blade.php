<!-- ========Footer Section Start======== -->
<footer class="footer">
    <div class="container">
        <div class="footer-top row g-4">
            <div class="col-lg-4 ">
                <div class="footer-info pe-lg-5">
                    <div class="footer-log">
                        <img src="{{showImage(filePath()['site_logo']['path'].'/'.$general->site_logo)}}" alt="{{translate('Site Logo')}}"
                            >
                    </div>
                    <p class="mb-2">{{getArrayValue(@$footer_content->section_value, 'text')}}</p>
                    <p>{{getArrayValue(@$footer_content->section_value, 'sub_text')}}</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3">
                <h5 class="footer-menu-title">
                    {{translate('Section Link')}}
                </h5>
                <ul class="mt-2 footer-menus">
                    <li><a href="#home" class="footer-menu">{{translate('Home')}}</a></li>
                    <li><a href="#about" class="footer-menu">{{translate('About')}}</a></li>
                    <li ><a href="#features" class="footer-menu">{{translate('Features')}}</a></li>
                    <li ><a href="#pricing" class="footer-menu">{{translate('Pricing')}}</a></li>
                    <li ><a href="#faq" class="footer-menu">{{translate("Faq's")}}</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3">
                <h5 class="footer-menu-title">
                    {{translate("Resources")}}
                </h5>
                <ul class="mt-2 footer-menus">
                    @foreach($pages as $page)
                        <li>
                            <a href="{{route('page',[Str::slug(getArrayValue(@$page->section_value, 'title')),$page->id])}}" class="footer-menu">{{getArrayValue(@$page->section_value, 'title')}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="go-to-dashboard">
                    <img src="{{showImage(filePath()['frontend']['path'].'/'. getArrayValue(@$footer_content->section_value, 'overview_transparent_image'),'416x242')}}" alt="">
                    <div class="laptop-content">
                        <a href="#" class="go-to-dashboard-link">
                            <i class="fa-solid fa-arrow-up"></i>
                            <span>
                                {{translate("Go Top")}}
                            </span>
                        </a>
                        <div class="lap-img">
                            <img src="{{showImage(filePath()['frontend']['path'].'/'. getArrayValue(@$footer_content->section_value, 'overview_image'),'325x225')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom d-flex align-items-center flex-column-reverse flex-md-row justify-content-between text-center gap-4">
            <div class="copyright">
                <p>&copy;{{getArrayValue(@$footer_content->section_value, 'copyright_text')}}</p>
            </div>

            <div class="d-flex align-items-center justify-content-center gap-4">
                @foreach($socail_icons as $icons)
                    <a href="{{getArrayValue(@$icons->section_value, 'url')}}" class="footer-social">
                        {!!getArrayValue(@$icons->section_value, 'social_icon')!!}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</footer>
