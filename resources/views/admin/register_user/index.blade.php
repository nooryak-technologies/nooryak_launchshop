@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">
      {{ __('Registered Users') }}
    </h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('admin.dashboard') }}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Users Management') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Registered Users') }}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      {{-- Tab Navigation --}}
      <ul class="nav nav-tabs mb-3" id="registeredUsersTabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link {{ request()->input('active_tab') !== 'verified' ? 'active' : '' }}"
            id="registered-tab" href="{{ route('admin.register.user') }}" role="tab">
            <i class="fas fa-users mr-1"></i> {{ __('Registered Customers') }}
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->input('active_tab') === 'verified' ? 'active' : '' }}"
            id="verified-tab" href="{{ route('admin.register.user', ['active_tab' => 'verified', 'lead_filter' => request()->input('lead_filter', 'all')]) }}" role="tab">
            <i class="fas fa-phone-square-alt mr-1"></i> {{ __('Verified Users') }}
            @php
              try { $leadCount = \App\Models\VerifiedPhoneLead::count(); } catch(\Exception $e) { $leadCount = 0; }
            @endphp
            @if($leadCount > 0)
              <span class="badge badge-info ml-1">{{ $leadCount }}</span>
            @endif
          </a>
        </li>
      </ul>

      {{-- ============================================================= --}}
      {{-- TAB 1 : Registered Customers --}}
      {{-- ============================================================= --}}
      @if(request()->input('active_tab') !== 'verified')
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-6">
              <div class="card-title">
                {{ __('Registered Users') }}
              </div>
            </div>
            <div class="col-lg-6 mt-2 mt-lg-0 d-block d-lg-flex justify-content-end gap-3">
              <button class="btn btn-danger float-none btn-sm d-none bulk-delete"
                data-href="{{ route('register.user.bulk.delete') }}"><i class="flaticon-interface-5"></i>
                {{ __('Delete') }}</button>
              <form action="{{ url()->full() }}" class="float-none mt-2 mt-lg-0">
                <input type="text" name="term" class="form-control min-w-250" value="{{ request()->input('term') }}"
                  placeholder="{{ __('Search by Username / Email') }}">
              </form>
              <button class="btn btn-primary mt-2 mt-lg-0 float-none btn-sm gap-3" data-toggle="modal"
                data-target="#addUserModal"><i class="fas fa-plus"></i> {{ __('Add User') }}</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($users) == 0)
                <h3 class="text-center">{{ __('NO USER FOUND') }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Username') }}</th>
                        <th scope="col">{{ __('Email') }}</th>
                        <th scope="col">{{ __('Featured') }}</th>
                        <th scope="col">{{ __('Preview Template') }}</th>
                        <th scope="col">{{ __('WhatsApp') }}</th>
                        <th scope="col">{{ __('Email Status') }}</th>
                        <th scope="col">{{ __('Account') }}</th>
                        <td scope="col">{{ __('Action') }}</td>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $key => $user)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $user->id }}">
                          </td>
                          <td>{{ $user->username }}</td>
                          <td>{{ $user->email }}</td>

                          <td>
                            <form id="userFrom{{ $user->id }}" class="d-inline-block"
                              action="{{ route('register.user.featured') }}" method="post">
                              @csrf
                              <select
                                class="form-control form-control-sm {{ $user->featured == 1 ? 'bg-success' : 'bg-danger' }}"
                                name="featured"
                                onchange="document.getElementById('userFrom{{ $user->id }}').submit();">
                                <option value="1" {{ $user->featured == 1 ? 'selected' : '' }}>{{ __('Yes') }}
                                </option>
                                <option value="0" {{ $user->featured == 0 ? 'selected' : '' }}>{{ __('No') }}
                                </option>
                              </select>
                              <input type="hidden" name="user_id" value="{{ $user->id }}">
                            </form>
                          </td>

                          <td>
                            <div class="d-inline-block">
                              <select data-user_id="{{ $user->id }}"
                                class="template-select form-control form-control-sm {{ $user->preview_template == 1 ? 'bg-success' : 'bg-danger' }}"
                                name="preview_template">
                                <option value="1" {{ $user->preview_template == 1 ? 'selected' : '' }}>
                                  {{ __('Yes') }}</option>
                                <option value="0" {{ $user->preview_template == 0 ? 'selected' : '' }}>
                                  {{ __('No') }}</option>
                              </select>
                            </div>
                            @if ($user->preview_template == 1)
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#templateImgModal{{ $user->id }}">{{ __('Edit') }}</button>
                            @endif
                          </td>

                          @includeIf('admin.register_user.template-modal')
                          @includeIf('admin.register_user.template-image-modal')

                          <td>
                            <form id="whatsappForm{{ $user->id }}" class="d-inline-block"
                              action="{{ route('register.user.whatsapp') }}" method="post">
                              @csrf
                              <select
                                class="form-control form-control-sm {{ $user->whatsapp_status == 1 ? 'bg-success' : 'bg-danger' }}"
                                name="whatsapp_status"
                                onchange="document.getElementById('whatsappForm{{ $user->id }}').submit();">
                                <option value="1" {{ $user->whatsapp_status == 1 ? 'selected' : '' }}>
                                  {{ __('Enable') }}</option>
                                <option value="0" {{ $user->whatsapp_status == 0 ? 'selected' : '' }}>
                                  {{ __('Disable') }}</option>
                              </select>
                              <input type="hidden" name="user_id" value="{{ $user->id }}">
                            </form>
                          </td>

                          <td>
                            <form id="emailForm{{ $user->id }}" class="d-inline-block"
                              action="{{ route('register.user.email') }}" method="post">
                              @csrf
                              <select
                                class="form-control form-control-sm {{ strtolower($user->email_verified) == 1 ? 'bg-success' : 'bg-danger' }}"
                                name="email_verified"
                                onchange="document.getElementById('emailForm{{ $user->id }}').submit();">
                                <option value="1" {{ strtolower($user->email_verified) == 1 ? 'selected' : '' }}>
                                  {{ __('Verified') }}</option>
                                <option value="0" {{ strtolower($user->email_verified) == 0 ? 'selected' : '' }}>
                                  {{ __('Unverified') }}</option>
                              </select>
                              <input type="hidden" name="user_id" value="{{ $user->id }}">
                            </form>
                          </td>

                          <td>
                            <form id="statusForm{{ $user->id }}" class="d-inline-block"
                              action="{{ route('register.user.ban') }}" method="post">
                              @csrf
                              <select
                                class="form-control form-control-sm {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}"
                                name="status"
                                onchange="document.getElementById('statusForm{{ $user->id }}').submit();">
                                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>{{ __('Active') }}
                                </option>
                                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>{{ __('Deactive') }}
                                </option>
                              </select>
                              <input type="hidden" name="user_id" value="{{ $user->id }}">
                            </form>
                          </td>
                          <td>
                            <div class="dropdown  ">
                              <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{ __('Actions') }}
                              </button>
                              <div class="dropdown-menu dropdown-style2" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                  href="{{ route('register.user.view', $user->id) }}">{{ __('Details') }}</a>
                                <a class="dropdown-item"
                                  href="{{ route('register.user.changePass', $user->id) }}">{{ __('Change Password') }}</a>
                                <button class="editbtn editBtn" data-toggle="modal" data-target="#mailModal"
                                  data-email="{{ $user->email }}">{{ __('Mail') }}</button>

                                <form class="deleteform d-block" action="{{ route('register.user.delete') }}"
                                  method="post">
                                  @csrf
                                  <input type="hidden" name="user_id" value="{{ $user->id }}">
                                  <button type="submit" class="deletebtn">
                                    {{ __('Delete') }}
                                  </button>
                                </form>
                                <a target="_blank" class="dropdown-item"
                                  href="{{ route('register.user.secret_login', $user->id) }}">{{ __('Secret Login') }}</a>
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
        <div class="card-footer">
          <div class="row">
            <div class="d-inline-block mx-auto">
              {{ $users->appends(['term' => request()->input('term')])->links() }}
            </div>
          </div>
        </div>
      </div>
      @endif

      {{-- ============================================================= --}}
      {{-- TAB 2 : Verified Users (Phone OTP leads) --}}
      {{-- ============================================================= --}}
      @if(request()->input('active_tab') === 'verified')
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="card-title">
                <i class="fas fa-phone-square-alt mr-1 text-info"></i>
                {{ __('Verified Users') }}
                <small class="text-muted ml-2">{{ __('Users who requested OTP during registration') }}</small>
              </div>
            </div>
            <div class="col-lg-6 mt-2 mt-lg-0 d-flex justify-content-end align-items-center gap-3">
              {{-- Filter Dropdown --}}
              <form action="{{ route('admin.register.user') }}" method="GET" class="d-flex align-items-center gap-2">
                <input type="hidden" name="active_tab" value="verified">
                <select name="lead_filter" class="form-control form-control-sm" onchange="this.form.submit()" style="min-width:170px;">
                  <option value="all" {{ $leadFilter === 'all' ? 'selected' : '' }}>{{ __('All Verified Users') }}</option>
                  <option value="purchased" {{ $leadFilter === 'purchased' ? 'selected' : '' }}>{{ __('Purchased Plan') }}</option>
                  <option value="not_purchased" {{ $leadFilter === 'not_purchased' ? 'selected' : '' }}>{{ __('Not Purchased') }}</option>
                </select>
              </form>
            </div>
          </div>
        </div>
        <div class="card-body">
          @php
            $tableReady = true;
            try { \App\Models\VerifiedPhoneLead::first(); } catch(\Exception $e) { $tableReady = false; }
          @endphp
          @if(!$tableReady)
            <div class="alert alert-warning">
              <i class="fas fa-exclamation-triangle mr-1"></i>
              {{ __('The verified_phone_leads table does not exist yet. Please run the migration or execute the SQL below.') }}
              <pre class="mt-2 bg-light p-2" style="font-size:12px;">CREATE TABLE IF NOT EXISTS `verified_phone_leads` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL UNIQUE,
  `country_code` varchar(255) DEFAULT NULL,
  `purchased` tinyint(1) NOT NULL DEFAULT 0,
  `otp_sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;</pre>
            </div>
          @elseif($verifiedLeads->total() === 0)
            <h3 class="text-center text-muted py-4">
              <i class="fas fa-phone-slash d-block mb-2" style="font-size:48px;"></i>
              {{ __('No verified phone leads found') }}
            </h3>
          @else
            <div class="table-responsive">
              <table class="table table-striped mt-3">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Phone Number') }}</th>
                    <th>{{ __('Country Code') }}</th>
                    <th>{{ __('Plan Status') }}</th>
                    <th>{{ __('OTP Sent At') }}</th>
                    <th>{{ __('Registered At') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($verifiedLeads as $lead)
                  <tr>
                    <td>{{ $lead->id }}</td>
                    <td>{{ $lead->name ?: '-' }}</td>
                    <td>
                      <strong>{{ $lead->phone }}</strong>
                    </td>
                    <td>{{ $lead->country_code ?: '-' }}</td>
                    <td>
                      @if($lead->purchased)
                        <span class="badge badge-success px-2 py-1">
                          <i class="fas fa-check mr-1"></i>{{ __('Purchased') }}
                        </span>
                      @else
                        <span class="badge badge-warning px-2 py-1">
                          <i class="fas fa-clock mr-1"></i>{{ __('Not Purchased') }}
                        </span>
                      @endif
                    </td>
                    <td>{{ $lead->otp_sent_at ? $lead->otp_sent_at->format('d M Y, h:i A') : '-' }}</td>
                    <td>{{ $lead->created_at ? $lead->created_at->format('d M Y') : '-' }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
        @if(isset($verifiedLeads) && $verifiedLeads->total() > 0)
        <div class="card-footer">
          <div class="row">
            <div class="d-inline-block mx-auto">
              {{ $verifiedLeads->appends(['active_tab' => 'verified', 'lead_filter' => $leadFilter])->links() }}
            </div>
          </div>
        </div>
        @endif
      </div>
      @endif

    </div>
  </div>


  <!-- Send Mail Modal -->
  <div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLongTitle">{{ __('Send Mail') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxEditForm" class="" action="{{ route('admin.custom-domain.mail') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="">{{ __('Email Address') }} <span class="text-danger">**</span></label>
              <input id="inemail" type="email" class="form-control" name="email"
                placeholder="{{ __('Enter email') }}">
              <p id="eerremail" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">{{ __('Subject') }} <span class="text-danger">**</span></label>
              <input id="insubject" type="text" class="form-control" name="subject" value=""
                placeholder="{{ __('Enter subject') }}">
              <p id="eerrsubject" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">{{ __('Message') }} <span class="text-danger">**</span></label>
              <textarea id="inmessage" class="form-control summernote" name="message" placeholder="{{ __('Enter message') }}"
                data-height="150"></textarea>
              <p id="eerrmessage" class="mb-0 text-danger em"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
          <button id="updateBtn" type="button" class="btn btn-primary">{{ __('Send Mail') }}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Add User') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('register.user.store') }}" method="POST" id="ajaxForm">
            @csrf
            <div class="form-group">
              <label for="">{{ __('Username') }} <span class="text-danger">**</span></label>
              <input class="form-control" type="text" name="username">
              <p id="errusername" class="text-danger mb-0 em"></p>
            </div>
            <div class="form-group">
              <label for="">{{ __('Shop Name') }} <span class="text-danger">**</span></label>
              <input class="form-control" type="text" name="shop_name">
              <p id="errshop_name" class="text-danger mb-0 em"></p>
            </div>
            <div class="form-group">
              <label for="">{{ __('Category') }}</label>
              <select name="category" class="form-control">
                <option value="" selected>{{ __('Select Category') }}</option>
                @foreach ($categories as $category)
                  <option value="{{ $category->unique_id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              <p id="errcategory" class="text-danger mb-0 em"></p>
            </div>
            <div class="form-group">
              <label for="">{{ __('Email') }} <span class="text-danger">**</span></label>
              <input class="form-control" type="email" name="email">
              <p id="erremail" class="text-danger mb-0 em"></p>
            </div>
            <div class="form-group">
              <label for="">{{ __('Password') }} <span class="text-danger">**</span></label>
              <input class="form-control" type="password" name="password">
              <p id="errpassword" class="text-danger mb-0 em"></p>
            </div>
            <div class="form-group">
              <label for="">{{ __('Confirm Password') }} <span class="text-danger">**</span></label>
              <input class="form-control" type="password" name="password_confirmation">
            </div>
            <div class="form-group">
              <label for="">{{ __('Package / Plan') }} <span class="text-danger">**</span></label>
              <select name="package_id" class="form-control">
                @if (!empty($packages))
                  @foreach ($packages as $package)
                    <option value="{{ $package->id }}">{{ __($package->title) }} ({{ __($package->term) }})</option>
                  @endforeach
                @endif
              </select>
              <p id="errpackage_id" class="text-danger mb-0 em"></p>
            </div>
            <div class="form-group">
              <label for="">{{ __('Payment Gateway') }} <span class="text-danger">**</span></label>
              <select name="payment_gateway" class="form-control">
                @if (!empty($gateways))
                  @foreach ($gateways as $gateway)
                    <option value="{{ $gateway->name }}">{{ __(ucwords($gateway->name)) }}</option>
                  @endforeach
                @endif
              </select>
              <p id="errpayment_gateway" class="text-danger mb-0 em"></p>
            </div>
            <div class="form-group">
              <label for="">{{ __('Publicly Hidden') }} <span class="text-danger">**</span></label>
              <select name="online_status" class="form-control">
                <option value="1">{{ __('No') }}</option>
                <option value="0">{{ __('Yes') }}</option>
              </select>
              <p id="erronline_status" class="text-danger mb-0 em"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer text-center">
          <button id="submitBtn" type="button" class="btn btn-primary">{{ __('Add User') }}</button>
        </div>
      </div>
    </div>
  </div>
@endsection
