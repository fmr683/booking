
@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h2>User</h2>
    </div>

 <div class="card-body card-padding">

{!! Form::open(array('route' => array($action["action"], (!empty($user->id) ? $user->id : '' )),
 'class' => 'form', 'method' => $action["method"])) !!}

<div class="form-group fg-line">
      <label for="name">Name</label>
      <input type="text"  name="name" value="{{ $user->name or '' }}" class="form-control input-sm" id="name" placeholder="Name" required>
  </div>

  <div class="form-group fg-line">
      <label for="name">Email</label>
      <input type="email"  name="email" value="{{ $user->email or '' }}" class="form-control input-sm" id="email" placeholder="Email" required>
  </div>

  <div class="form-group fg-line">
      <label for="name">Password</label>
      <input type="password"  name="password" value="" class="form-control input-sm" id="password" placeholder="Password">
  </div>

  <div class="form-group fg-line">
      <label for="name">Re-Password</label>
      <input type="password"  name="re_password" value="" class="form-control input-sm" id="re_password" placeholder="Re-password">
  </div>

   <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
{!! Form::close() !!}

@if (!empty($user->id)) 

  <div class="row">
    <div class="col-sm-10 col-xs-6"></div>
    <div class="col-sm-2 col-xs-6">
{!! Form::open(array('route' => array($action["action"], !empty($user->id) ? $user->id : '' ),
 'class' => 'form', 'method' => 'DELETE')) !!}
  <button type="submit" class="btn btn-danger btn-sm m-t-10">Delete</button>
{!! Form::close() !!}
</div>
  </div>


@endif

  </div>
</div>

@endsection