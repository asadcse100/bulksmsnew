@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="table_heading d-flex align--center justify--between">
                    <nav  aria-label="breadcrumb">
					  	<ol class="breadcrumb">
					    	<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{translate('Dashboard')}}</a></li>
					    	<li class="breadcrumb-item" aria-current="page"> {{translate('General Setting')}}</li>
					    	<li class="breadcrumb-item" aria-current="page">{{translate('Last time cron job run')}}<i class="las la-arrow-right"></i><span class="text--success"> {{getDateTime($general->cron_job_run)}}</span></li>
					  	</ol>
					</nav>
					<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#cronjob" class="btn--dark text--light border-0 px-3 py-1 rounded ms-3"><i class="las la-key"></i> {{translate('Setup Cron Jobs')}}</a>
                </div>
				<div class="card">
					<div class="card-body">
						<form action="{{route('admin.general.setting.store')}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row">

								<!-- Group One -->
								<div class="mb-3 col-lg-3 col-md-3">
									<label for="site_name" class="form-label">{{translate('Site Name')}} <sup class="text--danger">*</sup></label>
									<input type="text" name="site_name" id="site_name" class="form-control" value="{{$general->site_name}}" placeholder="{{translate('Enter Site Name')}}" required>
								</div>

								<div class="mb-3 col-lg-3 col-md-3">
									<label for="copyright" class="form-label">{{translate('Copyright Note')}} <sup class="text--danger">*</sup></label>
									<input type="text" name="copyright" id="copyright" class="form-control" value="{{$general->copyright}}" placeholder="{{translate('Enter Site Name')}}" required max="20">
								</div>

								<div class="mb-3 col-lg-3 col-md-3">
                                	<label for="primary_color">
                                		{{translate('Primary Color')}}
                                		<sup class="text--danger">*</sup>
                                	</label>
                                    <div class="input-group">
									  <div class="input-group-prepend">
									    	<input type='text' class="input-group-text color-picker" value="{{$general->primary_color}}"/>
									  </div>
									  <input type="text" class="form-control color-code" name="primary_color" id="primary_color" value="{{$general->primary_color}}"/>
									</div>
                                </div>

                                <div class="mb-3 col-lg-3 col-md-3">
                                	<label for="secondary_color">
                                		{{translate('Secondary Color')}}
                                		<sup class="text--danger">*</sup>
                                	</label>
                                    <div class="input-group">
									  <div class="input-group-prepend">
									    	<input type='text' class="input-group-text color-picker" value="{{$general->secondary_color}}"/>
									  </div>
									  <input type="text" class="form-control color-code" name="secondary_color" id="secondary_color" value="{{$general->secondary_color}}"/>
									</div>
                                </div>




                                <!-- Group Two -->
                                <div class="mb-3 col-lg-3 col-md-3">
									<label for="timelocation" class="form-label">{{translate('Time Zone')}} <sup class="text--danger">*</sup></label>
									<select class="form-control" id="timelocation" name="timelocation" required="">
										@foreach($timeLocations as $timeLocation)
											<option value="'{{ @$timeLocation}}'" @if(config('app.timezone') == $timeLocation) selected @endif>{{$timeLocation}}</option>
										@endforeach
									</select>
								</div>

								<div class="mb-3 col-lg-3 col-md-3">
									<label for="country_code">{{translate('Country Code')}} <sup class="text--danger">*</sup></label>
									<div class="input-group">
									  	<div class="input-group-prepend">
									    	<span class="input-group-text" id="country--dial--code">
									    	{{$general->country_code}}
									    	</span>
									  	</div>
									  	<select name="country_code" class="form-control" id="country_code">
									    <@foreach($countries as $countryData)
											<option value="{{$countryData->dial_code}}" @if($general->country_code == $countryData->dial_code) selected="" @endif>{{$countryData->country}}</option>
										@endforeach
										</select>
									</div>
								</div>

                                <div class="mb-3 col-lg-3 col-md-3">
									<label for="currency_name" class="form-label">{{translate('Currency')}} <sup class="text--danger">*</sup></label>
									<input type="text" name="currency_name" id="currency_name" class="form-control" value="{{$general->currency_name}}" placeholder="{{translate('Enter Currency Name')}}" required>
								</div>

								<div class="mb-3 col-lg-3 col-md-3">
									<label for="currency_symbol" class="form-label">{{translate('Currency Symbol')}} <sup class="text--danger">*</sup></label>
									<input type="text" name="currency_symbol" id="currency_symbol" class="form-control" value="{{$general->currency_symbol}}" placeholder="{{translate('Enter Currency Symbol')}}" required>
								</div>


								<!-- Group Three -->
								<div class="mb-3 col-lg-3 col-md-3">
									<label for="registration_status" class="form-label">{{translate('User Registration')}} <sup class="text--danger">*</sup></label>
									<select class="form-control" id="registration_status" name="registration_status" required="">
										<option value="1" @if($general->registration_status == 1) selected @endif>{{translate('ON')}}</option>
										<option value="2" @if($general->registration_status == 2) selected @endif>{{translate('OFF')}}</option>
									</select>
								</div>

								<div class="mb-3 col-lg-3 col-md-3">
                                    <label for="email_verification_status" class="form-label">{{translate('Email Verification Status')}} <sup class="text--danger">*</sup></label>
                                    <select class="form-control" id="email_verification_status" name="email_verification_status" required="">
                                        <option value="1" @if($general->email_verification_status == 1) selected @endif>{{translate('ON')}}</option>
                                        <option value="2" @if($general->email_verification_status == 2) selected @endif>{{translate('OFF')}}</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-3 col-md-3">
									<label for="sign_up_bonus" class="form-label">{{translate('Signup Bonus Status')}} <sup class="text--danger">*</sup></label>
									<select class="form-control" id="sign_up_bonus" name="sign_up_bonus" required="">
										<option value="1" @if($general->sign_up_bonus == 1) selected @endif>{{translate('ON')}}</option>
										<option value="2" @if($general->sign_up_bonus == 2) selected @endif>{{translate('OFF')}}</option>
									</select>
								</div>

								<div class="mb-3 col-lg-3 col-md-3">
									<label for="plan_id" class="form-label">{{translate('Signup Plan')}} <sup class="text--danger">*</sup></label>
									<select class="form-control" id="plan_id" name="plan_id" required="">
										@foreach($plans as $plan)
											<option value="{{$plan->id}}" @if($plan->id == $general->plan_id) selected @endif>{{$plan->name}}</option>
										@endforeach
									</select>
								</div>


								<!-- Group Four -->
								<div class="mb-3 col-lg-3 col-md-3">
									<label for="sms_gateway" class="form-label">{{translate('SMS Gateway')}} <sup class="text--danger">*</sup></label>
									<select class="form-control" id="sms_gateway" name="sms_gateway" required="">
										<option value="1" @if($general->sms_gateway == 1) selected @endif>{{translate('Api Gateway')}}</option>
										<option value="2" @if($general->sms_gateway == 2) selected @endif>{{translate('Android Gateway')}}</option>
									</select>
								</div>

								<div class="mb-3 col-lg-3 col-md-3">
									<label for="panel_logo" class="form-label">{{translate('Panel Logo')}}</label>
									<input type="file" name="panel_logo" id="panel_logo" class="form-control">
								</div>

								<div class="mb-3 col-lg-3 col-md-3">
									<label for="site_logo" class="form-label">{{translate('Site Logo')}}</label>
									<input type="file" name="site_logo" id="site_logo" class="form-control">
								</div>

								<div class="mb-3 col-lg-3 col-md-3">
									<label for="site_favicon" class="form-label">{{translate('Favicon')}}</label>
									<input type="file" name="site_favicon" id="site_favicon" class="form-control">
								</div>


								<!-- Group Five -->
								<div class="mb-3 col-lg-4 col-md-4">
								  	<div class="form-check form-switch">
										<input class="form-check-input" name="cron_pop_up" type="checkbox" role="switch" id="cron_pop_up" value="true" {{$general->cron_pop_up=="true" ? "checked" : ""}}>
										<label class="form-check-label" for="cron_pop_up">{{translate('Turn On/Off In Dashbord Popup notification')}}</label>
									</div>
								</div>

								<div class="mb-3 col-lg-4 col-md-4">
								  	<div class="form-check form-switch">
										<input class="form-check-input" name="debug_mode" type="checkbox" role="switch" id="debug_mode" value="true" {{$general->debug_mode=="true" ? "checked" : ""}}>
										<label class="form-check-label" for="debug_mode">{{translate('Debug Mode For Developing Purpose')}}</label>
									</div>
								</div>

								<div class="mb-3 col-lg-4 col-md-4">
								  	<div class="form-check form-switch">
										<input class="form-check-input" name="maintenance_mode" type="checkbox" role="switch" id="maintenance_mode" value="true" {{$general->maintenance_mode=="true" ? "checked" : ""}}>
										<label class="form-check-label" for="maintenance_mode">{{translate('Maintenance Mode For Site Maintenance')}}</label>
									</div>
								</div>

								 <!-- Group Extra -->
								<div class="mb-3 col-lg-12 col-md-12" id="maintenance_mode_div" @if($general->maintenance_mode != "true") style="display:none" @endif>
									<label for="maintenance_mode_message" class="form-label">{{translate('Maintenance Mode Message')}}
										<sup class="text--danger">*</sup></label>
									<input type="text" name="maintenance_mode_message" id="maintenance_mode_message" class="form-control" value="{{$general->maintenance_mode_message}}" placeholder="{{translate('Write some message for maintenance mode page')}}">
								</div>


								<!-- Group Six -->
                                <div class="mb-3 col-lg-4 col-md-4">
                                    <label for="whatsapp_credit_count" class="form-label">{{translate('WhatsApp Word Count')}} <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">{{translate('1 Credit')}} </span>
                                        <input type="text" id="rate" name="whatsapp_word_count" value="{{$general->whatsapp_word_count}}" class="form-control" placeholder="{{translate('Enter number of words')}}" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>


                                <div class="mb-3 col-lg-4 col-md-4">
                                	<label for="whatsapp_credit_count" class="form-label">{{translate('SMS Word Count Plain Text')}} <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">{{translate('1 Credit')}} </span>
                                        <input type="text" id="rate" name="sms_word_text_count" value="{{$general->sms_word_text_count}}" class="form-control" placeholder="{{translate('Enter number of words')}}" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-4 col-md-4">
                                	<label for="whatsapp_credit_count" class="form-label">{{translate('SMS Word Count Unicode')}} <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">{{translate('1 Credit')}} </span>
                                        <input type="text" id="rate" name="sms_word_unicode_count" value="{{$general->sms_word_unicode_count}}" class="form-control" placeholder="{{translate('Enter number of words')}}" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>

							<button type="submit" class="btn btn--primary w-100 text-light">{{translate('Submit')}}</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="cronjob" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-md">
        <div class="modal-content">
            <div class="modal-body">
            	<div class="card">
        			<div class="card-header bg--lite--violet">
            			<div class="card-title text-center text--light">
            				<h6 class="text--light">{{translate('Cron Job Setting')}}</h6>
            				<p>{{translate('Set the cron once every minute this is the ideal time')}}</p>
            			</div>
            		</div>
	                <div class="card-body">
	            		<div class="mb-3">
	            			<label for="queue_url" class="form-label">{{translate('Cron Job ii')}} <sup class="text--danger">* {{translate('Set time for 1 minute')}}</sup></label>
	            			<div class="input-group mb-3">
							  	<input type="text" class="form-control" value="curl -s {{route('queue.work')}}" id="queue_url" aria-describedby="basic-addon2" readonly="">
							 	 <div class="input-group-append pointer">
							    	<span class="input-group-text bg--success text--light" id="basic-addon2" onclick="queue()">{{translate('Copy')}}</span>
							  	</div>
							</div>
	            		</div>
	            		<div class="mb-3">
	            			<label for="cron--run" class="form-label">{{translate('Cron Job i')}} <sup class="text--danger">* {{translate('Set time for 2 minutes')}}</sup></label>
	            			<div class="input-group mb-3">
							  	<input type="text" class="form-control" value="curl -s {{route('cron.run')}}" id="cron--run" aria-describedby="basic-addon2" readonly="">
							 	 <div class="input-group-append pointer">
							    	<span class="input-group-text bg--success text--light" id="basic-addon2" onclick="cronJobRun()">{{translate('Copy')}}</span>
							  	</div>
							</div>
	            		</div>
		            </div>
            	</div>
            </div>
            <div class="modal_button2">
                <button type="button" class="w-100" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('style-include')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/spectrum.css') }}">
@endpush

@push('script-include')
    <script src="{{ asset('assets/dashboard/js/spectrum.js') }}"></script>
@endpush

@push('scriptpush')
<script>
	"use strict";


    $('select[name=country_code]').on('change', function(){
        var value = $(this).val();
        $("#country--dial--code").text(value);
    });

    $('#maintenance_mode').on('click',function (e) {
        var status = $(this).val();
        if($(this).prop("checked") === true){
            $("#maintenance_mode_div").fadeIn();
        }
        else if($(this).prop("checked") === false){
            $("#maintenance_mode_div").fadeOut();
        }
    })

    function cronJobRun() {
        var copyText = document.getElementById("cron--run");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        notify('success', 'Copied the text : ' + copyText.value);
    }

    function queue() {
        var copyText = document.getElementById("queue_url");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        notify('success', 'Copied the text : ' + copyText.value);
    }

    const initColorPicker = (color) => {
        $('.color-picker').spectrum({
            color,
            change: function (color) {
                $(this).parent().siblings('.color-code').val(color.toHexString().replace(/^#?/, ''));
            }
        });
    };

    const initColorCodeInput = () => {
        $('.color-code').on('input', function () {
            const color_value = $(this).val();
            $(this).parents('.input-group').find('.color-picker').spectrum({
                color: color_value,
            });
        });
    };

    // Initialize color picker and color code input
    const color = $(this).data('color');
    initColorPicker(color);
    initColorCodeInput();
</script>
@endpush

@push('stylepush')
    <style>
        .sp-preview-inner {
            width: 100px;
        }

        .sp-replacer {
            padding: 0;
            margin: 0;
            border-right: none;
            border: 2px solid rgba(0, 0, 0, .125);
            border-radius: 5px 0 0 5px;
            height: 39.1px;
        }

        .sp-preview {
            border: 1px;
            width: 90px;
            height: 45px;
        }

        .sp-dd {
            display: none;
        }
    </style>
@endpush
