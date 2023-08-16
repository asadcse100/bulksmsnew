

<!-- ==========About us start========== -->
<section class="grow pt-100" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-5 col-lg-6">
                <div class="grow-left">
                    <div class="section-title text-start">
                        <span class="title-anim">{{getArrayValue(@$about_content->section_value, 'title')}}</span>
                        <h3 class="title-anim">{{getArrayValue(@$about_content->section_value, 'heading')}}</h3>
                    </div>

                    <div>
                        <p class="title-anim">{{getArrayValue(@$about_content->section_value, 'sub_heading')}}</p>
                        <div class="row py-md-4">
                            <div class="col-xl-9 col-lg-12 col-md-9">
                                @foreach($about_element as $element)
                                    <div class="grow-card fade-bottom">
                                        <span class="icon-avaters">
                                            <i class="fa-solid fa-check"></i>
                                        </span>

                                        <div class="grow-card-content">
                                            <h5>{{getArrayValue(@$element->section_value, 'title')}}</h5>
                                            <p>{{getArrayValue(@$element->section_value, 'sub_title')}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <a href="{{getArrayValue(@$about_content->section_value, 'btn_url')}}" class="ig-btn btn--lg btn--primary">{{getArrayValue(@$about_content->section_value, 'btn_name')}}</a>
                    </div>
                </div>
            </div>
            <div class=" col-xl-7 col-lg-6 mt-4">
                <div class="grow-right">
                    <div class="grow-img">
                        <img src="{{showImage(filePath()['frontend']['path'].'/'. @getArrayValue(@$about_content->section_value, 'about_image'),'2230x1250')}}" alt="{{@getArrayValue(@$about_content->section_value,'about_image')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
