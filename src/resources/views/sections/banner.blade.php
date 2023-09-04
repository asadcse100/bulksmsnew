<div class="banner overflow-hidden" id="home" style="background-image: linear-gradient(rgba(255,255,255,0.8),rgba(255,255,255,0.8)) ,url({{showImage(filePath()['frontend']['path'].'/'. getArrayValue(@$banner_content->section_value, 'background_image'),'3000x2000')}});">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="pb-md-5 pb-4 border-bottom banner-left">
                    <h1>{{getArrayValue(@$banner_content->section_value, 'heading')}}</h1>
                    <p>{{getArrayValue(@$banner_content->section_value, 'sub_heading')}}</p>
                    <div class="d-flex align-items-center gap-4 banner-action">
                        <a href="  {{getArrayValue(@$banner_content->section_value, 'btn_url')}}" class="ig-btn btn--lg btn--primary btn--capsule banner-btn">
                            {{getArrayValue(@$banner_content->section_value, 'btn_name')}}
                        </a>
                        <a href="{{getArrayValue(@$banner_content->section_value, 'video_url_name')}}" data-dimbox="youtube"
                           data-dimbox-ratio="16x9" class="ig-btn btn--lg d-flex align-items-center banner-action-item banner-btn"> <i class="fa-solid fs-20 fa-play pe-2"></i>   {{getArrayValue(@$banner_content->section_value, 'video_btn_name')}}
                        </a>
                    </div>
                </div>

                <div class="pt-md-5 pt-4 sponsor-area">
                    <h6>

                    </h6>
                    <div class="customer-slider">
                        @if(!empty($banner_element))
                        @foreach($banner_element as $element)
                            <span>
                                <img src="{{showImage(filePath()['frontend']['path'].'/'. @getArrayValue(@$element->section_value, 'client_image'),'134x40')}}" alt="">
                            </span>
                        @endforeach
                        @endif
                    </div>

                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 ">
                <div class="banner_img">
                    <img class="img-fluid" src="{{showImage(filePath()['frontend']['path'].'/'. @getArrayValue(@$banner_content->section_value, 'banner_image'),'3500x1740')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>


