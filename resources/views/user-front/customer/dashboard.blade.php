@extends('user-front.layout')

@section('content')
@section('breadcrumb_title', $pageHeading->dashboard_page ?? __('Dashboard'))
@section('page-title', $pageHeading->dashboard_page ?? __('Dashboard'))

<!-- Dashboard Start -->
<section class="user-dashboard pt-100 pb-70">
  <div class="container">
    <div class="row gx-xl-5">
      @includeIf('user-front.customer.side-navbar')

      <div class="col-lg-9">
        <div class="row">
          <div class="col-lg-12">
            <div class="user-profile-details mb-30">
              <div class="account-info radius-md bg-white p-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.04);">
                @php
                  $cust = Auth::guard('customer')->user();
                  $cFullName = trim(($cust->first_name ?? '') . ' ' . ($cust->last_name ?? ''));
                  if (empty($cFullName)) {
                      $cFullName = $cust->username ?? __('User');
                  }
                  $cEmail = $cust->email;
                  $cPhone = $cust->contact_number ?: ($cust->billing_number ?: null);
                  $cCity = $cust->city ?: ($cust->billing_city ?: null);
                  $cCountry = $cust->country ?: ($cust->billing_country ?: null);
                  $cAddress = $cust->address ?: ($cust->billing_address ?: null);
                @endphp
                <div class="title d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                  <h3 class="mb-0" style="font-size: 20px; font-weight: 700; color: #1e293b;">
                    <i class="fas fa-id-card text-primary mr-2 me-2"></i>{{ $keywords['Account Information'] ?? __('Account Information') }}
                  </h3>
                  <a href="{{ route('customer.edit_profile', getParam()) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; padding: 5px 14px; font-size: 13px; font-weight: 600;">
                    <i class="fas fa-edit mr-1"></i> {{ $keywords['Edit Profile'] ?? __('Edit Profile') }}
                  </a>
                </div>
                <div class="main-info">
                  <div class="row g-3">
                    <!-- Name -->
                    <div class="col-md-4 col-sm-6 mb-3">
                      <div class="customer-info-box p-3 rounded" style="background: #f8fafc; border: 1px solid #eef2f6; height: 100%;">
                        <div class="d-flex align-items-center mb-1">
                          <i class="fas fa-user mr-2 me-2" style="font-size: 14px; color: #64748b;"></i>
                          <span style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">{{ $keywords['Name'] ?? __('Name') }}</span>
                        </div>
                        <div style="font-size: 14px; font-weight: 600; color: #0f172a; word-break: break-word;">
                          {{ $cFullName }}
                        </div>
                      </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-4 col-sm-6 mb-3">
                      <div class="customer-info-box p-3 rounded" style="background: #f8fafc; border: 1px solid #eef2f6; height: 100%;">
                        <div class="d-flex align-items-center mb-1">
                          <i class="fas fa-envelope mr-2 me-2" style="font-size: 14px; color: #64748b;"></i>
                          <span style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">{{ $keywords['Email'] ?? __('Email') }}</span>
                        </div>
                        <div style="font-size: 14px; font-weight: 600; color: #0f172a; word-break: break-word;">
                          {{ $cEmail }}
                        </div>
                      </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-4 col-sm-6 mb-3">
                      <div class="customer-info-box p-3 rounded" style="background: #f8fafc; border: 1px solid #eef2f6; height: 100%;">
                        <div class="d-flex align-items-center mb-1">
                          <i class="fas fa-phone-alt mr-2 me-2" style="font-size: 14px; color: #64748b;"></i>
                          <span style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">{{ $keywords['Phone'] ?? __('Phone') }}</span>
                        </div>
                        <div style="font-size: 14px; font-weight: 600; color: #0f172a; word-break: break-word;">
                          @if(!empty($cPhone))
                            {{ $cPhone }}
                          @else
                            <span style="font-size: 13px; font-weight: normal; font-style: italic; color: #94a3b8;">{{ __('Not provided') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>

                    <!-- City -->
                    <div class="col-md-4 col-sm-6 mb-3">
                      <div class="customer-info-box p-3 rounded" style="background: #f8fafc; border: 1px solid #eef2f6; height: 100%;">
                        <div class="d-flex align-items-center mb-1">
                          <i class="fas fa-city mr-2 me-2" style="font-size: 14px; color: #64748b;"></i>
                          <span style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">{{ $keywords['City'] ?? __('City') }}</span>
                        </div>
                        <div style="font-size: 14px; font-weight: 600; color: #0f172a; word-break: break-word;">
                          @if(!empty($cCity))
                            {{ $cCity }}
                          @else
                            <span style="font-size: 13px; font-weight: normal; font-style: italic; color: #94a3b8;">{{ __('Not provided') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>

                    <!-- Country -->
                    <div class="col-md-4 col-sm-6 mb-3">
                      <div class="customer-info-box p-3 rounded" style="background: #f8fafc; border: 1px solid #eef2f6; height: 100%;">
                        <div class="d-flex align-items-center mb-1">
                          <i class="fas fa-globe mr-2 me-2" style="font-size: 14px; color: #64748b;"></i>
                          <span style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">{{ $keywords['Country'] ?? __('Country') }}</span>
                        </div>
                        <div style="font-size: 14px; font-weight: 600; color: #0f172a; word-break: break-word;">
                          @if(!empty($cCountry))
                            {{ $cCountry }}
                          @else
                            <span style="font-size: 13px; font-weight: normal; font-style: italic; color: #94a3b8;">{{ __('Not provided') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>

                    <!-- Address -->
                    <div class="col-md-4 col-sm-6 mb-3">
                      <div class="customer-info-box p-3 rounded" style="background: #f8fafc; border: 1px solid #eef2f6; height: 100%;">
                        <div class="d-flex align-items-center mb-1">
                          <i class="fas fa-map-marker-alt mr-2 me-2" style="font-size: 14px; color: #64748b;"></i>
                          <span style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">{{ $keywords['Address'] ?? __('Address') }}</span>
                        </div>
                        <div style="font-size: 14px; font-weight: 600; color: #0f172a; word-break: break-word;">
                          @if(!empty($cAddress))
                            {{ $cAddress }}
                          @else
                            <span style="font-size: 13px; font-weight: normal; font-style: italic; color: #94a3b8;">{{ __('Not provided') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @if ($shop_settings->catalog_mode != 1)
          <div class="row gx-lg-4">
            <div class="col-md-4">
              <div class=" card-box radius-md mb-30 color-1">
                <div class="card-icon">
                  <i class="far fa-clock"></i>
                </div>
                <div class="card-info">
                  <h4>{{ $keywords['Pending Orders'] ?? __('Pending Orders') }} </h4>
                  <p class="fs-4 mb-0">{{ $pending_orders }} </p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card-box radius-md mb-30 color-2">
                <div class="card-icon">
                  <i class="fas fa-sync-alt"></i>
                </div>
                <div class="card-info">
                  <h4>{{ $keywords['Processing Orders'] ?? __('Processing Orders') }} </h4>
                  <p class="fs-4 mb-0">{{ $processing_orders }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card-box color-3 radius-md mb-30">
                <div class="card-icon">
                  <i class="far fa-check-circle"></i>
                </div>
                <div class="card-info">
                  <h4>{{ $keywords['Completed Orders'] ?? __('Completed Orders') }} </h4>
                  <p class="fs-4 mb-0">{{ $completed_orders }}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="account-info radius-md mb-30">
                <div class="title">
                  <h3>{{ $keywords['Recent Orders'] ?? __('Recent Orders') }} </h3>
                </div>
                <div class="main-info">
                  <div class="main-table">
                    <div class="table-responsiv overflow-x-scroll-mobile">
                      <table class="dataTables_wrapper dt-responsive table-striped dt-bootstrap4 w-100">
                        <thead>
                          <tr>
                            <th>{{ $keywords['Order number'] ?? __('Order number') }} </th>
                            <th>{{ $keywords['Date'] ?? __('Date') }} </th>
                            <th>{{ $keywords['Amount'] ?? __('Amount') }} </th>
                            <th>{{ $keywords['Order Status'] ?? __('Order Status') }} </th>
                            <th>{{ $keywords['Action'] ?? __('Action') }} </th>
                          </tr>
                        </thead>
                        <tbody>
                          @if (count($orders) > 0)
                            @foreach ($orders as $order)
                              <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                <td>
                                  {{ userSymbolPrice($order->total, $order->currency_position, $order->currency_sign) }}
                                </td>
                                <td>
                                  @if ($order->order_status == 'pending')
                                    <span
                                      class="pending">{{ $keywords[ucfirst($order->order_status)] ?? __('Pending') }}
                                    </span>
                                  @elseif ($order->order_status == 'rejected')
                                    <span class="rejected">
                                      {{ $keywords[ucfirst($order->order_status)] ?? __('Rejected') }}
                                    </span>
                                  @elseif ($order->order_status == 'processing')
                                    <span class="processing">
                                      {{ $keywords[ucfirst($order->order_status)] ?? __('Processing') }}
                                    </span>
                                  @elseif ($order->order_status == 'out for delivery')
                                    <span class="badge" style="background: #8b5cf6; color: #fff; font-size: 11px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">
                                      {{ $keywords['Out for Delivery'] ?? __('Out for Delivery') }}
                                    </span>
                                  @elseif ($order->order_status == 'completed')
                                    <span class="completed">
                                      {{ $keywords[ucfirst($order->order_status)] ?? __('Completed') }}
                                    </span>
                                  @endif
                                  @if (!empty($order->tracking_number))
                                    <div class="mt-1">
                                      <a href="{{ !empty($order->tracking_url) ? $order->tracking_url : '#' }}" target="_blank" style="font-size: 11px; color: #16a34a; font-weight: 600; text-decoration: underline;"><i class="fas fa-truck mr-1"></i>{{ $order->tracking_number }}</a>
                                    </div>
                                  @endif
                                </td>
                                <td><a href="{{ route('customer.orders-details', ['id' => $order->id, getParam()]) }}"
                                    class="btn base-bg" class="btn">{{ $keywords['Details'] ?? __('Details') }} </a>
                                </td>
                              </tr>
                            @endforeach
                          @else
                            <tr>
                              <td colspan="5" class="text-center pt-3">
                                {{ $keywords['No Orders'] ?? __('No Orders') }}
                              </td>
                            </tr>
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
<!-- Dashboard End -->
@endsection
