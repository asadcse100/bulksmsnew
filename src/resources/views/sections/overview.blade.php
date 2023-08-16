<section class="get-start pt-100">
    <div class="get-start-bg"></div>
    <div class="container">
        <div class="get-start-container">
            <div class="text-center get-start-content">
                <div class="text-center section-title">
                    <h3 class="title-anim text-white">{{getArrayValue(@$overview_content->section_value, 'heading')}}</h3>
                    <p class="title-anim text-white">{{getArrayValue(@$overview_content->section_value, 'sub_heading')}}</p>
                </div>
                <div class="mt-4 d-flex align-items-center justify-content-center gap-4">
                    <a href="{{getArrayValue(@$overview_content->section_value, 'btn_left_url')}}" class="ig-btn btn--lg btn--white">{{getArrayValue(@$overview_content->section_value, 'btn_left_name')}}</a>
                    <a href="{{getArrayValue(@$overview_content->section_value, 'btn_right_url')}}" class="ig-btn btn--lg btn--white-outline">{{getArrayValue(@$overview_content->section_value, 'btn_right_name')}}</a>
                </div>
            </div>
            <div class="get-start-dash">
                <div>
                    <img src="{{showImage(filePath()['frontend']['path'].'/'. getArrayValue(@$overview_content->section_value, 'overview_image'),'952x450')}}" alt="">
                </div>
                <div class="get-start-dash-sm">
                    <img src="{{showImage(filePath()['frontend']['path'].'/'. getArrayValue(@$overview_content->section_value, 'overview_min_image'),'300x192')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
