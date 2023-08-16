<section class="pricing-plans pt-100" id="pricing">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="text-center section-title">
                    <h3 class="title-anim">{{translate(getArrayValue(@$plan_content->section_value, 'heading'))}}</h3>
                    <p class="title-anim">{{translate(getArrayValue(@$plan_content->section_value, 'sub_heading'))}}</p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            @foreach($plans as $key => $plan)
                @if($plan->amount>0)
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-item">
                        <div class="price">
                            <span>{{$general->currency_symbol}}{{shortAmount($plan->amount)}} </span> <small>/{{$plan->duration}} {{ translate('Days')}}</small>
                        </div>

                        <div class="pricing-detail">
                            <h5>{{ucfirst($plan->name)}}</h5>
                        </div>

                        <ul class="pricing-features">
                            <li class="pricing-feature">
                                <span><i class="fa-solid fa-check"></i></span>
                                {{$plan->credit}} {{ translate('SMS Credit') }}
                            </li>
                            <li class="pricing-feature">
                                <span><i class="fa-solid fa-check"></i></span>
                                {{$plan->email_credit}} {{ translate('Email Credit') }}
                            </li>
                            <li class="pricing-feature">
                                <span><i class="fa-solid fa-check"></i></span>
                                {{$plan->whatsapp_credit?? '0'}} {{ translate('WhatsApp Credit') }}
                            </li>
                            <li class="pricing-feature">
                                <span><i class="fa-solid fa-check"></i></span>
                                {{ translate('1 Credit for '.$general->sms_word_text_count.' plain word')}}
                            </li>
                            <li class="pricing-feature">
                                <span><i class="fa-solid fa-check"></i></span>
                                {{ translate('1 Credit for '.$general->sms_word_unicode_count.' unicode word')}}
                            </li>
                            <li class="pricing-feature">
                                <span><i class="fa-solid fa-check"></i></span>
                                {{ translate('1 Credit for '.$general->whatsapp_word_count.' word')}}
                            </li>
                            <li class="pricing-feature">
                                <span><i class="fa-solid fa-check"></i></span>
                                {{ translate('1 Credit for per Email')}}
                            </li>
                        </ul>

                        <a href="{{route('user.plan.create')}}" class="ig-btn btn--primary-outline btn--lg w-100">
                            @if($subscription)
                                @if($plan->id == $subscription->plan_id)
                                    @if(Carbon\Carbon::now()->toDateTimeString() > $subscription->expired_date)
                                        {{ translate("Renew") }}
                                    @else
                                        {{ translate('Current Plan')}}
                                    @endif
                                @else
                                    {{ translate('Upgrade Plan')}}
                                @endif
                            @else
                                {{ translate('Purchase Now')}}
                            @endif
                        </a>
                        @if($plan->recommended_status == 1)
                            <div class="ribbon">
                                <span>{{translate('Recommended')}}</span>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
