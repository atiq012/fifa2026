{{-- <div class="card">
    <div class="card-body">
        <div class="table-responsive ">
            <table class="table table-sm table-hover align-middle mb-0">
                <thead class="table-header-custom">
                    <tr>
                        <th style="width:8%"><i class="fas fa-hashtag me-1"></i>Rank</th>
                        <th style="width:32%">Player</th>
                        <th style="width:12%" class="text-end"><i class="fas fa-chart-line me-1"></i>Pts</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($players as $player)
                        <tr style="background:#fffbef;">
                            <td class="text-center">
                                @if ($loop->first)
                                    <span class="rank-badge rank-gold">
                                        <i class="fas fa-crown" style="font-size:0.65rem;"></i>
                                    </span>
                                @elseif($loop->iteration == 2)
                                    <span class="rank-badge rank-silver">2</span>
                                @elseif($loop->iteration == 3)
                                    <span class="rank-badge rank-bronze">3</span>
                                @else
                                    <span class="rank-badge rank-plain">{{ $loop->iteration }}</span>
                                @endif

                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div>
                                        <div class="player-name">{{ $player->full_name }}</div>
                                        <div class="player-sub">{{ $player->depart_name }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-end points-value">0</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div> --}}

<h2 class="section-title mt-3">Your Performance</h2>
<div class="perf-card mb-3">
    <div class="perf-header">
        <div>
            <div class="perf-header-title">Current Rank</div>
            <div class="perf-rank-badge">
                <span class="perf-rank-num">#{{ $myRank }}</span>
            </div>
        </div>
        <div class="perf-trophy">🏆</div>
    </div>

    <div class="perf-stats-row">
        <div class="perf-stat-cell">
            <div class="perf-stat-val">{{ $totalPoints }}</div>
            <div class="perf-stat-lbl">Points</div>
        </div>
        <div class="perf-stat-cell">
            <div class="perf-stat-val">{{ $total_correct_predictions }}</div>
            <div class="perf-stat-lbl">Correct</div>
        </div>
        <div class="perf-stat-cell">
            <div class="perf-stat-val perf-streak-val">
                {{ $myStreak > 0 ? '🔥' : '' }}{{ $myStreak }}
            </div>
            <div class="perf-stat-lbl">Streak</div>
        </div>
    </div>

    <div class="perf-accuracy-wrap">
        <div class="perf-accuracy-meta">
            <span class="perf-accuracy-label">Goal Accuracy</span>
            <span class="perf-accuracy-pct">{{ number_format($myAccuracy, 1) }}%</span>
        </div>
        <div class="perf-bar-track">
            <div class="perf-bar-fill" style="width: {{ min((float)$myAccuracy, 100) }}%"></div>
        </div>
    </div>

    <div class="perf-footer">
        {{ $totalPredictions }} total predictions &nbsp;·&nbsp; {{ $total_correct_predictions }} wins
    </div>
</div>
