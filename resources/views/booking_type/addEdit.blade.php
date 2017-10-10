
@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h2>Booking Types</h2>
    </div>

 <div class="card-body card-padding">
 
  {!! Form::open(array('route' => array($action["action"], (!empty($bookingType->id) ? $bookingType->id : '' )),
  'class' => 'form', 'method' => $action["method"])) !!}

   <div class="form-group fg-line">
        <label for="name">Hall Name</label>
        <input type="text" name="name" class="form-control input-sm" value="{{ $bookingType->name or '' }}" id="name" placeholder="Hall Name" required>
    </div>

     <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
  {!! Form::close() !!}

  @if (!empty($bookingType->id)) 

  <div class="row">
    <div class="col-sm-10 col-xs-6"></div>
    <div class="col-sm-2 col-xs-6"> {!! Form::open(array('route' => array($action["action"], !empty($bookingType->id) ? $bookingType->id : '' ),
    'class' => 'form', 'method' => 'DELETE')) !!}
      <button type="submit" class="btn btn-danger btn-sm m-t-10">Delete</button>
    {!! Form::close() !!}
    </div>
  </div>
 
  </div>
</div>

@endif

@endsection