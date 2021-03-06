@layout('templates.main')
@section('content')
<div class="row boxback">
		<div class="col-md-2">
				<div class="sidebar">
					<h4>{{__('home.weare')}}.: {{User::count()}}</h4>  
					<h4>{{__('home.freelancers')}}.: {{User::where('freelancer', '=', 1)->count()}}</h4>
					<h4>{{__('users.new_users')}}</h4>
					@if ( Auth::guest() )
						{{HTML::link('connect/session/facebook', __('home.sign-up').' (Facebook)', array('class' => 'btn btn-sm btn-warning'))}}
						{{HTML::link('connect/session/github', '&nbsp;'. __('home.sign-up').' (Github) &nbsp;&nbsp;', array('class' => 'btn btn-sm btn-warning'))}}
						{{HTML::link('connect/session/linkedin', __('home.sign-up').' (Linkedin)', array('class' => 'btn btn-sm btn-warning'))}}
					@endif
					<p>{{__('users.about1')}}</p>
					<h4><span class="slash">{{__('users.new_users')}}</span></h4>
				<table>
					@foreach ($newUsers as $user)
					<tr>
						<td>
							<a href="{{URL::to('/users/'.$user->id)}}">
								{{HTML::image($user->getImageUrl('square'), $user->name, array('width' => 50, 'height'=>50, 'title' => $user->name))}}
							</a>
						</td>
						<td>
							@foreach ($user->partial_badges(1) as $badge)
								<a href="{{URL::to('/badges/'.$badge->id)}}">
									{{HTML::image('img/badges/'.$badge->image, $badge->name, array('width' => 50, 'height'=>50, 'title' => $badge->name))}}
								</a>
							@endforeach
							@for ($i = 1; $i <= (1-count($user->activebadges)); $i++)
								{{HTML::image('img/badges/unlock100.png', 'Unlock', array('width' => 50, 'height'=>50, 'title' => 'Unlock'))}}
							@endfor
						</td>
					</tr>
					@endforeach
				</table>

				<h4><span class="slash">{{__('badges.new_badges')}}</span></h4>
				<table>
					@foreach ($newBadges as $badge)
					
					<tr>
						<td>
							<a href="{{URL::to('/badges/'.$badge->id)}}">
								{{HTML::image('img/badges/'.$badge->image, $badge->name, array('width' => 50, 'height'=>50, 'title' => $badge->name))}}
							</a>
						</td>
					</tr>
					@endforeach
				</table>

				</div> <!-- /sidebar -->
		</div>
		<div class="col-md-10" id="container">
			@foreach ($topUsers as $topUser)
			<?php
				$user = User::find($topUser->id);
				$technology_points = count($user->technologies);
				?>
				<div class="box">
					<a href="{{URL::to('/users/'.$user->id)}}">
						{{HTML::image($user->getImageUrl('large'), $user->name, array('width'=>'200', 'class'=>'dev', 'title' => $user->name, 'id' => 'profilepicture'))}}
					</a>
					<p>{{HTML::link('/users/'.$user->id, $user->name)}}<p>

					<div class="progress">
					  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{$user->life*14.28}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$user->life*14.28}}%">
					    {{__('home.alwayshere')}} <span class="glyphicon glyphicon-heart"></span>
					  </div>
					</div>
					
					@foreach ($user->partial_badges(4) as $badge)
						<a href="{{URL::to('/badges/'.$badge->id)}}">
							{{HTML::image('img/badges/'.$badge->image, $badge->name, array('width' => 30, 'height'=>30, 'title' => $badge->name))}}
						</a>
					@endforeach
					@for ($i = 0; $i <= (3-count($user->activebadges)); $i++)
						{{HTML::image('img/badges/unlock100.png', 'Unlock', array('width' => 30, 'height'=>30, 'title' => 'Unlock'))}}
					@endfor				
					<div class="pull-right">
					@if (count($user->technologies) <= 19)
						{{HTML::image('img/browserquest/'.'level1-mini.png',  __('user.level').' 1', array('width' => 24, 'height'=>24, 'title' =>__('user.level').' 1'))}}
					@elseif (count($user->technologies) <= 79)
						{{HTML::image('img/browserquest/'.'level2-mini.png',  __('user.level').' 2', array('width' => 24, 'height'=>24, 'title' => __('user.level').' 2'))}}					
					@elseif (count($user->technologies) <= 219)
						{{HTML::image('img/browserquest/'.'level3-mini.png',  __('user.level').' 2', array('width' => 24, 'height'=>24, 'title' => __('user.level').' 2'))}}					
					@else
						{{HTML::image('img/browserquest/'.'level4-mini.png',  __('user.level').' 3', array('width' => 24, 'height'=>24, 'title' => __('user.level').' 3'))}}
					@endif
						{{count($user->technologies)}} {{HTML::image('img/coin16.png', 'Coin')}}
					</div>
				</div>
			@endforeach
		</div>
	</div>	
@endsection