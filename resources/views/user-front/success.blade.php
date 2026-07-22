@extends('user-front.layout')

@section('breadcrumb_title', $keywords['Payment Success'] ?? __('Payment Success'))
@section('page-title', $keywords['Payment Success'] ?? __('Payment Success'))

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
  <div class="purchase-message pb-100 ">
    <div class="container mx-auto">
      <div class="purchase-success text-center">
        <div class="success-icon-area">
          @includeIf('user-front.partials.success-svg')
        </div>
        <h3 class="mb-2 congratulation">
          {{ $keywords['success'] ?? __('Success') . '!' }}
        </h3>
        <p class="mt-2 description">
          {{ $keywords['your_transaction_was_successful'] ?? __('Your transaction was successful') . '.' }}
        </p>
        <p class="mb-3 description">
          {{ $keywords['We_have_sent_you_a_mail_with_an_invoice'] ?? __('We have sent you a mail with an invoice') . '.' }}
        </p>
        <a href="{{ route('front.user.shop', getParam()) }}"
          class="btn btn-md btn-primary radius-sm">{{ $keywords['Back to Shop'] ?? __('Back to Shop') }}</a>
      </div>
    </div>
  </div>

  <!--====== Purchase Success Section End ======-->
@endsection
