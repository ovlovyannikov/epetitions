@extends('templates.default')

@section('content')
<div class="row">
      <div class="col-lg-8">
        <div class="petition">
            <p>СУТЬ ЗВЕРНЕННЯ:</p>
            <h3 class="petition_title" style="margin-top: 10px;">{{ $petition->title }}</h3>
            <br />
            <p>АВТОР: {{ $petition->author }}</p>
            <p>СТАТУС: {{ $petition->status_name }}</p>
            <p>ДАТА ПОЧАТКУ ЗБОРУ ПІДПИСІВ: {{ $petition->created_at }}</p>
            <br />
            <p>ТЕКСТ ЕЛЕКТРОННОЇ ПИТИЦІЇ:</p>
            <p>{{ $petition->body }}</p>
            <br />
            @if($petition->answer)
                <p>ВІДПОВІДЬ:</p>
                <p>{{ $petition->answer }}</p>
                <br />
            @endif
            <p>ПЕРЕЛІК ОСІБ, ЯКІ ПІДПИСАЛИ ЕЛЕКТРОННУ ПЕТИЦІЮ:</p>
            <ul>
              @foreach ($signs as $sign)
                <li>{{ $sign->author }} (дата підпису: {{ $sign->created_at }})</li>
              @endforeach
            <ul>
        </div>
      </div>

      <div class="col-lg-4">
            <p class="text-center">ЗАГАЛЬНА КІЛЬКІСТЬ ОСІБ, ЯКІ ПІДПИСАЛИ ЕЛЕКТРОННУ ПЕТИЦІЮ:</p>
            <h3 class="text-center petition_body" style="margin-top: 10px;">{{ $petition->count_signs }} з 200 необхідних</h3>

            <p class="text-center">ДО КІНЦЯ ЗБОРУ ПІДПИСІВ ЗАЛИШИЛОСЯ (ДНІВ):</p>
            <h3 class="text-center petition_days" style="margin-top: 10px;">{{ $petition->days }}</h3>

              @if(!Auth::check())
                <div class="text-center alert alert-danger" role="alert">
                  Для того, щоб підтримати петицію, необхідно
                  <a href="{{ route('auth.signin') }}">авторизуватися</a>.
                </div>              
              @else
                  <p class="text-center">ПІДТРИМАТИ ЕЛЕКТРОННУ ПЕТИЦІЮ:</p>							  	
					
					  @if (Auth::user()->hasPetSignUser($petition->id, Auth::user()->id))
						  <div class="text-center alert alert-success" role="alert">
								Ви вже підтримали цю петицію.						
						  </div> 
					  @else
						  <p class="text-center">
							  <a href="{{ route('petition.sign', ['petitionId' => $petition->id]) }}"
								class="btn btn-primary btn-lg active" role="button">ПІДПИСАТИ</a>
						  </p>                
					  @endif					
				  
              @endif


      </div>
</div>
@stop
