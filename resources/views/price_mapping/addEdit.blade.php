
@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h2>Price Mappings</h2>
    </div>

 <div class="card-body card-padding">
{!! Form::open(array('route' => array($action["action"], (!empty($priceMapping->id) ? $priceMapping->id : '' )),
 'class' => 'form', 'method' => $action["method"])) !!}

   <div class="form-group fg-line" >
   <p class="f-500 c-black m-b-15">Day Type</p>
          <select class="chosen" data-placeholder="Choose Day Type" name="day_type" required>
           @foreach(dayTypes() as $key => $dayType)
            <option value="{{$key}}" {{ (!empty($priceMapping) && $priceMapping->day_type == $key ? 'selected' : '')  }}>{{$dayType}}</option>
          @endforeach
        </select>
    </div>

      <div class="row">
       <p class="f-500 c-black m-b-15" style="padding-left: 12px"> Booking Types</p>
        @foreach ($bookingTypes as $key => $booking) 

        <div class="col-sm-3 m-b-20">
            <div class="toggle-switch" data-ts-color="blue">
                <label for="{{$booking->id}}" class="ts-label">{{$booking->name}}</label>
                  <input id="{{$booking->id}}" type="checkbox" hidden="hidden" name="btype_id[]" value="{{$booking->id}}" 
                  @if (!empty($priceMappingBookingType))
                    @foreach ($priceMappingBookingType as $key => $pmbt) 
                    
                      {{($pmbt->btype_id == $booking->id ? 'checked': '')}}
                    
                    @endforeach  
                  @endif
                  >
                <label for="{{$booking->id}}" class="ts-helper"></label>
            </div>
        </div>

        @endforeach
</div>

   <div class="form-group fg-line">
        <label for="name">Price</label>
        <input type="number" name="price" value="{{ $priceMapping->price or '' }}" class="form-control input-sm" id="price" placeholder="Price" required>
    </div>


<button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>


{!! Form::close() !!}

@if (!empty($priceMapping->id)) 


  <div class="row">
    <div class="col-sm-10 col-xs-6"></div>
    <div class="col-sm-2 col-xs-6">
{!! Form::open(array('route' => array($action["action"], !empty($priceMapping->id) ? $priceMapping->id : '' ),
 'class' => 'form', 'method' => 'DELETE')) !!}
   <button type="submit" class="btn btn-danger btn-sm m-t-10">Delete</button>
{!! Form::close() !!}
 </div>
  </div>

@endif

</div>
  </div>
</div>


@endsection