MyApp.controller('CreatelistPageController', function($scope, $http, $timeout, rate, $window)
{
	$scope.confirm_delete = function(list_id, message){
		var r = confirm(message);
		if (r == true) {
		    $window.location.href = '/deletelist/'+list_id;
		}
	}
	
	$scope.movies = pass.movies == '[]' ? []:pass.movies;

	$scope.search_movie = function(movie){
		if(movie.input==undefined) return;
		var temp=movie.input.replace(/ /g , "%20");
		movie.movie_title='';
		movie.movie_id='';
		movie.poster_path='';
		if(temp.length == 0){
			movie.movies='';
		}else{
			rate.search_movies(pass.constants_api_key, pass.lang, temp, 1, movie.mode != 1 ? 'movies':'tv')
			.then(function(response){
				console.log(response.data);
				movie.movies=response.data.results.slice(0, 10);
			});
		}
	}

	$scope.choose_movie = function(index, movie, mode){
		console.log(index, movie);
		rate.suck_movie_series(movie.id, movie.mode);
		$scope.movies[index].movie_id=movie.id;
		$scope.movies[index].searchmode=false;
		$scope.movies[index].overview=movie.overview;
		$scope.movies[index].poster_path=movie.poster_path;
		$scope.movies[index].movie_title=mode!=1?(movie.title + (movie.release_date.length > 0 ? ' ('+movie.release_date.substring(0, 4)+')' : '')):(movie.name + (movie.first_air_date.length > 0 ? ' ('+movie.first_air_date.substring(0, 4)+')' : ''));
	}

	$scope.refresh_list = function(){
		if($scope.movies.length == 0){
			$scope.movies.push( {
				'position':1,
				'movie_title':'',
				'movie_id':'',
				'poster_path':'',
				'user_text':'',
				'overview':''
			} );
		}
		console.log($scope.movies)
	}
	$scope.refresh_list();

	$scope.set_focus = function(index){
		console.log(index)
		$timeout(function () {
	       angular.element('#back_of_vitrin_'+index).focus();
	    });
	}

	$scope.new_list = function(){
		$scope.movies.push( {
			'position':$scope.movies.length+1,
			'movie_title':'',
			'movie_id':'',
			'poster_path':'',
			'user_text':'',
			'overview':''
		} );
	}

	$scope.remove_from_list = function(index){
		$scope.movies.splice(index, 1);
		console.log(index, $scope.movies)
		$scope.refresh_list();
	}

	if(pass.is_auth==1){
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// QUICK RATE /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.first_quick_vote=function()
	{
		$('#quick_vote_movies_or_series').modal('show');
	};

	$scope.quickvote=function()
	{
		$('#quick_vote_movies_or_series').modal('hide');
		$scope.get_quick_rate();
		$('#myModal').modal('show');
	};

	$scope.get_quick_rate=function()
	{
		if($scope.quick_vote_mode == 'movies'){
			f1 = 'get_quick_rate';
		}else{
			f1 = 'get_quick_rate_series';
		}
		rate[f1](pass.lang)
		.then(function(response){
			console.log(response.data)
			if(response.data.length>0){
				$scope.modalmovies=response.data;
				$scope.next_quick_rate();
				$("body").tooltip({ selector: '[data-toggle=tooltip]' });
			}else{
				$('#myModal').modal('hide');
			}
		});
	};
	$scope.quick_vote_mode='movies';
	$scope.get_quick_rate();

	$scope.next_quick_rate=function()
	{
		if($scope.modalmovies.length>1){
			$scope.modalmovie = $scope.modalmovies[0];
			$scope.next_modalmovie = $scope.modalmovies[1];
			$scope.modalmovie.is_quick_rate=true;
		}else if($scope.modalmovies.length==1){
			$scope.modalmovie = $scope.modalmovies[0];
			$scope.modalmovie.is_quick_rate=true;
		}else{
			$scope.get_quick_rate();
		}
	};

	$scope.previous_quick_rate_movie=null;
	$scope.previous_quick_rate=function()
	{
		$scope.modalmovies.unshift($scope.previous_quick_rate_movie);
		$scope.modalmovie = $scope.previous_quick_rate_movie;
		$scope.previous_quick_rate_movie=null;
	};

	$scope.quick_later=function()
	{
		if($scope.quick_vote_mode == 'movies'){
			f1 = 'add_later';
			f2 = 'un_later';
			v1 = 'later_id';
		}else{
			f1 = 'series_add_later';
			f2 = 'series_un_later';
			v1 = 'id';
		}
		if($scope.modalmovie.later_id == null){
			rate[f1]($scope.modalmovie.id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.modalmovie.later_id=response.data.data[v1];
					$scope.modify_movies($scope.modalmovie);
				}
			});
		}else{
			rate[f2]($scope.modalmovie.later_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope.modalmovie.later_id=null;
					$scope.modify_movies($scope.modalmovie);
				}
			});
		}
	};

	$scope.quick_rate=function(rate_code)
	{
		console.log(rate_code)
		if($scope.quick_vote_mode == 'movies'){
			f1 = 'add_rate';
			f2 = 'un_rate';
			v1 = 'rated_id';
		}else{
			f1 = 'series_add_rate';
			f2 = 'series_un_rate';
			v1 = 'id';
		}
		if(rate_code != null){
			rate[f1]($scope.modalmovie.id, rate_code)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.modalmovie.rated_id=response.data.data[v1];
					$scope.modalmovie.rate_code=response.data.data.rate;
					$scope.previous_quick_rate_movie=$scope.modalmovies.shift();
					$(".tooltip").hide();
					$scope.modify_movies($scope.previous_quick_rate_movie);
					$scope.next_quick_rate();
					if(pass.tt_navbar < 100) $scope.get_watched_movie_number();
				}
			});
		}else if(rate_code == null){
			rate[f2]($scope.modalmovie.rated_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope.modalmovie.rated_id=null;
					$scope.modalmovie.rate_code=null;
					$scope.previous_quick_rate_movie=$scope.modalmovies.shift();
					$(".tooltip").hide();
					$scope.modify_movies($scope.previous_quick_rate_movie);
					$scope.next_quick_rate();
					if(pass.tt_navbar < 100) $scope.get_watched_movie_number();
				}
			});
		}
	};

	$scope.quick_ban=function()
	{
		if($scope.quick_vote_mode == 'movies'){
			f1 = 'add_ban';
			f2 = 'un_ban';
			v1 = 'ban_id';
		}else{
			f1 = 'series_add_ban';
			f2 = 'series_un_ban';
			v1 = 'id';
		}
		if($scope.modalmovie.ban_id == null){
			rate[f1]($scope.modalmovie.id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.modalmovie.ban_id=response.data.data[v1];
					$scope.modify_movies($scope.modalmovie);
				}
			});
		}else{
			rate[f2]($scope.modalmovie.ban_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope.modalmovie.ban_id=null;
					$scope.modify_movies($scope.modalmovie);
				}
			});
		}
	};

	$scope.modify_movies=function(movie){
		if(_.where($scope.movies, {id:movie.id}).length>0){
			temp=_.where($scope.movies, {id:movie.id})[0];
			temp.ban_id=movie.ban_id;
			temp.later_id=movie.later_id;
			temp.rated_id=movie.rated_id;
			temp.rate_code=movie.rate_code;
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// QUICK RATE /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	}



	if(pass.is_auth==1){
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// TUTORIAL ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
		$scope.watched_movie_number = pass.watched_movie_number;

		if(pass.tt_navbar < 100 || pass.tt_movie < 50){
			if(pass.tt_navbar<50){
				if(pass.tt_navbar==0)location.hash="tooltip-navbar-quickvote";
				else if(pass.tt_navbar==1)location.hash="tooltip-navbar-search";
				else if(pass.tt_navbar==2)location.hash="tooltip-navbar-recommendations";
				else if(pass.tt_navbar==3)location.hash="tooltip-navbar-profile";
				else if(pass.tt_navbar==4)location.hash="tooltip-navbar-percentage";
			}else if(location.href.indexOf('topcorn.xyz/movie/')>-1){
				if(pass.tt_movie<50){
					if(pass.tt_movie==0)location.hash="tooltip-movie-share";
					else if(pass.tt_movie==1)location.hash="tooltip-movie-search";
					else if(pass.tt_movie==2)location.hash="tooltip-movie-cast";
					else if(pass.tt_movie==3)location.hash="tooltip-movie-review";
				}
			}else if(pass.tt_navbar<100){
				if(pass.watched_movie_number>49&&pass.tt_navbar<70)location.hash="tooltip-footer-like";
				else if(pass.watched_movie_number>199)location.hash="tooltip-footer-donate";
			}

			window.addEventListener("hashchange", function(){ 
				console.log(location.hash)
				if(location.hash.indexOf('tooltip-navbar-quickvote')>-1){
					$("[data-toggle=popover]").popover('hide');
					$('#quickvote').popover('show');
				}else if(location.hash.indexOf('tooltip-navbar-search')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 1)
					.then(function(response){
						pass.tt_navbar=1;
						$('#search').popover('show');
					});
				}else if(location.hash.indexOf('tooltip-navbar-recommendations')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 2)
					.then(function(response){
						pass.tt_navbar=2;
						$('#recommendations').popover('show');
					});
				}else if(location.hash.indexOf('tooltip-navbar-profile')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 3)
					.then(function(response){
						pass.tt_navbar=3;
						$('#profile').popover('show');
					});
				}else if(location.hash.indexOf('tooltip-navbar-percentage')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 4)
					.then(function(response){
						pass.tt_navbar=4;
						if(pass.watched_movie_number<50) $('#percentage').popover('show');
						else location.hash="#navbar-tooltips-done";
					});
				}else if(location.hash.indexOf('navbar-tooltips-done')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 50)
					.then(function(response){
						pass.tt_navbar=50;
						if(location.href.indexOf('topcorn.xyz/movie')>-1) location.hash='#tooltip-movie-share';
					});
				}else if(location.hash.indexOf('tooltip-footer-like')>-1){
					$("[data-toggle=popover]").popover('hide');
					setTimeout(function() {
						$('#like').popover('show');
					}, 2500);
				}else if(location.hash.indexOf('tooltip-footer-donate')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 70)
					.then(function(response){
						pass.tt_navbar=70;
						if($scope.watched_movie_number>199){
							setTimeout(function() {
								$('#donate').popover('show');
							}, 2500);
						}
					});
				}else if(location.hash.indexOf('navbar-tooltips-all-done')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 100)
					.then(function(response){
						pass.tt_navbar=100;
					});
				}else if(location.hash.indexOf('cancel-tooltips')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 50)
					.then(function(response){
						pass.tt_navbar=50;
					});
					///////////////////MOVIE///////////////////////
				}else if(location.hash.indexOf('tooltip-movie-share')>-1){
					$("[data-toggle=popover]").popover('hide');
					setTimeout(function() {
						$('#share').popover('show');
					}, 2500);
				}else if(location.hash.indexOf('tooltip-movie-search')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('movie', 1)
					.then(function(response){
						pass.tt_movie=1;
						setTimeout(function() {
							$('#google').popover('show');
						}, 2500);
					});
				}else if(location.hash.indexOf('tooltip-movie-cast')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('movie', 2)
					.then(function(response){
						pass.tt_movie=2;
						setTimeout(function() {
							$('#cast').popover('show');
						}, 2500);
					});
				}else if(location.hash.indexOf('tooltip-movie-review')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('movie', 3)
					.then(function(response){
						pass.tt_movie=3;
						setTimeout(function() {
							$('#review').popover('show');
						}, 2500);
					});
				}else if(location.hash.indexOf('movie-tooltips-done')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('movie', 50)
					.then(function(response){
						pass.tt_movie=50;
					});
				}else if(location.hash.indexOf('cancel-movie-tooltips')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('movie', 60)
					.then(function(response){
						pass.tt_movie=60;
					});
					///////////////////MOVIE///////////////////////
				}else if(location.hash.indexOf('close-tooltip')>-1){
					$("[data-toggle=popover]").popover('hide');
				}
			}, false);
		}

		if(pass.tt_navbar < 100){
			console.log(pass)
			$scope.get_watched_movie_number = function(){
				rate.get_watched_movie_number()
				.then(function(response){
					console.log(response);
					$scope.watched_movie_number=response.data;
					if($scope.watched_movie_number<50) $scope.calculate_percentage();
					$scope.cry_for_help();
				});
			}

			$scope.cry_for_help = function(){
				if($scope.watched_movie_number>49 && pass.tt_navbar < 70) location.hash="tooltip-footer-like";
				else if($scope.watched_movie_number>199 && pass.tt_navbar < 100) location.hash="tooltip-footer-donate";
			}
			if(pass.tt_navbar>49)$scope.cry_for_help();

			$scope.calculate_percentage = function(){
				$scope.percentage = pass.lang=='tr' ? '%'+$scope.watched_movie_number*2 : $scope.watched_movie_number*2+'%';
			}
			$scope.calculate_percentage();
		}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// TUTORIAL ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	}
});