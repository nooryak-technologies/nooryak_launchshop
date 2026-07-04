@extends('user.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Shipping Gateways') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('user-dashboard') }}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Shop Settings') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Shipping Gateways') }}</a>
      </li>
    </ul>
  </div>
  
  <div class="row">
    {{-- Commented out AfterShip
    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('user.shipping_gateway.aftership_update') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('AfterShip') }}</div>
              </div>
            </div>
          </div>
          <div class="card-body">
            @php
              if ($aftership && !is_null($aftership->information)) {
                  $aftershipInfo = json_decode($aftership->information, true);
              } else {
                  $aftershipInfo = [];
              }
            @endphp
            <div class="form-group">
              <label>{{ __('Status') }}</label>
              <div class="selectgroup w-100">
                <label class="selectgroup-item">
                  <input type="radio" name="status" value="1" class="selectgroup-input"
                    {{ $aftership && $aftership->status == 1 ? 'checked' : '' }}>
                  <span class="selectgroup-button">{{ __('Active') }}</span>
                </label>
                <label class="selectgroup-item">
                  <input type="radio" name="status" value="0" class="selectgroup-input"
                    {{ !$aftership || $aftership->status == 0 ? 'checked' : '' }}>
                  <span class="selectgroup-button">{{ __('Deactive') }}</span>
                </label>
              </div>
            </div>
            <div class="form-group">
              <label>{{ __('AfterShip API Key') }}</label>
              <input class="form-control" name="api_key" value="{{ $aftershipInfo['api_key'] ?? '' }}" placeholder="Enter API Key">
              @if ($errors->has('api_key'))
                <p class="mb-0 text-danger">{{ $errors->first('api_key') }}</p>
              @endif
            </div>
          </div>
          <div class="card-footer text-center">
            <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
          </div>
        </form>
      </div>
    </div>
    --}}

    {{-- Shiprocket --}}
    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('user.shipping_gateway.shiprocket_update') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('Shiprocket') }}</div>
              </div>
            </div>
          </div>
          <div class="card-body">
            @php
              if ($shiprocket && !is_null($shiprocket->information)) {
                  $shiprocketInfo = json_decode($shiprocket->information, true);
              } else {
                  $shiprocketInfo = [];
              }
            @endphp
            <div class="form-group">
              <label>{{ __('Status') }}</label>
              <div class="selectgroup w-100">
                <label class="selectgroup-item">
                  <input type="radio" name="status" value="1" class="selectgroup-input"
                    {{ $shiprocket && $shiprocket->status == 1 ? 'checked' : '' }}>
                  <span class="selectgroup-button">{{ __('Active') }}</span>
                </label>
                <label class="selectgroup-item">
                  <input type="radio" name="status" value="0" class="selectgroup-input"
                    {{ !$shiprocket || $shiprocket->status == 0 ? 'checked' : '' }}>
                  <span class="selectgroup-button">{{ __('Deactive') }}</span>
                </label>
              </div>
            </div>
            <div class="form-group">
              <label>{{ __('Shiprocket Login Email') }}</label>
              <input class="form-control" name="email" value="{{ $shiprocketInfo['email'] ?? '' }}" placeholder="Enter Email">
              @if ($errors->has('email'))
                <p class="mb-0 text-danger">{{ $errors->first('email') }}</p>
              @endif
            </div>
            <div class="form-group">
              <label>{{ __('Shiprocket Password') }}</label>
              <input type="password" class="form-control" name="password" value="{{ $shiprocketInfo['password'] ?? '' }}" placeholder="Enter Password">
              @if ($errors->has('password'))
                <p class="mb-0 text-danger">{{ $errors->first('password') }}</p>
              @endif
            </div>
          </div>
          <div class="card-footer text-center">
            <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
          </div>
        </form>
      </div>
    </div>

    {{-- Commented out Shippo
    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('user.shipping_gateway.shippo_update') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('Shippo') }}</div>
              </div>
            </div>
          </div>
          <div class="card-body">
            @php
              if ($shippo && !is_null($shippo->information)) {
                  $shippoInfo = json_decode($shippo->information, true);
              } else {
                  $shippoInfo = [];
              }
            @endphp
            <div class="form-group">
              <label>{{ __('Status') }}</label>
              <div class="selectgroup w-100">
                <label class="selectgroup-item">
                  <input type="radio" name="status" value="1" class="selectgroup-input"
                    {{ $shippo && $shippo->status == 1 ? 'checked' : '' }}>
                  <span class="selectgroup-button">{{ __('Active') }}</span>
                </label>
                <label class="selectgroup-item">
                  <input type="radio" name="status" value="0" class="selectgroup-input"
                    {{ !$shippo || $shippo->status == 0 ? 'checked' : '' }}>
                  <span class="selectgroup-button">{{ __('Deactive') }}</span>
                </label>
              </div>
            </div>
            <div class="form-group">
              <label>{{ __('Shippo API Key / Token') }}</label>
              <input class="form-control" name="api_key" value="{{ $shippoInfo['api_key'] ?? '' }}" placeholder="Enter API Key">
              @if ($errors->has('api_key'))
                <p class="mb-0 text-danger">{{ $errors->first('api_key') }}</p>
              @endif
            </div>
          </div>
          <div class="card-footer text-center">
            <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
          </div>
        </form>
      </div>
    </div>
    --}}
  </div>
@endsection
