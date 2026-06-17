<!-- Header -->
{{-- <div class="wc-header">
    <div class="row p-2">
        <div class="col-12 col-sm-12 col-md-6 mt-3 ">
            <div class="info-box">
                <span class="info-box-icon text-bg-primary shadow-sm">
                    <i class="fa fa-trophy"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">World Cup 2026 • Prediction Game</span>
                    <span class="info-box-number">
                        <p class="wc-desc">Group stage • 48 matches remaining</p>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6">
            <div class="card glass-card">
                <div class="card-body card-body-transparent p-0" style="min-height:82px;">
                    <div class="px-2">
                        <div class="d-flex py-2">
                            <div class="row">
                                <div class="col-md-{{ isset($favorite_team) ? 2 : 4 }} col-sm-{{ isset($favorite_team) ? 2 : 3 }}  }}">
                                    @php
                                        $user = Auth::user();
                                        $emp = DB::table('emps')->where('id', $user->emp_id)->first();
                                    @endphp
                                    @isset($emp)
                                        <img height="60" width="60"
                                            src="https://myportal.galaxybd.com/public/{{ $emp->image_path ?? 'default-avatar.png' }}"
                                            alt="image" style="border-radius: 50%; object-fit: cover">
                                    @endisset
                                </div>
                                <div class="col-md-5 col-sm-3">
                                    <span style="color: black">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <div class="support-team-flag">
                                        @isset($favorite_team)
                                            <img height="20%" width="20%" class="wc-flag"
                                                src="{{ $favorite_team->team->flag ?? '' }}" alt="img">
                                        @endisset
                                        <button class="wc-settings-btn" onclick="showScreen('settings')"
                                            aria-label="Settings"><img src="{{ asset('images/football.svg') }}" class="football-icon-3d" alt="football"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> --}}

<div class="wc-header sh-stadium">
    @php
        $user = Auth::user();
        $emp = DB::table('emps')->where('id', $user->emp_id)->first();
        if ($emp && ($emp->image_path ?? null)) {
            $hLocal = str_starts_with($emp->image_path, 'public/') ? substr($emp->image_path, 7) : $emp->image_path;
            $hSrc = file_exists(public_path($hLocal))
                ? asset($hLocal)
                : 'https://myportal.galaxybd.com/public/' . $emp->image_path;
        } else {
            $hSrc = asset('images/default-avatar.svg');
        }
    @endphp

    {{-- Decorative football ghost --}}
    <img src="{{ asset('images/football.svg') }}" class="sh-deco-ball" aria-hidden="true">

    {{-- Decorative flag ghost --}}
    @isset($favorite_team)
        <img src="{{ $favorite_team->team->flag ?? '' }}" class="sh-deco-flag" aria-hidden="true">
    @endisset

    {{-- ── ROW 1: Hero title bar ── --}}
    <div class="sh-title-bar">
        <i class="fa fa-futbol-o sh-tb-ball"></i>
        <span class="sh-tb-main">PREDICTION GAME</span>
        <span class="sh-tb-year">2026</span>
    </div>

    {{-- ── ROW 2: Body row ── --}}
    <div class="sh-body-row">

        {{-- LEFT: Trophy + tournament info --}}
        <div class="sh-left-col">
            <div class="sh-trophy-wrap">
                <i class="fa fa-trophy sh-trophy-icon"></i>
            </div>
            <div class="sh-tourn-info">
                <span class="sh-tourn-name">FIFA WORLD CUP 2026</span>
                {{-- <span class="sh-tourn-stage">Group Stage · 48 matches remaining</span> --}}
            </div>
        </div>

        {{-- RIGHT: User name + flag + avatar + settings --}}
        <div class="sh-right-col">
            <div class="sh-user-meta">
                <span class="sh-user-name">{{ Auth::user()->name }}</span>
                <div class="sh-user-sub">
                    @isset($favorite_team)
                        <img class="sh-flag" src="{{ $favorite_team->team->flag ?? '' }}" alt="flag">
                    @endisset
                    <button class="sh-settings-btn" onclick="showScreen('settings')" aria-label="Settings">
                        <i class="fa fa-cog sh-settings-ico"></i>
                    </button>
                </div>
            </div>
            <div class="sh-avatar-stage" onclick="openAvatarModal({{ Auth::id() }})">
                <img class="sh-player-img" src="{{ $hSrc }}" alt="avatar"
                     onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                <div class="sh-upload-dot">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Navigation -->
<div class="nav-tabs">
    <button class="nav-tab-btn nav-tab-dashboard" onclick="showScreen('dashboard')" data-predictions-url="{{ route('dashboard') }}">
        <i class="fa fa-home nav-tab-icon"></i>
        <span class="nav-tab-label">Dashboard</span>
    </button>
    <button class="nav-tab-btn nav-tab-predictions" onclick="showScreen('predictions')" data-predictions-url="{{ route('predictions') }}">
        <i class="fa fa-bullseye nav-tab-icon"></i>
        <span class="nav-tab-label">My Predictions</span>
    </button>
    <button class="nav-tab-btn nav-tab-leaderboard" onclick="showScreen('leaderboard')" data-predictions-url="{{ route('leaderboard') }}">
        <i class="fa fa-trophy nav-tab-icon"></i>
        <span class="nav-tab-label">Leaderboard</span>
    </button>
    @if (Auth::user()->role_id == 1)
        <button class="nav-tab-btn nav-tab-update" onclick="showScreen('update_result')" data-predictions-url="{{ route('update_result') }}">
            <i class="fa fa-edit nav-tab-icon"></i>
            <span class="nav-tab-label">Update Result</span>
        </button>
    @endif
    {{-- <button onclick="showScreen('analytics')" data-predictions-url="{{ route('analytics') }}">Analytics</button> --}}
</div>
