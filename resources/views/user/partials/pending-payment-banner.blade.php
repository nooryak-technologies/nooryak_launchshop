@php
  use App\Models\Membership;
  $pendingUpiMembership = null;
  if (Auth::check()) {
      $pendingUpiMembership = Membership::where('user_id', Auth::id())
          ->where('status', 0)
          ->whereYear('start_date', '<>', '9999')
          ->latest()
          ->first();
  }
@endphp

@if ($pendingUpiMembership)
  <div class="alert alert-warning mb-4 shadow-sm border-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between p-3" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border-left: 5px solid #f59e0b !important; border-radius: 12px; color: #92400e;">
    <div class="d-flex align-items-center mb-2 mb-md-0">
      <div class="mr-3 text-warning" style="font-size: 26px;">
        <i class="fas fa-clock fa-spin" style="animation-duration: 4s;"></i>
      </div>
      <div>
        <h5 class="mb-1 font-weight-bold" style="color: #78350f; font-size: 15px;">
          {{ __('Payment Verification Pending') }} 
          <span class="badge badge-warning ml-1 font-weight-bold" style="font-size: 11px; background-color: #f59e0b; color: #fff;">{{ __('Pending Approval') }}</span>
        </h5>
        <p class="mb-0 text-muted" style="font-size: 13px; color: #92400e !important;">
          {{ __('Your plan payment of') }} <strong>{{ format_price($pendingUpiMembership->price) }}</strong> {{ __('via') }} <strong>{{ $pendingUpiMembership->payment_method ?? 'UPI' }}</strong> 
          @if (!empty($pendingUpiMembership->transaction_id))
            ({{ __('UTR') }}: <strong>{{ $pendingUpiMembership->transaction_id }}</strong>)
          @endif
          {{ __('is currently under review by our admin team. Your plan will activate automatically upon approval.') }}
        </p>
      </div>
    </div>
    <div class="d-flex align-items-center mt-2 mt-md-0 flex-shrink-0">
      <button type="button" class="btn btn-sm btn-warning font-weight-bold shadow-sm" data-toggle="modal" data-target="#userUploadProofModal" style="background: #f59e0b; border-color: #d97706; color: #fff; border-radius: 8px; padding: 7px 15px;">
        <i class="fas fa-file-invoice mr-1"></i> 
        {{ !empty($pendingUpiMembership->receipt) ? __('View / Update Proof') : __('Upload Payment Proof & UTR') }}
      </button>
    </div>
  </div>

  <!-- User Upload Proof Modal -->
  <div class="modal fade" id="userUploadProofModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content shadow-lg" style="border-radius: 14px; border: none; overflow: hidden;">
        <div class="modal-header py-3 px-4" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
          <h5 class="modal-title font-weight-bold text-dark" style="font-size: 15px;">
            <i class="fas fa-receipt text-warning mr-2"></i> {{ __('Submit UPI Payment Proof & UTR') }}
          </h5>
          <button type="button" class="close text-secondary" data-dismiss="modal" aria-label="Close" style="outline: none;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('user.membership.upload-proof') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="membership_id" value="{{ $pendingUpiMembership->id }}">
          <div class="modal-body p-4">
            <div class="form-group mb-3 px-0">
              <label class="font-weight-bold text-dark" style="font-size: 13px;">{{ __('UTR / Transaction Reference Number') }}</label>
              <input type="text" name="transaction_id" class="form-control" placeholder="{{ __('Enter 12-digit UPI reference / UTR number') }}" value="{{ $pendingUpiMembership->transaction_id ?? '' }}" style="border-radius: 8px;">
              <small class="text-muted">{{ __('Found in your GPay / PhonePe / Paytm / Bank transaction receipt.') }}</small>
            </div>

            <div class="form-group mb-2 px-0">
              <label class="font-weight-bold text-dark" style="font-size: 13px;">{{ __('Payment Screenshot / Receipt') }}</label>
              <input type="file" name="receipt" class="form-control-file" accept="image/*,.pdf" style="font-size: 13px;">
              <small class="text-muted d-block mt-1">{{ __('Upload PNG, JPG, JPEG, WEBP or PDF (max 10MB).') }}</small>

              @if (!empty($pendingUpiMembership->receipt))
                <div class="mt-3 p-2 bg-light rounded border text-center">
                  <span class="d-block small text-muted font-weight-bold mb-1">{{ __('Currently Uploaded Proof:') }}</span>
                  <a href="{{ asset('assets/front/img/membership/receipt/' . $pendingUpiMembership->receipt) }}" target="_blank" class="btn btn-xs btn-outline-primary py-1 px-3" style="border-radius: 6px;">
                    <i class="fas fa-eye mr-1"></i> {{ __('View Existing Receipt') }}
                  </a>
                </div>
              @endif
            </div>
          </div>
          <div class="modal-footer py-2 px-4 bg-light d-flex justify-content-between">
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" style="border-radius: 8px;">{{ __('Cancel') }}</button>
            <button type="submit" class="btn btn-sm btn-primary font-weight-bold" style="border-radius: 8px; padding: 7px 18px;">
              <i class="fas fa-check mr-1"></i> {{ __('Submit Proof') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endif

