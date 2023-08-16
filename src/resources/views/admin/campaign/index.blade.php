@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	    	<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="card-body">
                    	<form action="{{route('admin.campaign.search')}}" method="post">
                            @csrf
	                        <div class="row align-items-center">
	                            <div class="col-lg-4">
	                                <label  class="form-label mb-2">{{ translate('By Name')}}</label>
	                                <input type="text" autocomplete="off" name="search"  placeholder="{{ translate('Search With Name')}}" class="form-control" id="search" value="{{@$search}}">
	                            </div>
                                @php
                                   $statuses = ['Active', 'DeActive', 'Completed', 'Ongoing'];
                                @endphp
                                <input type="hidden" name="chanel" value="{{@$chanel}}">
	                            <div class="col-lg-4">
	                                <label class="form-label mb-2">{{ translate('By Status')}}</label>
	                                 <select name="status" class="form-select" id="">
                                         <option value="">
                                            {{translate('Select Status')}}
                                         </option>
                                          @foreach( $statuses as $status)

                                            <option {{ @$searchStatus ==  $status ? 'selected' :""}} value="{{ $status}}"> {{ $status}}</option>

                                          @endforeach
                                     </select>
	                            </div>
	                            <div class="col-lg-1">
	                                <button class="btn btn--primary w-100 h-45 mt-4" type="submit">
	                                    <i class="fas fa-search"></i> {{ translate('Search')}}
	                                </button>
	                            </div>
								<div class="col-lg-1">
									@php
									    $routeName =  "admin.campaign.".strtolower($chanel);
									@endphp
	                                <a href="{{route($routeName)}}" class="btn btn--success w-100 h-45 mt-4" type="submit">
	                                    <i class="fas fa-sync"></i> {{ translate('Reset')}}
                                    </a>
	                            </div>
	                            <div class="col-lg-1">
	                                <a href="{{route('admin.campaign.create',strtolower($chanel))}}" class="btn btn--info w-100 h-45 mt-4" type="submit">
	                                    <i class="fas fa-plus"></i> {{ translate('create')}}
                                    </a>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>

	        </div>

	 		<div class="col-lg-12 mt-2">
	            <div class="card mb-4">
	                <div class="responsive-table">
		                <table class="m-0 text-center table--light">
		                    <thead>
		                        <tr>

		                            <th>{{ translate('Name')}}</th>
		                            <th>{{ translate('Chanel')}}</th>
		                            <th>{{ translate('Total Contacts')}}</th>
		                            <th>{{ translate('Schedule Time')}}</th>
		                            <th>{{ translate('Status')}}</th>
		                            <th>{{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($campaigns as $campaign)
			                    <tr class="@if($loop->even)@endif">


				                     <td data-label="{{ translate('Name')}}">
				                     	 {{$campaign->name}}
				                    </td>

				                     <td data-label="{{ translate('Chanel')}}">
				                     	 {{$campaign->chanel}}
				                    </td>

				                    <td data-label="{{ translate('Contacts')}}">
										<a href="{{route('admin.campaign.contacts',$campaign->id)}}" class="s_btn--primary text--light"> {{ translate('view Contact')}} ({{$campaign->contacts->count()}}) </a>
				                    </td>

									<td data-label="{{ translate('Time')}}">
										{{getDateTime($campaign->schedule_time)}}
								    </td>

				                    <td data-label="{{ translate('Status')}}">
				                    	@if($campaign->status == 'Active')
				                    		<span class="badge badge--primary">{{ translate('Active')}}</span>
				                    	@elseif($campaign->status == 'Ongoing')
				                    		<span class="badge badge--info">{{ translate('Ongoing')}}</span>
				                    	@elseif($campaign->status == 'DeActive')
				                    		<span class="badge badge--danger">{{ translate('Inctive')}}</span>
				                    	@elseif($campaign->status == 'Completed')
				                    		<span class="badge badge--success">{{ translate('Completed')}}</span>
										@endif
				                    </td>

				                    <td data-label={{ translate('Action')}}>

										<a href="{{route('admin.campaign.edit',$campaign->id)}}" class="btn--info text--light"><i class="las la-pen"></i>
									   </a>

				                    	<a href="javascript:void(0)" class="ms-2 btn--danger text--light campDelete"
				                    		data-bs-toggle="modal"
				                    		data-bs-target="#delete"
				                    		data-delete_id="{{$campaign->id}}"
				                    		><i class="las la-trash"></i>
                                        </a>
				                    </td>
			                    </tr>
			                @empty
			                	<tr>
			                		<td class="text-muted text-center" colspan="100%">{{ translate('No Data Found')}}</td>
			                	</tr>
			                @endforelse
		                </table>
	            	</div>
	                <div class="m-3">
	                	{{$campaigns->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>




<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form action="{{route('admin.campaign.delete')}}" method="POST">
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
