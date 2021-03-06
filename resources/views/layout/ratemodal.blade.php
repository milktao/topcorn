<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" ng-cloak>
	<div class="votecard modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="card">
				<img class="card-img" ng-src="{{config('constants.image.rate_modal')[$image_quality]}}@{{modalmovie.poster_path}}" on-error-src="{{config('constants.image.rate_modal_error')}}" alt="Card image">
				<div class="card-img-overlay p-2">
					<div class="text-center h-100 d-flex flex-column justify-content-between">
						<div class="d-flex flex-row justify-content-between">
							<div class="faderdiv">
							</div>
							<div class="faderdiv">
								<div class="h4 mr-3" data-toggle="tooltip" data-placement="top" data-original-title="@{{modalmovie.original_title.length>0?modalmovie.original_title:modalmovie.original_name}}"><a ng-href="/@{{modalmovie.title.length>0?'movie':'series'}}/@{{modalmovie.id}}" target={{$target}}><span class="badge btn-verydark yeswrap text-white">@{{modalmovie.title.length>0?modalmovie.title:modalmovie.name}} <small class="text-muted d-block pt-1" ng-if="modalmovie.release_date.length > 0"><em>(@{{modalmovie.release_date.substring(0, 4)}})</em></small><small class="text-muted d-block pt-1" ng-if="modalmovie.first_air_date.length > 0"><em>(@{{modalmovie.first_air_date.substring(0, 4)}})</em></small></span></a></div>
							</div>
							<div class="faderdiv">
								<button type="button" class="btn btn-verydark btn-lg float-right border-circle text-white" data-dismiss="modal" data-backdrop="false" aria-label="Close">
									<span><i class="fa fa-times"></i></span>
								</button>
							</div>
						</div>
						<div class="d-flex flex-column votediv">
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-success btn-lg" ng-class="{'bordered_button':modalmovie.rate_code==5}" ng-click="modalmovie.is_quick_rate ? quick_rate(5) : rate(modalmovie.index, 5)">{{ __('general.definitely_recommend') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-info btn-lg" ng-class="{'bordered_button':modalmovie.rate_code==4}" ng-click="modalmovie.is_quick_rate ? quick_rate(4) : rate(modalmovie.index, 4)">{{ __('general.recommend') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-secondary btn-lg" ng-class="{'bordered_button':modalmovie.rate_code==3}" ng-click="modalmovie.is_quick_rate ? quick_rate(3) : rate(modalmovie.index, 3)">{{ __('general.not_sure') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-warning btn-lg" ng-class="{'bordered_button':modalmovie.rate_code==2}" ng-click="modalmovie.is_quick_rate ? quick_rate(2) : rate(modalmovie.index, 2)">{{ __('general.dont_recommend') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="d-flex flex-row justify-content-between mt-2" ng-if="!(modalmovie.is_quick_rate && previous_quick_rate_movie)">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-danger btn-lg" ng-class="{'bordered_button':modalmovie.rate_code==1}" ng-click="modalmovie.is_quick_rate ? quick_rate(1) : rate(modalmovie.index, 1)">{{ __('general.definitely_dont_recommend') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="row mt-2 align-items-end" ng-if="modalmovie.is_quick_rate && previous_quick_rate_movie">
								<div class="col-2 faderdiv">
									<button type="button" class="btn btn-verydark btn-lg float-left text-white" ng-click="previous_quick_rate()">
										<i class="fa fa-undo"></i>
									</button>
								</div>
								<div class="col-8 faderdiv">
									<button class="btn btn-danger btn-lg" ng-class="{'bordered_button':modalmovie.rate_code==1}" ng-click="modalmovie.is_quick_rate ? quick_rate(1) : rate(modalmovie.index, 1)">{{ __('general.definitely_dont_recommend') }}</button>
								</div>
								<div class="col-2"></div>
							</div>
						</div>
						<div class="d-flex flex-row justify-content-between align-items-end">
							<div class="faderdiv">
								<button type="button" class="btn btn-verydark btn-lg float-left border-circle text-white" ng-class="modalmovie.later_id!=null ? 'text-warning' : 'text-white'" ng-show="modalmovie.is_quick_rate" ng-click="modalmovie.is_quick_rate ? quick_later() : later(modalmovie.index)" data-toggle="tooltip" data-placement="bottom" title="{{ __('general.tooltip_watchlater') }}">
									<span ng-show="modalmovie.later_id!=null"><i class="fas fa-clock"></i></span><span ng-show="modalmovie.later_id==null"><i class="far fa-clock"></i></span>
								</button>
							</div>
							<div class="faderdiv">
								<button class="btn btn-verydark btn-lg border-circle text-white" ng-click="modalmovie.is_quick_rate ? quick_rate(0) : rate(modalmovie.index, null)">{{ __('general.havent_seen') }}</button>
							</div>
							<div class="faderdiv">
								<button type="button" class="btn btn-verydark btn-lg float-left border-circle" ng-class="modalmovie.ban_id!=null ? 'text-danger' : 'text-white'" ng-show="modalmovie.is_quick_rate" ng-click="modalmovie.is_quick_rate ? quick_ban() : ban(modalmovie.index)" data-toggle="tooltip" data-placement="bottom" title="{{ __('general.tooltip_ban') }}">
									<i class="fa fa-ban"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<img class="d-none" ng-src="{{config('constants.image.rate_modal')[$image_quality]}}@{{next_modalmovie.poster_path}}" on-error-src="{{config('constants.image.rate_modal_error')}}" alt="Card image">

<div class="modal fade" id="quick_vote_movies_or_series" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">{{ __('navbar.sequentialvote') }}</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addban" ng-click="quick_vote_mode='movies';quickvote()">{{ __('general.p_movies') }}</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addban" ng-click="quick_vote_mode='series';quickvote()">{{ __('general.p_series') }}</button>
			</div>
		</div>
	</div>
</div>