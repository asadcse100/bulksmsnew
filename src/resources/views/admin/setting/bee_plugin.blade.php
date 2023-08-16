@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="table_heading d-flex align--center justify--between">
                    <nav  aria-label="breadcrumb">
					  	<ol class="breadcrumb">
					    	<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ translate('Dashboard')}}</a></li>
					    	<li class="breadcrumb-item" aria-current="page"> {{ translate('Bee Plugin Setup')}}</li>
					  	</ol>
					</nav>
                </div>

                @php
                    $beefree = (json_decode($general->bee_plugin,true));
                @endphp

				<div class="card">
					<div class="card-body">
						<form action="{{ route('admin.general.setting.beefree.update') }}" method="post" class="d-flex flex-column gap-3">
                           @csrf
							<div class="shadow-lg p-3 mb-5 bg-body rounded">
								<h6>{{ translate('Bee Free Credentials Setup')}}<sup class="pointer" title="{{ translate('To setup bee free auth')}}">  <a href="https://developers.beefree.io/" target="_blank"><i class="fa fa-info-circle"></i></a> </sup></h6>

								<div class="row">
                                    @foreach($beefree as $key => $cred)
                                       <div class="mb-3 col-lg-6">
                                        <label for="{{$key}}">{{ ucwords(str_replace('_', ' ', $key))}} <sup class="text--danger">*</sup></label>
                                            @if($key == 'status')
                                              <select class="form-select" name="bee_plugin[{{$key}}]"  id="{{$key}}">
                                                    <option value="1" @if($cred == 1) selected  @endif>ON</option>
                                                    <option value="2" @if($cred ==  2) selected  @endif>OFF</option>
                                              </select>
                                            @else
                                                <input type="text"  name="bee_plugin[{{$key}}]" id="{{$key}}" class="form-control"  value="{{$cred}}" placeholder="********" required>
                                            @endif
                                       </div>
                                    @endforeach

								</div>
							</div>
							<button type="submit" class="btn btn--primary w-100 text-light">{{ translate('Submit')}}</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection



