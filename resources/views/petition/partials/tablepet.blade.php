<table id="table_petition" class="table table-striped">
    <thead>
      <tr>
        <th class="navbar-custom">Суть звернення</th>
        <th class="text-center navbar-custom">Залишилося днів</th>
        <th class="text-center navbar-custom">Зібрано підписів</th>
        <th class="text-center navbar-custom">Виконано</th>
      </tr>
    </thead>
    <tbody>
      	@foreach ($petitions as $petition)
        <tr>
            <td>  <a class="pull-left" href="{{ route('petition.item', [
            'id' => $petition->id ]) }}">{{ $petition->title }}</a>&nbsp; @if(Auth::check())  @if (Auth::user()->hasPetSignUser($petition->id, Auth::user()->id)) <span class="label label-success">Петиція підписана!</span> @endif @endif </td>
            <td class="text-center">{{ $petition->days}}</td>
            <td class="text-center">{{ $petition->count_signs }}</td>
            <td class="text-center">
              <input name="supervisor" type="checkbox" @if ( $petition->done==1 ) checked="checked" @endif />
              </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $petitions->render() !!}
