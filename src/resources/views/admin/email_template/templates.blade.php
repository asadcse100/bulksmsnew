@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12">
                <div class="rounded_box">
                    @if(!request()->routeIs('admin.template.email.user.list'))
                        <div class="row align--center ">

                            <div class="col-12 col-md-8 col-lg-8 col-xl-7">
                                <div class="row mb-2">
                                    <div class="col-6 col-md-6 col-lg-5 col-xl-3 px-2 py-1">
                                        <a href="{{route('admin.template.email.create')}}" class="w-100 btn--success text--light border-0 px-1 py-2 rounded ms-2" ><i class="las la-plus"></i>{{translate('Create Template')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="responsive-table">
                        <table class="w-100 m-0 text-center table--light">
                            <thead>
                                <tr>
                                    @if(request()->routeIs('admin.template.email.user.list'))
                                      <th> {{ translate('User')}}</th>
                                    @endif
                                    <th> {{ translate('Name')}}</th>
                                    <th> {{ translate('Provider')}}</th>
                                    <th> {{ translate('Status')}}</th>
                                    <th> {{ translate('Action')}}</th>
                                </tr>
                            </thead>
                            @forelse($emailTemplates as $emailTemplate)
                                <tr class="@if($loop->even)@endif">
                                    @if(request()->routeIs('admin.template.email.user.list'))
                                        <td data-label=" {{ translate('User Name')}}">
                                            {{$emailTemplate->user ? $emailTemplate->user->name :"N/A"}}
                                        </td>
                                    @endif
                                    <td data-label=" {{ translate('Name')}}">
                                        {{$emailTemplate->name}}
                                    </td>

                                    <td data-label=" {{ translate('provider')}}">
                                        @if($emailTemplate->provider == 1)
                                        <span class="badge badge--success"> {{ translate('Beepro')}}</span>
                                        @else
                                            <span class="badge badge--info"> {{ translate('Texteditor')}}</span>
                                        @endif
                                    </td>

                                    <td data-label=" {{ translate('Status')}}">

                                        @if(request()->routeIs('admin.template.email.user.list'))
                                            @if($emailTemplate->status ==1)
                                                <div class="badge bg-primary">{{translate('Approved')}}</div>
                                            @elseif($emailTemplate->status == 2)
                                                <div class="badge bg-warning">{{translate('Pending')}}</div>
                                            @elseif($emailTemplate->status == 3)
                                                <div class="badge bg-danger">{{translate('Rejected')}}</div>
                                            @endif
                                        @else

                                            @if($emailTemplate->status == 1)
                                            <span class="badge badge--success"> {{ translate('Active')}}</span>
                                            @else
                                                <span class="badge badge--danger"> {{ translate('Inactive')}}</span>
                                            @endif

                                        @endif

                                    </td>

                                    <td data-label={{ translate('Action') }}>
                                        @if(!request()->routeIs('admin.template.email.user.list'))
                                            <a class="btn--primary text--light me-2" href="{{route('admin.template.email.edit', $emailTemplate->id)}}"><i class="las la-pen"></i></a>
                                            @else

                                            <a class="btn--primary text--light me-2 statusUpdate" data-bs-toggle="modal" 		data-bs-target="#updateStatus" href="javascript:void(0)"
											data-id="{{$emailTemplate->id}}" data-status="{{$emailTemplate->status}}">
											<i class="las la-pen"></i>
                                        @endif

                                        <a href="javascript:void(0)" class="templateDelete btn--danger text--light"
                                        data-bs-toggle="modal"
                                        data-bs-target="#delete"
                                        data-delete_id="{{$emailTemplate->id}}"
                                        ><i class="las la-trash"></i></a>
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
                        {{$emailTemplates->links()}}
                    </div>
                </div>

	        </div>
	    </div>
	</div>
</section>

<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form action="{{route('admin.template.email.delete')}}" method="POST">
        		@csrf
        		<input type="hidden" name="id" value="">
	            <div class="modal_body2">
	                <div class="modal_icon2">
	                    <i class="las la-trash"></i>
	                </div>
	                <div class="modal_text2 mt-3">
	                    <h6>{{ translate('Are you sure to delete this Template')}}</h6>
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

<div class="modal fade" id="updateStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('admin.template.email.status.update')}}" method="POST">
				@csrf
				<input type="hidden" name="id">
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">{{translate('Status Update')}}</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3" id="statusAppend">

							</div>
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
	                <button type="submit" class="bg--success">{{translate('Update')}}</button>
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
        $(document).on('click','.templateDelete',function(e){
            var modal = $('#delete');
			modal.find('input[name=id]').val($(this).attr('data-delete_id'));
			modal.modal('show');
            e.preventDefault()
        })

        $('.statusUpdate').on('click', function(){
			var modal = $('#updateStatus');
			modal.find('input[name=id]').val($(this).data('id'));
			var value = $(this).data('status');
			$('#statusAppend').html('')
			$('#statusAppend').html(`
				<label for="status" class="form-label">{{translate('Status')}} <sup class="text--danger">*</sup></label>
				<select name="status" id="status" class="form-control" >
					<option  ${value == 1 ? 'selected' : ''} value="1">{{translate('Approved')}}</option>
					<option  ${value == 2 ? 'selected' : ''} value="2">{{translate('Pending')}}</option>
					<option  ${value == 3 ? 'selected' : ''} value="3">{{translate('Reject')}}</option>
				</select>
			`)
			modal.modal('show');
		});


	})(jQuery);
</script>
@endpush
