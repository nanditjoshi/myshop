
@extends('auth.app')
@section('page-title') Verify Your Email Address @endsection
@section('body-class') login-page @endsection

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/login') }}"><b>{{ __('Home') }}</b></a>
    </div>
    <!-- /.login-logo -->
   

    <div class="login-box-body">
        <p class="login-box-msg">{{ __('Verify Your Email Address') }}</p>

        <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        
            <div class="form-group has-feedback">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <br/><br/>
                <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('click here to request another') }}</button>
            </div>
        </form>    
            
    </div>
@endsection
@section('customescript')
<script>
    
</script>
@endsection
