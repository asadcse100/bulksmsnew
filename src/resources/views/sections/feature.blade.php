<section id="features" class="pt-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-6 mx-auto">
                <div class="text-center section-title">
                    <h3 class="title-anim">{{getArrayValue(@$feature_content->section_value, 'heading')}}</h3>
                    <p class="title-anim">{{getArrayValue(@$feature_content->section_value, 'sub_heading')}}</p>
                </div>
            </div>
        </div>

        <div class="">
            <div class="feature-items row g-4">

                @foreach($feature_element as $element)
                    <div class="col-lg-4 col-md-6">
                        <div class="p-3 p-md-4 rounded-2 feature-item">
                            <div class="feature-head d-flex align-items-center justify-content-between">
                                <span class="feature-icon">
                                    {!!getArrayValue(@$element->section_value, 'feature_icon')!!}
                                 </span>
                                <a href="javascript:void(0)" type="button" data-bs-toggle="modal" data-bs-target="#section-{{$loop->index}}" class="ig-btn btn--primary-outline btn--sm btn--capsule">{{getArrayValue($element->section_value, 'btn_name')}}</a>
                            </div>
                            <div class="feature-text">
                                <h4>{{getArrayValue(@$element->section_value, 'title')}}</h4>
                                <p>{{getArrayValue(@$element->section_value, 'description')}}</p>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="section-{{$loop->index}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog nafiz modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="staticBackdropLabel">
                                {{translate("Detials")}}
                              </h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{getArrayValue(@$element->section_value, 'description')}}
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                {{translate('Close')}}
                              </button>

                            </div>
                          </div>
                        </div>
                      </div>
                @endforeach

            </div>
        </div>
    </div>
</section>


  <!-- Modal -->

