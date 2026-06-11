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

<div class="card">
    <div class="card-body p-3">
        <h2 class="section-title">Your Performance</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Your Rank</div>
                <div class="stat-value">#</div>
                <div class="stat-subtitle">of 700 employees</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Points</div>
                <div class="stat-value">{{ $totalPoints }}</div>
                <div class="stat-subtitle">{{ $total_correct_predictions }} correct predictions</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Accuracy</div>
                <div class="stat-value">0%</div>
                <div class="stat-subtitle">Above average</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Streak</div>
                <div class="stat-value">0</div>
                <div class="stat-subtitle">Keep it going!</div>
            </div>
        </div>
    </div>
</div>
