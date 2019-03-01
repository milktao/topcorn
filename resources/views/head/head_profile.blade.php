@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[], 
	"lang":"{{ App::getlocale() }}",
	"profile_user_id":"{{ $profile_user_id }}", 
	"is_auth":"{{  Auth::Check()  }}",
	"follow_id":{{ $follow_id }},
	"is_following_you":{{ $is_following_you }},
    "constants_image_thumb_nail":"{{config('constants.image.thumb_nail')[$image_quality]}}",
	@if(Auth::check())
	"user_id":{{ Auth::id() }},
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }}
	@endif
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/ProfilePageController.js?v={{config('constants.version')}}"></script>
@endsection
@section('controllername' ,'ProfilePageController')

@section('title')
@{{page_variables.notification_count>0?'('+page_variables.notification_count+') ':''}}
{{ $profile_user_name.__('title.profile') }}
@endsection