@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('user/user.login') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')
<div class="row">
    
    <div class="col-md-6 col-md-offset-3">
    <div class="page-header">
    	<h1>Login into your account</h1>
    </div>
    <a href="/user/google-login/" class='btn btn-large btn-danger btn-block'>Google Login</a>
    <a href="/user/google-login" class='btn btn-large btn-primary btn-block'>Facebook Login</a>
    <hr>
    <form class="form-horizontal" method="POST" action="{{ URL::to('user/login') }}" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset>
            <div class="form-group">
                <label class="col-md-2 control-label" for="email">{{ Lang::get('confide::confide.username_e_mail') }}</label>
                <div class="col-md-10">
                    <input class="form-control" tabindex="1" placeholder="{{ Lang::get('confide::confide.username_e_mail') }}" type="text" name="email" id="email" value="{{ Input::old('email') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="password">
                    {{ Lang::get('confide::confide.password') }}
                </label>
                <div class="col-md-10">
                    <input class="form-control" tabindex="2" placeholder="{{ Lang::get('confide::confide.password') }}" type="password" name="password" id="password">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <div class="checkbox">
                        <label for="remember">{{ Lang::get('confide::confide.login.remember') }}
                            <input type="hidden" name="remember" value="0">
                            <input tabindex="4" type="checkbox" name="remember" id="remember" value="1">
                        </label>
                    </div>
                </div>
            </div>

            @if ( Session::get('error') )
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            @if ( Session::get('notice') )
            <div class="alert">{{ Session::get('notice') }}</div>
            @endif

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <button tabindex="3" type="submit" class="btn btn-primary">{{ Lang::get('confide::confide.login.submit') }}</button>
                    <a class="btn btn-default" href="forgot">{{ Lang::get('confide::confide.login.forgot_password') }}</a>
                </div>
            </div>
        </fieldset>
    </form>
    </div>
</div>
@stop

@section('script')
<script>
    $('#google-login').on('click',function(){
        $.ajax({
            url: '/user/login',
            type: 'GET',
            data: {},
            success: function (data) {
                alert(data);
            }
        });
    });
    
</script>
@stop
