
@push('stylepush')

   <style>
	  .nav-link.active{
		background: aliceblue !important;
	  }
   </style>
@endpush
@extends('user.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="col-xl">
					<form action="{{route('user.campaign.store')}}" method="POST" enctype="multipart/form-data">
						@csrf
					    <div class="card mb-3">
						    <h6 class="card-header">{{ translate('Campaign Info & Target Audience Set')}}</h6>
						    <div class="card-body">
					    		<div class="row">

									<input type="hidden" name="chanel" value="{{@$chanel}}">


									<div class="col-md-4 mb-2">
					            		<label class="form-label">
					            			{{ translate('Campaign Name')}}  <sup class="text-danger">*</sup>
					            		</label>
					            		<div class="input-group input-group-merge">
								             <input class="form-control" type="text" name="name" placeholder="{{translate('Enter Name')}}" value="{{old('name')}}">
					            		</div>

					          		</div>

					          		<div class="col-md-4 mb-2">
					            		<label class="form-label">
					            			{{ translate('From Group')}}
					            		</label>
					            		<div class="input-group input-group-merge">
								            <select class="form-control keywords" name="group[]" id="group" multiple="multiple">
												<option value="" disabled="">{{ translate('Select One')}}

                                                </option>
												@foreach($groups as $group)
													<option
													@if (old("group")){{ (in_array($group->id, old("group")) ? "selected":"") }}@endif
													value="{{$group->id}}">{{$group->name}}</option>
												@endforeach
											</select>
					            		</div>
					            		<div class="form-text">
					            			{{ translate('Can be select single or multiple group')}}
										</div>
					          		</div>
					          		<div class="col-md-4 mb-2">
					            		<label class="form-label">
					            			{{ translate('Import File')}}
					            		</label>
					            		<div class="input-group input-group-merge">
					              			<input class="form-control" type="file" name="file" id="file">
					            		</div>

					            		<div class="form-text">
					            			{{ translate('Download Sample: ')}}
											@if($chanel =='Email')
												<a href="{{route('demo.email.file.downlode', 'csv')}}"><i class="fa fa-download" aria-hidden="true"></i> {{ translate('csv')}}, </a>
												<a href="{{route('demo.email.file.downlode', 'xlsx')}}"><i class="fa fa-download" aria-hidden="true"></i> {{ translate('xlsx')}}</a>
											@else
												<a href="{{route('demo.file.downlode', 'csv')}}"><i class="fa fa-download" aria-hidden="true"></i> {{ translate('csv')}}, </a>
												<a href="{{route('demo.file.downlode', 'xlsx')}}"><i class="fa fa-download" aria-hidden="true"></i> {{ translate('xlsx')}}</a>
											@endif
										</div>

					          		</div>


					    		</div>
					      	</div>
					    </div>
                        @if($chanel =='Email')
							<div class="card mb-3">
								<h6 class="card-header"> {{ucfirst($chanel)}} {{ translate(' Header Information')}}</h6>
								<div class="card-body">
									<div class="row">
										<div class="col-md-4 mb-2">
											<label class="form-label">
												{{ translate('Subject')}} <sup class="text-danger">*</sup>
											</label>
											<div class="input-group input-group-merge">
												<input type="text"  value="{{old("subject")}}" name="subject" id="subject" class="form-control" placeholder="{{ translate('Write email subject here')}}">
											</div>
										</div>
										<div class="col-md-4 mb-2">
											<label class="form-label">
												{{ translate('Send From')}}
											</label>
											<div class="input-group input-group-merge">
													<input class="form-control" value="{{old("from_name")}}" placeholder="{{ translate('Sender Name (Optional)')}}" type="text" name="from_name" id="from_name">
											</div>
										</div>
										<div class="col-md-4 mb-2">
											<label class="form-label">
												{{ translate('Reply To Email')}}
											</label>
											<div class="input-group input-group-merge">
													<input class="form-control" value="{{old("reply_to_email")}}" type="email" placeholder="{{ translate('Reply To Email (Optional)')}}" name="reply_to_email" id="reply_to_email">
											</div>
										</div>
									</div>
								</div>
							</div>
						@endif


					    <div class="card mb-3">
						    <h6 class="card-header"> {{ucfirst($chanel)}} {{ translate(' Body')}}</h6>
							  @if($chanel == 'Email')
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<label class="form-label">
												{{ translate('Message Body')}} <sup class="text-danger">*</sup>
											</label>
											<div class="input-group">
												<textarea  class="form-control" name="message" id="message" rows="2"> {{old("message")}}  </textarea>
											</div>

											<div class="text-end mt-2">
												<a href="javascript:void(0);" id="selectEmailTemplate"
													class="btn btn-sm btn-info">
												{{translate('Use Email Template')}}
												</a>
											</div>
										</div>
									</div>
								</div>
							  @else
								<div class="card-body">
									<div class="row">

										@if($chanel == 'Sms')
											<div class="mb-3">
												<label class="form-label">
													{{ translate('Select SMS Type')}} <sup class="text-danger">*</sup>
												</label>
												<div class="input-group input-group-merge">
														<div class="form-check form-check-inline">
															<div class="form-check form-check-inline">
															<input class="form-check-input" {{old("smsType") == "plain" ?'checked' :"" }}  type="radio" name="smsType" id="smsTypeText" value="plain" checked="">
															<label class="form-check-label" for="smsTypeText">{{ translate('Text')}}</label>
														</div>

														<div class="form-check form-check-inline">
															<input {{old("smsType") == "unicode" ?'checked' :"" }}   class="form-check-input" type="radio" name="smsType" id="smsTypeUnicode" value="unicode">
															<label class="form-check-label" for="smsTypeUnicode">{{ translate('Unicode')}}</label>
														</div>
													</div>
												</div>
											</div>
										@endif

										<div class="md-12">
										<label class="form-label">
											{{ translate('Write Message')}} <sup class="text-danger">*</sup>
										</label>
										<div class="input-group input-group-merge speech-to-text" id="messageBox">
												<textarea class="form-control" name="message" id="smsmessage" placeholder="{{ translate('Enter SMS Content &  For Mention Name Use ')}}@php echo "{{". 'name' ."}}"  @endphp" aria-describedby="text-to-speech-icon"> {{old('message')}}  </textarea>
												<span class="input-group-text" id="text-to-speech-icon">
												<i class='fa fa-microphone pointer text-to-speech-toggle'></i>
												</span>
										</div>
										<div class="input-group">
											<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#templatedata">{{ translate('Use Template')}}</a>
										</div>
										<div class="text-end message--word-count"></div>
										</div>
									</div>

									@if($chanel == 'Whatsapp')

										<div class="row">
											<div class="col-md-6 mt-4 mb-2">
												<label class="form-label">
													{{ translate('Send Message With Media')}}
												</label>
												<select name="" class="form-control" id="selectTypeChange">
													<option value="">{{ translate('Select Media Type')}}</option>
													<option value="file">{{ translate('Document')}}</option>
													<option value="image">{{ translate('Image')}}</option>
													<option value="audio">{{ translate('Audio')}}</option>
													<option value="video">{{ translate('Video')}}</option>
												</select>
											</div>

											<div class="col-md-6 mt-4 mb-2">
												<label class="form-label">
													{{ translate('Upload File')}}
												</label>
												<div class="input-group" id="uploadfile">
													<input class="form-control" type="file" id="file">
												</div>
											</div>
										</div>
									@endif
								</div>
							  @endif
					    </div>

					    <div class="card mb-3">
						    <h6 class="card-header">{{ translate('Sending Options')}}</h6>
						    <div class="card-body">
				          		<div class="row">
					          		<div class="col-md-4 ">
                                        <label for="schedule_date" class="form-label">
                                            {{translate("Schedule Date & Time")}}
                                            <sup class="text-danger">*</sup></label>
				                       	<input type="datetime-local" value= "{{old("schedule_date")}}" name="schedule_date" id="schedule_date" class="form-control" required="">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="repeat" class="form-label">
                                            {{translate('Repeat Every')}}   <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="number" required id="repeatNumber" class="form-control" value="{{old('repeat_number')}}" name="repeat_number"
                                            id="repeat">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="repeat-time" class="form-label">
                                            {{translate('Repeat in')}}   <sup class="text-danger">*</sup>
                                        </label>
                                        <select class="form-select" required name="repeat_format" id="repeat-time">
                                            <option {{old('repeat_format') == 'day' ? 'selected' :""}}  value="day">{{ translate('Day') }}</option>
                                            <option  {{old('repeat_format') == 'month' ? 'selected' :""}}    value="month">{{ translate('Month') }}</option>
                                            <option  {{old('repeat_format') == 'year' ? 'selected' :""}}   value="year">{{ translate('Year') }}</option>
                                        </select>

                                    </div>
				          		</div>
				          	</div>
				        </div>

					    <button type="submit" class="btn btn-primary me-sm-3 me-1">
							{{translate("Submit")}}
						</button>
				    </form>
				</div>
			</div>
		</div>
	</div>
</section>


<div class="modal fade" id="templatedata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            	<div class="card">
            		<div class="card-header bg--lite--violet">
            			<div class="card-title text-center text--light">{{ translate('SMS Template')}}</div>
            		</div>
	                <div class="card-body">
						<div class="mb-3">
							<label for="template" class="form-label">{{ translate('Select Template')}} <sup class="text--danger">*</sup></label>
							<select class="form-control" name="template" id="template" required>
								<option value="" disabled="" selected="">{{ translate('Select One')}}</option>
								@foreach($templates as $template)
									<option value="{{$template->message}}">{{$template->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
            	</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="globalModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div id="modal-size" class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title"></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="modal-body" class="modal-body">

            </div>
        </div>
    </div>
</div>

@endsection


@push('scriptpush')
<script>
	(function($){
		"use strict";

		const modal = $('#globalModal');
		$('.keywords').select2({
			tags: true,
			tokenSeparators: [',']
		});




		$(document).on('click','#use-template',function(e){
			var html  = $(this).attr('data-html')
			const domElement = document.querySelector( '.ck-editor__editable' );
			const emailEditorInstance = domElement.ckeditorInstance;
			emailEditorInstance.setData( html );
			modal.modal('hide');
        })



        if("{{$chanel}}" == 'Email'){
			$(document).ready(function() {

				CKEDITOR.ClassicEditor.create(document.getElementById("message"), {
					placeholder: document.getElementById("message").getAttribute("placeholder"),
					toolbar: {
					items: [
						'heading',
						'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
						'alignment', '|',
						'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', 'removeFormat', 'findAndReplace', '-',
						'bulletedList', 'numberedList', '|',
						'outdent', 'indent', '|',
						'undo', 'redo',
						'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
						'horizontalLine', 'pageBreak', '|',
						'sourceEditing'
					],
					shouldNotGroupWhenFull: true
					},
					list: {
					properties: {
						styles: true,
						startIndex: true,
						reversed: true
					}
					},
					heading: {
					options: [
						{ model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
						{ model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
						{ model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
						{ model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
						{ model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
						{ model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
						{ model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
					]
					},
					fontFamily: {
					options: [
						'default',
						'Arial, Helvetica, sans-serif',
						'Courier New, Courier, monospace',
						'Georgia, serif',
						'Lucida Sans Unicode, Lucida Grande, sans-serif',
						'Tahoma, Geneva, sans-serif',
						'Times New Roman, Times, serif',
						'Trebuchet MS, Helvetica, sans-serif',
						'Verdana, Geneva, sans-serif'
					],
					supportAllValues: true
					},
					fontSize: {
					options: [10, 12, 14, 'default', 18, 20, 22],
					supportAllValues: true
					},
					htmlSupport: {
					allow: [
						{
						name: /.*/,
						attributes: true,
						classes: true,
						styles: true
						}
					]
					},
					htmlEmbed: {
					showPreviews: true
					},
					link: {
					decorators: {
						addTargetToExternalLinks: true,
						defaultProtocol: 'https://',
						toggleDownloadable: {
						mode: 'manual',
						label: 'Downloadable',
						attributes: {
							download: 'file'
						}
						}
					}
					},
					mention: {
					feeds: [
						{
						marker: '@',
						feed: [
							'@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
							'@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
							'@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
							'@sugar', '@sweet', '@topping', '@wafer'
						],
						minimumCharacters: 1
						}
					]
					},
					removePlugins: [
					'CKBox',
					'CKFinder',
					'EasyImage',
					'RealTimeCollaborativeComments',
					'RealTimeCollaborativeTrackChanges',
					'RealTimeCollaborativeRevisionHistory',
					'PresenceList',
					'Comments',
					'TrackChanges',
					'TrackChangesData',
					'RevisionHistory',
					'Pagination',
					'WProofreader',
					'MathType'
					]
				});
			});
		}




		$(document).on('click','#selectEmailTemplate',function(e){
			$("#selectEmailTemplate").html('{{translate("Template Loading...")}}');
			appendTemplate()
			e.preventDefault()
        })

		//load pre-build template method start
		function  appendTemplate(){
			$.ajax({
				method:"GET",
				url:"{{ route('user.template.email.list') }}",
				dataType:'json'
			}).then(response=>{
				$("#selectEmailTemplate").html('{{translate("Use Email Template")}}');
				appendModalData(response.view)
			})
        }

		   // append modal data method start
		function appendModalData(view){

			$('#modal-title').html(`{{translate('Pre Build Template')}}`)


			var html = `
				<div class="modal-body">
				   ${view}
				</div>
			`
			$('#modal-body').html(html)
			modal.modal('show');
		}





		if("{{$chanel}}" == 'Sms'){
			var wordLength = {{$general->sms_word_text_count}};
			$('input[type=radio][name=smsType]').on('change', function(){
				if(this.value == "unicode"){
					wordLength = {{$general->sms_word_unicode_count}};
				}else{
					wordLength = {{$general->sms_word_text_count}};
				}
			});

			$(`textarea[name=message]`).on('keyup', function(event) {
				var character = $(this).val();
				var word = character.split(" ");
				var sms = 1;
				if (character.length > wordLength) {
					sms = Math.ceil(character.length / wordLength);
				}
				if (character.length > 0) {
					$(".message--word-count").html(`
						<span class="text--success character">${character.length}</span> {{ translate('Character')}} |
						<span class="text--success word">${word.length}</span> {{ translate('Words')}} |
						<span class="text--success word">${sms}</span> {{ translate('SMS')}} (${wordLength} Char./SMS)`);
				}else{
					$(".message--word-count").empty()
				}
			});
		}

		if("{{$chanel}}" == 'Whatsapp'){
			var wordLength = {{$general->whatsapp_word_count}};

			$(`textarea[name=message]`).on('keyup', function(event) {
				var credit = wordLength;
				var character = $(this).val();
				var characterleft = credit - character.length;
				var word = character.split(" ");
				var sms = 1;
				if (character.length > wordLength) {
					sms = Math.ceil(character.length / wordLength);
				}
				if (character.length > 0) {
					$(".message--word-count").html(`
						<span class="text--success character">${character.length}</span> {{ translate('Character')}} |
						<span class="text--success word">${word.length}</span> {{ translate('Words')}} |
						<span class="text--success word">${sms}</span> {{ translate('SMS')}} (${wordLength} Char./SMS)`);
				}else{
					$(".message--word-count").empty()
				}
			});
			const selectType = $('#selectTypeChange');
	     	const fileInput = $('#uploadfile');

			selectType.on('change', () => {
				const selectedValue = selectType.val();
				switch (selectedValue) {
				case 'file':
					fileInput.html('<input class="form-control" type="file" name="document" id="document" accept=".doc,.docx,.pdf">');
					break;
				case 'image':
					fileInput.html('<input class="form-control" type="file" name="image" id="image" accept=".jpg,.jpeg,.png,.gif">');
					break;
				case 'audio':
					fileInput.html('<input class="form-control" type="file" name="audio" id="audio" accept=".mp3,.wav">');
					break;
				case 'video':
					fileInput.html('<input class="form-control" type="file" name="video" id="video" accept=".mp4,.mov,.avi">');
					break;
				default:
					fileInput.html('<input class="form-control" type="file" name="" id="file">');
					break;
				}
			});
		}


	    $('select[name=template]').on('change', function(){
	    	var character = $(this).val();
	    	$('textarea[name=message]').val(character);
		    $('#templatedata').modal('toggle');
		});



        var t = window.SpeechRecognition || window.webkitSpeechRecognition,
            e = document.querySelectorAll(".speech-to-text");
	    if (null != t && null != e) {
	        var n = new t;
            var e = !1;
        	$('#text-to-speech-icon').on('click',function () {
				var messageBox = document.getElementById('messageBox');
				messageBox.querySelector(".form-control").focus(), n.onspeechstart = function() {
                    e = !0
                }, !1 === e && n.start(), n.onerror = function() {
                    e = !1
                }, n.onresult = function(e) {
                    messageBox.querySelector(".form-control").value = e.results[0][0].transcript
                }, n.onspeechend = function() {
                    e = !1, n.stop()
                }
			});
	    }

	    const inputNumber = document.getElementById('number');
		if(inputNumber){
			inputNumber.addEventListener('keyup', function() {
			const cleanedValue = this.value.replace(/[^\d.-]/g, '');
			this.value = cleanedValue;
		  });
		}



	})(jQuery);
</script>
@endpush

