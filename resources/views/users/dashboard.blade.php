@extends('dashboardLayout.main')

@section('styles')
    <style>
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            /* smooth scroll on iOS */
            scrollbar-width: thin;
            border-radius: 20px;
        }

        .table-header-custom {
            background: #1a2c3e;
            color: white;
        }

        .table-header-custom th {
            font-weight: 600;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding: 0.6rem 0.75rem;
            border-bottom: 2px solid #ffc107;
            color: #fff;
        }

        .table-responsive {
            border-radius: 5px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table-sm td,
        .table-sm th {
            padding: 0.45rem 0.75rem;
            vertical-align: middle;
        }

        .table tbody tr {
            border-left: 3px solid transparent;
            transition: background 0.15s;
        }

        .table tbody tr:hover {
            background-color: #fef9e6 !important;
            border-left-color: #ffc107;
        }

        /* Rank badges */
        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .rank-gold {
            background: #FFD966;
            color: #7d5d00;
        }

        .rank-silver {
            background: #E0E4E9;
            color: #4a5568;
        }

        .rank-bronze {
            background: #E8C9A0;
            color: #704e2c;
        }

        .rank-plain {
            font-size: 0.8rem;
            font-weight: 600;
            color: #556677;
        }

        /* Player avatar */
        .player-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            flex-shrink: 0;
        }

        .player-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: #1f2e3a;
        }

        .player-sub {
            font-size: 0.7rem;
            color: #7a8fa0;
            line-height: 1.2;
        }

        /* Dept badge */
        .dept-badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 50px;
            background: #eef2f5;
            color: #2c4b6e;
            white-space: nowrap;
        }

        /* Points */
        .points-value {
            font-weight: 700;
            font-size: 0.9rem;
            color: #1e4663;
        }

        /* Accuracy bar */
        .acc-bar-wrap {
            width: 60px;
            height: 6px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            display: inline-block;
            margin-right: 6px;
        }

        .acc-bar-fill {
            height: 6px;
            border-radius: 4px;
            background: #28a745;
        }

        .acc-text {
            font-size: 0.75rem;
            font-weight: 600;
            color: #2d6a4f;
        }

        .cricket-card {
            width: 100%;
            max-width: 460px;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* RESULT header */
        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 16px 10px 16px;
            border-bottom: 1px solid #E5E9F0;
            background: #FFFFFF;
        }

        .result-label {
            font-size: 12px;
            font-weight: 700;
            color: #059669;
            background: #ECFDF5;
            padding: 2px 10px;
            border-radius: 4px;
            letter-spacing: 0.3px;
        }

        /* Team rows - exact spacing like image */
        .team-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* padding: 12px 16px; */
            padding: 8px 18px;
            border-bottom: 1px solid #EDF2F7;
        }

        .team-name-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .team-short {
            font-size: 18px;
            font-weight: 700;
            color: #1E293B;
            letter-spacing: -0.2px;
        }

        .team-full {
            font-size: 12px;
            color: #64748B;
            font-weight: 450;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100px;
        }

        .team-score-group {
            display: flex;
            align-items: center;
            gap: 1px;
        }

        .runs {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 13px;
            font-weight: 500;
            color: #0F172A;
            letter-spacing: -0.5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 130px;
        }

        .pred-icon {
            display: inline-flex;
            align-items: center;
            font-size: 14px;
            line-height: 1;
            flex-shrink: 0;
        }

        .wickets {
            font-size: 17px;
            font-weight: 600;
            color: #475569;
        }

        /* Overs + target line - matches image exactly */
        .overs-target {
            padding: 8px 16px 6px 16px;
            font-size: 12px;
            font-family: 'SF Mono', 'Menlo', monospace;
            color: #5B6E8C;
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
            letter-spacing: 0.2px;
        }

        /* Result message - green pill style */
        .result-message {
            padding: 12px 16px;
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
        }

        .result-message {
            font-size: 11px;
            font-weight: 600;
            color: #0F3B2C;
            background: #E6F7EF;
            display: inline-block;
            width: auto;
            padding: 5px 14px;
            border-radius: 24px;
            margin: 4px 0 4px 5px;
        }

        /* Schedule link - right aligned with arrow */
        .schedule-link {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            color: #3B82F6;
            background: #FFFFFF;
            /* cursor: default; */
            text-decoration: none;
        }

        .schedule-link svg {
            stroke: #3B82F6;
            stroke-width: 1.8;
        }

        .predictions-scroll {
            max-height: 520px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
            transition: scrollbar-color 0.2s;
        }

        .predictions-scroll:hover {
            scrollbar-color: #cbd5e1 transparent;
        }

        .predictions-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .predictions-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .predictions-scroll::-webkit-scrollbar-thumb {
            background: transparent;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .predictions-scroll:hover::-webkit-scrollbar-thumb {
            background: #cbd5e1;
        }

        /* ── My Stats Overview ── */
        .mystats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        .pstat-card {
            background: var(--ps-bg);
            border-radius: 18px;
            overflow: hidden;
            position: relative;
            padding: 18px 18px 16px;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--ps-border);
            opacity: 0;
            transform: translateY(14px);
            animation: pstatIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) var(--anim-delay, 0s) forwards;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 2px 12px var(--ps-shadow);
            cursor: default;
        }

        .pstat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px var(--ps-shadow);
        }

        @keyframes pstatIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Decorative blobs */
        .pstat-card::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 115px;
            height: 115px;
            border-radius: 50%;
            background: var(--ps-blob);
            pointer-events: none;
        }

        .pstat-card::after {
            content: '';
            position: absolute;
            top: 28px;
            right: 18px;
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: var(--ps-blob2);
            pointer-events: none;
        }

        /* Color variants */
        .pstat-green {
            --ps-bg: #f0fdf4;
            --ps-border: #bbf7d0;
            --ps-shadow: rgba(34, 197, 94, 0.12);
            --ps-blob: #bbf7d0;
            --ps-blob2: #dcfce7;
            --ps-icon-bg: #dcfce7;
            --ps-badge-bg: #dcfce7;
            --ps-badge: #15803d;
            --ps-num: #14532d;
            --ps-lbl: #15803d;
            --ps-sub: #16a34a;
            --ps-divider: #bbf7d0;
            --ps-footer: #4ade80;
            --ps-bar: #16a34a;
            --ps-dot-win: #16a34a;
            --ps-dot-empty: #bbf7d0;
        }

        .pstat-blue {
            --ps-bg: #eff6ff;
            --ps-border: #bfdbfe;
            --ps-shadow: rgba(59, 130, 246, 0.12);
            --ps-blob: #bfdbfe;
            --ps-blob2: #dbeafe;
            --ps-icon-bg: #dbeafe;
            --ps-badge-bg: #dbeafe;
            --ps-badge: #1d4ed8;
            --ps-num: #1e3a8a;
            --ps-lbl: #1d4ed8;
            --ps-sub: #2563eb;
            --ps-divider: #bfdbfe;
            --ps-footer: #60a5fa;
            --ps-bar: #2563eb;
            --ps-dot-win: #2563eb;
            --ps-dot-empty: #bfdbfe;
        }

        /* Top row: icon + badge */
        .pstat-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .pstat-icon-box {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--ps-icon-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            animation: pstatIconIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) var(--anim-delay, 0s) both;
        }

        @keyframes pstatIconIn {
            from {
                opacity: 0;
                transform: scale(0.6);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .pstat-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 4px 9px;
            border-radius: 99px;
            background: var(--ps-badge-bg);
            color: var(--ps-badge);
            letter-spacing: 0.3px;
            position: relative;
            z-index: 1;
            white-space: nowrap;
        }

        /* Numbers */
        .pstat-num {
            font-size: 36px;
            font-weight: 900;
            color: var(--ps-num);
            line-height: 1;
            letter-spacing: -1.5px;
            margin-bottom: 4px;
            position: relative;
            z-index: 1;
        }

        .pstat-lbl {
            font-size: 11px;
            font-weight: 600;
            color: var(--ps-lbl);
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        /* Progress bar */
        .pstat-prog-track {
            height: 6px;
            background: var(--ps-divider);
            border-radius: 6px;
            overflow: hidden;
            margin: 2px 0 10px;
            position: relative;
            z-index: 1;
        }

        .pstat-prog-fill {
            height: 6px;
            border-radius: 6px;
            width: 0%;
            background: var(--ps-bar);
            transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1) 0.5s;
        }

        /* Divider */
        .pstat-divider {
            height: 1px;
            background: var(--ps-divider);
            margin: 8px 0;
            position: relative;
            z-index: 1;
        }

        /* Footer */
        .pstat-footer {
            font-size: 11px;
            color: var(--ps-sub);
            font-weight: 600;
            position: relative;
            z-index: 1;
        }

        /* Sub-section label */
        .pstat-sub-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--ps-lbl);
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }

        /* Streak dots */
        .pstat-dots-row {
            display: flex;
            gap: 5px;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .pstat-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            opacity: 0;
            transform: scale(0);
            animation: pstatDotPop 0.28s cubic-bezier(0.34, 1.56, 0.64, 1) var(--dot-delay, 0.6s) forwards;
        }

        .pstat-dot.win {
            background: var(--ps-dot-win);
        }

        .pstat-dot.lose {
            background: var(--ps-dot-empty);
            border: 1.5px solid var(--ps-footer);
        }

        .pstat-dot.empty {
            background: var(--ps-dot-empty);
        }

        @keyframes pstatDotPop {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Flame */
        .pstat-flame {
            font-size: 13px;
            display: inline-block;
            animation: pstatFlamePulse 1.3s ease-in-out infinite alternate;
        }

        @keyframes pstatFlamePulse {
            from {
                filter: drop-shadow(0 0 2px rgba(251, 146, 60, 0.4));
            }

            to {
                filter: drop-shadow(0 0 8px rgba(251, 146, 60, 0.9));
                transform: scale(1.08);
            }
        }

        .pstat-countup {
            display: inline;
        }

        @media (max-width: 640px) {
            .mystats-grid {
                grid-template-columns: 1fr;
            }

            .pstat-num {
                font-size: 30px;
            }
        }

        /* ── Top Standings toggle ── */
        .standings-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
            margin-bottom: 1rem;
            padding: 4px 0;
        }

        .standings-header:hover .standings-arrow {
            color: #1d4ed8;
        }

        .standings-arrow {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #64748b;
            transition: background 0.2s, color 0.2s;
            flex-shrink: 0;
        }

        .standings-arrow svg {
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .standings-arrow.open svg {
            transform: rotate(180deg);
        }

        @keyframes standingsSlideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .standings-body-visible {
            animation: standingsSlideDown 0.3s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
    </style>
@endsection
@section('content')
    <div id="dashboard" class="screen active">
        <div class="row g-0 m-0">
            <div class="col-12 col-md-8 px-md-3">

                {{-- ── My Performance Overview ── --}}
                @php
                    $winRate =
                        $totalPredictions > 0 ? round(($total_correct_predictions / $totalPredictions) * 100, 1) : 0;
                    $last8Preds = $pred
                        ->filter(fn($p) => $p->is_correct !== null)
                        ->values()
                        ->slice(-8)
                        ->values();
                @endphp

                <h2 class="section-title mt-1">My Performance</h2>
                <div class="mystats-grid">

                    {{-- Card 1: Points & Win Rate --}}
                    <div class="pstat-card pstat-green" style="--anim-delay:0s">
                        <div class="pstat-top">
                            <div class="pstat-icon-box" style="--anim-delay:0.05s">⚡</div>
                            <span class="pstat-badge">Win Rate {{ (int) $winRate }}%</span>
                        </div>
                        <div class="pstat-num pstat-countup" data-count="{{ (int) $totalPoints }}">0</div>
                        <div class="pstat-lbl">Total Points</div>
                        <div class="pstat-prog-track">
                            <div class="pstat-prog-fill" data-pct="{{ $winRate }}"></div>
                        </div>
                        <div class="pstat-divider"></div>
                        <div class="pstat-footer">{{ $total_correct_predictions }} wins &nbsp;·&nbsp;
                            {{ $totalPredictions }} played</div>
                    </div>

                    {{-- Card 2: Rank & Streak --}}
                    <div class="pstat-card pstat-blue" style="--anim-delay:0.1s">
                        <div class="pstat-top">
                            <div class="pstat-icon-box" style="--anim-delay:0.15s">🏆</div>
                            <span class="pstat-badge">
                                @if ($myStreak > 0)
                                    <span class="pstat-flame">🔥</span> {{ $myStreak }} streak
                                @else
                                    No streak
                                @endif
                            </span>
                        </div>
                        <div class="pstat-num">#{{ $myRank }}</div>
                        <div class="pstat-lbl">Global Rank</div>
                        <div class="pstat-sub-label">Last 8 predictions</div>
                        <div class="pstat-dots-row">
                            @foreach ($last8Preds as $di => $dp)
                                <div class="pstat-dot {{ (int) $dp->is_correct === 1 ? 'win' : 'lose' }}"
                                    style="--dot-delay:{{ 0.5 + $di * 0.065 }}s"
                                    title="{{ (int) $dp->is_correct === 1 ? 'Win' : 'Loss' }}"></div>
                            @endforeach
                            @for ($dj = $last8Preds->count(); $dj < 8; $dj++)
                                <div class="pstat-dot empty" style="--dot-delay:{{ 0.5 + $dj * 0.065 }}s"></div>
                            @endfor
                        </div>
                        <div class="pstat-divider"></div>
                        <div class="pstat-footer">{{ $myStreak }} consecutive wins</div>
                    </div>

                </div>

                <h2 class="section-title">Upcoming Matches</h2>

                @foreach ($nextThreeMatches as $fixture)
                    @php
                        $date = $fixture->date;
                        $time = $fixture->time;
                        $datetime = DateTime::createFromFormat('Y-m-d g:i a', $date . ' ' . $time);
                        $result = $datetime->format('Y-m-d H:i:s');
                        $target = \Carbon\Carbon::parse($result, 'Asia/Dhaka');
                    @endphp
                    <div class="match-card" data-match-epoch="{{ $target->timestamp }}">
                        <div class="match-header">
                            <span class="match-time urgent">
                                {{ \Carbon\Carbon::parse($fixture->date)->format('M d, Y') }}
                                {{ \Carbon\Carbon::parse($fixture->time)->format('g:i A') }}
                            </span>
                            <span class="match-time-static text-muted" style="font-size: 12px;">
                                @php
                                    $now = \Carbon\Carbon::now('Asia/Dhaka');
                                    $diff = $target->diff($now);
                                    $totalHours = $diff->days * 24 + $diff->h;
                                @endphp
                                Starts in {{ $totalHours }}H {{ $diff->i }}M
                            </span>
                            <span class="match-countdown-live"
                                style="display:none; font-size:13px; font-weight:700; color:#e74c3c; letter-spacing:1px;">
                                🔒 Closes in <span class="countdown-timer">--:--</span>
                            </span>
                        </div>
                        <div class="match-body">
                            <div class="team">
                                <div class="team-name"> <img height="18" width="18"
                                        src="{{ $fixture->team1->flag ?? '' }}" alt="">
                                    {{ $fixture->team1->name ?? $fixture->team1_name }}
                                </div>
                                <div class="team-rank">Rank
                                    #{{ $fixture->team1->rank ?? ($fixture->team1_rank ?? 'N/A') }}</div>
                            </div>
                            <div class="vs-text">vs</div>

                            <div class="team">
                                <div class="team-name"><img height="18" width="18"
                                        src="{{ $fixture->team2->flag ?? '' }}" alt="">
                                    {{ $fixture->team2->name ?? $fixture->team2_name }}
                                </div>
                                <div class="team-rank">Rank
                                    #{{ $fixture->team2->rank ?? ($fixture->team2_rank ?? 'N/A') }}</div>
                            </div>
                        </div>

                        @if ($myPr->contains((int) $fixture->id))
                        @else
                            <button class="primary" style="width: 100%;" data-bs-toggle="modal"
                                data-bs-target="#predictionModal" data-fixture-id="{{ $fixture->id }}"
                                data-team1-name="{{ $fixture->team1->name ?? $fixture->team1_name }}"
                                data-team1-rank="{{ $fixture->team1->rank ?? ($fixture->team1_rank ?? 'N/A') }}"
                                data-team2-name="{{ $fixture->team2->name ?? $fixture->team2_name }}"
                                data-team2-rank="{{ $fixture->team2->rank ?? ($fixture->team2_rank ?? 'N/A') }}"
                                data-date="{{ \Carbon\Carbon::parse($fixture->date)->format('M d, Y') }}"
                                data-time="{{ \Carbon\Carbon::parse($fixture->time)->format('g:i A') }}">
                                🏆 Make Prediction
                            </button>
                        @endif

                    </div>
                @endforeach

                <!-- Bootstrap 5 Prediction Modal -->
                <div class="modal" id="predictionModal" aria-labelledby="predictionModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title fs-4" id="predictionModalLabel">Match Prediction</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="text-center mb-3 pb-2 border-bottom">
                                    <p class="mb-1 small text-secondary" id="modalMatchGroup">Round of 16</p>
                                    <p class="mb-0 small text-secondary" id="modalDateTime">Today 8:00 PM
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
                                    <div class="flex-grow-1 text-center">
                                        <p class="mb-2 fw-semibold" id="team1Name" style="color: #2c2c2a;">
                                            Argentina</p>
                                        <p class="mb-0 small text-secondary" id="team1Rank">Rank #2</p>
                                    </div>
                                    <div class="text-center text-secondary">
                                        <p class="mb-0 fw-semibold">vs</p>
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="mb-2 fw-semibold" id="team2Name" style="color: #2c2c2a;">
                                            Canada</p>
                                        <p class="mb-0 small text-secondary" id="team2Rank">Rank #49</p>
                                    </div>
                                </div>
                                </p>
                                <!-- Head-to-Head Section -->
                                {{-- <div class="bg-light p-3 rounded-3 mb-4">
                                <p class="mb-2 small fw-semibold text-secondary">Head-to-Head (Last 5)
                                </p>
                                <div class="d-flex gap-1">
                                    <div class="flex-grow-1 text-center p-1 bg-white rounded small fw-semibold text-success">
                                        W</div>
                                    <div class="flex-grow-1 text-center p-1 bg-white rounded small fw-semibold text-success">
                                        W</div>
                                    <div class="flex-grow-1 text-center p-1 bg-white rounded small fw-semibold text-warning">
                                        D</div>
                                    <div class="flex-grow-1 text-center p-1 bg-white rounded small fw-semibold text-success">
                                        W</div>
                                    <div class="flex-grow-1 text-center p-1 bg-white rounded small fw-semibold text-success">
                                        W</div>
                                </div>
                            </div> --}}

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Who will win?</label>
                                    <div class="d-flex flex-column gap-2" id="winnerOptions">
                                        <div class="border rounded-3 p-2">
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div>
                                                    <input class="form-check-input" type="radio" name="winner"
                                                        id="winnerTeam1" value="team1">
                                                    <label class="form-check-label fw-medium" id="winnerTeam1Label"
                                                        for="winnerTeam1">Argentina</label>
                                                </div>
                                                <span class="small text-success fw-semibold">+5 pts</span>
                                            </div>
                                        </div>
                                        {{-- <div class="border rounded-3 p-2">
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div>
                                                    <input class="form-check-input" type="radio" name="winner"
                                                        id="winnerDraw" value="draw">
                                                    <label class="form-check-label fw-medium"
                                                        for="winnerDraw">Draw</label>
                                                </div>
                                                <span class="small text-success fw-semibold">+5 pts</span>
                                            </div>
                                        </div> --}}
                                        <div class="border rounded-3 p-2 option-team2">
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div>
                                                    <input class="form-check-input" type="radio" name="winner"
                                                        id="winnerTeam2" value="team2">
                                                    <label class="form-check-label fw-medium" id="winnerTeam2Label"
                                                        for="winnerTeam2">Canada</label>
                                                </div>
                                                <span class="small text-success fw-semibold">+5 pts</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <p class="mb-2 small fw-semibold text-danger">*Predict Match Score (Including Penalties)

                                <div class="mb-3">
                                    <label class="form-label fw-semibold"><span id="team1_name"></span>
                                        Goal Scrore</label>
                                    <input type="number" id="team1_goals" class="form-control" name="team1_goals"
                                        placeholder="0" value="0" pattern="[0-9]*" inputmode="numeric">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold"><span id="team2_name"></span>
                                        Goal Scrore</label>

                                    <input type="number" id="team2_goals" class="form-control" name="team2_goals"
                                        placeholder="0" value="0" pattern="[0-9]*" inputmode="numeric">
                                </div>

                                <div class="alert alert-info small mb-0" role="alert">
                                    <i class="bi bi-info-circle"></i> You can edit your prediction anytime
                                    until the match starts.
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="primary" onclick="savePrediction()">✓ Save
                                    Prediction</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- select my team --}}
                @if ($favorite_team == null)
                    <!-- Modal Structure -->
                    <div class="modal fade" id="teamModal" tabindex="-1" aria-labelledby="teamModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="autoForm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="teamModalLabel">Welcome!</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <div class="form-group">
                                            <label for="team1">Select Your Favourite Team</label>
                                            <select name="team1" id="team1" class="form-control select2">
                                                <option value="">Select Team</option>
                                                @foreach ($teams as $team)
                                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="primary" onclick="saveTeam()">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif



                <div class="standings-header mt-1" id="standingsToggle" onclick="toggleStandings()">
                    <h2 class="section-title mb-0">Top Standings</h2>
                    <div class="standings-arrow" id="standingsArrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>
                </div>
                @php
                    $medalMeta = [
                        ['icon' => '🥇', 'label' => '1st Place', 'badge' => '⚽ Top Predictor', 'class' => 'gold'],
                        ['icon' => '🥈', 'label' => '2nd Place', 'badge' => '⚽ Runner Up', 'class' => 'silver'],
                        ['icon' => '🥉', 'label' => '3rd Place', 'badge' => '⚽ 3rd Place', 'class' => 'bronze'],
                    ];
                @endphp
                <div class="medals mb-2" id="standingsBody" style="display:none;overflow:hidden;">
                    @foreach ($medalMeta as $i => $meta)
                        @php $p = $top3->get($i); @endphp
                        <div class="medal-card {{ $meta['class'] }}" data-rank="{{ $i + 1 }}">
                            <div class="medal-top-bar"></div>
                            <div class="medal-icon">{{ $meta['icon'] }}</div>
                            <div class="medal-label">{{ $meta['label'] }}</div>
                            @if ($p)
                                <div class="medal-name">{{ $p->full_name }}</div>
                                <div class="medal-dept-name">{{ $p->depart_name }}</div>
                                <div class="medal-pts-row">
                                    <span class="medal-pts-val">{{ $p->total_points }}</span>
                                    <span class="medal-pts-lbl">pts</span>
                                </div>
                                @if ($p->team_flag)
                                    <div class="medal-team-flag">
                                        <img src="{{ $p->team_flag }}" alt="{{ $p->team_name }}" width="20"
                                            height="14" style="border-radius:2px;object-fit:cover;margin-right:4px;">
                                        {{ $p->team_name }}
                                    </div>
                                @endif
                            @else
                                <div class="medal-name">--</div>
                            @endif
                            <div class="medal-ball">{{ $meta['badge'] }}</div>
                        </div>
                    @endforeach
                </div>

                <h2 class="section-title" style="margin-top: 2rem;">Quick Links</h2>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <button style="flex: 1; min-width: 150px;" onclick="showScreen('predictions')"
                        data-predictions-url="{{ route('predictions') }}">📋 My Predictions</button>
                    <button style="flex: 1; min-width: 150px;" onclick="showScreen('leaderboard')"
                        data-predictions-url="{{ route('leaderboard') }}">🏆 Leaderboard</button>
                </div>
            </div>
            <div class="col-12 col-md-4 px-md-2">
                <div class="row">
                    @if ($allPred->count() > 0)
                        <div class="col-md-12">
                            <h2 class="section-title mt-3">Predictions</h2>
                            <div class="predictions-scroll">
                                @include('users.allPredictions')
                            </div>
                        </div>
                    @endif

                    <div class="col-md-12">
                        @include('users.sidebar')
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        /* ── Top Standings toggle ── */
        function toggleStandings() {
            var body = document.getElementById('standingsBody');
            var arrow = document.getElementById('standingsArrow');
            if (body.style.display === 'none' || body.style.display === '') {
                body.style.display = 'flex';
                body.classList.add('standings-body-visible');
                arrow.classList.add('open');
            } else {
                body.style.display = 'none';
                body.classList.remove('standings-body-visible');
                arrow.classList.remove('open');
            }
        }

        /* ── My Stats: count-up + donut animation ── */
        document.addEventListener('DOMContentLoaded', function() {

            function easeOutCubic(t) {
                return 1 - Math.pow(1 - t, 3);
            }

            function countUp(el, target, duration, delay) {
                setTimeout(function() {
                    if (target === 0) {
                        el.textContent = '0';
                        return;
                    }
                    const start = performance.now();

                    function tick(now) {
                        const progress = Math.min((now - start) / duration, 1);
                        el.textContent = Math.round(easeOutCubic(progress) * target);
                        if (progress < 1) requestAnimationFrame(tick);
                    }
                    requestAnimationFrame(tick);
                }, delay);
            }

            /* Count-up */
            document.querySelectorAll('.pstat-countup[data-count]').forEach(function(el) {
                const target = parseFloat(el.dataset.count) || 0;
                countUp(el, target, 1100, 350);
            });

            /* Progress bar animation */
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    document.querySelectorAll('.pstat-prog-fill[data-pct]').forEach(function(el) {
                        const pct = Math.min(Math.max(parseFloat(el.dataset.pct) || 0, 0),
                            100);
                        el.style.width = pct + '%';
                    });
                });
            });
        });

        const buttons = document.querySelectorAll('.nav-tabs button');
        buttons.forEach(btn => btn.classList.remove('active'));
        if (buttons.length >= 1) {
            buttons[0].classList.add('active');
        }
        preventNumberInputScroll('team1_goals');
        preventNumberInputScroll('team2_goals');

        /* ── Match countdown: card locks 3 min before kickoff ── */
        (function() {
            var LOCK_BEFORE_MS = 3 * 60 * 1000; // 3 min

            function updateCountdowns() {
                document.querySelectorAll('.match-card[data-match-epoch]').forEach(function(card) {
                    var matchEpoch = parseInt(card.dataset.matchEpoch, 10) * 1000;
                    var closeEpoch = matchEpoch - LOCK_BEFORE_MS;
                    var staticEl = card.querySelector('.match-time-static');
                    var liveEl = card.querySelector('.match-countdown-live');
                    var timerEl = card.querySelector('.countdown-timer');
                    var diffToClose = closeEpoch - Date.now();

                    if (diffToClose <= 0) {
                        card.style.display = 'none';
                        return;
                    }

                    if (diffToClose <= 60 * 60 * 1000) {
                        if (staticEl) staticEl.style.display = 'none';
                        if (liveEl) liveEl.style.display = 'inline';
                        var totalSecs = Math.floor(diffToClose / 1000);
                        var m = Math.floor(totalSecs / 60);
                        var s = totalSecs % 60;
                        var pad = function(n) {
                            return String(n).padStart(2, '0');
                        };
                        if (timerEl) timerEl.textContent = pad(m) + ':' + pad(s);
                    } else {
                        if (staticEl) staticEl.style.display = 'inline';
                        if (liveEl) liveEl.style.display = 'none';
                    }
                });
            }

            updateCountdowns();
            setInterval(updateCountdowns, 1000);
        })();

        function preventNumberInputScroll(inputId) {
            const input = document.getElementById(inputId);
            if (input) {
                input.addEventListener('wheel', (e) => {
                    e.target.blur();
                    e.preventDefault();
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {

            function initSelect2() {
                $('#team1').select2({
                    dropdownParent: $('#teamModal'),
                    placeholder: 'Select a team',
                    allowClear: true,
                    width: '100%'
                });
            }

            // Check condition from backend
            @if ($favorite_team == null)
                var modal = new bootstrap.Modal(document.getElementById('teamModal'));

                // Initialize Select2 when modal is fully shown
                modal._element.addEventListener('shown.bs.modal', function() {
                    initSelect2();
                });

                // Show the modal
                modal.show();
            @endif

            // Handle form submission
            $('#submitTeam').on('click', function() {
                var selectedTeam = $('#team1').val();
                if (selectedTeam && selectedTeam !== '') {
                    $('#autoForm').submit();
                } else {
                    alert('Please select a team');
                }
            });
        });


        function saveTeam() {
            const team = document.getElementById('team1').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const formData = new FormData();
            formData.append('team', team || 0);
            formData.append('_token', csrfToken);

            fetch('{{ route('saveMyteam') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw err;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    showToast('Favorite team saved successfully!', 'success');

                    const modal = bootstrap.Modal.getInstance(document.getElementById('teamModal'));
                    modal.hide();

                    // clear form
                    document.getElementById('team1').value = '';

                })
                .catch(error => {
                    showToast('Failed to save changes. Please try again.', 'danger');
                });

        }
    </script>
@endsection
