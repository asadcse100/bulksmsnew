@extends('user.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="responsive-table">
		                <table class="m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                            <th>{{translate('Name')}}</th>
		                            <th>{{translate('Message')}}</th>
		                            <th>{{translate('Status')}}</th>
		                            <th>{{translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($templates as $template)
			                    <tr class="@if($loop->even)@endif">
				                    <td data-label="{{translate('Name')}}">
				                    	{{$template->name}}
				                    </td>

									<td data-label="{{translate('Message')}}">
				                    	{{$template->message}}
				                    </td>
									<td data-label="{{translate('Status')}}">
				                    	@if($template->status == 1)
											<div class="badge bg-primary">{{translate('Approved')}}</div>
				                    	@elseif($template->status == 2)
											<div class="badge bg-warning">{{translate('Pending')}}</div>
										@elseif($template->status == 3)
											<div class="badge bg-danger">{{translate('Rejected')}}</div>
										@endif
				                    </td>

				                    <td data-label={{translate('Action')}}>
			                    		<a class="btn--primary text--light template" data-bs-toggle="modal" data-bs-target="#updatebrand" href="javascript:void(0)"
			                    			data-id="{{$template->id}}"
			                    			data-name="{{$template->name}}"
			                    			data-message="{{$template->message}}"><i class="las la-pen"></i></a>
			                    		<a class="btn--danger text--light delete" data-bs-toggle="modal" data-bs-target="#deletetemplate" href="javascript:void(0)"data-id="{{$template->id}}"><i class="las la-trash"></i></a>
				                    </td>
			                    </tr>
			                @empty
			                	<tr>
			                		<td class="text-muted text-center" colspan="100%">{{translate('No Data Found')}}</td>
			                	</tr>
			                @endforelse
		                </table>
	            	</div>
	                <div class="m-3">
	                	{{$templates->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
	<a href="javascript:void(0);" class="support-ticket-float-btn" data-bs-toggle="modal" data-bs-target="#createTemplate" title="{{translate('Create New Template')}}">
		<i class="fa fa-plus ticket-float"></i>
	</a>
</section>


<div class="modal fade" id="createTemplate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('user.phone.book.template.store')}}" method="POST">
				@csrf
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">{{translate('Add New Template')}}</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3">
								<label for="name" class="form-label">{{translate('Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="{{translate('Enter Name')}}" required>
							</div>

							<div class="mb-3">
								<label for="message" class="form-label">{{translate('Message') }}<sup class="text--danger">*</sup></label>
								<textarea rows="5"  class="form-control" id="message" name="message" placeholder="{{translate('Enter Message')}}" required=""></textarea>
							</div>
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
	                <button type="submit" class="bg--success">{{translate('Submit')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>


<div class="modal fade" id="updatetemplate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('user.phone.book.template.update')}}" method="POST">
				@csrf
				<input type="hidden" name="id">
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">{{translate('Update Group')}}</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3">
								<label for="name" class="form-label">{{translate('Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="{{translate('Enter Name')}}" required>
							</div>

							<div class="mb-3">
								<label for="message" class="form-label">{{translate('Message')}} <sup class="text--danger">*</sup></label>
								<textarea rows="5"  class="form-control" id="message" name="message" placeholder="{{translate('Enter Message')}}" required=""></textarea>
							</div>
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
	                <button type="submit" class="bg--success">{{translate('Submit')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>



<div class="modal fade" id="deletetemplate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{route('user.phone.book.template.delete')}}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal_body2">
					<div class="modal_icon2">
						<i class="las la-trash"></i>
					</div>
					<div class="modal_text2 mt-3">
						<h6>{{translate('Are you sure to want delete this group?')}}</h6>
					</div>
				</div>
				<div class="modal_button2">
					<button type="button" class="" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
					<button type="submit" class="bg--danger">{{translate('Delete')}}</button>
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
		$('.template').on('click', function(){
			var modal = $('#updatetemplate');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.find('input[name=name]').val($(this).data('name'));
			modal.find('textarea[name=message]').val($(this).data('message'));
			modal.modal('show');
		});

		$('.delete').on('click', function(){
			var modal = $('#deletetemplate');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.modal('show');
		});
	})(jQuery);
</script>
@endpush
