@extends('user.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Themes') }}</h4>
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
        <a href="#">{{ __('Site Settings') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Themes') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title">{{ __('Themes') }}</div>
            </div>
          </div>
        </div>

        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 m-auto">
              <form id="themeAjaxForm" action="{{ route('user.theme.update') }}" method="post">
                @csrf

                <div class="form-group">
                  <label class="form-label">{{ __('Theme') }} <span class="text-danger">**</span></label>
                  <div class="row">
                    @php
                      $currentTheme = !empty($data->theme) ? $data->theme : 'clothing';
                      $themes = [
                        ['key' => 'electronics', 'name' => 'Electronics', 'img' => 'electronics.PNG'],
                        ['key' => 'fashion', 'name' => 'Fashion', 'img' => 'fashion.PNG'],
                        ['key' => 'furniture', 'name' => 'Furniture', 'img' => 'furniture.PNG'],
                        ['key' => 'kids', 'name' => 'Kids', 'img' => 'kids.PNG'],
                        ['key' => 'vegetables', 'name' => 'Grocery', 'img' => 'vegetables.PNG'],
                        ['key' => 'manti', 'name' => 'Multipurpose', 'img' => 'manti.png'],
                        ['key' => 'pet', 'name' => 'Pet', 'img' => 'pet.png'],
                        ['key' => 'skinflow', 'name' => 'Skinflow', 'img' => 'skinflow.png'],
                        ['key' => 'jewellery', 'name' => 'Jewellery', 'img' => 'jewellery.png'],
                        ['key' => 'clothing', 'name' => 'Clothing', 'img' => 'clothing.png'],
                        ['key' => 'grocery2', 'name' => 'Ecom Grocery', 'img' => 'grocery2.png'],
                      ];
                    @endphp

                    @foreach ($themes as $thm)
                      @php
                        $isSelected = ($thm['key'] == $currentTheme);
                      @endphp
                      <div class="col-6 col-sm-4 mb-4">
                        <div style="position: relative;">
                          <label class="imagecheck mb-2" style="{{ $isSelected ? 'border: 2px solid #22c55e; border-radius: 8px; box-shadow: 0 4px 12px rgba(34,197,94,0.25); cursor: pointer;' : 'opacity: 0.65; filter: grayscale(40%); cursor: not-allowed; pointer-events: none;' }}">
                            <input name="theme" type="radio" value="{{ $thm['key'] }}" class="imagecheck-input"
                              {{ $isSelected ? 'checked' : 'disabled' }}>
                            <figure class="imagecheck-figure" style="position: relative; overflow: hidden; margin-bottom: 0; border-radius: 6px;">
                              <img src="{{ asset('assets/front/img/user/themes/' . $thm['img']) }}" alt="{{ $thm['name'] }}"
                                class="imagecheck-image">
                              @if(!$isSelected)
                                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.45); display: flex; align-items: center; justify-content: center; z-index: 2;">
                                  <span class="badge badge-warning" style="font-size: 11px; font-weight: 700; padding: 5px 10px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 6px rgba(0,0,0,0.3);">{{ __('Coming Soon') }}</span>
                                </div>
                              @endif
                            </figure>
                          </label>
                          <h5 class="text-center mb-1" style="font-weight: 600; font-size: 14px;">
                            {{ __($thm['name']) }}
                            @if($isSelected)
                              <span class="badge badge-success ml-1" style="font-size: 10px; vertical-align: middle;">{{ __('Active') }}</span>
                            @endif
                          </h5>
                          @if($thm['key'] == 'grocery2' && $isSelected)
                            <div class="text-center">
                              @php
                                $grocery2PreviewUrl = detailsUrl(Auth::user('web'));
                                $grocery2PreviewUrl .= (str_contains($grocery2PreviewUrl, '?') ? '&' : '?') . 'preview_theme=grocery2';
                              @endphp
                              <a href="{{ $grocery2PreviewUrl }}" target="_blank" class="btn btn-primary btn-sm mt-1 py-1 px-2" style="font-size: 11px;">
                                <i class="fas fa-eye mr-1"></i>{{ __('Preview') }}
                              </a>
                            </div>
                          @endif
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="button" id="themeSubmitBtn" class="btn btn-success">
                {{ __('Update') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
  $('#themeSubmitBtn').on('click', function(e) {
    e.preventDefault();
    $('.request-loader').addClass('show');
    var $btn = $(this);
    $btn.prop('disabled', true);
    var form = document.getElementById('themeAjaxForm');
    var fd = new FormData(form);

    $.ajax({
      url: $(form).attr('action'),
      method: 'POST',
      data: fd,
      processData: false,
      contentType: false,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      success: function(res) {
        $('.request-loader').removeClass('show');
        $btn.prop('disabled', false);
        bootnotify("{{ __('Theme updated successfully!') }}", 'Success', 'success');
      },
      error: function(xhr) {
        $('.request-loader').removeClass('show');
        $btn.prop('disabled', false);
        bootnotify("{{ __('Something went wrong') }}", 'Warning', 'warning');
      }
    });
  });
});
</script>
@endsection
