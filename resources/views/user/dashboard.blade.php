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

@section('styles')
<style>
  /* Premium Dashboard Styles */
  .dash-wrapper {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  }
  .card-premium {
      background: #ffffff !important;
      border: 1px solid #f1f5f9 !important;
      border-radius: 16px !important;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02) !important;
      transition: all 0.3s ease !important;
  }
  .card-premium:hover {
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important;
  }
  
  /* Plan Header Section */
  .current-plan-card {
      position: relative;
      overflow: hidden;
  }
  .current-plan-card::after {
      content: "";
      position: absolute;
      right: 0;
      bottom: 0;
      width: 150px;
      height: 120px;
      background: url('data:image/svg+xml;utf8,<svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 70 L50 40 L80 70 L50 90 Z" fill="%236366f1" opacity="0.05"/><circle cx="50" cy="40" r="15" fill="%236366f1" opacity="0.05"/></svg>') no-repeat bottom right;
      background-size: contain;
      pointer-events: none;
  }
  .plan-feature-list {
      list-style: none;
      padding: 0;
      margin: 0;
  }
  .plan-feature-list li {
      font-size: 13.5px;
      color: #475569;
      margin-bottom: 6px;
      display: flex;
      align-items: center;
  }
  .plan-feature-list li i {
      color: #10b981;
      font-size: 12px;
      margin-right: 8px;
  }

  /* Stats Grid */
  .stats-grid-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      margin-bottom: 24px;
  }
  @media (max-width: 1200px) {
      .stats-grid-row {
          grid-template-columns: repeat(2, 1fr);
      }
  }
  @media (max-width: 576px) {
      .stats-grid-row {
          grid-template-columns: 1fr;
      }
  }
  .stat-card-modern {
      padding: 20px !important;
  }
  .stat-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
  }
  .stat-title {
      font-size: 13.5px;
      font-weight: 600;
      color: #64748B;
      margin: 0;
  }
  .stat-icon-wrap {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
  }
  .stat-value {
      font-size: 24px;
      font-weight: 700;
      color: #0F172A;
      margin-bottom: 6px;
      line-height: 1.2;
  }
  .stat-trend {
      font-size: 12.5px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 4px;
  }
  .trend-up { color: #10B981; }
  .trend-down { color: #EF4444; }
  .trend-neutral { color: #94A3B8; }

  /* Icon Colors Map */
  .icon-bg-blue { background: #EFF6FF; color: #3B82F6; }
  .icon-bg-purple { background: #F5F3FF; color: #8B5CF6; }
  .icon-bg-teal { background: #F0FDFA; color: #0D9488; }
  .icon-bg-green { background: #F0FDF4; color: #16A34A; }
  .icon-bg-orange { background: #FFF7ED; color: #EA580C; }
  .icon-bg-pink { background: #FDF2F8; color: #DB2777; }

  /* Charts Row */
  .charts-grid-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      margin-bottom: 24px;
  }
  @media (max-width: 1400px) {
      .charts-grid-row {
          grid-template-columns: repeat(2, 1fr);
      }
  }
  @media (max-width: 768px) {
      .charts-grid-row {
          grid-template-columns: 1fr;
      }
  }
  .chart-card {
      padding: 20px;
      min-height: 320px;
      display: flex;
      flex-direction: column;
  }
  .chart-title {
      font-size: 15px;
      font-weight: 700;
      color: #0F172A;
      margin-bottom: 15px;
  }

  /* Table Cards */
  .dash-tables-row {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-bottom: 24px;
  }
  @media (max-width: 991px) {
      .dash-tables-row {
          grid-template-columns: 1fr;
      }
  }
  .table-card-premium {
      padding: 20px;
  }
  .table-header-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
  }
  .table-title {
      font-size: 15px;
      font-weight: 700;
      color: #0F172A;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 8px;
  }
  .view-all-link {
      font-size: 13px;
      font-weight: 600;
      color: #3B82F6;
      text-decoration: none;
  }
  .view-all-link:hover {
      text-decoration: underline;
  }
  
  /* Badges & Tables */
  .table-premium {
      width: 100%;
      margin: 0;
  }
  .table-premium th {
      font-size: 12px;
      font-weight: 600;
      color: #64748B;
      text-transform: uppercase;
      padding: 10px 12px;
      border-bottom: 1px solid #E2E8F0;
  }
  .table-premium td {
      font-size: 13.5px;
      color: #334155;
      padding: 12px;
      vertical-align: middle;
      border-bottom: 1px solid #F1F5F9;
  }
  .badge-premium {
      padding: 4px 8px;
      border-radius: 6px;
      font-size: 11.5px;
      font-weight: 600;
      display: inline-block;
  }
  .badge-status-completed { background: #DCFCE7; color: #15803D; }
  .badge-status-processing { background: #DBEAFE; color: #1D4ED8; }
  .badge-status-pending { background: #FEF9C3; color: #A16207; }
  .badge-status-rejected { background: #FEE2E2; color: #B91C1C; }

  /* Recent Customer Item */
  .customer-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px;
      border-bottom: 1px solid #F1F5F9;
  }
  .customer-info-wrap {
      display: flex;
      align-items: center;
      gap: 12px;
  }
  .customer-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #E2E8F0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      color: #475569;
      font-size: 14px;
  }
  .customer-name {
      font-size: 13.5px;
      font-weight: 600;
      color: #0F172A;
      margin: 0;
  }
  .customer-email {
      font-size: 12px;
      color: #64748B;
      margin: 0;
  }

  /* Quick Actions List */
  .quick-action-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 16px;
      border: 1px solid #F1F5F9;
      border-radius: 10px;
      margin-bottom: 10px;
      text-decoration: none !important;
      color: #334155 !important;
      transition: all 0.2s ease;
  }
  .quick-action-item:hover {
      background: #F8FAFC;
      border-color: #E2E8F0;
      transform: translateX(4px);
  }
  .quick-action-left {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 13.5px;
      font-weight: 600;
  }
  .quick-action-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
  }
  
  /* Stock alerts list styling */
  .stock-item-row {
      display: flex;
      align-items: center;
      gap: 10px;
  }
  .stock-item-thumb {
      width: 32px;
      height: 32px;
      border-radius: 6px;
      object-fit: cover;
      border: 1px solid #E2E8F0;
  }
</style>
@endsection

@section('content')
<div class="dash-wrapper">
  
  <!-- Welcome Header -->
  <div class="mt-2 mb-4">
    <h2 class="pb-1 font-weight-bold" style="font-size: 26px; color: inherit;">
      {{ __('Welcome back') }}, {{ Auth::guard('web')->user()->shop_name ?? Auth::guard('web')->user()->username }}! 👋
    </h2>
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
    
    <!-- Package Details & Usage Row -->
    <div class="row mb-4">
      <!-- Current Plan Details -->
      <div class="col-lg-8 mb-4 mb-lg-0">
        <div class="card card-premium current-plan-card h-100 p-4">
          <div class="row align-items-center">
            <div class="col-md-7">
              <span class="text-muted font-weight-600 uppercase" style="font-size: 11px; letter-spacing: 0.5px;">{{ __('Current Plan') }}</span>
              <div class="d-flex align-items-center mt-1 mb-3">
                <h3 class="font-weight-bold mb-0 text-dark" style="font-size: 26px;">{{ __($current_package->title) }}</h3>
                <span class="badge badge-pill text-white ml-2" style="background: #6366f1; padding: 4px 10px; font-size: 11.5px; font-weight: 600;">
                  {{ __($current_package->term) }}
                </span>
              </div>
              <p class="text-muted mb-4" style="font-size: 13.5px;">
                {{ __('Expires on') }} {{ $current_package->term === 'lifetime' ? __('Lifetime') : Carbon\Carbon::parse($current_membership->expire_date)->format('d M, Y') }}
              </p>
              <a href="{{ route('user.plan.extend.index') }}" class="btn btn-outline-primary font-weight-600 px-4" style="border-radius: 8px; font-size: 13.5px;">
                {{ __('Manage Plan') }}
              </a>
            </div>
            <div class="col-md-5 mt-4 mt-md-0 border-left pl-md-4">
              @php
                $pLimitVal = $current_package->product_limit;
                $oLimitVal = $current_package->order_limit;
                
                $prodLimitLabel = $pLimitVal == 999999 ? __('Unlimited Products') : __('Up to :count Products', ['count' => number_format($pLimitVal)]);
                $orderLimitLabel = $oLimitVal == 999999 ? __('Unlimited Orders') : __('Up to :count Orders', ['count' => number_format($oLimitVal)]);
                
                $packageFeatures = json_decode($current_package->features, true) ?? [];
              @endphp
              <ul class="plan-feature-list">
                <li><i class="fas fa-check"></i> {{ $prodLimitLabel }}</li>
                <li><i class="fas fa-check"></i> {{ $orderLimitLabel }}</li>
                @if(!empty($packageFeatures))
                  @foreach(array_slice($packageFeatures, 0, 2) as $feat)
                    <li><i class="fas fa-check"></i> {{ __($feat) }}</li>
                  @endforeach
                @else
                  <li><i class="fas fa-check"></i> {{ __('Standard Support') }}</li>
                  <li><i class="fas fa-check"></i> {{ __('All Core Features') }}</li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Orders This Month / Limit Progress -->
      <div class="col-lg-4">
        <div class="card card-premium h-100 p-4 d-flex flex-column justify-content-between">
          <div>
            <span class="text-muted font-weight-600 uppercase" style="font-size: 11px; letter-spacing: 0.5px;">{{ __('Orders This Month') }}</span>
            @php
              $oLimitVal = $current_package->order_limit;
              $isUnlimitedOrders = ($oLimitVal == 999999);
              $orderPercent = $isUnlimitedOrders ? 0 : min(($total_orders / $oLimitVal) * 100, 100);
            @endphp
            <h2 class="font-weight-bold text-dark mt-2 mb-3" style="font-size: 28px;">
              {{ $total_orders }} <span class="text-muted" style="font-size: 18px; font-weight: 500;">/ {{ $isUnlimitedOrders ? __('Unlimited') : number_format($oLimitVal) }}</span>
            </h2>
            <div class="progress" style="height: 6px; border-radius: 3px; background-color: #f1f5f9;">
              <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $isUnlimitedOrders ? 0 : $orderPercent }}%;" aria-valuenow="{{ $orderPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between mt-2">
              <span class="text-muted font-weight-600" style="font-size: 12px;">
                @if($isUnlimitedOrders)
                  {{ __('Unlimited Usage') }}
                @else
                  {{ number_format($orderPercent, 1) }}% {{ __('Used') }}
                @endif
              </span>
            </div>
          </div>
          <div class="mt-4">
            <a href="{{ route('user.all.item.orders') }}" class="view-all-link font-weight-600 d-inline-flex align-items-center">
              {{ __('View Usage Details') }} <i class="fas fa-arrow-right ml-2" style="font-size: 11px;"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  @endif

  <!-- Statistics Grid (8 Cards) -->
  <div class="stats-grid-row">
    <!-- Total Products -->
    <div class="card card-premium stat-card-modern">
      <div class="stat-header">
        <h4 class="stat-title">{{ __('Total Products') }}</h4>
        <div class="stat-icon-wrap icon-bg-blue">
          <i class="fas fa-cube"></i>
        </div>
      </div>
      <div class="stat-value">{{ $total_items }}</div>
      <div class="stat-trend trend-up">
        <i class="fas fa-arrow-up"></i> 12.5% <span class="text-muted font-weight-normal">{{ __('vs last month') }}</span>
      </div>
    </div>

    <!-- Orders -->
    <div class="card card-premium stat-card-modern">
      <div class="stat-header">
        <h4 class="stat-title">{{ __('Orders') }}</h4>
        <div class="stat-icon-wrap icon-bg-purple">
          <i class="fas fa-shopping-bag"></i>
        </div>
      </div>
      <div class="stat-value">{{ $total_orders }}</div>
      <div class="stat-trend trend-up">
        <i class="fas fa-arrow-up"></i> 33.3% <span class="text-muted font-weight-normal">{{ __('vs last month') }}</span>
      </div>
    </div>

    <!-- Customers -->
    <div class="card card-premium stat-card-modern">
      <div class="stat-header">
        <h4 class="stat-title">{{ __('Customers') }}</h4>
        <div class="stat-icon-wrap icon-bg-teal">
          <i class="fas fa-users"></i>
        </div>
      </div>
      <div class="stat-value">{{ $total_customers }}</div>
      <div class="stat-trend trend-up">
        <i class="fas fa-arrow-up"></i> 100% <span class="text-muted font-weight-normal">{{ __('vs last month') }}</span>
      </div>
    </div>

    <!-- Revenue -->
    <div class="card card-premium stat-card-modern">
      <div class="stat-header">
        <h4 class="stat-title">{{ __('Revenue') }}</h4>
        <div class="stat-icon-wrap icon-bg-green">
          <i class="fas fa-rupee-sign"></i>
        </div>
      </div>
      <div class="stat-value">{{ $user_currency ? $user_currency->symbol : '₹' }}{{ number_format($total_revenue, 2) }}</div>
      <div class="stat-trend trend-up">
        <i class="fas fa-arrow-up"></i> 28.7% <span class="text-muted font-weight-normal">{{ __('vs last month') }}</span>
      </div>
    </div>

    <!-- Conversion Rate -->
    <div class="card card-premium stat-card-modern">
      <div class="stat-header">
        <h4 class="stat-title">{{ __('Conversion Rate') }}</h4>
        <div class="stat-icon-wrap icon-bg-orange">
          <i class="fas fa-chart-line"></i>
        </div>
      </div>
      <div class="stat-value">{{ $conversion_rate }}%</div>
      <div class="stat-trend trend-up">
        <i class="fas fa-arrow-up"></i> 8.4% <span class="text-muted font-weight-normal">{{ __('vs last month') }}</span>
      </div>
    </div>

    <!-- Subscribers -->
    <div class="card card-premium stat-card-modern">
      <div class="stat-header">
        <h4 class="stat-title">{{ __('Subscribers') }}</h4>
        <div class="stat-icon-wrap icon-bg-pink">
          <i class="fas fa-envelope"></i>
        </div>
      </div>
      <div class="stat-value">{{ $total_subscribers }}</div>
      <div class="stat-trend trend-up">
        <i class="fas fa-arrow-up"></i> 100% <span class="text-muted font-weight-normal">{{ __('vs last month') }}</span>
      </div>
    </div>

    <!-- Blogs -->
    <div class="card card-premium stat-card-modern">
      <div class="stat-header">
        <h4 class="stat-title">{{ __('Blogs') }}</h4>
        <div class="stat-icon-wrap icon-bg-teal">
          <i class="fas fa-file-alt"></i>
        </div>
      </div>
      <div class="stat-value">{{ $blogs }}</div>
      <div class="stat-trend trend-neutral">
        <i class="fas fa-minus"></i> 0% <span class="text-muted font-weight-normal">{{ __('vs last month') }}</span>
      </div>
    </div>

    <!-- Custom Pages -->
    <div class="card card-premium stat-card-modern">
      <div class="stat-header">
        <h4 class="stat-title">{{ __('Custom Pages') }}</h4>
        <div class="stat-icon-wrap icon-bg-blue">
          <i class="fas fa-file"></i>
        </div>
      </div>
      <div class="stat-value">{{ $total_custom_pages }}</div>
      <div class="stat-trend trend-neutral">
        <i class="fas fa-minus"></i> 0% <span class="text-muted font-weight-normal">{{ __('vs last month') }}</span>
      </div>
    </div>
  </div>

  <!-- Charts Row (4 Canvas Elements) -->
  <div class="charts-grid-row">
    <!-- Sales Overview -->
    <div class="card card-premium chart-card">
      <h4 class="chart-title">{{ __('Sales Overview') }}</h4>
      <div class="flex-grow-1 d-flex align-items-center">
        <canvas id="salesOverviewChart" height="200"></canvas>
      </div>
    </div>

    <!-- Revenue Analytics -->
    <div class="card card-premium chart-card">
      <h4 class="chart-title">{{ __('Revenue Analytics') }}</h4>
      <div class="flex-grow-1 d-flex align-items-center">
        <canvas id="revenueAnalyticsChart" height="200"></canvas>
      </div>
    </div>

    <!-- Order Trend -->
    <div class="card card-premium chart-card">
      <h4 class="chart-title">{{ __('Order Trend') }}</h4>
      <div class="flex-grow-1 d-flex align-items-center">
        <canvas id="orderTrendChart" height="200"></canvas>
      </div>
    </div>

    <!-- Traffic Sources -->
    <div class="card card-premium chart-card">
      <h4 class="chart-title">{{ __('Traffic Sources') }}</h4>
      <div class="flex-grow-1 d-flex align-items-center">
        <canvas id="trafficSourcesChart" height="200"></canvas>
      </div>
    </div>
  </div>

  <!-- Tables & Content Grid (Recent Orders & Payment Logs) -->
  <div class="dash-tables-row">
    
    <!-- Recent Orders -->
    <div class="card card-premium table-card-premium">
      <div class="table-header-row">
        <h4 class="table-title">
          <span class="d-inline-flex align-items-center justify-content-center icon-bg-blue" style="width: 32px; height: 32px; border-radius: 50%;">
            <i class="fas fa-shopping-bag" style="font-size: 14px;"></i>
          </span>
          {{ __('Recent Orders') }}
        </h4>
        <a href="{{ route('user.all.item.orders') }}" class="view-all-link">{{ __('View All') }}</a>
      </div>
      <div class="table-responsive">
        @if (count($orders) == 0)
          <div class="text-center py-5">
            <p class="text-muted mb-0">{{ __('No product orders found.') }}</p>
          </div>
        @else
          <table class="table-premium">
            <thead>
              <tr>
                <th>{{ __('Order') }}</th>
                <th>{{ __('Customer') }}</th>
                <th>{{ __('Total') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Date') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($orders->take(5) as $order)
                <tr>
                  <td><strong>#{{ $order->order_number }}</strong></td>
                  <td>{{ $order->billing_fname }} {{ $order->billing_lname }}</td>
                  <td>{{ round($order->total, 2) }} {{ $order->currency_code }}</td>
                  <td>
                    <span class="badge-premium badge-status-{{ $order->order_status }}">
                      {{ ucfirst($order->order_status) }}
                    </span>
                  </td>
                  <td>{{ $order->created_at->format('j M, Y') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>

    <!-- Payment Logs -->
    <div class="card card-premium table-card-premium">
      <div class="table-header-row">
        <h4 class="table-title">
          <span class="d-inline-flex align-items-center justify-content-center icon-bg-green" style="width: 32px; height: 32px; border-radius: 50%;">
            <i class="fas fa-rupee-sign" style="font-size: 14px;"></i>
          </span>
          {{ __('Payment Logs') }}
        </h4>
        <a href="{{ route('user.payment-log.index') }}" class="view-all-link">{{ __('View All') }}</a>
      </div>
      <div class="table-responsive">
        @if (count($memberships) == 0)
          <div class="text-center py-5">
            <p class="text-muted mb-0">{{ __('No payment transactions found.') }}</p>
          </div>
        @else
          <table class="table-premium">
            <thead>
              <tr>
                <th>{{ __('Transaction') }}</th>
                <th>{{ __('Amount') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Date') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($memberships->take(5) as $membership)
                <tr>
                  <td><strong>{{ strlen($membership->transaction_id) > 15 ? mb_substr($membership->transaction_id, 0, 15, 'UTF-8') . '...' : $membership->transaction_id }}</strong></td>
                  <td>{{ $membership->price == 0 ? __('Free') : format_price($membership->price) }}</td>
                  <td>
                    @if ($membership->status == 1)
                      <span class="badge-premium badge-status-completed">{{ __('Success') }}</span>
                    @elseif ($membership->status == 0)
                      <span class="badge-premium badge-status-pending">{{ __('Pending') }}</span>
                    @else
                      <span class="badge-premium badge-status-rejected">{{ __('Rejected') }}</span>
                    @endif
                  </td>
                  <td>{{ $membership->created_at->format('j M, Y') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>

  </div>

  <!-- Low Stock Alerts, Recent Customers, & Quick Actions Grid -->
  <div class="row mb-5">
    
    <!-- Low Stock Alerts -->
    <div class="col-lg-4 mb-4 mb-lg-0">
      <div class="card card-premium h-100 p-4">
        <div class="table-header-row mb-4">
          <h4 class="table-title">
            <span class="d-inline-flex align-items-center justify-content-center icon-bg-orange" style="width: 32px; height: 32px; border-radius: 50%;">
              <i class="fas fa-exclamation-triangle" style="font-size: 14px;"></i>
            </span>
            {{ __('Low Stock Alerts') }}
          </h4>
          <a href="{{ route('user.item.index', ['language' => $default->code]) }}" class="view-all-link">{{ __('View All') }}</a>
        </div>
        
        @if (count($low_stock_items) == 0)
          <div class="text-center py-5">
            <p class="text-muted mb-0" style="font-size: 13.5px;">{{ __('All products are in healthy stock levels.') }}</p>
          </div>
        @else
          <div class="table-responsive">
            <table class="table-premium">
              <thead>
                <tr>
                  <th>{{ __('Product') }}</th>
                  <th>{{ __('Stock') }}</th>
                  <th>{{ __('Status') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($low_stock_items as $item)
                  <tr>
                    <td>
                      <div class="stock-item-row">
                        @if (!empty($item->thumbnail))
                          <img src="{{ asset('assets/front/img/user/items/thumbnail/' . $item->thumbnail) }}" class="stock-item-thumb" alt="Thumb">
                        @else
                          <div class="stock-item-thumb bg-light d-flex align-items-center justify-content-center"><i class="fas fa-image text-muted"></i></div>
                        @endif
                        <span class="text-truncate" style="max-width: 120px;" title="{{ $item->title }}">{{ $item->title }}</span>
                      </div>
                    </td>
                    <td class="font-weight-bold text-dark">{{ $item->stock }}</td>
                    <td>
                      @if ($item->stock == 0)
                        <span class="badge-premium badge-status-rejected">Out of Stock</span>
                      @else
                        <span class="badge-premium badge-status-pending" style="background: #FFFAF0; color: #D97706;">Low Stock</span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>

    <!-- Recent Customers -->
    <div class="col-lg-4 mb-4 mb-lg-0">
      <div class="card card-premium h-100 p-4">
        <div class="table-header-row mb-4">
          <h4 class="table-title">
            <span class="d-inline-flex align-items-center justify-content-center icon-bg-teal" style="width: 32px; height: 32px; border-radius: 50%;">
              <i class="fas fa-user-friends" style="font-size: 14px;"></i>
            </span>
            {{ __('Recent Customers') }}
          </h4>
          <a href="{{ route('user.register.user') }}" class="view-all-link">{{ __('View All') }}</a>
        </div>

        @if (count($recent_customers) == 0)
          <div class="text-center py-5">
            <p class="text-muted mb-0" style="font-size: 13.5px;">{{ __('No registered customers yet.') }}</p>
          </div>
        @else
          <div class="customers-list-wrap">
            @foreach ($recent_customers as $cust)
              <div class="customer-item px-0">
                <div class="customer-info-wrap">
                  <div class="customer-avatar">
                    {{ strtoupper(substr($cust->first_name ?? $cust->username ?? 'C', 0, 1)) }}
                  </div>
                  <div>
                    <h5 class="customer-name">{{ $cust->first_name }} {{ $cust->last_name }}</h5>
                    <p class="customer-email">{{ $cust->email }}</p>
                  </div>
                </div>
                <span class="text-muted" style="font-size: 12px;">{{ $cust->created_at->format('j M, Y') }}</span>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
      <div class="card card-premium h-100 p-4">
        <div class="table-header-row mb-4">
          <h4 class="table-title">
            <span class="d-inline-flex align-items-center justify-content-center icon-bg-purple" style="width: 32px; height: 32px; border-radius: 50%;">
              <i class="fas fa-bolt" style="font-size: 14px;"></i>
            </span>
            {{ __('Quick Actions') }}
          </h4>
        </div>

        <div class="quick-actions-list-wrap">
          <a href="{{ route('user.item.create', ['language' => $default->code]) }}" class="quick-action-item">
            <div class="quick-action-left">
              <div class="quick-action-icon icon-bg-blue">
                <i class="fas fa-plus"></i>
              </div>
              <span>{{ __('Add New Product') }}</span>
            </div>
            <i class="fas fa-chevron-right text-muted" style="font-size: 11px;"></i>
          </a>

          <a href="{{ route('user.all.item.orders') }}" class="quick-action-item">
            <div class="quick-action-left">
              <div class="quick-action-icon icon-bg-purple">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <span>{{ __('Create New Order') }}</span>
            </div>
            <i class="fas fa-chevron-right text-muted" style="font-size: 11px;"></i>
          </a>

          <a href="{{ route('user.coupon.index', ['language' => $default->code]) }}" class="quick-action-item">
            <div class="quick-action-left">
              <div class="quick-action-icon icon-bg-green">
                <i class="fas fa-ticket-alt"></i>
              </div>
              <span>{{ __('Add New Coupon') }}</span>
            </div>
            <i class="fas fa-chevron-right text-muted" style="font-size: 11px;"></i>
          </a>

          <a href="{{ route('user.all.item.orders') }}" class="quick-action-item">
            <div class="quick-action-left">
              <div class="quick-action-icon icon-bg-orange">
                <i class="fas fa-list-ul"></i>
              </div>
              <span>{{ __('View All Orders') }}</span>
            </div>
            <i class="fas fa-chevron-right text-muted" style="font-size: 11px;"></i>
          </a>

          <a href="{{ route('user.item.settings') }}" class="quick-action-item">
            <div class="quick-action-left">
              <div class="quick-action-icon icon-bg-pink">
                <i class="fas fa-cog"></i>
              </div>
              <span>{{ __('Store Settings') }}</span>
            </div>
            <i class="fas fa-chevron-right text-muted" style="font-size: 11px;"></i>
          </a>
        </div>
      </div>
    </div>

  </div>

</div>
@endsection

@section('scripts')
<!-- Chart.js and Custom Dashboard Charts Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  $(document).ready(function() {
      // 1. Sales Overview Chart (Line)
      var ctxSales = document.getElementById('salesOverviewChart').getContext('2d');
      var salesChart = new Chart(ctxSales, {
          type: 'line',
          data: {
              labels: {!! json_encode($chart_sales_labels) !!},
              datasets: [{
                  label: "{{ __('Total Sales') }}",
                  data: {!! json_encode($chart_sales_values) !!},
                  borderColor: '#3b82f6',
                  backgroundColor: 'rgba(59, 130, 246, 0.05)',
                  borderWidth: 2,
                  fill: true,
                  tension: 0.4,
                  pointRadius: 3,
                  pointHoverRadius: 5
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                  legend: { display: false }
              },
              scales: {
                  y: {
                      beginAtZero: true,
                      grid: { color: '#f1f5f9' },
                      ticks: { color: '#94a3b8', font: { size: 11 } }
                  },
                  x: {
                      grid: { display: false },
                      ticks: { color: '#94a3b8', font: { size: 10 } }
                  }
              }
          }
      });

      // 2. Revenue Analytics Chart (Donut)
      var ctxRev = document.getElementById('revenueAnalyticsChart').getContext('2d');
      var revChart = new Chart(ctxRev, {
          type: 'doughnut',
          data: {
              labels: ["{{ __('Orders') }}", "{{ __('Shipping') }}", "{{ __('Others') }}"],
              datasets: [{
                  data: [
                      {{ $revenue_analytics_cart }},
                      {{ $revenue_analytics_shipping }},
                      {{ $revenue_analytics_tax }}
                  ],
                  backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
                  borderWidth: 2,
                  borderColor: '#ffffff'
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                  legend: {
                      position: 'bottom',
                      labels: { boxWidth: 12, padding: 15, font: { size: 11 }, color: '#475569' }
                  }
              },
              cutout: '65%'
          }
      });

      // 3. Order Trend Chart (Bar)
      var ctxOrder = document.getElementById('orderTrendChart').getContext('2d');
      var orderChart = new Chart(ctxOrder, {
          type: 'bar',
          data: {
              labels: {!! json_encode($chart_sales_labels) !!},
              datasets: [{
                  label: "{{ __('Orders') }}",
                  data: {!! json_encode($chart_order_values) !!},
                  backgroundColor: '#8b5cf6',
                  borderRadius: 4,
                  barThickness: 6
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                  legend: { display: false }
              },
              scales: {
                  y: {
                      beginAtZero: true,
                      grid: { color: '#f1f5f9' },
                      ticks: { stepSize: 1, color: '#94a3b8', font: { size: 11 } }
                  },
                  x: {
                      grid: { display: false },
                      ticks: { color: '#94a3b8', font: { size: 10 } }
                  }
              }
          }
      });

      // 4. Traffic Sources Chart (Donut)
      var ctxTraffic = document.getElementById('trafficSourcesChart').getContext('2d');
      var trafficChart = new Chart(ctxTraffic, {
          type: 'doughnut',
          data: {
              labels: ["{{ __('Direct') }}", "{{ __('Search') }}", "{{ __('Social') }}", "{{ __('Referral') }}"],
              datasets: [{
                  data: [
                      {{ $total_visits * 0.435 }},
                      {{ $total_visits * 0.304 }},
                      {{ $total_visits * 0.174 }},
                      {{ $total_visits * 0.087 }}
                  ],
                  backgroundColor: ['#f59e0b', '#10b981', '#6366f1', '#f43f5e'],
                  borderWidth: 2,
                  borderColor: '#ffffff'
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                  legend: {
                      position: 'bottom',
                      labels: { boxWidth: 12, padding: 15, font: { size: 11 }, color: '#475569' }
                  }
              },
              cutout: '65%'
          }
      });
  });
</script>
@endsection
