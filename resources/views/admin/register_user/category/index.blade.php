@extends('admin.layout')

@section('content')
  <!-- Page Header & Breadcrumbs -->
  <div class="page-header mb-4">
    <h3 class="fw-bold m-0" style="font-size: 1.5rem; color: var(--text-main);">{{ __('Categories') }}</h3>
    <ul class="breadcrumbs p-0 m-0 d-flex align-items-center" style="gap: 8px; list-style: none; font-size: 0.85rem;">
      <li class="nav-home">
        <a href="{{ route('admin.dashboard') }}" class="text-primary">
          <i class="fas fa-home"></i>
        </a>
      </li>
      <li class="separator text-muted">/</li>
      <li class="nav-item">
        <a href="#" class="text-muted">{{ __('Users Management') }}</a>
      </li>
      <li class="separator text-muted">/</li>
      <li class="nav-item">
        <span class="text-subtle">{{ __('Categories') }}</span>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">

      <div class="card-table-custom">
        <!-- Card Header -->
        <div class="card-table-header">
          <div class="card-table-title">
            <div class="icon-badge">
              <i class="fas fa-th-large"></i>
            </div>
            <span>{{ __('Categories') }}</span>
          </div>

          <div class="card-table-actions">
            <div class="mr-2">
              @include('admin.partials.languages')
            </div>
            <a href="#" class="btn-add-category" data-toggle="modal" data-target="#createModal">
              <i class="fas fa-plus"></i> {{ __('Add Category') }}
            </a>
          </div>
        </div>

        <!-- Table Body -->
        <div class="p-0">
          @if (count($categories) == 0)
            <div class="p-5 text-center">
              <h4 class="text-muted">{{ __('NO CATEGORIES FOUND') }}</h4>
            </div>
          @else
            <div class="table-responsive">
              <table class="custom-table" id="basic-datatables">
                <thead>
                  <tr>
                    <th scope="col" style="width: 60px;">#</th>
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col" style="width: 140px;">{{ __('Serial Number') }}</th>
                    <th scope="col" style="width: 160px; text-align: right;">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $itemIcons = [
                      'jeweller' => ['icon' => 'fas fa-gem', 'class' => 'purple-item'],
                      'skinflow' => ['icon' => 'fas fa-pump-soap', 'class' => 'blue-item'],
                      'pet'      => ['icon' => 'fas fa-paw', 'class' => 'pink-item'],
                      'electron' => ['icon' => 'fas fa-laptop', 'class' => 'orange-item'],
                      'grocer'   => ['icon' => 'fas fa-shopping-cart', 'class' => 'green-item'],
                      'furnit'   => ['icon' => 'fas fa-chair', 'class' => 'cyan-item'],
                    ];
                  @endphp

                  @foreach ($categories as $category)
                    @php
                      $nameLower = strtolower($category->name);
                      $matchedIcon = 'fas fa-layer-group';
                      $matchedClass = 'purple-item';

                      foreach ($itemIcons as $key => $conf) {
                        if (str_contains($nameLower, $key)) {
                          $matchedIcon = $conf['icon'];
                          $matchedClass = $conf['class'];
                          break;
                        }
                      }
                    @endphp
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>
                        <div class="cat-item-wrapper">
                          <div class="cat-icon-badge {{ $matchedClass }}">
                            <i class="{{ $matchedIcon }}"></i>
                          </div>
                          <span class="cat-name-text">{{ $category->name }}</span>
                        </div>
                      </td>
                      <td>
                        @if ($category->status == 1)
                          <span class="badge-status-active">{{ __('Active') }}</span>
                        @else
                          <span class="badge badge-danger rounded-pill px-3 py-2" style="font-size: 0.75rem;">{{ __('Deactive') }}</span>
                        @endif
                      </td>
                      <td>{{ $category->serial_number }}</td>
                      <td>
                        <div class="action-btn-group justify-content-end">
                          <a class="btn-action-purple"
                            href="{{ route('register.user.category_edit', $category->id) . '?language=' . request()->input('language') }}"
                            title="{{ __('Edit') }}">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <form class="deleteform d-inline-block m-0" action="{{ route('register.user.category_delete') }}" method="post">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                            <button type="submit" class="btn-action-red deletebtn" title="{{ __('Delete') }}">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </form>
                          <button class="btn-action-dots" title="{{ __('More Options') }}">
                            <i class="fas fa-ellipsis-v"></i>
                          </button>
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


  <!-- Create Category Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
        <div class="modal-header border-bottom">
          <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">{{ __('Add Category') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-4">
          <form id="ajaxForm" class="modal-form" action="{{ route('register.user.category_store') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @foreach ($langs as $lang)
              <div class="form-group">
                <label class="font-weight-bold mb-1">{{ __('Name') }} ({{ $lang->name }})
                  @if ($lang->is_default == 1)
                    <span class="text-danger">*</span>
                  @endif
                </label>

                <input type="text"
                  class="form-control rounded-lg {{ $lang->rtl == 1 ? 'important_rtl text-right' : 'important_ltr' }}"
                  name="{{ $lang->code }}_name" value="" placeholder="{{ __('Enter name') }}">
                <p id="err{{ $lang->code }}_name" class="mb-0 text-danger em"></p>
              </div>
            @endforeach
            <div class="form-group">
              <label class="font-weight-bold mb-1">{{ __('Status') }} <span class="text-danger">*</span></label>
              <select class="form-control rounded-lg" name="status">
                <option value="" selected disabled>{{ __('Select a status') }}</option>
                <option value="1">{{ __('Active') }}</option>
                <option value="0">{{ __('Deactive') }}</option>
              </select>
              <p id="errstatus" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label class="font-weight-bold mb-1">{{ __('Serial Number') }} <span class="text-danger">*</span></label>
              <input type="number" class="form-control rounded-lg" name="serial_number" value=""
                placeholder="{{ __('Enter Serial Number') }}">
              <p id="errserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning mt-1">
                <small>{{ __('The higher the serial number is, the later the user category will be shown.') }}</small>
              </p>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top p-3">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">{{ __('Close') }}</button>
          <button id="submitBtn" type="button" class="btn btn-primary rounded-pill px-4">{{ __('Submit') }}</button>
        </div>
      </div>
    </div>
  </div>
@endsection
