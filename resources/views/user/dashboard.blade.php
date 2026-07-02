@extends('user.layout')
@php
  $default = \App\Models\User\Language::where('is_default', 1)->first();
  $user = Auth::guard('web')->user();
  $package = \App\Http\Helpers\UserPermissionHelper::currentPackagePermission($user->id);
  if (!empty($user)) {
      $permissions = \App\Http\Helpers\UserPermissionHelper::packagePermission($user->id);
      $permissions = json_decode($permissions, true);
  }
@endphp

@section('content')
  <div class="mt-2 mb-4">
    <h2 class="pb-1 font-weight-bold" style="font-size: 26px; color: inherit;">{{ __('Welcome back') }},
      {{ Auth::guard('web')->user()->shop_name ?? Auth::guard('web')->user()->username }}! 👋</h2>
    <p class="text-muted mb-0" style="font-size: 15px;">{{ __("Here's what's happening with your store today.") }}</p>
  </div>
  @if (is_null($package))
    @php
      $pendingMemb = \App\Models\Membership::query()
          ->where([['user_id', '=', Auth::id()], ['status', 0]])
          ->whereYear('start_date', '<>', '9999')
          ->orderBy('id', 'DESC')
          ->first();
      $pendingPackage = isset($pendingMemb) ? \App\Models\Package::query()->findOrFail($pendingMemb->package_id) : null;
    @endphp

    @if ($pendingPackage)
      <div class="alert alert-warning">
        {{ __('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.') }}
      </div>
      <div class="alert alert-warning">
        <strong>{{ __('Pending Package:') }} </strong> {{ $pendingPackage->title }}
        <span class="badge badge-secondary">{{ $pendingPackage->term }}</span>
        <span class="badge badge-warning">{{ __('Decision Pending') }}</span>
      </div>
    @else
      <div class="alert alert-warning">
        {{ __('Your membership is expired. Please purchase a new package / extend the current package.') }}
      </div>
    @endif
  @else
    <div class="row justify-content-center align-items-center mb-4">
      <div class="col-12">
        <div class="card card-body py-3 px-4 mb-0 border-0 shadow-sm" style="border-radius: 12px;">
          @if ($package_count >= 2)
            @if ($next_membership->status == 0)
              <div class="alert alert-danger mb-2 p-2" style="border-radius: 8px; font-size: 13px;">
                <strong>{{ __('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.') }}</strong>
              </div>
            @elseif ($next_membership->status == 1)
              <div class="alert alert-danger mb-2 p-2" style="border-radius: 8px; font-size: 13px;">
                <strong>{{ __('You have another package to activate after the current package expires. You cannot purchase / extend any package, until the next package is activated') }}</strong>
              </div>
            @endif
          @endif
          <div class="d-flex align-items-center flex-wrap">
            <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 50%; background: rgba(13, 110, 253, 0.1);">
              <i class="fas fa-cube text-primary" style="font-size: 20px;"></i>
            </div>
            <div class="d-flex align-items-center flex-wrap my-1">
              <span class="mr-1 font-weight-bold">{{ __('Current Package:') }}</span>
              <span class="mr-2 font-weight-bold">{{ __($current_package->title) }}</span>
              <span class="badge badge-pill text-white mr-2" style="background: #6366f1; padding: 5px 12px; font-size: 12px; font-weight: 600;">{{ __($current_package->term) }}</span>
              <span class="text-muted" style="font-size: 13px;">
                @if ($current_membership->is_trial == 1)
                  ({{ __('Expire Date:') }} {{ Carbon\Carbon::parse($current_membership->expire_date)->format('jS M, Y') }})
                  <span class="badge badge-primary ml-1">{{ __('Trial') }}</span>
                @else
                  ({{ __('Expire Date:') }} {{ $current_package->term === 'lifetime' ? __('Lifetime') : Carbon\Carbon::parse($current_membership->expire_date)->format('jS M, Y') }})
                @endif
              </span>
            </div>
          </div>
          @if ($package_count >= 2)
            <div class="mt-2 pt-2 border-top" style="font-size: 13px;">
              <strong>{{ __('Next Package To Activate:') }} </strong>
              {{ $next_package->title }} <span class="badge badge-secondary">{{ $next_package->term }}</span>
              @if ($current_package->term != 'lifetime' && $current_membership->is_trial != 1)
                ({{ __('Activation Date:') }} {{ Carbon\Carbon::parse($next_membership->start_date)->format('jS M, Y') }},
                {{ __('Expire Date:') }} {{ $next_package->term === 'lifetime' ? __('Lifetime') : Carbon\Carbon::parse($next_membership->expire_date)->format('jS M, Y') }})
              @endif
              @if ($next_membership->status == 0)
                <span class="badge badge-warning">{{ __('Decision Pending') }}</span>
              @endif
            </div>
          @endif
        </div>
      </div>
    </div>
  @endif

  <div class="row">
    @if (!is_null($package))
      <div class="col-sm-6 col-md-4 mb-4">
        <a class="card card-stats card-round stat-card-gradient-blue card-tooltip-trigger h-100 mb-0 d-block p-3"
          href="{{ route('user.item.index', ['language' => $default->code]) }}">
          <div class="d-flex align-items-center">
            <div class="stat-card-icon-box mr-3">
              <i class="fas fa-store-alt text-primary" style="font-size: 22px;"></i>
            </div>
            <div>
              <p class="mb-1 font-weight-500 text-white" style="font-size: 14px; opacity: 0.9;">{{ __('Total Items') }}</p>
              <h3 class="mb-0 font-weight-bold text-white" style="font-size: 30px; line-height: 1;">{{ $total_items }}</h3>
            </div>
          </div>
          <i class="fas fa-store-alt stat-card-watermark"></i>
          <div class="stat-card-divider">
            <span>{{ __('View all items') }}</span>
            <i class="fas fa-arrow-right"></i>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-4 mb-4">
        <a class="card card-stats card-round stat-card-gradient-purple card-tooltip-trigger h-100 mb-0 d-block p-3"
          href="{{ route('user.all.item.orders') }}">
          <div class="d-flex align-items-center">
            <div class="stat-card-icon-box mr-3">
              <i class="fas fa-shopping-cart" style="font-size: 22px; color: #8b5cf6;"></i>
            </div>
            <div>
              <p class="mb-1 font-weight-500 text-white" style="font-size: 14px; opacity: 0.9;">{{ __('Total Orders') }}</p>
              <h3 class="mb-0 font-weight-bold text-white" style="font-size: 30px; line-height: 1;">{{ $total_orders }}</h3>
            </div>
          </div>
          <i class="fas fa-shopping-cart stat-card-watermark"></i>
          <div class="stat-card-divider">
            <span>{{ __('View all orders') }}</span>
            <i class="fas fa-arrow-right"></i>
          </div>
        </a>
      </div>

      <div class="col-sm-6 col-md-4 mb-4">
        <a class="card card-stats card-round stat-card-gradient-cyan card-tooltip-trigger h-100 mb-0 d-block p-3"
          href="{{ route('user.register.user') }}">
          <div class="d-flex align-items-center">
            <div class="stat-card-icon-box mr-3">
              <i class="fas fa-users" style="font-size: 22px; color: #06b6d4;"></i>
            </div>
            <div>
              <p class="mb-1 font-weight-500 text-white" style="font-size: 14px; opacity: 0.9;">{{ __('Registered Customers') }}</p>
              <h3 class="mb-0 font-weight-bold text-white" style="font-size: 30px; line-height: 1;">{{ $total_customers }}</h3>
            </div>
          </div>
          <i class="fas fa-users stat-card-watermark"></i>
          <div class="stat-card-divider">
            <span>{{ __('View customers') }}</span>
            <i class="fas fa-arrow-right"></i>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-4 mb-4">
        <a class="card card-stats card-round stat-card-gradient-orange card-tooltip-trigger h-100 mb-0 d-block p-3"
          href="{{ route('user.subscriber.index') }}">
          <div class="d-flex align-items-center">
            <div class="stat-card-icon-box mr-3">
              <i class="fas fa-envelope-open" style="font-size: 22px; color: #f97316;"></i>
            </div>
            <div>
              <p class="mb-1 font-weight-500 text-white" style="font-size: 14px; opacity: 0.9;">{{ __('Subscribers') }}</p>
              <h3 class="mb-0 font-weight-bold text-white" style="font-size: 30px; line-height: 1;">{{ $total_subscribers }}</h3>
            </div>
          </div>
          <i class="fas fa-envelope-open stat-card-watermark"></i>
          <div class="stat-card-divider">
            <span>{{ __('View subscribers') }}</span>
            <i class="fas fa-arrow-right"></i>
          </div>
        </a>
      </div>
    @endif


    @if (!empty($permissions) && in_array('Blog', $permissions))
      <div class="col-sm-6 col-md-4 mb-4">
        <a class="card card-stats card-round stat-card-gradient-green card-tooltip-trigger h-100 mb-0 d-block p-3"
          href="{{ route('user.blog.index') }}">
          <div class="d-flex align-items-center">
            <div class="stat-card-icon-box mr-3">
              <i class="fas fa-blog" style="font-size: 22px; color: #10b981;"></i>
            </div>
            <div>
              <p class="mb-1 font-weight-500 text-white" style="font-size: 14px; opacity: 0.9;">{{ __('Blogs') }}</p>
              <h3 class="mb-0 font-weight-bold text-white" style="font-size: 30px; line-height: 1;">{{ $blogs }}</h3>
            </div>
          </div>
          <i class="fas fa-blog stat-card-watermark"></i>
          <div class="stat-card-divider">
            <span>{{ __('View all blogs') }}</span>
            <i class="fas fa-arrow-right"></i>
          </div>
        </a>
      </div>
    @endif


    @if (!empty($permissions) && in_array('Custom Page', $permissions))
      <div class="col-sm-6 col-md-4 mb-4">
        <a class="card card-stats card-round stat-card-gradient-red card-tooltip-trigger h-100 mb-0 d-block p-3"
          href="{{ route('user.page.index') }}">
          <div class="d-flex align-items-center">
            <div class="stat-card-icon-box mr-3">
              <i class="la flaticon-file" style="font-size: 24px; color: #ef4444;"></i>
            </div>
            <div>
              <p class="mb-1 font-weight-500 text-white" style="font-size: 14px; opacity: 0.9;">{{ __('Custom Pages') }}</p>
              <h3 class="mb-0 font-weight-bold text-white" style="font-size: 30px; line-height: 1;">{{ $total_custom_pages }}</h3>
            </div>
          </div>
          <i class="la flaticon-file stat-card-watermark"></i>
          <div class="stat-card-divider">
            <span>{{ __('View pages') }}</span>
            <i class="fas fa-arrow-right"></i>
          </div>
        </a>
      </div>
    @endif
  </div>

  <div class="row">
    <div class="col-lg-6">
      <div class="row row-card-no-pd">
        <div class="col-md-12">
          <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-header border-0 pb-0 pt-4 px-4 bg-transparent d-flex justify-content-between align-items-center">
              <h4 class="card-title font-weight-bold mb-0 d-flex align-items-center" style="font-size: 18px;">
                <span class="d-inline-flex align-items-center justify-content-center mr-2" style="width: 34px; height: 34px; border-radius: 50%; background: rgba(13, 110, 253, 0.1);">
                  <i class="fas fa-shopping-bag text-primary" style="font-size: 15px;"></i>
                </span>
                {{ __('Latest Product Orders') }}
              </h4>
              <div class="dropdown">
                <button class="btn btn-link text-muted p-0" type="button" data-toggle="dropdown"><i class="fas fa-ellipsis-h" style="font-size: 16px;"></i></button>
              </div>
            </div>
            <div class="card-body px-4 pt-3 pb-4">
              <div class="row">
                <div class="col-lg-12">
                  @if (count($orders) == 0)
                    <div class="text-center py-5 my-3">
                      <div class="mb-3 d-flex justify-content-center">
                        <svg width="120" height="120" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <circle cx="100" cy="100" r="80" fill="rgba(13, 110, 253, 0.05)"/>
                          <path d="M60 85 L100 65 L140 85 L100 105 Z" fill="#93C5FD"/>
                          <path d="M60 85 V125 L100 145 V105 Z" fill="#60A5FA"/>
                          <path d="M140 85 V125 L100 145 V105 Z" fill="#3B82F6"/>
                          <path d="M60 85 L80 75 L120 95 L100 105 Z" fill="#2563EB" opacity="0.3"/>
                          <!-- Sparkles -->
                          <path d="M40 60 L43 50 L53 47 L43 44 L40 34 L37 44 L27 47 L37 50 Z" fill="#F59E0B" opacity="0.8"/>
                          <path d="M150 50 L152 42 L160 40 L152 38 L150 30 L148 38 L140 40 L148 42 Z" fill="#3B82F6" opacity="0.8"/>
                          <path d="M155 130 L157 124 L163 122 L157 120 L155 114 L153 120 L147 122 L153 124 Z" fill="#10B981" opacity="0.8"/>
                          <circle cx="50" cy="130" r="4" fill="#6366F1" opacity="0.6"/>
                        </svg>
                      </div>
                      <h4 class="font-weight-bold mb-1" style="font-size: 16px;">{{ __('NO PRODUCT ORDER FOUND') }}</h4>
                      <p class="text-muted mb-0" style="font-size: 14px;">{{ __('Looks like there are no product orders yet.') }}</p>
                    </div>
                  @else
                    <div class="table-responsive">
                      <table class="table table-striped mt-3">
                        <thead>
                          <tr>
                            <th scope="col">{{ __('Order Number') }}</th>
                            <th scope="col">{{ __('Total') }}</th>
                            <th scope="col">{{ __('Order Status') }}</th>
                            <th scope="col">{{ __('Payment Status') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($orders as $key => $order)
                            <tr>
                              <td>
                                #{{ $order->order_number }}
                              </td>

                              <td>
                                {{ round($order->total, 2) }}
                                ({{ $order->currency_code }})
                              </td>
                              <td>
                                @if ($order->order_status != 'rejected')
                                  <form id="statusForm{{ $order->id }}" class="d-inline-block"
                                    action="{{ route('user.item.orders.status') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <select
                                      class="w-min-max-100 form-control form-control-sm
                              @if ($order->order_status == 'pending') bg-warning
                              @elseif ($order->order_status == 'processing')
                                bg-primary
                              @elseif ($order->order_status == 'completed')
                                bg-success
                              @elseif ($order->order_status == 'rejected')
                                bg-danger @endif
                              "
                                      name="order_status"
                                      onchange="document.getElementById('statusForm{{ $order->id }}').submit();">
                                      <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>
                                        {{ __('Pending') }}</option>
                                      <option value="processing"
                                        {{ $order->order_status == 'processing' ? 'selected' : '' }}>
                                        {{ __('Processing') }}</option>
                                      <option value="completed"
                                        {{ $order->order_status == 'completed' ? 'selected' : '' }}>
                                        {{ __('Completed') }}</option>
                                      <option value="rejected"
                                        {{ $order->order_status == 'rejected' ? 'selected' : '' }}>
                                        {{ __('Rejected') }}</option>
                                    </select>
                                  </form>
                                @else
                                  <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                @endif

                              </td>
                              <td>
                                @if ($order->gateway_type != 'offline')
                                  @if ($order->payment_status == 'Completed')
                                    <span class="badge badge-success">{{ __('Completed') }}</span>
                                  @elseif($order->payment_status == 'Pending')
                                    <span class="badge badge-warning">{{ __('Pending') }}</span>
                                  @elseif($order->payment_status == 'Rejected')
                                    <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                  @endif
                                @elseif ($order->gateway_type == 'offline')
                                  @if ($order->payment_status == 'Rejected')
                                    <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                  @else
                                    <form action="{{ route('user.item.paymentStatus') }}"
                                      id="paymentStatusForm{{ $order->id }}" method="POST">
                                      @csrf
                                      <input type="hidden" name="order_id" value="{{ $order->id }}">
                                      <select
                                        class="form-control-sm text-white border-0
                                    @if ($order->payment_status == 'Completed') bg-success
                                    @elseif($order->payment_status == 'Pending')
                                        bg-warning @endif
                                    "
                                        name="payment_status"
                                        onchange="document.getElementById('paymentStatusForm{{ $order->id }}').submit();">
                                        <option value="Pending"
                                          {{ $order->payment_status == 'Pending' ? 'selected' : '' }}>
                                          {{ __('Pending') }}</option>
                                        <option value="Completed"
                                          {{ $order->payment_status == 'Completed' ? 'selected' : '' }}>
                                          {{ __('Completed') }}</option>
                                        <option value="Rejected"
                                          {{ $order->payment_status == 'Rejected' ? 'selected' : '' }}>
                                          {{ __('Rejected') }}</option>
                                      </select>
                                    </form>
                                  @endif
                                @endif
                              </td>
                              <td>
                                <div class="dropdown">
                                  <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    {{ __('Actions') }}
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('user.item.details', $order->id) }}"
                                      target="_blank">{{ __('Details') }}</a>
                                    <a class="dropdown-item"
                                      href="{{ asset('assets/front/invoices/' . $order->invoice_number) }}"
                                      target="_blank">{{ __('Invoice') }}</a>
                                    <form class="deleteform d-block" action="{{ route('user.item.order.delete') }}"
                                      method="post">
                                      @csrf
                                      <input type="hidden" name="order_id" value="{{ $order->id }}">
                                      <button type="submit" class="deletebtn">
                                        {{ __('Delete') }}
                                      </button>
                                    </form>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="row row-card-no-pd">
        <div class="col-md-12">
          <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-header border-0 pb-0 pt-4 px-4 bg-transparent d-flex justify-content-between align-items-center">
              <h4 class="card-title font-weight-bold mb-0 d-flex align-items-center" style="font-size: 18px;">
                <span class="d-inline-flex align-items-center justify-content-center mr-2" style="width: 34px; height: 34px; border-radius: 50%; background: rgba(16, 185, 129, 0.1);">
                  <i class="fas fa-dollar-sign text-success" style="font-size: 15px;"></i>
                </span>
                {{ __('Recent Payment Logs') }}
              </h4>
              <div class="dropdown">
                <button class="btn btn-link text-muted p-0" type="button" data-toggle="dropdown"><i class="fas fa-ellipsis-h" style="font-size: 16px;"></i></button>
              </div>
            </div>
            <div class="card-body px-4 pt-3 pb-4">
              <div class="row">
                <div class="col-lg-12">
                  @if (count($memberships) == 0)
                    <div class="text-center py-5 my-3">
                      <h4 class="font-weight-bold mb-1" style="font-size: 16px;">{{ __('NO PAYMENT LOG FOUND') }}</h4>
                      <p class="text-muted mb-0" style="font-size: 14px;">{{ __('Looks like there are no payment transactions yet.') }}</p>
                    </div>
                  @else
                    <div class="table-responsive">
                      <table class="table table-striped mt-3">
                        <thead>
                          <tr>
                            <th scope="col">{{ __('Transaction Id') }}</th>
                            <th scope="col">{{ __('Amount') }}</th>
                            <th scope="col">{{ __('Payment Status') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($memberships as $key => $membership)
                            <tr>
                              <td>
                                {{ strlen($membership->transaction_id) > 30 ? mb_substr($membership->transaction_id, 0, 30, 'UTF-8') . '...' : $membership->transaction_id }}
                              </td>
                              @php
                                $bex = json_decode($membership->settings);
                              @endphp
                              <td>
                                @if ($membership->price == 0)
                                  Free
                                @else
                                  {{ format_price($membership->price) }}
                                @endif
                              </td>
                              <td>
                                @if ($membership->status == 1)
                                  <h3 class="d-inline-block badge badge-success">
                                    {{ __('Success') }}
                                  </h3>
                                @elseif ($membership->status == 0)
                                  <h3 class="d-inline-block badge badge-warning">
                                    {{ __('Pending') }}
                                  </h3>
                                @elseif ($membership->status == 2)
                                  <h3 class="d-inline-block badge badge-danger">
                                    {{ __('Rejected') }}
                                  </h3>
                                @endif
                              </td>
                              <td>
                                @if (!empty($membership->name !== 'anonymous'))
                                  <a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#detailsModal{{ $membership->id }}">{{ __('Detail') }}</a>
                                @else
                                  -
                                @endif
                              </td>
                            </tr>
                            <div class="modal fade" id="detailsModal{{ $membership->id }}" tabindex="-1"
                              role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                      {{ __('Details') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <h3 class="text-warning">{{ __('Member details') }}
                                    </h3>
                                    <label>{{ __('Name') }}</label>
                                    <p>{{ $membership->user->shop_name }}</p>
                                    <label>{{ __('Email') }}</label>
                                    <p>{{ $membership->user->email }}</p>
                                    <label>{{ __('Phone') }}</label>
                                    <p>{{ $membership->user->phone }}</p>
                                    <h3 class="text-warning">
                                      {{ __('Payment details') }}</h3>
                                    <p><strong>{{ __('Cost') . ':' }} </strong>
                                      {{ $membership->price == 0 ? __('Free') : $membership->price }}
                                    </p>
                                    <p><strong>{{ __('Currency:') }} </strong>
                                      {{ $membership->currency }}
                                    </p>
                                    <p><strong>{{ __('Method') }}: </strong>
                                      {{ __($membership->payment_method) }}
                                    </p>
                                    <h3 class="text-warning">
                                      {{ __('Package Details') }}</h3>
                                    <p><strong>{{ __('Title') }}:
                                      </strong>{{ __($membership->package->title) }}
                                    </p>
                                    <p><strong>{{ __('Term') }}: </strong>
                                      {{ __($membership->package->term) }}
                                    </p>
                                    <p><strong>{{ __('Start Date') }}: </strong>
                                      @if (\Illuminate\Support\Carbon::parse($membership->start_date)->format('Y') == '9999')
                                        <span class="badge badge-danger">{{ __('Never Activated') }}</span>
                                      @else
                                        {{ \Illuminate\Support\Carbon::parse($membership->start_date)->format('jS M ,Y') }}
                                      @endif
                                    </p>
                                    <p><strong>{{ __('Expire Date') }}: </strong>

                                      @if (\Illuminate\Support\Carbon::parse($membership->start_date)->format('Y') == '9999')
                                        -
                                      @else
                                        @if ($membership->modified == 1)
                                          {{ \Illuminate\Support\Carbon::parse($membership->expire_date)->addDay()->format('jS M ,Y') }}
                                          <span
                                            class="badge badge-primary btn-xs">{{ __('modified  by Admin') }}</span>
                                        @else
                                          {{ $membership->package->term == 'lifetime' ? __('Lifetime') : \Illuminate\Support\Carbon::parse($membership->expire_date)->format('jS M ,Y') }}
                                        @endif
                                      @endif
                                    </p>
                                    <p>
                                      <strong>{{ __('Purchase Type') }}: </strong>
                                      @if ($membership->is_trial == 1)
                                        {{ __('Trial') }}
                                      @else
                                        {{ $membership->price == 0 ? __('Free') : __('Regular') }}
                                      @endif
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    <div class="mt-3 pt-2">
                      <a href="{{ route('user.payment-log.index') }}" class="font-weight-bold text-primary d-inline-flex align-items-center" style="font-size: 14px;">
                        {{ __('View all payments') }} <i class="fas fa-arrow-right ml-2"></i>
                      </a>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
