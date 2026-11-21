<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ __('Sales Report') }}</title>
  @php
    $primary_color = !empty($userBs->base_color) ? ('#' . str_replace('#', '', $userBs->base_color)) : '#1e3a8a';
    $currSymbol = '₹';
    
    function fmtInr($amt) {
        return '₹' . number_format((float)$amt, 2, '.', ',');
    }
  @endphp
  <style>
    @page {
      margin: 12mm 10mm;
      size: a4 landscape;
    }
    * {
      font-family: 'DejaVu Sans', sans-serif !important;
      box-sizing: border-box;
    }
    body {
      font-family: 'DejaVu Sans', sans-serif !important;
      font-size: 10px;
      color: #1e293b;
      line-height: 1.4;
      margin: 0;
      padding: 0;
      background: #ffffff;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .bold { font-weight: bold; }

    /* Header */
    .header-table {
      border-bottom: 2px solid #0f172a;
      padding-bottom: 10px;
      margin-bottom: 12px;
    }
    .report-title {
      font-size: 18px;
      font-weight: bold;
      color: #0f172a;
      margin: 0 0 3px 0;
    }
    .report-subtitle {
      font-size: 10px;
      color: #64748b;
      margin: 0;
    }

    /* KPI Summary Cards */
    .kpi-table {
      margin-bottom: 14px;
    }
    .kpi-card {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 4px;
      padding: 8px 10px;
      text-align: center;
    }
    .kpi-label {
      font-size: 8px;
      font-weight: bold;
      text-transform: uppercase;
      color: #64748b;
      margin-bottom: 2px;
    }
    .kpi-value {
      font-size: 13px;
      font-weight: bold;
      color: #0f172a;
    }

    /* Orders Table */
    .report-table {
      width: 100%;
      border: 1px solid #cbd5e1;
      margin-top: 5px;
    }
    .report-table th {
      background-color: #0f172a;
      color: #ffffff;
      font-size: 8.5px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      padding: 6px 5px;
      border: 1px solid #0f172a;
    }
    .report-table td {
      border: 1px solid #e2e8f0;
      padding: 5px 5px;
      font-size: 8.5px;
      vertical-align: middle;
    }
    .report-table tr:nth-child(even) {
      background-color: #f8fafc;
    }
    .badge-pill {
      display: inline-block;
      padding: 2px 6px;
      font-size: 7.5px;
      font-weight: bold;
      border-radius: 3px;
    }
    .badge-completed {
      background-color: #ecfdf5;
      color: #047857;
    }
    .badge-pending {
      background-color: #fef3c7;
      color: #b45309;
    }
    .footer-total-row td {
      background-color: #f1f5f9 !important;
      font-weight: bold;
      font-size: 9px;
      border-top: 2px solid #0f172a;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <table class="header-table">
    <tr>
      <td style="width: 55%; vertical-align: middle;">
        <h1 class="report-title">{{ $userBs->website_title ?? ($user->username ?? 'LaunchShop Store') }}</h1>
        <p class="report-subtitle">Official Sales & Revenue Performance Report (Currency: INR - ₹)</p>
      </td>
      <td style="width: 45%; vertical-align: middle;" class="text-right">
        <div style="font-size: 9px; color: #64748b; line-height: 1.4;">
          <strong>Date Range:</strong> <span style="color: #0f172a; font-weight: bold;">{{ $rangeLabel ?? 'Filtered Period' }}</span><br>
          <strong>Generated At:</strong> {{ $generatedAt }}<br>
          <strong>Total Orders Exported:</strong> {{ count($orders) }}
        </div>
      </td>
    </tr>
  </table>

  <!-- KPI Summary Cards -->
  <table class="kpi-table" style="width: 100%;">
    <tr>
      <td style="width: 20%; padding-right: 4px;">
        <div class="kpi-card" style="border-left: 3px solid #10b981;">
          <div class="kpi-label">Total Revenue</div>
          <div class="kpi-value" style="color: #047857;">{{ fmtInr($totalRevenue) }}</div>
        </div>
      </td>
      <td style="width: 20%; padding: 0 2px;">
        <div class="kpi-card" style="border-left: 3px solid #3b82f6;">
          <div class="kpi-label">Total Orders</div>
          <div class="kpi-value" style="color: #1d4ed8;">{{ count($orders) }}</div>
        </div>
      </td>
      <td style="width: 20%; padding: 0 2px;">
        <div class="kpi-card" style="border-left: 3px solid #f59e0b;">
          <div class="kpi-label">Total Cart Subtotal</div>
          <div class="kpi-value" style="color: #b45309;">{{ fmtInr($totalCart) }}</div>
        </div>
      </td>
      <td style="width: 20%; padding: 0 2px;">
        <div class="kpi-card" style="border-left: 3px solid #8b5cf6;">
          <div class="kpi-label">Total GST Tax</div>
          <div class="kpi-value" style="color: #6d28d9;">{{ fmtInr($totalTax) }}</div>
        </div>
      </td>
      <td style="width: 20%; padding-left: 4px;">
        <div class="kpi-card" style="border-left: 3px solid #ec4899;">
          <div class="kpi-label">Total Shipping</div>
          <div class="kpi-value" style="color: #be185d;">{{ fmtInr($totalShipping) }}</div>
        </div>
      </td>
    </tr>
  </table>

  <!-- Sales Data Table -->
  <table class="report-table">
    <thead>
      <tr>
        <th class="text-center" style="width: 3%;">#</th>
        <th class="text-left" style="width: 11%;">Order #</th>
        <th class="text-left" style="width: 8%;">Date</th>
        <th class="text-left" style="width: 14%;">Customer Name</th>
        <th class="text-left" style="width: 11%;">Phone / Email</th>
        <th class="text-left" style="width: 9%;">Gateway</th>
        <th class="text-center" style="width: 7%;">Pay Status</th>
        <th class="text-center" style="width: 7%;">Order Status</th>
        <th class="text-right" style="width: 7%;">Cart (₹)</th>
        <th class="text-right" style="width: 6%;">Tax (₹)</th>
        <th class="text-right" style="width: 6%;">Ship (₹)</th>
        <th class="text-right" style="width: 6%;">Disc (₹)</th>
        <th class="text-right" style="width: 8%;">Total (₹)</th>
      </tr>
    </thead>
    <tbody>
      @php
        $sumCart = 0;
        $sumTax = 0;
        $sumShipping = 0;
        $sumDiscount = 0;
        $sumTotal = 0;
      @endphp
      @foreach ($orders as $idx => $o)
        @php
          $sumCart += ($o->cart_total ?? 0);
          $sumTax += ($o->tax ?? 0);
          $sumShipping += ($o->shipping_charge ?? 0);
          $sumDiscount += ($o->discount ?? 0);
          $sumTotal += ($o->total ?? 0);

          $cName = !empty($o->billing_fname) ? ($o->billing_fname . ' ' . ($o->billing_lname ?? '')) : ($o->shipping_fname ?? 'Customer');
          $cPhone = !empty($o->billing_number) ? $o->billing_number : ($o->shipping_number ?? '-');
        @endphp
        <tr>
          <td class="text-center bold">{{ $idx + 1 }}</td>
          <td class="text-left bold" style="color: #0f172a;">#{{ $o->order_number }}</td>
          <td class="text-left">{{ \Carbon\Carbon::parse($o->created_at)->format('d-M-Y') }}</td>
          <td class="text-left bold">{{ $cName }}</td>
          <td class="text-left" style="font-size: 8px;">{{ $cPhone }}</td>
          <td class="text-left">{{ ucfirst($o->method ?? 'Online') }}</td>
          <td class="text-center">
            <span class="badge-pill {{ strtolower($o->payment_status) == 'completed' ? 'badge-completed' : 'badge-pending' }}">
              {{ ucfirst($o->payment_status ?? 'Pending') }}
            </span>
          </td>
          <td class="text-center">
            <span class="badge-pill {{ strtolower($o->order_status) == 'completed' ? 'badge-completed' : 'badge-pending' }}">
              {{ ucfirst($o->order_status ?? 'Pending') }}
            </span>
          </td>
          <td class="text-right">{{ fmtInr($o->cart_total ?? 0) }}</td>
          <td class="text-right">{{ fmtInr($o->tax ?? 0) }}</td>
          <td class="text-right">{{ fmtInr($o->shipping_charge ?? 0) }}</td>
          <td class="text-right" style="color: #dc2626;">{{ ($o->discount > 0) ? ('-' . fmtInr($o->discount)) : '₹0.00' }}</td>
          <td class="text-right bold" style="color: #047857;">{{ fmtInr($o->total ?? 0) }}</td>
        </tr>
      @endforeach

      <!-- Grand Totals Row -->
      <tr class="footer-total-row">
        <td colspan="8" class="text-right bold">Grand Totals (INR):</td>
        <td class="text-right bold">{{ fmtInr($sumCart) }}</td>
        <td class="text-right bold">{{ fmtInr($sumTax) }}</td>
        <td class="text-right bold">{{ fmtInr($sumShipping) }}</td>
        <td class="text-right bold" style="color: #dc2626;">-{{ fmtInr($sumDiscount) }}</td>
        <td class="text-right bold" style="color: #047857;">{{ fmtInr($sumTotal) }}</td>
      </tr>
    </tbody>
  </table>

  <!-- Page Footer -->
  <table style="width: 100%; margin-top: 15px; font-size: 8px; color: #64748b; border-top: 1px solid #cbd5e1; padding-top: 5px;">
    <tr>
      <td style="width: 50%;">
        Generated by LaunchShop E-Commerce Management System &bull; All amounts displayed in Indian Rupees (INR - ₹)
      </td>
      <td style="width: 50%;" class="text-right">
        Report Generated on {{ $generatedAt }}
      </td>
    </tr>
  </table>

</body>
</html>
