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
            border-radius: 16px;
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
    </style>
@endsection
@section('content')
    <!-- Leaderboard Screen -->
    <div id="leaderboard" class="screen active">
        <h2 class="section-title">Global Rankings</h2>

        <div class="medals mb-2">
            <div class="medal-card gold">
                <div class="medal-icon">🥇</div>
                <div class="medal-label">1st Place</div>
                <div class="medal-name">-</div>
            </div>
            <div class="medal-card silver">
                <div class="medal-icon">🥈</div>
                <div class="medal-label">2nd Place</div>
                <div class="medal-name">-</div>
            </div>
            <div class="medal-card bronze">
                <div class="medal-icon">🥉</div>
                <div class="medal-label">3rd Place</div>
                <div class="medal-name">-</div>
            </div>
        </div>

        <div class="form-group">
            {{-- <select onchange="filterLeaderboard(this.value)">
                <option value="all">All Employees</option>
                <option value="dept">My Department</option>
                <option value="week">This Week</option>
            </select> --}}
        </div>

        <div class="search-bar">
            <input type="search" placeholder="Search player..." id="searchInput" onkeyup="filterTable()">
            <button>🔍</button>
        </div>

        <div class="leaderboard">
            <div class="leaderboard-header">
                <div class="leaderboard-cell">Rank</div>
                <div class="leaderboard-cell">Player</div>
                {{-- <div class="leaderboard-cell">Dept</div> --}}
                <div class="leaderboard-cell leaderboard-points">Points</div>
                <div class="leaderboard-cell leaderboard-accuracy">Accuracy</div>
            </div>
            @foreach ($players as $player)
            <div class="leaderboard-row highlight">
                <div class="leaderboard-cell leaderboard-rank">
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
                </div>
                <div class="leaderboard-cell">
                    {{ $player->full_name }}
                    <br>
                    <small>{{  $player->depart_name }}</small>
                </div>
                {{-- <div class="leaderboard-cell">{{ $player->depart_name }}</div> --}}
                <div class="leaderboard-cell leaderboard-points">0</div>
                <div class="leaderboard-cell leaderboard-accuracy">0%</div>
            </div>
            @endforeach
        </div>

        {{-- <div class="table-responsive rounded-3 shadow-sm">
            <table class="table table-sm table-hover align-middle mb-0">
                <thead class="table-header-custom">
                    <tr>
                        <th style="width:8%"></i>Rank</th>
                        <th style="width:10%">Employee</th>
                        <th style="width:32%"><i class="fas fa-user me-1"></i>Player</th>
                        <th style="width:18%"><i class="fas fa-building me-1"></i>Dept</th>
                        <th style="width:12%" class="text-end"><i class="fas fa-chart-line me-1"></i>Pts</th>
                        <th style="width:20%"><i class="fas fa-bullseye me-1"></i>Accuracy</th>
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
                            <td class="player-sub">{{ $player->emp_code }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">

                                    <div>
                                        <div class="player-name">{{ $player->full_name }}</div>
                                        <div class="player-sub">{{ $player->depart_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="dept-badge"><i class="fas fa-microchip me-1"
                                        style="font-size:0.6rem;"></i>{{ $player->depart_name }}</span></td>
                            <td class="text-end points-value">0</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="acc-bar-wrap">
                                        <div class="acc-bar-fill" style="width:0%;"></div>
                                    </div>
                                    <span class="acc-text">0%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}

        {{-- <div class="pagination">
            <button>←</button>
            <button class="active">1</button>
            <button>2</button>
            <button>3</button>
            <button>→</button>
        </div> --}}
    </div>
@endsection

@section('scripts')
    <script>
        const buttons = document.querySelectorAll('.nav-tabs button');
        buttons.forEach(btn => btn.classList.remove('active'));
        if (buttons.length >= 3) {
            buttons[2].classList.add('active');
        }
    </script>
@endsection
