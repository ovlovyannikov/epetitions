@extends('templates.default')

@section('content')
	     <div class="row">
              <div class="col-lg-5">
                  @include('user.partials.userblock')
                  <hr>

									@if (!$statuses->count())
							      <p>{{ $user->getFirstNameOrUsername() }} нічого не опублікував.</p>
							    @else

									@foreach ($statuses as $status)
						      <div class="media">
						                <a class="pull-left" href="{{ route('profile.index'), [
						                'username' => $status->user->username
						                ] }}">
						                    <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}"
						                    src="{{ $status->user->getAvatarUrl() }}">
						                </a>
						                <div class="media-body">
						                    <h4 class="media-heading"><a href="{{ route('profile.index',
						                      ['username' => $status->user->username]) }}">{{ $status->user->getNameOrUsername() }}</a></h4>
						                    <p>{{ $status->body }}</p>
						                    <ul class="list-inline">
						                        <li>{{ $status->created_at->diffForHumans() }}</li>
																		@if ($status->user->id !== Auth::user()->id)
						                            <li><a href="{{ route('status.like', [
						                            'statusId' => $status->id
						                            ]) }}">Подобається</a></li>
																		@endif
						                            <li>{{ $status->likes->count() }} {{ str_plural('like', $status->likes->count() ) }}</li>
						                    </ul>

						                    @foreach ($status->replies as $reply)
						                    <div class="media">
						                        <a class="pull-left" href="{{ route('profile.index', [
						                        'username' => $reply->user->username
						                        ]) }}">
						                            <img class="media-object" alt="{{ $reply->user->getNameOrUsername() }}"
						                            src="{{ $reply->user->getAvatarUrl() }}">
						                        </a>
						                        <div class="media-body">
						                            <h5 class="media-heading"><a href="{{ route('profile.index', [
						                            'username' => $reply->user->username
						                            ]) }}">{{ $reply->user->getNameOrUsername() }}</a></h5>
						                            <p>{{ $reply->body }}</p>
						                            <ul class="list-inline">
						                                <li>{{ $reply->created_at->diffForHumans() }}</li>
																						@if ($reply->user->id !== Auth::user()->id)
						                                    <li><a href="{{ route('status.like', [
										                            'statusId' => $reply->id
										                            ]) }}">Like</a></li>
																						@endif
						                                    <li>{{ $reply->likes->count() }} {{ str_plural('like', $reply->likes->count() ) }}</li>

						                            </ul>
						                        </div>
						                    </div>
						                    @endforeach

																@if ($authUserIsFriend || Auth::user()->id === $status->user->id)
									                    <form role="form" action="{{ route('status.reply',
									                    ['statusId' => $status->id] ) }}" method="post">
									                        <div class="form-group{{ $errors->has("reply-{$status->id}") ?
									                            ' has-error' : '' }}">
									                            <textarea name="reply-{{ $status->id }}" class="form-control"
									                              rows="2" placeholder="Відповідь на статус"></textarea>
									                            @if ($errors->has("reply-{$status->id}"))
									                              <span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
									                            @endif
									                        </div>
									                        <input type="submit" value="Відповісти" class="btn btn-default btn-sm">
									                        <input type="hidden" name="_token" value="{{ Session::token() }}">
									                    </form>
																@endif
						                </div>
						      </div>
						      @endforeach

									@endif

              </div>
              <div class="col-lg-4 col-lg-offset-3">
									@if (Auth::user()->hasFriendRequestsPending($user))
											<p> Чекаємо на підтвердження від {{ $user->getFirstNameOrUsername() }} </p>
									@elseif (Auth::user()->hasFriendRequestReceived($user))
											<a href="{{ route('friend.accept', ['username' => $user->username]) }}" class="btn btn-primary">Підтвердити запит</a>
									@elseif (Auth::user()->isFriendWith($user))
											<p>Ви та {{ $user->getNameOrUsername() }} друзі.</p>
									@elseif (Auth::user()->id !== $user->id)
											<a href="{{ route('friend.add', ['username' => $user->username]) }}" class="btn btn-primary">Додати друга</a>
									@endif

									<h4> Друзі {{ $user->getFirstNameOrUsername() }}а</h4>
									@if (!$user->friends()->count())
										<p>{{ $user->getFirstNameOrUsername() }} не має друзів.</p>
									@else
										@foreach ($user->friends() as $user)
											@include('user/partials/userblock')
										@endforeach
									@endif
              </div>
       </div>
@stop
