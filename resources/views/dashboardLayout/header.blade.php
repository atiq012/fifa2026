<!-- Header -->
<div class="wc-header">
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
                                <div
                                    class="col-md-{{ isset($favorite_team) ? 2 : 4 }} col-sm-{{ isset($favorite_team) }} ? 2 : 3 }}">
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
                                <div class="col-md-6">
                                    <span style="color: black">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <div class="support-team-flag">
                                        @isset($favorite_team)
                                            <img height="20%" width="20%" class="wc-flag"
                                                src="{{ $favorite_team->team->flag ?? '' }}" alt="img">
                                        @endisset
                                        <button class="wc-settings-btn" onclick="showScreen('settings')"
                                            aria-label="Settings">⚙️</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Navigation -->
<div class="nav-tabs">
    <button onclick="showScreen('dashboard', this)" data-predictions-url="{{ route('dashboard') }}">Dashboard</button>
    <button onclick="showScreen('predictions', this)" data-predictions-url="{{ route('predictions') }}">My
        Predictions</button>
    <button onclick="showScreen('leaderboard', this)"
        data-predictions-url="{{ route('leaderboard') }}">Leaderboard</button>
    @if (Auth::user()->role_id == 1)
        <button onclick="showScreen('update_result', this)" data-predictions-url="{{ route('update_result') }}">Update
            Result</button>
    @endif
    {{-- <button onclick="showScreen('analytics')" data-predictions-url="{{ route('analytics') }}">Analytics</button> --}}
</div>
