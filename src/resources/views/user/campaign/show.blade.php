@extends('user.layouts.app')
@section('panel')


<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12 p-1">
	            <div class="rounded_box">

	                <div class="responsive-table">
		                <table class="m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                            <th> #</th>
		                            <th> {{ translate('Campaign')}}</th>
		                            <th> {{ translate('Contact')}}</th>
		                            <th> {{ translate('Status')}}</th>
		                            <th> {{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($contacts as $contact)
			                    <tr class="@if($loop->even)@endif">
			                    	<td data-label=" #">
				                    	{{$loop->iteration}}
				                    </td>

				                     <td data-label=" {{ translate('Campaign')}}">
				                    	 {{$campaign->name}}
				                    </td>

				                    <td data-label=" {{ translate('contact')}}">
				                    	{{$contact->contact}}
				                    </td>


				                    <td data-label=" {{ translate('Status')}}">
				                    	@if($contact->status == 'Processing')
				                    		<span class="badge badge--primary">{{ translate('Processing')}}</span>
				                    	@elseif($contact->status == 'Pending')
				                    		<span class="badge badge--info">{{ translate('Pending')}}</span>
				                    	@elseif($contact->status == 'Fail')
				                    		<span class="badge badge--danger">{{ translate('Fail')}}</span>
				                    	@elseif($contact->status == 'Success')
				                    		<span class="badge badge--success">{{ translate('Success')}}</span>
				                    	@elseif($contact->status == 'Schedule')
				                    		<span class="badge badge--info">{{ translate('Schedule')}}</span>
                                            @else
                                              N/A
										@endif

				                    </td>

                                    <td>
                                        <a href="javascript:void(0)" class="btn--danger text--light campDelete"
				                    		data-bs-toggle="modal"
				                    		data-bs-target="#delete"
				                    		data-delete_id="{{$contact->id}}"
				                    		><i class="las la-trash"></i>
                                        </a>
                                    </td>
			                    </tr>
			                @empty
			                	<tr>
			                		<td class="text-muted text-center" colspan="100%"> {{ translate('No Data Found')}}</td>
			                	</tr>
			                @endforelse
		                </table>
	            	</div>
	                <div class="m-3">
	                	{{$contacts->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>

<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form action="{{route('user.campaign.contact.delete')}}" method="POST">
        		@csrf
        		<input type="hidden" name="id" value="">
	            <div class="modal_body2">
	                <div class="modal_icon2">
	                    <i class="las la-trash"></i>
	                </div>
	                <div class="modal_text2 mt-3">
	                    <h6>{{ translate('Are you sure to delete this Camapign')}}</h6>
	                </div>
	            </div>
	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--danger">{{ translate('Delete')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>

@endsection

@push('scriptpush')
<script>
	(function($){
		"use strict";
		$('.campDelete').on('click', function(){
			var modal = $('#delete');
			modal.find('input[name=id]').val($(this).data('delete_id'));
			modal.modal('show');
		});
	})(jQuery);
</script>
@endpush
