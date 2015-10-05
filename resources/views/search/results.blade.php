@extends('templates.default')

@section('content')
	<h3>Ви шукали "{{ Request::input('query') }}"</h3>
	@if (!$petitions)
		<p>Нічого не знайшли.</p>
	@else
		<div class="row">
			<div class="col-lg-12">
			@foreach ($petitions as $petition)
				@include('petition/partials/tablepet')
			@endforeach
			</div>

		</div>
	@endif
@stop
