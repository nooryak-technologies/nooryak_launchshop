<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ __('Shipping Parcel Stickers') }}</title>
  @php
    $primary_color = !empty($userBs->base_color) ? ('#' . str_replace('#', '', $userBs->base_color)) : '#0f172a';
    $currSymbol = '₹';
    
    function fmtInr($amt) {
        return '₹' . number_format((float)$amt, 2, '.', ',');
    }
  @endphp
  <style>
    @page {
      margin: 8mm 8mm;
      size: a4 portrait;
    }
    * {
      font-family: 'DejaVu Sans', sans-serif !important;
      box-sizing: border-box;
    }
    body {
      font-family: 'DejaVu Sans', sans-serif !important;
      font-size: 10px;
      color: #0f172a;
      line-height: 1.35;
      margin: 0;
      padding: 0;
      background: #ffffff;
    }
    .sticker-container {
      width: 100%;
      border: 2px solid #0f172a;
      border-radius: 4px;
      padding: 10px;
      margin-bottom: 15px;
      page-break-after: always;
      background: #ffffff;
    }
    .sticker-container:last-child {
      page-break-after: avoid;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .bold { font-weight: bold; }

    /* Header Bar */
    .header-table {
      border-bottom: 2px solid #0f172a;
      padding-bottom: 8px;
      margin-bottom: 8px;
    }
    .store-brand {
      font-size: 16px;
      font-weight: bold;
      color: #0f172a;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .label-tag {
      font-size: 9px;
      color: #475569;
      font-weight: normal;
      margin-top: 2px;
    }

    /* Badges */
    .badge-box {
      border: 2px solid #0f172a;
      padding: 6px 12px;
      border-radius: 4px;
      text-align: center;
      display: inline-block;
    }
    .badge-cod {
      background-color: #fee2e2;
      border-color: #dc2626;
      color: #991b1b;
    }
    .badge-prepaid {
      background-color: #ecfdf5;
      border-color: #059669;
      color: #065f46;
    }

    /* Meta Barcode section */
    .meta-box {
      border: 1px solid #cbd5e1;
      background: #f8fafc;
      padding: 8px;
      margin-bottom: 8px;
      border-radius: 3px;
    }
    .order-barcode {
      font-family: monospace !important;
      font-size: 14px;
      font-weight: bold;
      letter-spacing: 3px;
      padding: 2px 0;
      color: #0f172a;
    }

    /* Address Grid */
    .address-table {
      margin-bottom: 8px;
      border: 1px solid #0f172a;
    }
    .address-table td {
      vertical-align: top;
      padding: 8px 10px;
      font-size: 10px;
    }
    .address-to {
      width: 60%;
      border-right: 1px solid #0f172a;
      background-color: #ffffff;
    }
    .address-from {
      width: 40%;
      background-color: #f8fafc;
    }
    .addr-heading {
      font-size: 10px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #475569;
      border-bottom: 1px dashed #cbd5e1;
      padding-bottom: 3px;
      margin-bottom: 4px;
    }
    .addr-name {
      font-size: 12px;
      font-weight: bold;
      color: #0f172a;
      margin-bottom: 3px;
    }
    .addr-phone {
      font-size: 11px;
      font-weight: bold;
      color: #0f172a;
      margin-top: 5px;
    }

    /* Items Table */
    .items-table {
      border: 1px solid #0f172a;
      margin-bottom: 8px;
    }
    .items-table th {
      background-color: #0f172a;
      color: #ffffff;
      font-size: 9px;
      text-transform: uppercase;
      padding: 5px 6px;
      border: 1px solid #0f172a;
    }
    .items-table td {
      border: 1px solid #e2e8f0;
      padding: 5px 6px;
      font-size: 9px;
      vertical-align: top;
    }
    .variation-chip {
      display: inline-block;
      font-size: 8px;
      color: #475569;
      background: #f1f5f9;
      padding: 1px 4px;
      border-radius: 2px;
      margin-top: 2px;
    }

    /* Summary Calculation */
    .summary-table td {
      padding: 3px 6px;
      font-size: 9px;
    }
    .total-highlight {
      font-size: 12px;
      font-weight: bold;
      color: #0f172a;
      background: #f1f5f9;
      border-top: 1px solid #0f172a;
      border-bottom: 1px solid #0f172a;
    }

    /* Notice & Footer */
    .sticker-footer {
      border-top: 1px dashed #94a3b8;
      padding-top: 5px;
      margin-top: 6px;
      font-size: 8px;
      color: #64748b;
    }
    .cut-line {
      border-top: 1px dashed #94a3b8;
      margin: 10px 0;
      text-align: center;
      position: relative;
    }
  </style>
</head>
<body>

  @foreach ($orders as $index => $order)
    @php
      $isCod = (stripos($order->method, 'cod') !== false || stripos($order->method, 'cash') !== false || strtolower($order->gateway_type) == 'offline');
      $deliveryName = !empty($order->shipping_fname) ? ($order->shipping_fname . ' ' . ($order->shipping_lname ?? '')) : ($order->billing_fname . ' ' . ($order->billing_lname ?? ''));
      $deliveryPhone = !empty($order->shipping_number) ? $order->shipping_number : $order->billing_number;
      $deliveryEmail = !empty($order->shipping_email) ? $order->shipping_email : $order->billing_email;
      $deliveryAddr = !empty($order->shipping_address) ? $order->shipping_address : $order->billing_address;
      $deliveryCity = !empty($order->shipping_city) ? $order->shipping_city : $order->billing_city;
      $deliveryState = !empty($order->shipping_state) ? $order->shipping_state : $order->billing_state;
      $deliveryCountry = !empty($order->shipping_country) ? $order->shipping_country : $order->billing_country;
      
      $senderName = $userBs->website_title ?? ($user->username ?? 'LaunchShop Store');
      $senderAddr = !empty($userBs->address) ? $userBs->address : 'Store Warehouse & Fulfillment Center';
      $senderPhone = !empty($userBs->phone) ? $userBs->phone : ($user->phone ?? '');
      $senderEmail = !empty($userBs->email) ? $userBs->email : ($user->email ?? '');

      $logoDataUri = null;
      if (!empty($userBs->logo)) {
          $possiblePaths = [
              public_path('assets/front/img/user/' . $userBs->logo),
              public_path('assets/user/img/' . $userBs->logo),
              public_path('assets/front/img/' . $userBs->logo),
              public_path($userBs->logo),
          ];
          foreach ($possiblePaths as $path) {
              if (file_exists($path) && is_file($path)) {
                  $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                  $mime = ($ext === 'svg') ? 'image/svg+xml' : (($ext === 'png') ? 'image/png' : (($ext === 'jpg' || $ext === 'jpeg') ? 'image/jpeg' : 'image/' . $ext));
                  $logoDataUri = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
                  break;
              }
          }
      }
    @endphp

    <div class="sticker-container">
      <!-- Header -->
      <table class="header-table">
        <tr>
          <td style="width: 50%; vertical-align: middle;">
            @if (!empty($logoDataUri))
              <img src="{{ $logoDataUri }}" style="max-height: 44px; max-width: 180px; display: block; margin-bottom: 4px;" alt="Logo">
            @else
              <div class="store-brand">{{ $senderName }}</div>
            @endif
            <div class="label-tag">E-Commerce Shipping Package Label & Packing Slip</div>
          </td>
          <td style="width: 50%; vertical-align: middle;" class="text-right">
            @if ($isCod)
              <div class="badge-box badge-cod">
                <div style="font-size: 11px; font-weight: bold; letter-spacing: 0.5px;">CASH ON DELIVERY (COD)</div>
                <div style="font-size: 13px; font-weight: bold; margin-top: 1px;">COLLECT: {{ fmtInr($order->total) }}</div>
              </div>
            @endif
          </td>
        </tr>
      </table>

      <!-- Order Metadata Box -->
      <div class="meta-box">
        <table style="width: 100%;">
          <tr>
            <td style="width: 35%;">
              <div style="font-size: 9px; color: #64748b; text-transform: uppercase;">Order Number</div>
              <div style="font-size: 13px; font-weight: bold; color: #0f172a;">#{{ $order->order_number }}</div>
            </td>
            <td style="width: 35%; padding-left: 10px;">
              <div style="font-size: 9px; color: #64748b; text-transform: uppercase;">Order Date & Time</div>
              <div style="font-size: 10px; font-weight: bold;">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</div>
              <div style="font-size: 9px; color: #475569; margin-top: 2px;">
                <strong>Payment Mode:</strong> {{ ucfirst($order->method ?? 'Online') }}
              </div>
            </td>
            <td style="width: 30%;" class="text-right">
              <div style="font-size: 9px; color: #64748b; text-transform: uppercase;">Shipping Gateway</div>
              <div style="font-size: 10px; font-weight: bold; color: #0f172a;">{{ $order->shipping_method ?? 'Standard Delivery' }}</div>
              <div style="font-size: 9px; color: #475569; margin-top: 2px;">
                Status: <span style="font-weight: bold; color: #059669;">{{ ucfirst($order->order_status ?? 'Completed') }}</span>
              </div>
            </td>
          </tr>
        </table>
      </div>

      <!-- FROM & TO Address Grid -->
      <table class="address-table">
        <tr>
          <!-- DELIVER TO -->
          <td class="address-to">
            <div class="addr-heading">DELIVER TO (RECIPIENT)</div>
            <div class="addr-name">{{ $deliveryName }}</div>
            <div style="line-height: 1.4; color: #334155;">
              {{ $deliveryAddr }}<br>
              <strong>{{ $deliveryCity }}</strong>{{ !empty($deliveryState) ? (', ' . $deliveryState) : '' }}<br>
              {{ $deliveryCountry }}
            </div>
            <div class="addr-phone">
              MOBILE: {{ $deliveryPhone }}
            </div>
            @if (!empty($deliveryEmail))
              <div style="font-size: 9px; color: #64748b; margin-top: 1px;">Email: {{ $deliveryEmail }}</div>
            @endif
          </td>

          <!-- SHIPPED FROM -->
          <td class="address-from">
            <div class="addr-heading">SHIPPED FROM (SENDER)</div>
            <div class="addr-name" style="font-size: 11px;">{{ $senderName }}</div>
            <div style="line-height: 1.4; color: #475569;">
              {{ $senderAddr }}<br>
              @if (!empty($userBs->city) || !empty($userBs->state))
                {{ $userBs->city ?? '' }}{{ !empty($userBs->state) ? (', ' . $userBs->state) : '' }}<br>
              @endif
              India
            </div>
            @if (!empty($senderPhone))
              <div style="margin-top: 4px; font-weight: bold; font-size: 9px; color: #0f172a;">
                Support: {{ $senderPhone }}
              </div>
            @endif
            @if (!empty($senderEmail))
              <div style="font-size: 8px; color: #64748b;">{{ $senderEmail }}</div>
            @endif
          </td>
        </tr>
      </table>

      <!-- Product Items in Order -->
      <table class="items-table">
        <thead>
          <tr>
            <th class="text-center" style="width: 5%;">#</th>
            <th class="text-left" style="width: 50%;">Product Details & Variation</th>
            <th class="text-center" style="width: 15%;">SKU</th>
            <th class="text-center" style="width: 8%;">Qty</th>
            <th class="text-right" style="width: 11%;">Price</th>
            <th class="text-right" style="width: 11%;">Total</th>
          </tr>
        </thead>
        <tbody>
          @php
            $itemIndex = 1;
          @endphp
          @if ($order->orderitems && count($order->orderitems) > 0)
            @foreach ($order->orderitems as $item)
              @php
                $variations = !empty($item->variations) ? json_decode($item->variations) : null;
                $rowTotal = ($item->price ?? 0) * ($item->qty ?? 1);
              @endphp
              <tr>
                <td class="text-center bold">{{ $itemIndex++ }}</td>
                <td class="text-left">
                  <div class="bold" style="color: #0f172a;">{{ $item->title ?? 'Product Item' }}</div>
                  @if (!empty($variations))
                    <div style="margin-top: 2px;">
                      @foreach ($variations as $varKey => $varVal)
                        @php
                          $vName = isset($varVal->name) ? $varVal->name : '';
                        @endphp
                        <span class="variation-chip">
                          <strong>{{ is_string($varKey) ? $varKey : 'Option' }}:</strong> {{ $vName }}
                        </span>
                      @endforeach
                    </div>
                  @endif
                </td>
                <td class="text-center" style="color: #64748b; font-family: monospace;">
                  {{ !empty($item->sku) ? $item->sku : '-' }}
                </td>
                <td class="text-center bold" style="font-size: 10px;">{{ $item->qty ?? 1 }}</td>
                <td class="text-right">{{ fmtInr($item->price ?? 0) }}</td>
                <td class="text-right bold">{{ fmtInr($rowTotal) }}</td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="6" class="text-center" style="padding: 10px; color: #64748b;">
                {{ __('No item details recorded for this order.') }}
              </td>
            </tr>
          @endif
        </tbody>
      </table>

      <!-- Summary & Total Calculation -->
      <table style="width: 100%; margin-bottom: 6px;">
        <tr>
          <td style="width: 55%; vertical-align: top; padding-right: 10px;">
            <div style="border: 1px dashed #cbd5e1; border-radius: 4px; padding: 6px; background: #f8fafc; font-size: 8.5px; color: #475569;">
              <strong>Delivery Instructions:</strong><br>
              &bull; Please inspect package seal before accepting delivery.<br>
              &bull; If package is damaged or tampered, do not accept.<br>
              &bull; For customer support or returns, visit <strong>{{ $senderName }}</strong>.
            </div>
          </td>
          <td style="width: 45%; vertical-align: top;">
            <table class="summary-table" style="width: 100%; border: 1px solid #cbd5e1;">
              <tr>
                <td class="text-left" style="color: #475569;">Cart Subtotal:</td>
                <td class="text-right bold">{{ fmtInr($order->cart_total ?? ($order->total - ($order->shipping_charge ?? 0))) }}</td>
              </tr>
              @if (!empty($order->shipping_charge) && $order->shipping_charge > 0)
                <tr>
                  <td class="text-left" style="color: #475569;">Shipping Fee:</td>
                  <td class="text-right bold">{{ fmtInr($order->shipping_charge) }}</td>
                </tr>
              @endif
              @if (!empty($order->discount) && $order->discount > 0)
                <tr>
                  <td class="text-left" style="color: #dc2626;">Discount:</td>
                  <td class="text-right bold" style="color: #dc2626;">-{{ fmtInr($order->discount) }}</td>
                </tr>
              @endif
              @if (!empty($order->tax) && $order->tax > 0)
                <tr>
                  <td class="text-left" style="color: #475569;">GST Tax:</td>
                  <td class="text-right bold">{{ fmtInr($order->tax) }}</td>
                </tr>
              @endif
              <tr class="total-highlight">
                <td class="text-left bold" style="padding: 5px 6px;">Grand Total:</td>
                <td class="text-right bold" style="padding: 5px 6px;">{{ fmtInr($order->total) }}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

      <!-- Footer Notice -->
      <table class="sticker-footer" style="width: 100%;">
        <tr>
          <td style="width: 60%;">
            This is a computer-generated shipping document & invoice. Requires no physical signature.
          </td>
          <td style="width: 40%;" class="text-right">
            Page {{ $index + 1 }} of {{ count($orders) }} &bull; Order #{{ $order->order_number }}
          </td>
        </tr>
      </table>
    </div>
  @endforeach

</body>
</html>
