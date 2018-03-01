@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[],
	"lang":"{{ App::getlocale() }}", 
	"secondary_lang":"{{ Auth::User()->secondary_lang }}", 
	"hover_title_language":"{{ Auth::User()->hover_title_language }}", 
	"image_quality":"{{ Auth::User()->image_quality }}", 
	"margin_x_setting":"{{ Auth::User()->margin_x_setting }}", 
	"open_new_tab":"{{ Auth::User()->open_new_tab }}", 
	"pagination":"{{ Auth::User()->pagination }}", 
	"show_crew":"{{ Auth::User()->show_crew }}", 
	"pemosu_mode":"{{ Auth::User()->pemosu_mode }}", 
	"min_vote_count":"{{ Auth::User()->min_vote_count }}", 
	"theme":"{{ Auth::User()->theme }}", 
	@if(Auth::check())
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
<script src="/js/controllers/AccountInterfacePageController.js"></script>
@endsection
@section('controllername','AccountInterfacePageController')

@section('title')
{{ __('title.account') }}
@endsection