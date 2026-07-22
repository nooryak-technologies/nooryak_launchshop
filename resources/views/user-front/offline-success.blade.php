@extends('user-front.layout')
@section('page-title', $keywords['order_success'] ?? __('Success'))

@section('styles')
<style>
.success-breadcrumb {
  padding-top: 15px !important;
  padding-bottom: 0 !important;
  margin-top: 0 !important;
  min-height: auto !important;
}
.success-breadcrumb .content h2 {
  margin-bottom: 0 !important;
}
.purchase-message {
  padding-top: 15px !important;
}
@media (max-width: 767px) {
  .success-breadcrumb {
    padding-top: 10px !important;
    padding-bottom: 0 !important;
  }
  .purchase-message {
    padding-top: 5px !important;
    padding-bottom: 30px !important;
  }
}
</style>
@endsection

@section('content')
  <!--====== Purchase Success Section Start ======-->
  <div class="purchase-message ptb-100">
    <div class="container mx-auto">
      <div class="purchase-success text-center">
        <div class="success-icon-area">
          @includeIf('user-front.partials.success-svg')
        </div>
        <h3 class="mb-2 congratulation">
          {{ $keywords['success'] ?? __('Success') . '!' }}
        </h3>
        <p class="mt-2 description">
          {{ $keywords['Your_Order_has_been_successfully_placed'] ?? __('Your order has been successfully placed') . '.' }}
          {{ $keywords['Please_wait_for_confirmation'] ?? __('Please wait for confirmation') . '.' }}
        </p>
        <a href="{{ route('front.user.shop', getParam()) }}"
          class="btn btn-md btn-primary radius-sm">{{ $keywords['Back To shop'] ?? __('Back To shop') }}</a>
      </div>
    </div>
  </div>

  <!--====== Purchase Success Section End ======-->
@endsection
