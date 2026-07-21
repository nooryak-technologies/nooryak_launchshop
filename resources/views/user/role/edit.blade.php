@extends('user.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Edit Staff Role') }}</h4>
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
        <a href="{{ route('user.role.index') }}">{{ __('Roles & Permissions') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Edit Role') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{ __('Edit Role & Permissions') }}</div>
          <a class="btn btn-info btn-sm float-right" href="{{ route('user.role.index') }}">
            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
          </a>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <form id="ajaxForm" action="{{ route('user.role.update') }}" method="POST">
                @csrf
                <input type="hidden" name="role_id" value="{{ $role->id }}">

                <div class="form-group">
                  <label for="">{{ __('Role Name') }} *</label>
                  <input type="text" class="form-control" name="name" value="{{ $role->name }}" placeholder="{{ __('Enter role name') }}">
                  <p id="errname" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                  <label class="form-label"><strong>{{ __('Assign Permissions') }} *</strong></label>
                  <p id="errpermissions" class="mb-2 text-danger em"></p>

                  @php
                    $rolePermissions = !empty($role->permissions) ? json_decode($role->permissions, true) : [];
                    $allPermissions = [
                        'Shop Management',
                        'Products',
                        'Orders',
                        'Coupons',
                        'Shipping Charges',
                        'Shipping Gateways',
                        'Currencies',
                        'Shop Settings',
                        'Registered Customers',
                        'Pages',
                        'Subscribers',
                        'Staff Management'
                    ];
                  @endphp

                  <div class="row">
                    @foreach ($allPermissions as $perm)
                      <div class="col-md-6 mb-2">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="edit_perm_{{ Str::slug($perm) }}" name="permissions[]" value="{{ $perm }}" {{ is_array($rolePermissions) && in_array($perm, $rolePermissions) ? 'checked' : '' }}>
                          <label class="custom-control-label" for="edit_perm_{{ Str::slug($perm) }}">{{ __($perm) }}</label>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-footer text-center">
          <button id="submitBtn" type="button" class="btn btn-success">{{ __('Update Role') }}</button>
        </div>
      </div>
    </div>
  </div>
@endsection
