<section class="pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="text-center section-title">
                    <h3 class="title-anim">{{getArrayValue(@$cta_content->section_value, 'heading')}}</h3>
                    <p class="title-anim">{{getArrayValue(@$cta_content->section_value, 'sub_heading')}}</p>
                </div>
            </div>
        </div>
        <div class="position-relative d-flex flex-nowrap flex-column-reverse">
            <div class="row g-4">

                @foreach($cta_element as $element)
                    <div class="col-xl-3
                     {{$loop->even ? "offset-xl-6 offset-lg-4" :"" }}
                     col-lg-4 col-md-6">
                        <div class="choose-card fade-bottom">
                            <div class="icon">
                                <img src="{{showImage(filePath()['frontend']['path'].'/'. @getArrayValue(@$element->section_value, 'card_image'),'95x95')}}" alt="">
                            </div>
                            <h4> {{getArrayValue(@$element->section_value, 'title')}}</h4>
                            <p>
                                {{getArrayValue(@$element->section_value, 'description')}}
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="choose-middel-test mb-3 mb-md-5 mb-lg-0">
                <div class="model-img">
                    <img src="{{showImage(filePath()['frontend']['path'].'/'. @getArrayValue(@$cta_content->section_value, 'cta_image'),'3900x2825')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
