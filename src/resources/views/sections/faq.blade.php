<section class="faq pt-100 pb-100" id="faq">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-6 me-auto">
                <div class="section-title text-start">
                    <span class="title-anim">{{translate(getArrayValue(@$faq_content->section_value, 'heading'))}}</span>
                    <h3 class="title-anim">{{translate(getArrayValue(@$faq_content->section_value, 'sub_heading'))}}</h3>
                </div>
            </div>
        </div>

        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <div class="custiom-accordion">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @foreach($faq_element as $key => $element)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne-{{$key}}">
                                    <button class="accordion-button @if(!$loop->first) collapsed @endif" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-{{$key}}"
                                            aria-expanded="false" aria-controls="flush-collapseOne">
                                        {{translate(getArrayValue(@$element->section_value, 'question'))}}
                                    </button>
                                </h2>
                                <div id="flush-collapseOne-{{$key}}" class="accordion-collapse collapse @if($loop->first) show @endif"
                                     aria-labelledby="flush-headingOne-{{$key}}"
                                     data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">{{translate(getArrayValue(@$element->section_value, 'answer'))}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-5 ps-lg-5">
                <div class="faq-left">
                    <div class="faq-left-title">
                        <span class="title-anim"></span>
                        <h3 class="title-anim"></h3>
                    </div>
                    <div>
                        <img src="{{@showImage(filePath()['frontend']['path'].'/'. getArrayValue(@$faq_content->section_value, 'background_image'),'746x418')}}" alt="{{translate('faq image')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
