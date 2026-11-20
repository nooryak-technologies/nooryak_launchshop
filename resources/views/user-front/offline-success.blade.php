@extends('user-front.layout')
@section('page-title', $keywords['order_success'] ?? __('Order Placed Successfully'))

@section('content')
  <style>
    .purchase-message {
      padding-top: 240px !important;
      padding-bottom: 90px !important;
      position: relative !important;
      z-index: 1 !important;
    }
    .purchase-success {
      max-width: 540px !important;
      margin: 0 auto !important;
      text-align: center !important;
    }
    .success-icon-area {
      max-width: 250px !important;
      margin: 0 auto 25px auto !important;
    }
    .success-icon-area svg {
      width: 100% !important;
      height: auto !important;
      max-height: 240px !important;
      object-fit: contain !important;
      display: block !important;
      margin: 0 auto !important;
    }
    .purchase-success .congratulation {
      font-size: 32px !important;
      font-weight: 700 !important;
      color: #1e293b !important;
      margin-bottom: 12px !important;
      text-transform: capitalize !important;
      letter-spacing: -0.5px !important;
    }
    .purchase-success .description-main {
      font-size: 18px !important;
      font-weight: 600 !important;
      color: #0f172a !important;
      margin-bottom: 8px !important;
      line-height: 1.5 !important;
    }
    .purchase-success .description-email {
      font-size: 15px !important;
      color: #475569 !important;
      margin-bottom: 6px !important;
      line-height: 1.6 !important;
    }
    .purchase-success .description-note {
      font-size: 14px !important;
      color: #64748b !important;
      margin-bottom: 25px !important;
      line-height: 1.5 !important;
    }
    @media only screen and (max-width: 1199.98px) {
      .purchase-message {
        padding-top: 140px !important;
        padding-bottom: 70px !important;
      }
      .purchase-success .congratulation {
        font-size: 28px !important;
      }
    }
    @media only screen and (max-width: 767.98px) {
      .purchase-message {
        padding-top: 110px !important;
        padding-bottom: 50px !important;
      }
      .success-icon-area {
        max-width: 190px !important;
      }
      .purchase-success .congratulation {
        font-size: 24px !important;
      }
    }
    .theme-grocery2 .purchase-message {
      padding-top: 60px !important;
      padding-bottom: 70px !important;
    }
    @media only screen and (max-width: 767.98px) {
      .theme-grocery2 .purchase-message {
        padding-top: 40px !important;
        padding-bottom: 40px !important;
      }
    }
  </style>

  <!--====== Purchase Success Section Start ======-->
  <div class="purchase-message">
    <div class="container mx-auto">
      <div class="purchase-success text-center">
        <div class="success-icon-area">
          @includeIf('user-front.partials.success-svg')
        </div>
        <h3 class="congratulation">
          {{ !empty($keywords['success']) && strtolower($keywords['success']) !== 'success' ? $keywords['success'] : __('Order Placed Successfully!') }}
        </h3>
        <p class="description-main">
          {{ $keywords['Your_Order_has_been_successfully_placed'] ?? __('Your order has been successfully placed.') }}
        </p>
        <p class="description-email">
          <i class="fal fa-envelope mr-1 text-primary"></i> {{ $keywords['We_have_sent_you_a_mail_with_an_invoice'] ?? __('An email with your order details and invoice has been sent to your registered mail.') }}
        </p>
        <p class="description-note">
          {{ $keywords['Please_wait_for_confirmation'] ?? __('Please wait for seller confirmation.') }}
        </p>
        <a href="{{ route('front.user.shop', getParam()) }}"
          class="btn btn-md btn-primary radius-sm" style="padding: 12px 32px; font-weight: 600; font-size: 15px; border-radius: 8px;">{{ $keywords['Back To shop'] ?? __('Back to Shop') }}</a>
      </div>
    </div>
  </div>

  <!--====== Purchase Success Section End ======-->
@endsection
