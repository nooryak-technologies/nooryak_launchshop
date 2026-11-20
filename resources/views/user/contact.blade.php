@extends('user.layout')
@php
  $userDefaultLang = \App\Models\User\Language::where([
      ['user_id', \Illuminate\Support\Facades\Auth::id()],
      ['is_default', 1],
  ])->first();
  $userLanguages = \App\Models\User\Language::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
@endphp

@includeIf('user.partials.rtl-style')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Contact Page') }}</h4>
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
        <a href="#">{{ __('Contact Page') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-10">
              <div class="card-title">{{ __('Update Contact Page') }}</div>
            </div>

            <div class="col-lg-2">
              @if (!is_null($userDefaultLang))
                @if (!empty($userLanguages))
                  <select name="userLanguage" class="form-control"
                    onchange="window.location='{{ url()->current() . '?language=' }}'+this.value">
                    <option value="" selected disabled>
                      {{ __('Select a Language') }}</option>
                    @foreach ($userLanguages as $lang)
                      <option value="{{ $lang->code }}"
                        {{ $lang->code == request()->input('language') ? 'selected' : '' }}>{{ $lang->name }}</option>
                    @endforeach
                  </select>
                @endif
              @endif
            </div>
          </div>
        </div>

        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 m-auto">
              <form id="contactSecForm"
                action="{{ route('user.contact.update', ['language' => request()->input('language')]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label>{{ __('Address') }}</label>
                  <textarea class="form-control" name="contact_addresses" rows="3">{{ $data->contact_addresses ?? null }}</textarea>
                  <p class="mb-0 text-warning">
                    {{ __('Use newline to seperate multiple addresses.') }}
                  </p>
                  @if ($errors->has('contact_addresses'))
                    <p class="mb-0 text-danger">{{ $errors->first('contact_addresses') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Phone') }}</label>
                  <input class="form-control" name="contact_numbers" data-role="tagsinput"
                    value="{{ $data->contact_numbers ?? null }}" />
                  <p class="mb-0 text-warning">
                    {{ __('Use comma (,) to seperate multiple contact numbers.') }}
                  </p>
                  @if ($errors->has('contact_numbers'))
                    <p class="mb-0 text-danger">{{ $errors->first('contact_numbers') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Email') }}</label>
                  <input class="form-control" name="contact_mails" data-role="tagsinput"
                    value="{{ $data->contact_mails ?? null }}">
                  <p class="mb-0 text-warning">
                    {{ __('Use comma (,) to seperate multiple contact mails.') }}
                  </p>
                  @if ($errors->has('contact_mails'))
                    <p class="mb-0 text-danger">{{ $errors->first('contact_mails') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Latitude') }}</label>
                  <input type="text" class="form-control" name="latitude"
                    value="{{ @$data->latitude != null ? $data->latitude : '' }}"
                    placeholder="{{ __('Enter Latitude') }}">
                  @if ($errors->has('latitude'))
                    <p class="mt-2 mb-0 text-danger">{{ $errors->first('latitude') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Longitude') }}</label>
                  <input type="text" class="form-control" name="longitude"
                    value="{{ @$data->longitude != null ? $data->longitude : '' }}"
                    placeholder="{{ __('Enter Longitude') }}">
                  @if ($errors->has('longitude'))
                    <p class="mt-2 mb-0 text-danger">{{ $errors->first('longitude') }}</p>
                  @endif
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" form="contactSecForm" class="btn btn-success">
                {{ __('Update') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Customer Messages / Inquiries Section --}}
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <div class="card-title font-weight-bold">
                <i class="fas fa-inbox text-primary mr-2"></i>{{ __('Customer Inquiries & Messages') }}
                @if(!empty($contact_messages) && $contact_messages->count() > 0)
                  <span class="badge badge-primary badge-pill ml-2">{{ $contact_messages->count() }}</span>
                @endif
              </div>
            </div>
            <div class="col-4 text-right">
              <span class="text-muted small"><i class="fas fa-info-circle mr-1"></i>{{ __('Messages sent via Contact Us form') }}</span>
            </div>
          </div>
        </div>
        <div class="card-body">
          @if(empty($contact_messages) || $contact_messages->isEmpty())
            <div class="text-center py-4">
              <i class="fal fa-envelope-open text-muted fa-3x mb-3"></i>
              <h5 class="text-muted">{{ __('No messages received yet') }}</h5>
              <p class="text-muted small mb-0">{{ __('When customers send messages through your store contact page, they will appear here.') }}</p>
            </div>
          @else
            <div class="table-responsive">
              <table class="table table-striped mt-2" id="basic-datatables">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('Date') }}</th>
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Email') }}</th>
                    <th scope="col">{{ __('Subject') }}</th>
                    <th scope="col">{{ __('Message') }}</th>
                    <th scope="col">{{ __('Action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($contact_messages as $key => $msg)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>
                        <span class="small font-weight-bold">{{ $msg->created_at ? $msg->created_at->format('d M, Y') : '-' }}</span><br>
                        <span class="text-muted small">{{ $msg->created_at ? $msg->created_at->format('h:i A') : '' }}</span>
                      </td>
                      <td>{{ $msg->fullname }}</td>
                      <td><a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a></td>
                      <td>{{ $msg->subject }}</td>
                      <td>
                        <button type="button" class="btn btn-sm btn-info py-1 px-2" data-toggle="modal" data-target="#msgModal{{ $msg->id }}">
                          <i class="fas fa-eye mr-1"></i>{{ __('View') }}
                        </button>
                        {{-- Modal for full message --}}
                        <div class="modal fade" id="msgModal{{ $msg->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title font-weight-bold">{{ $msg->subject }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p class="mb-1"><strong>{{ __('From') }}:</strong> {{ $msg->fullname }} (&lt;<a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a>&gt;)</p>
                                <p class="mb-3 text-muted small"><strong>{{ __('Date') }}:</strong> {{ $msg->created_at ? $msg->created_at->format('d M Y, h:i A') : '' }}</p>
                                <div class="p-3 bg-light rounded text-dark" style="white-space: pre-wrap; font-size: 14px; line-height: 1.6;">{{ $msg->message }}</div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">{{ __('Close') }}</button>
                                <a href="mailto:{{ $msg->email }}?subject={{ urlencode('Re: ' . $msg->subject) }}" class="btn btn-primary btn-sm"><i class="fas fa-reply mr-1"></i>{{ __('Reply') }}</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <form class="d-inline-block deleteform" action="{{ route('user.contact_message.delete', $msg->id) }}" method="post" onsubmit="return confirm('{{ __('Are you sure you want to delete this message?') }}');">
                          @csrf
                          <button type="submit" class="btn btn-danger btn-sm py-1 px-2" title="{{ __('Delete') }}">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
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
@endsection
