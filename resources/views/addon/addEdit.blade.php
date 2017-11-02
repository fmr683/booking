

@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h2>Extras</h2>
    </div>

 <div class="card-body card-padding">

{!! Form::open(array('route' => array($action["action"], (!empty($addon->id) ? $addon->id : '' )),
 'class' => 'form', 'method' => $action["method"])) !!}

 <div class="form-group fg-line">
      <label for="name">Extras Name</label>
      <input type="text"  name="add_name" value="{{ $addon->add_name or '' }}" class="form-control input-sm" id="add_name" placeholder="Extras Name" required>
  </div>

 <div class="form-group fg-line" >
   <p class="f-500 c-black m-b-15">Day Type</p>
          <select class="chosen" data-placeholder="Choose Day Type" name="day_type" required>
           @foreach(dayTypes() as $key => $dayType)
            <option value="{{$key}}" {{ (!empty($addon) && $addon->day_type == $key ? 'selected' : '')  }}>{{$dayType}}</option>
          @endforeach
        </select>
    </div>

 <div class="form-group fg-line">
      <label for="name">Extras price</label>
      <input type="number"  name="price" value="{{ $addon->price or '' }}" class="form-control input-sm" id="price" placeholder="Addon Price" required>
  </div>


   <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
{!! Form::close() !!}

@if (!empty($addon->id)) 
<br/>
  <div class="row">
    <div class="col-sm-10 col-xs-6">  <div class="alert alert-warning" role="alert">If there are bookings attached to <b>{{ $addon->add_name or '' }}</b>, then if you delete it; related booking will not appear</b> </div></div>
    <div class="col-sm-2 col-xs-6">
{!! Form::open(array('route' => array($action["action"], !empty($addon->id) ? $addon->id : '' ),
 'class' => 'form', 'method' => 'DELETE')) !!}
  <button type="submit" class="btn btn-danger btn-sm m-t-10">Delete</button>
{!! Form::close() !!}
</div>
  </div>

@endif

  </div>
</div>

@endsection