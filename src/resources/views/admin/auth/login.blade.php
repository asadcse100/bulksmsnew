@extends('admin.layouts.auth')
@section('content')

@php
   $panel_logo =  $general->panel_logo ?  $general->panel_logo : "panel_logo.png"
@endphp
            
<form action="{{route('admin.authenticate')}}" method="POST">
    @csrf
    <div class="logo">
        <img src="{{showImage(filePath()['panel_logo']['path'].'/'.$panel_logo)}}" alt="logo">
        <h3>{{ translate('Admin login')}}</h3>
    </div>
    <div class="input-field email">
          <i class="fas fa-envelope"></i>
        <input type="text" id="login-email" name="username" placeholder="{{ translate('Enter Username')}}">
    </div>
    <div class="input-field password">
         <i class="fas fa-lock"></i>
        <input type="password"  name="password" id="login-email" placeholder="{{ translate('Enter Password')}}">
    </div>
    <div class="forgot-pass">
        <a href="{{route('admin.password.request')}}">{{ translate('Forgot password')}}?</a>
    </div>
    <button type="submit" class="btn-login">{{ translate('Sign In')}}</button>
</form>
@endsection
