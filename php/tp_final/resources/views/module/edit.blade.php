@extends('base')
@section('page-title')
Edit Module
@endsection

@section('page-content')
<form action="{{ route('modules.update', ['module' => $module]) }}" method="POST">
@csrf
@method('PUT')

<div class="nes-field mt-2">
  <label for="name">Module name</label>
  <input type="text" id="name" name="name" class="nes-input" required value="{{ $module->name }}">
</div>
<div class="nes-field mt-2">
  <label for="description">Module Description</label>
  <textarea rows="4" id="description" name="description" class="nes-textarea" required>{{$module->description}}</textarea>
</div>


@if (sizeof($promos ?? []) > 0)
<div class="nes-field mt-2">
  <h4>Promos</h4>
  @foreach($promos as $promo)
      <label>
        <input 
        @foreach($module->promos as $mp)
          @if($mp->id == $promo->id) checked @endif
        @endforeach
        type="checkbox" class="nes-checkbox" id="promo-{{ $promo->id }}" value="{{ $promo->id }}" name="promos[]"/>
        <span>{{ $promo->name }} - {{ $promo->specialty }}</span>
      </label>
  @endforeach
</div>
@endif


@if (sizeof($students ?? []) > 0)
<div class="nes-field mt-2">
  <h4>Students:</h4>
  @foreach($students as $student)
      <label>
        <input 
        @foreach($module->students as $ms)
          @if($ms->id == $student->id) checked @endif
        @endforeach
        type="checkbox" class="nes-checkbox" id="student-{{ $student->id }}" value="{{ $student->id }}" name="students[]"/>
        <span>{{ $student->name }} {{ $student->surname }} ({{ $student->email }})</span>
      </label>
  @endforeach
</div>
@endif


<div class="nes-field mt-2">
  <button type="submit" class="nes-btn is-success">Update</button>
</div>
  

</form>
@endsection