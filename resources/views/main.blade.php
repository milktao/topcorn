@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_main')

@section('body')
<div class="mt-4" ng-show="page_variables.expanded==-1 || page_variables.expanded==1" id="scroll_to_top1" ng-cloak>
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
			<div class="dropdown d-inline">
			    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_1=5">
				    <span class="h5" ng-show="page_variables.active_tab_1==5">{{ __('general.p_movies') }}: {{ __('general.definitely_recommend') }}</span>
				    <span class="h5" ng-show="page_variables.active_tab_1==4">{{ __('general.p_movies') }}: {{ __('general.recommend') }}</span>
				    <span class="h5" ng-show="page_variables.active_tab_1=='now playing'">{{ __('general.p_movies') }}: {{ __('general.now_playing') }}</span>
			    </button>
			    <div class="dropdown-menu">
					<button class="dropdown-item" ng-click="page_variables.active_tab_1=5;get_first_page_data(1);">{{ __('general.definitely_recommend') }}</button>
					<button class="dropdown-item" ng-click="page_variables.active_tab_1=4;get_first_page_data(1);">{{ __('general.recommend') }}</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_1='now playing';get_first_page_data(1);">{{ __('general.now_playing') }}</button>
			    </div>
			</div>
		</div>
		<button class="btn btn-outline-secondary addban border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=1;iscast_movies1=true;is_expanded1=true;toggle_collapse('collapseMovies1', 'expand');" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addban border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1;is_expanded1=false;iscast_movies1=false;toggle_collapse('collapseMovies1', 'collapse');scroll_to_top('scroll_to_top1');" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div class="container-fluid" ng-show="iscast_movies1 && page_variables.active_tab_1!='now playing'">
		@if(Auth::check())
		<div class="dropdown d-inline">
			<button class="btn btn-outline-secondary dropdown-toggle mt-3 mr-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-filter"></i>
				<span ng-show="page_variables.f_following1=='following'">{{ __('general.followings') }}</span>
				<span ng-show="page_variables.f_following1=='all'">{{ __('general.all_users') }}</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="page_variables.f_following1='following';get_first_page_data(1);">{{ __('general.followings') }}</button>
				<button class="dropdown-item" ng-click="page_variables.f_following1='all';get_first_page_data(1);">{{ __('general.all_users') }}</button>
			</div>
		</div>
		@endif
		<div class="dropdown d-inline">
			<button class="btn btn-outline-secondary dropdown-toggle mr-2 mt-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-sort-amount-down"></i>
				<span ng-show="page_variables.f_sort1=='newest'">{{ __('general.latest_vote') }}</span>
				<span ng-show="page_variables.f_sort1=='most voted'">{{ __('general.most_voted') }}</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="page_variables.f_sort1='newest';get_first_page_data(1);">{{ __('general.latest_vote') }}</button>
				<button class="dropdown-item" ng-click="page_variables.f_sort1='most voted';get_first_page_data(1);">{{ __('general.most_voted') }}</button>
			</div>
		</div>
	</div>
	<div ng-show="similar_movies1.length>0">
    @include('layout.moviecard_6', ['suffix' => '1'])
	</div>
</div>
<div ng-show="page_variables.expanded==-1">
<!-- @yield('amazon_affiliate') -->
</div>
<div class="mt-4" ng-show="page_variables.expanded==-1 || page_variables.expanded==2" id="scroll_to_top2" ng-cloak>
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
			<div class="dropdown d-inline">
			    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_2='on air'">
			    <span class="h5" ng-show="page_variables.active_tab_2=='on air'">{{ __('general.p_series') }}: {{ ucwords(__('general.air_date')) }}</span>
			    <span class="h5" ng-show="page_variables.active_tab_2==5">{{ __('general.p_series') }}: {{ __('general.definitely_recommend') }}</span>
			    <span class="h5" ng-show="page_variables.active_tab_2==4">{{ __('general.p_series') }}: {{ __('general.recommend') }}</span>
			    </button>
			    <div class="dropdown-menu">
			        <button class="dropdown-item" ng-click="page_variables.active_tab_2=5;get_first_page_data(2);">{{ __('general.definitely_recommend') }}</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_2=4;get_first_page_data(2);">{{ __('general.recommend') }}</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_2='on air';get_first_page_data(2);">{{ ucwords(__('general.air_date')) }}</button>
			    </div>
			</div>
		</div>
		<button class="btn btn-outline-secondary addban border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=2;iscast_movies2=true;is_expanded2=true;toggle_collapse('collapseMovies2', 'expand');" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addban border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1;is_expanded2=false;iscast_movies2=false;toggle_collapse('collapseMovies2', 'collapse');scroll_to_top('scroll_to_top2');" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div class="container-fluid" ng-show="iscast_movies2">
		@if(Auth::check())
		<div class="dropdown d-inline" ng-show="page_variables.active_tab_2=='on air'">
			<button class="btn btn-outline-secondary dropdown-toggle mt-3 mr-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-filter"></i>
				<span ng-show="page_variables.f_watch_later2=='watch later'">{{ __('general.watch_later') }}</span>
				<span ng-show="page_variables.f_watch_later2=='all'">{{ __('general.all_series') }}</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="page_variables.f_watch_later2='watch later';get_first_page_data(2);">{{ __('general.watch_later') }}</button>
				<button class="dropdown-item" ng-click="page_variables.f_watch_later2='all';get_first_page_data(2);">{{ __('general.all_series') }}</button>
			</div>
		</div>
		<div class="dropdown d-inline" ng-show="page_variables.active_tab_2!='on air'">
			<button class="btn btn-outline-secondary dropdown-toggle mt-3 mr-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-filter"></i>
				<span ng-show="page_variables.f_following2=='following'">{{ __('general.followings') }}</span>
				<span ng-show="page_variables.f_following2=='all'">{{ __('general.all_users') }}</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="page_variables.f_following2='following';get_first_page_data(2);">{{ __('general.followings') }}</button>
				<button class="dropdown-item" ng-click="page_variables.f_following2='all';get_first_page_data(2);">{{ __('general.all_users') }}</button>
			</div>
		</div>
		@endif
		<div class="dropdown d-inline" ng-show="page_variables.active_tab_2!='on air'">
			<button class="btn btn-outline-secondary dropdown-toggle mr-2 mt-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-sort-amount-down"></i>
				<span ng-show="page_variables.f_sort2=='newest'">{{ __('general.latest_vote') }}</span>
				<span ng-show="page_variables.f_sort2=='most voted'">{{ __('general.most_voted') }}</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="page_variables.f_sort2='newest';get_first_page_data(2);">{{ __('general.latest_vote') }}</button>
				<button class="dropdown-item" ng-click="page_variables.f_sort2='most voted';get_first_page_data(2);">{{ __('general.most_voted') }}</button>
			</div>
		</div>
	</div>
	<div ng-show="similar_movies2.length>0">
    @include('layout.moviecard_6', ['suffix' => '2'])
	</div>
</div>
<div ng-show="page_variables.expanded==-1">
<!-- @yield('amazon_affiliate_2') -->
</div>
<div class="mt-4" ng-show="page_variables.expanded==-1 || page_variables.expanded==3" id="scroll_to_top3" ng-cloak>
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
			<div class="dropdown d-inline">
			    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_3='born today'">
				    <span class="h5" ng-show="page_variables.active_tab_3=='born today'">{{ __('general.people') }}: {{ __('general.born_today') }}</span>
				    <span class="h5" ng-show="page_variables.active_tab_3=='died today'">{{ __('general.people') }}: {{ __('general.died_today') }}</span>
				    <span class="h5" ng-show="page_variables.active_tab_3=='most popular'">{{ __('general.people') }}: {{ __('general.most_populer') }}</span>
			    </button>
			    <div class="dropdown-menu">
			        <button class="dropdown-item" ng-click="page_variables.active_tab_3='born today';get_first_page_data(3);">{{ __('general.born_today') }}</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_3='died today';get_first_page_data(3);">{{ __('general.died_today') }}</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_3='most popular';get_first_page_data(3);">{{ __('general.most_populer') }}</button>
			    </div>
			</div>
		</div>
		<button class="btn btn-outline-secondary addban border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=3;iscast3=true;is_expanded3=true;toggle_collapse('collapseCast3', 'expand');" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addban border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1;iscast3=false;is_expanded3=false;toggle_collapse('collapseCast3', 'collapse');scroll_to_top('scroll_to_top3');" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div ng-show="people3.length>0">
    @include('layout.peoplecard_6', ['suffix' => '3'])
	</div>
</div>
<div ng-show="page_variables.expanded==-1">
<!-- @yield('amazon_affiliate_3') -->
</div>
<div class="mt-4" ng-show="page_variables.expanded==-1 || page_variables.expanded==4" id="scroll_to_top4" ng-cloak>
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
			<div class="dropdown d-inline">
			    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_4='list'">
				    <span class="h5" ng-show="page_variables.active_tab_4=='comment'">{{ __('general.users') }}: {{ __('general.most_liked_commenters') }}</span>
				    <span class="h5" ng-show="page_variables.active_tab_4=='list'">{{ __('general.users') }}: {{ __('general.most_liked_list_creators') }}</span>
				    <span class="h5" ng-show="page_variables.active_tab_4=='follow'">{{ __('general.users') }}: {{ __('general.most_followed') }}</span>
			    </button>
			    <div class="dropdown-menu">
			        <button class="dropdown-item" ng-click="page_variables.active_tab_4='comment';get_first_page_data(4);">{{ __('general.most_liked_commenters') }}</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_4='list';get_first_page_data(4);">{{ __('general.most_liked_list_creators') }}</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_4='follow';get_first_page_data(4);">{{ __('general.most_followed') }}</button>
			    </div>
			</div>
		</div>
		<button class="btn btn-outline-secondary addban border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=4;iscast4=true;is_expanded4=true;toggle_collapse('collapseMovies4', 'expand');" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addban border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1;iscast4=false;is_expanded4=false;toggle_collapse('collapseMovies4', 'collapse');scroll_to_top('scroll_to_top4');" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div class="container-fluid" ng-show="iscast4">
		@if(Auth::check())
		<div class="dropdown d-inline">
			<button class="btn btn-outline-secondary dropdown-toggle mt-3 mr-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.f_following4='all'">
				<i class="fa fa-filter"></i>
				<span ng-show="page_variables.f_following4=='following'">{{ __('general.followings') }}</span>
				<span ng-show="page_variables.f_following4=='follower'">{{ __('general.followers') }}</span>
				<span ng-show="page_variables.f_following4=='all'">{{ __('general.all_users') }}</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="page_variables.f_following4='following';get_first_page_data(4);">{{ __('general.followings') }}</button>
				<button class="dropdown-item" ng-click="page_variables.f_following4='follower';get_first_page_data(4);">{{ __('general.followers') }}</button>
				<button class="dropdown-item" ng-click="page_variables.f_following4='all';get_first_page_data(4);">{{ __('general.all_users') }}</button>
			</div>
		</div>
		@endif
	</div>
	<div ng-show="users4.length>0">
    @include('layout.userscard_6', ['suffix' => '4'])
	</div>
</div>
<div ng-show="page_variables.expanded==-1">
<!-- @yield('amazon_affiliate_4') -->
</div>
<div class="mt-4" ng-show="page_variables.expanded==-1 || page_variables.expanded==5" id="scroll_to_top5" ng-cloak>
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
			<div class="dropdown d-inline">
			    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_5='newest'">
			    <span class="h5" ng-show="page_variables.active_tab_5=='newest'">{{ __('general.reviews') }}: {{ __('general.newest') }}</span>
			    <span class="h5" ng-show="page_variables.active_tab_5=='most liked'">{{ __('general.reviews') }}: {{ __('general.most_liked') }}</span>
			    </button>
			    <div class="dropdown-menu">
			        <button class="dropdown-item" ng-click="page_variables.active_tab_5='newest';get_first_page_data(5);">{{ __('general.newest') }}</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_5='most liked';get_first_page_data(5);">{{ __('general.most_liked') }}</button>
			    </div>
			</div>
		</div>
		<button class="btn btn-outline-secondary addban border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=5;iscast_movies5=true;is_expanded5=true;toggle_collapse('collapseMovies5', 'expand');" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addban border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1;iscast_movies5=false;is_expanded5=false;toggle_collapse('collapseMovies5', 'collapse');scroll_to_top('scroll_to_top5');" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div class="container-fluid" ng-show="iscast_movies5">
		@if(Auth::check())
		<div class="dropdown d-inline">
			<button class="btn btn-outline-secondary dropdown-toggle mt-3 mr-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.f_following5='all'">
				<i class="fa fa-filter"></i>
				<span ng-show="page_variables.f_following5=='following'">{{ __('general.followings') }}</span>
				<span ng-show="page_variables.f_following5=='all'">{{ __('general.all_users') }}</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="page_variables.f_following5='following';get_first_page_data(5);">{{ __('general.followings') }}</button>
				<button class="dropdown-item" ng-click="page_variables.f_following5='all';get_first_page_data(5);">{{ __('general.all_users') }}</button>
			</div>
		</div>
		@endif
	</div>
	<div ng-show="reviews5.length>0">
    @include('layout.reviews_6', ['suffix' => '5'])
	</div>
</div>
<div ng-show="page_variables.expanded==-1">
<!-- @yield('amazon_affiliate_5') -->
</div>
<div class="mt-4" ng-show="page_variables.expanded==-1 || page_variables.expanded==6" id="scroll_to_top6" ng-cloak>
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
			<div class="dropdown d-inline">
			    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_6='newest'">
			    <span class="h5" ng-show="page_variables.active_tab_6=='newest'">{{ __('general.lists') }}: {{ __('general.newest') }}</span>
			    <span class="h5" ng-show="page_variables.active_tab_6=='most liked'">{{ __('general.lists') }}: {{ __('general.most_liked') }}</span>
			    </button>
			    <div class="dropdown-menu">
			        <button class="dropdown-item" ng-click="page_variables.active_tab_6='newest';;get_first_page_data(6);">{{ __('general.newest') }}</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_6='most liked';;get_first_page_data(6);">{{ __('general.most_liked') }}</button>
			    </div>
			</div>
		</div>
		<button class="btn btn-outline-secondary addban border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=6;iscast6=true;is_expanded6=true;toggle_collapse('collapseMovies6', 'expand');" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addban border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1;iscast6=false;is_expanded6=false;toggle_collapse('collapseMovies6', 'collapse');scroll_to_top('scroll_to_top6');" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div class="container-fluid" ng-show="iscast6">
		@if(Auth::check())
		<div class="dropdown d-inline">
			<button class="btn btn-outline-secondary dropdown-toggle mt-3 mr-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.f_following6='all'">
				<i class="fa fa-filter"></i>
				<span ng-show="page_variables.f_following6=='following'">{{ __('general.followings') }}</span>
				<span ng-show="page_variables.f_following6=='all'">{{ __('general.all_users') }}</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="page_variables.f_following6='following';get_first_page_data(6);">{{ __('general.followings') }}</button>
				<button class="dropdown-item" ng-click="page_variables.f_following6='all';get_first_page_data(6);">{{ __('general.all_users') }}</button>
			</div>
		</div>
		@endif
	</div>
	<div ng-show="listes6.length>0">
		@include('layout.listcard_6', ['suffix' => '6'])
	</div>
</div>
@endsection