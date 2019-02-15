@extends('layout.app')

@include('head.head_accountnotificationsemails')

@section('body')
<h5 class="text-center text-md-left col mt-3 mt-md-4">{{ __('navbar.account') }}</h5>




<!-- Tabs Button -->
<div class="container-fluid mt-3 pb-1 d-none d-md-inline">
	<ul class="nav justify-content-md-center tab1">
		<li class="nav-item">
			<a class="nav-link text-muted" href="/account">{{ __('general.profile') }}</a>
		</li>
		<li class="nav-item">
			<a class="nav-link text-muted" href="/account/password">{{ __('general.password') }}</a>
		</li>
		<li class="nav-item mb-2">
			<a class="nav-link text-muted" href="/account/interface">{{ __('general.interface') }}</a>
		</li>
		<li class="nav-item mb-2">
			<a class="nav-link active text-muted" href="/account/notifications-emails">{{ __('general.notifications_emails') }}</a>
		</li>
	</ul>
</div>
<!-- Tabs Button -->




<!-- Tabs Button Mobile -->
<div class="scrollmenu my-3 d-md-none tab2">
	<a class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" href="/account">{{ __('general.profile') }}</a>
	<a class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" href="/account/password">{{ __('general.password') }}</a>
	<a class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" href="/account/interface">{{ __('general.interface') }}</a>
	<a class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration active" href="/account/notifications-emails">{{ __('general.notifications_emails') }}</a>
</div>
<!-- Tabs Button Mobile -->




@if(session()->has('status'))
    <div class="alert alert-success">
    {!! session('status') !!}
    </div>
@endif
<div class="container-fluid mt-3">
	<div class="row">
		<div class="col"></div>
		<div class="col-12 col-xl-10">
			<form id="the_form" class="form-horizontal" role="form" method="POST" action="/account/notifications-emails">
				{{ csrf_field() }}
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
						<div class="h6 text-muted">{{ __('general.when') }}</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="when_feature">{{ __('general.when_feature') }}</label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-tools"></i></div>
				                </div>
				                <select class="form-control" id="when_feature" name="when_feature">
									<option value="0" {{Auth::User()->when_feature==0?'selected':''}}>{{ __('general.dont_do_anything') }}</option>
									<option value="1" {{Auth::User()->when_feature==1?'selected':''}}>{{ __('general.do_notification') }}</option>
									<option value="2" {{Auth::User()->when_feature==2?'selected':''}}>{{ __('general.notification_and_email') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="when_air_date" ng-mouseenter="hovering_air=true" ng-mouseleave="hovering_air=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_when_air_date') }}">{{ __('general.when_air_date') }} <span ng-show="!hovering_air"><i class="far fa-question-circle"></i></span><span ng-show="hovering_air"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-clock"></i></div>
				                </div>
				                <select class="form-control" id="when_air_date" name="when_air_date">
									<option value="0" {{Auth::User()->when_air_date==0?'selected':''}}>{{ __('general.dont_do_anything') }}</option>
									<option value="1" {{Auth::User()->when_air_date==1?'selected':''}}>{{ __('general.do_notification') }}</option>
									<option value="2" {{Auth::User()->when_air_date==2?'selected':''}}>{{ __('general.notification_and_email') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="when_like">{{ __('general.when_like') }}</label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-heart"></i></div>
				                </div>
				                <select class="form-control" id="when_like" name="when_like" autofocus>
									<option value="0" {{Auth::User()->when_like==0?'selected':''}}>{{ __('general.dont_do_anything') }}</option>
									<option value="1" {{Auth::User()->when_like==1?'selected':''}}>{{ __('general.do_notification') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="when_watch_together" ng-mouseenter="hovering_tog=true" ng-mouseleave="hovering_tog=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_when_watch_together') }}">{{ __('general.when_air_date') }} <span ng-show="!hovering_tog"><i class="far fa-question-circle"></i></span><span ng-show="hovering_tog"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-user-friends"></i></div>
				                </div>
				                <select class="form-control" id="when_watch_together" name="when_watch_together">
									<option value="0" {{Auth::User()->when_watch_together==0?'selected':''}}>{{ __('general.dont_do_anything') }}</option>
									<option value="1" {{Auth::User()->when_watch_together==1?'selected':''}}>{{ __('general.do_notification') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="when_recommendation" ng-mouseenter="hovering_rec=true" ng-mouseleave="hovering_rec=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_when_recommendation') }}">{{ __('general.when_air_date') }} <span ng-show="!hovering_rec"><i class="far fa-question-circle"></i></span><span ng-show="hovering_rec"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-share"></i></div>
				                </div>
				                <select class="form-control" id="when_recommendation" name="when_recommendation">
									<option value="0" {{Auth::User()->when_recommendation==0?'selected':''}}>{{ __('general.dont_do_anything') }}</option>
									<option value="1" {{Auth::User()->when_recommendation==1?'selected':''}}>{{ __('general.do_notification') }}</option>
									<option value="2" {{Auth::User()->when_recommendation==2?'selected':''}}>{{ __('general.notification_and_email') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3"></div>
				    <div class="col-md-6">
				        <button type="submit" class="btn btn-primary btn-block">{{ __('general.save_changes') }}</button>
				    </div>
				</div>
			</form>
		</div>
		<div class="col"></div>
	</div>
</div>
@endsection