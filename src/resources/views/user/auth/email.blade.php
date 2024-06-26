@extends('layouts.frontend')
@section('content')
    <div class="col-12 col-md-12 col-lg-6 col-xl-6 px-0">
        <div class="login-left-section d-flex align-items-center justify-content-center">
            <div class="form-container">
                <div class="mb-3">
                    <h2>{{ translate('Verify your Email')}}</h2>
                </div>
                <form action="{{route('user.email.verification')}}" method="POST">
                    @csrf
                    <div class="my-3">
                        <div class="d-flex align-items-center border-bottom">
                            <i class="las la-lock fs-3 text-primary"></i>
                            <input type="text" name="code" placeholder="{{ translate('Enter Verify Code')}}" class="border-0 w-100 p-2" id="exampleInputEmail1"aria-describedby="emailHelp"/>
                        </div>
                    </div>
                    <button type="submit" class="shadow btn btn--info w-100 mt-2 text-light">
                        {{ translate('Submit')}}
                    </button>
                    <div class="col-lg-12 text-center">
                        <div class="mt-10">
                            <label>{{translate('Please check including your Junk/Spam Folder. if not found, you can')}} <a href="{{route('user.email.verification')}}" class="text--base">{{translate('Resend code')}}</a></label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
