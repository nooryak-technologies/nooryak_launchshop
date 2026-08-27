@extends('admin.layout')

@php
    $admin = Auth::guard('admin')->user();
    if (!empty($admin->role)) {
        $permissions = $admin->role->permissions;
        $permissions = json_decode($permissions, true);
    }
@endphp

@section('content')
    <!-- Top Welcome Banner -->
    <div class="welcome-banner">
        <div>
            <h1 class="welcome-title">{{ __('Welcome back,') }} <span class="text-purple">{{ Auth::guard('admin')->user()->first_name }} {{ Auth::guard('admin')->user()->last_name }}!</span> 👋</h1>
            <p class="welcome-subtitle">{{ __('Here\'s what\'s happening with your platform today.') }}</p>
        </div>
        <div class="welcome-rocket-graphic d-none d-lg-flex">
            <div class="rocket-text">
                <span class="b1">Build</span>
                <span class="b2">Launch</span>
                <span class="b3">Grow</span>
            </div>
            <span style="font-size: 2.75rem; filter: drop-shadow(0 10px 20px rgba(124, 58, 237, 0.35));">🚀</span>
        </div>
    </div>

    <!-- 6 Main Stat Cards Grid -->
    <div class="stat-card-grid">
        @if (empty($admin->role) || (!empty($permissions) && in_array('Users Management', $permissions)))
            <a class="stat-card-v2 bg-blue-grad" href="{{ route('admin.register.user') }}">
                <div class="card-top-row">
                    <div class="card-icon-wrapper">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-action-btn">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="stat-category">{{ __('Registered Users') }}</div>
                <div class="stat-number">{{ App\Models\User::count() }}</div>
                <div class="card-bottom-row">
                    <div class="stat-growth">
                        <i class="fas fa-arrow-up"></i> 12% from last month
                    </div>
                    <div class="stat-sparkline-bars">
                        <span style="height: 35%"></span>
                        <span style="height: 55%"></span>
                        <span style="height: 40%"></span>
                        <span style="height: 75%"></span>
                        <span style="height: 100%"></span>
                    </div>
                </div>
            </a>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Package Management', $permissions)))
            <a class="stat-card-v2 bg-green-grad" href="{{ route('admin.package.index') }}">
                <div class="card-top-row">
                    <div class="card-icon-wrapper">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <div class="card-action-btn">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="stat-category">{{ __('Packages') }}</div>
                <div class="stat-number">{{ App\Models\Package::count() }}</div>
                <div class="card-bottom-row">
                    <div class="stat-growth">
                        <i class="fas fa-arrow-up"></i> 33% from last month
                    </div>
                    <div class="stat-sparkline-bars">
                        <span style="height: 45%"></span>
                        <span style="height: 60%"></span>
                        <span style="height: 50%"></span>
                        <span style="height: 85%"></span>
                        <span style="height: 100%"></span>
                    </div>
                </div>
            </a>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Payment Log', $permissions)))
            <a class="stat-card-v2 bg-red-grad" href="{{ route('admin.payment-log.index') }}">
                <div class="card-top-row">
                    <div class="card-icon-wrapper">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div class="card-action-btn">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="stat-category">{{ __('Payment Logs') }}</div>
                <div class="stat-number">{{ App\Models\Membership::count() }}</div>
                <div class="card-bottom-row">
                    <div class="stat-growth">
                        <i class="fas fa-arrow-up"></i> 18% from last month
                    </div>
                    <div class="stat-sparkline-bars">
                        <span style="height: 30%"></span>
                        <span style="height: 50%"></span>
                        <span style="height: 45%"></span>
                        <span style="height: 70%"></span>
                        <span style="height: 95%"></span>
                    </div>
                </div>
            </a>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Admins Management', $permissions)))
            <a class="stat-card-v2 bg-purple-grad" href="{{ route('admin.user.index') }}">
                <div class="card-top-row">
                    <div class="card-icon-wrapper">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="card-action-btn">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="stat-category">{{ __('Registered Admins') }}</div>
                <div class="stat-number">{{ App\Models\Admin::count() }}</div>
                <div class="card-bottom-row">
                    <div class="stat-growth">
                        <i class="fas fa-arrow-up"></i> 0% from last month
                    </div>
                    <div class="stat-sparkline-bars">
                        <span style="height: 40%"></span>
                        <span style="height: 40%"></span>
                        <span style="height: 60%"></span>
                        <span style="height: 80%"></span>
                        <span style="height: 90%"></span>
                    </div>
                </div>
            </a>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Pages', $permissions)))
            <a class="stat-card-v2 bg-cyan-grad" href="{{ route('admin.blog.index', ['language' => $defaultLang->code]) }}">
                <div class="card-top-row">
                    <div class="card-icon-wrapper">
                        <i class="fas fa-rss"></i>
                    </div>
                    <div class="card-action-btn">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="stat-category">{{ __('Blog') }}</div>
                <div class="stat-number">{{ $defaultLang ? $defaultLang->blogs()->count() : 0 }}</div>
                <div class="card-bottom-row">
                    <div class="stat-growth">
                        <i class="fas fa-arrow-up"></i> 25% from last month
                    </div>
                    <div class="stat-sparkline-bars">
                        <span style="height: 30%"></span>
                        <span style="height: 50%"></span>
                        <span style="height: 65%"></span>
                        <span style="height: 70%"></span>
                        <span style="height: 100%"></span>
                    </div>
                </div>
            </a>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Users Management', $permissions)))
            <a class="stat-card-v2 bg-orange-grad" href="{{ route('admin.subscriber.index') }}">
                <div class="card-top-row">
                    <div class="card-icon-wrapper">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <div class="card-action-btn">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="stat-category">{{ __('Subscribers') }}</div>
                <div class="stat-number">{{ App\Models\Subscriber::count() }}</div>
                <div class="card-bottom-row">
                    <div class="stat-growth">
                        <i class="fas fa-arrow-up"></i> 50% from last month
                    </div>
                    <div class="stat-sparkline-bars">
                        <span style="height: 25%"></span>
                        <span style="height: 45%"></span>
                        <span style="height: 55%"></span>
                        <span style="height: 80%"></span>
                        <span style="height: 100%"></span>
                    </div>
                </div>
            </a>
        @endif
    </div>

    <!-- AI Engine Cards Grid -->
    <div class="stat-card-grid mb-4">
        @if (!empty($aiEngineStats))
            @foreach ($aiEngineStats as $key => $stat)
                @php
                    $engineName = strtoupper($stat['engine']);
                    $cardClass = str_contains($engineName, 'OPENAI') ? 'openai-card' : 'gemini-card';
                @endphp
                <div class="ai-card-custom {{ $cardClass }}">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="card-icon-wrapper" style="width:40px; height:40px; font-size:1rem;">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="ai-title" style="margin-bottom:0;">{{ __('AI Engine') }} : {{ $engineName }}</div>
                    </div>
                    <div class="ai-info-line"><strong>{{ __('Required AI Tokens') }} :</strong> {{ $stat['token_required'] }}</div>
                    <div class="ai-info-line"><strong>{{ __('Used AI Tokens') }} :</strong> {{ $stat['token_used'] }}</div>
                    <div class="ai-info-line"><strong>{{ __('Remaining AI Tokens') }} :</strong> {{ $stat['token_remaining'] }}</div>
                    <div class="ai-progress-track">
                        <div class="ai-progress-bar" style="width: 0%;"></div>
                    </div>
                </div>
            @endforeach
        @endif

        @if (!empty($aiEngineStats))
            @foreach ($aiEngineStats as $key => $stat)
                @php
                    $engineName = strtoupper($stat['engine']);
                    $cardClass = str_contains($engineName, 'OPENAI') ? 'image-openai-card' : 'image-gemini-card';
                @endphp
                <div class="ai-card-custom {{ $cardClass }}">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="card-icon-wrapper" style="width:40px; height:40px; font-size:1rem;">
                            <i class="fas fa-image"></i>
                        </div>
                        <div class="ai-title" style="margin-bottom:0;">{{ __('AI Image Engine') }} : {{ $engineName }}</div>
                    </div>
                    <div class="ai-info-line"><strong>{{ __('Required AI Images') }} :</strong> {{ $stat['image_required'] }}</div>
                    <div class="ai-info-line"><strong>{{ __('Used AI Images') }} :</strong> {{ $stat['image_used'] }}</div>
                    <div class="ai-info-line"><strong>{{ __('Remaining AI Images') }} :</strong> {{ $stat['image_remaining'] }}</div>
                    <div class="ai-progress-track">
                        <div class="ai-progress-bar" style="width: 0%;"></div>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="ai-info-notice-card">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-chart-pie" style="font-size: 1.2rem; color: #4F46E5;"></i>
                <h6 class="m-0">{{ __('AI Image Statistics (All Active Tenants)') }}</h6>
            </div>
            <p><strong>Scope:</strong> This data is calculated by combining all ACTIVE tenant memberships only.</p>
            <p><strong>Required AI Images:</strong> Total image generation quota allocated across all active tenants.</p>
            <p><strong>Used AI Images:</strong> Total number of AI-generated images created.</p>
            <p><strong>Remaining AI Images:</strong> Remaining available images for all tenants combined.</p>
            <p class="text-muted m-0" style="font-size:0.7rem;">Important: These numbers represent combined usage across all tenants.</p>
        </div>
    </div>

    <!-- Monthly Charts Section -->
    <div class="row">
        @if (empty($admin->role) || (!empty($permissions) && in_array('Payment Log', $permissions)))
            <div class="col-lg-6 mb-4">
                <div class="card-chart-custom">
                    <div class="card-header-flex">
                        <div class="chart-title">
                            <i class="far fa-calendar-alt text-primary"></i>
                            <span>{{ __('Monthly Income') }} ({{ date('Y') }})</span>
                        </div>
                        <select class="select-year-dropdown">
                            <option value="2026" selected>2026</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <div class="p-4">
                        <div class="chart-container" style="position: relative; height: 300px;">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Users Management', $permissions)))
            <div class="col-lg-6 mb-4">
                <div class="card-chart-custom">
                    <div class="card-header-flex">
                        <div class="chart-title">
                            <i class="far fa-calendar-check text-purple"></i>
                            <span>{{ __('Monthly Premium Users') }} ({{ date('Y') }})</span>
                        </div>
                        <select class="select-year-dropdown">
                            <option value="2026" selected>2026</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <div class="p-4">
                        <div class="chart-container" style="position: relative; height: 300px;">
                            <canvas id="usersChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Admin Footer Copyright Note -->
    <div class="admin-footer-copyright">
        Launchshop.in © {{ date('Y') }} All rights reserved | Nooryak Tech's Digital Product
    </div>
@endsection

@php
    $months = [];
    $inTotals = [];
    $userTotals = [];

    for ($i = 1; $i <= 12; $i++) {
        $monthNum = $i;
        $dateObj = DateTime::createFromFormat('!m', $monthNum);
        $months[] = $dateObj->format('M');

        $inFound = 0;
        foreach ($incomes as $key => $income) {
            if ($income->month == $i) {
                $inTotals[] = (float)$income->total;
                $inFound = 1;
                break;
            }
        }
        if ($inFound == 0) {
            $inTotals[] = 0;
        }

        $userFound = 0;
        foreach ($users as $key => $user) {
            if ($user->month == $i) {
                $userTotals[] = (int)$user->total;
                $userFound = 1;
                break;
            }
        }
        if ($userFound == 0) {
            $userTotals[] = 0;
        }
    }
@endphp

@section('scripts')
    <!-- Chart JS -->
    <script src="{{ asset('assets/admin/js/plugin/chart.min.js') }}"></script>
    <script>
        "use strict";
        var months = {!! json_encode($months) !!};
        var inTotals = {{ json_encode($inTotals) }};
        var userTotals = {{ json_encode($userTotals) }};
        var Monthly_Income = "{{ __('Monthly Income') }}";
        var Monthly_Premium_Users = "{{ __('Monthly Premium Users') }}";
    </script>
    <script src="{{ asset('assets/admin/js/chart-init.js') }}"></script>
@endsection
