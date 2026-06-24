@extends('dashboardLayout.main')
@section('styles')
    <style>
        /* ── Leaderboard table override ── */
        .leaderboard {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: none;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }

        .leaderboard-header {
            display: grid;
            grid-template-columns: 52px 1fr 72px 120px;
            gap: 0;
            background: linear-gradient(135deg, #0f2744 0%, #1a3f6e 100%);
            padding: 0;
            border-bottom: 2px solid #ffc107;
        }

        .leaderboard-row {
            display: grid;
            grid-template-columns: 52px 1fr 72px 120px;
            gap: 0;
            padding: 0;
            border-bottom: 1px solid #f0f2f5;
            align-items: center;
            transition: background 0.15s, transform 0.1s;
        }

        .leaderboard-row:last-child { border-bottom: none; }

        .leaderboard-row:hover {
            background: #f7f9ff !important;
            transform: translateX(2px);
        }

        .leaderboard-row.highlight {
            background: linear-gradient(90deg, #fffbe6 0%, #fff9e0 100%) !important;
            border-left: 3px solid #ffc107;
        }

        .leaderboard-cell {
            padding: 12px 10px;
            font-size: 13px;
            color: #2c2c2a;
            display: flex;
            align-items: center;
        }

        .leaderboard-header .leaderboard-cell {
            padding: 10px 10px;
            font-weight: 600;
            color: rgba(255,255,255,0.7);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* Rank cell */
        .cell-rank { justify-content: center; }

        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            font-size: 0.78rem;
            font-weight: 800;
        }

        .rank-gold   { background: linear-gradient(135deg,#FFD700,#FFA500); color: #5a3c00; box-shadow: 0 2px 8px rgba(255,165,0,0.4); }
        .rank-silver { background: linear-gradient(135deg,#D0D5DD,#A8B2C0); color: #3a4a5a; box-shadow: 0 2px 8px rgba(160,175,190,0.4); }
        .rank-bronze { background: linear-gradient(135deg,#CD7F32,#A0522D); color: #fff; box-shadow: 0 2px 8px rgba(160,82,45,0.35); }
        .rank-plain  { font-size: 0.82rem; font-weight: 700; color: #8a99aa; }

        /* Player cell */
        .cell-player { gap: 10px; }

        .player-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .player-info { display: flex; flex-direction: column; gap: 2px; min-width: 0; }

        .player-name {
            font-weight: 700;
            font-size: 0.84rem;
            color: #1a2840;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .player-meta {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .player-dept {
            font-size: 0.68rem;
            color: #8a99aa;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Points cell */
        .cell-pts {
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 1px;
            text-align: center;
        }

        .pts-number {
            font-weight: 800;
            font-size: 1rem;
            color: #1a3f6e;
            line-height: 1;
        }

        .pts-label {
            font-size: 0.6rem;
            color: #aab4c0;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Accuracy cell */
        .cell-acc {
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 10px 10px 10px 4px;
        }

        .acc-bar-wrap {
            width: 100%;
            height: 5px;
            background: #e9ecef;
            border-radius: 99px;
            overflow: hidden;
        }

        .acc-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, #22c55e, #16a34a);
            transition: width 0.6s ease;
        }

        .acc-bar-fill.medium { background: linear-gradient(90deg, #f59e0b, #d97706); }
        .acc-bar-fill.low    { background: linear-gradient(90deg, #ef4444, #dc2626); }

        .acc-text {
            font-size: 0.75rem;
            font-weight: 700;
            color: #16a34a;
            text-align: center;
            width: 100%;
        }

        .acc-text.medium { color: #d97706; }
        .acc-text.low    { color: #dc2626; }

        /* ── Prediction modal ── */
        .pred-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .pred-modal-backdrop.open { display: flex; }

        .pred-modal {
            background: #fff;
            border-radius: 16px;
            width: 100%;
            max-width: 680px;
            max-height: 88vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            overflow: hidden;
        }

        .pred-modal-head {
            background: linear-gradient(135deg, #0f2744, #1a3f6e);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .pred-modal-head h3 {
            color: #fff;
            margin: 0;
            font-size: 0.95rem;
            font-weight: 700;
        }

        .pred-modal-close {
            background: none;
            border: none;
            color: rgba(255,255,255,0.7);
            font-size: 1.4rem;
            cursor: pointer;
            line-height: 1;
            padding: 0 4px;
        }
        .pred-modal-close:hover { color: #fff; }

        .pred-modal-body {
            overflow-y: auto;
            flex: 1;
            padding: 0;
        }

        .pred-table-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .pred-match-table {
            width: 100%;
            min-width: 520px;
            border-collapse: collapse;
            font-size: 0.78rem;
        }

        .pred-match-table thead th {
            background: #f5f7fa;
            padding: 9px 10px;
            text-align: center;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #6b7a8d;
            font-weight: 700;
            border-bottom: 1px solid #e8ecf0;
            position: sticky;
            top: 0;
            white-space: nowrap;
        }

        .pred-match-table thead th:first-child { text-align: left; }

        .pred-match-table tbody tr { border-bottom: 1px solid #f0f2f5; }
        .pred-match-table tbody tr:last-child { border-bottom: none; }
        .pred-match-table tbody tr:hover { background: #f9fbff; }

        .pred-match-table td {
            padding: 10px 10px;
            vertical-align: middle;
            text-align: center;
        }

        .pred-match-table td:first-child { text-align: left; }

        .match-teams {
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .match-teams img { width: 16px; height: 16px; object-fit: contain; }

        .match-date {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 3px;
            font-size: 0.63rem;
            color: #8a99aa;
        }

        .cal-icon {
            display: inline-flex;
            align-items: center;
            flex-shrink: 0;
            opacity: 0.55;
        }

        .score-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 3px;
            font-weight: 700;
            font-size: 0.82rem;
            background: #f5f7fa;
            padding: 3px 8px;
            border-radius: 6px;
        }

        .score-sep { color: #aab4c0; font-weight: 400; }

        .pts-breakdown {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
        }

        .pts-row {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.67rem;
            color: #6b7a8d;
            white-space: nowrap;
        }

        .pts-row-label { font-weight: 500; }

        .pts-badge {
            display: inline-block;
            padding: 1px 5px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 0.67rem;
        }

        .pts-badge.w-pts  { background: #dbeafe; color: #1d4ed8; }
        .pts-badge.g-pts  { background: #fef9c3; color: #854d0e; }
        .pts-badge.zero   { background: #f0f2f5; color: #8a99aa; }

        .pts-total {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 99px;
            font-weight: 800;
            font-size: 0.72rem;
            border-top: 1px dashed #e8ecf0;
            padding-top: 4px;
            margin-top: 1px;
        }

        .pts-total.high  { color: #15803d; }
        .pts-total.mid   { color: #854d0e; }
        .pts-total.zero  { color: #8a99aa; }

        .modal-loading {
            padding: 40px;
            text-align: center;
            color: #8a99aa;
            font-size: 0.85rem;
        }

        .modal-empty {
            padding: 40px;
            text-align: center;
            color: #8a99aa;
            font-size: 0.85rem;
        }

        .leaderboard-row { cursor: pointer; }

        /* ── Mobile cards ── */
        .pred-cards { display: none; padding: 10px; }

        .pred-card {
            background: #fff;
            border: 1px solid #e8ecf0;
            border-radius: 12px;
            margin-bottom: 10px;
            overflow: hidden;
            box-shadow: 0 1px 6px rgba(0,0,0,0.05);
        }

        .pred-card:last-child { margin-bottom: 0; }

        .pred-card-head {
            background: #f5f7fa;
            padding: 10px 12px 8px;
            border-bottom: 1px solid #e8ecf0;
        }

        .pred-card-teams {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.82rem;
            font-weight: 700;
            color: #1a2840;
        }

        .pred-card-teams img { width: 16px; height: 16px; object-fit: contain; }

        .pred-card-date {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 4px;
            font-size: 0.63rem;
            color: #8a99aa;
        }

        .pred-card-body {
            padding: 10px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pred-card-scores {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pred-card-score-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
        }

        .pred-card-score-label {
            font-size: 0.58rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #8a99aa;
            font-weight: 600;
        }

        .pred-card-divider {
            width: 1px;
            height: 36px;
            background: #e8ecf0;
            flex-shrink: 0;
        }

        .pred-card-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 5px;
        }

        @media (max-width: 575px) {
            .pred-modal { border-radius: 12px; }
            .pred-table-wrap { display: none; }
            .pred-cards { display: block; }
        }

        /* Avatar color palette */
        .av-1 { background: linear-gradient(135deg,#6366f1,#4f46e5); }
        .av-2 { background: linear-gradient(135deg,#ec4899,#db2777); }
        .av-3 { background: linear-gradient(135deg,#14b8a6,#0d9488); }
        .av-4 { background: linear-gradient(135deg,#f97316,#ea580c); }
        .av-5 { background: linear-gradient(135deg,#8b5cf6,#7c3aed); }
        .av-6 { background: linear-gradient(135deg,#06b6d4,#0891b2); }
        .av-7 { background: linear-gradient(135deg,#84cc16,#65a30d); }
        .av-8 { background: linear-gradient(135deg,#f43f5e,#e11d48); }

        /* mobile-pts-inline: hidden on desktop, shown on mobile */
        .mobile-pts-inline { display: none; }

        @media (max-width: 575px) {
            /* 3-col grid: rank | player | acc+pts combined */
            .leaderboard-header,
            .leaderboard-row {
                grid-template-columns: 38px 1fr 72px;
            }

            /* hide standalone pts col */
            .cell-pts,
            .leaderboard-header .cell-pts { display: none; }

            /* acc cell: stack pts → acc% → bar */
            .cell-acc {
                padding: 10px 8px 10px 4px;
                gap: 3px;
            }

            /* show pts inline inside acc cell */
            .mobile-pts-inline {
                display: block;
                font-weight: 800;
                font-size: 0.92rem;
                color: #1a3f6e;
                text-align: center;
                line-height: 1;
                width: 100%;
            }
            .mobile-pts-inline small {
                display: block;
                font-size: 0.55rem;
                color: #aab4c0;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .leaderboard-cell { padding: 9px 5px; }

            .player-avatar { width: 28px; height: 28px; font-size: 0.6rem; }
            .player-name { font-size: 0.78rem; }
            .player-dept { font-size: 0.62rem; }

            .acc-text   { font-size: 0.68rem; }

            .rank-badge { width: 26px; height: 26px; font-size: 0.72rem; }
            .rank-plain { font-size: 0.76rem; }

            .leaderboard-header .leaderboard-cell {
                font-size: 0.58rem;
                padding: 8px 5px;
            }
        }
    </style>
@endsection
@section('content')
    <!-- Leaderboard Screen -->
    <div id="leaderboard" class="screen active">
        <h2 class="section-title">Galaxy Leaderboard</h2>

        <div class="medals mb-2">
            <div class="medal-card gold">
                <div class="medal-icon">🥇</div>
                <div class="medal-label">1st Place</div>
                <div class="medal-name">{{ $top3->get(0)?->full_name ?? '-' }}</div>
            </div>
            <div class="medal-card silver">
                <div class="medal-icon">🥈</div>
                <div class="medal-label">2nd Place</div>
                <div class="medal-name">{{ $top3->get(1)?->full_name ?? '-' }}</div>
            </div>
            <div class="medal-card bronze">
                <div class="medal-icon">🥉</div>
                <div class="medal-label">3rd Place</div>
                <div class="medal-name">{{ $top3->get(2)?->full_name ?? '-' }}</div>
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
            {{-- Header --}}
            <div class="leaderboard-header">
                <div class="leaderboard-cell cell-rank">#</div>
                <div class="leaderboard-cell cell-player">Player</div>
                <div class="leaderboard-cell cell-pts">Pts</div>
                <div class="leaderboard-cell cell-acc">Prediction Acc.</div>
            </div>

            @foreach ($players as $player)
                @php
                    $rankClass = match((int) $player->ranking) {
                        1 => 'rank-gold',
                        2 => 'rank-silver',
                        3 => 'rank-bronze',
                        default => 'rank-plain',
                    };
                    $isMe = auth()->id() === $player->user_id;
                    $acc = (float) $player->goal_accuracy;
                    $accClass = $acc >= 60 ? '' : ($acc >= 30 ? 'medium' : 'low');

                    // 2-word name
                    $nameParts = explode(' ', trim($player->full_name));
                    $displayName = implode(' ', array_slice($nameParts, 0, 2));

                    // Avatar image
                    $imgPath = $player->image_path ?? null;
                    if ($imgPath) {
                        $localPath = str_starts_with($imgPath, 'public/') ? substr($imgPath, 7) : $imgPath;
                        $avatarSrc = file_exists(public_path($localPath))
                            ? asset($localPath)
                            : 'https://myportal.galaxybd.com/public/' . $imgPath;
                    } else {
                        $avatarSrc = null;
                    }
                    $initials = collect($nameParts)->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->join('');
                    $avColor = 'av-' . (($player->user_id % 8) + 1);
                @endphp
                <div class="leaderboard-row {{ $isMe ? 'highlight' : '' }}"
                     data-user-id="{{ $player->user_id }}"
                     data-user-name="{{ $displayName }}"
                     data-team-flag="{{ $player->team_flag ?? '' }}">

                    {{-- Rank --}}
                    <div class="leaderboard-cell cell-rank">
                        @if(in_array((int) $player->ranking, [1, 2, 3]))
                            <span class="rank-badge {{ $rankClass }}">{{ $player->ranking }}</span>
                        @else
                            <span class="rank-plain">{{ $player->ranking }}</span>
                        @endif
                    </div>

                    {{-- Player --}}
                    <div class="leaderboard-cell cell-player">
                        @php
                            $canEdit = auth()->id() === 1 || $isMe;
                        @endphp
                        <div style="position:relative;flex-shrink:0;{{ $canEdit ? 'cursor:pointer;' : '' }}"
                             {{ $canEdit ? 'onclick=openAvatarModal(' . $player->user_id . ')' : '' }}>
                            @if($avatarSrc)
                                <img src="{{ $avatarSrc }}" alt="{{ $initials }}"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                     style="width:36px;height:36px;border-radius:50%;object-fit:cover;display:block;">
                                <div class="player-avatar {{ $avColor }}" style="display:none;width:36px;height:36px;">{{ $initials }}</div>
                            @else
                                <div class="player-avatar {{ $avColor }}">{{ $initials }}</div>
                            @endif
                            @if($canEdit)
                                <div style="position:absolute;bottom:-1px;right:-1px;width:13px;height:13px;background:#3b82f6;border-radius:50%;display:flex;align-items:center;justify-content:center;border:1.5px solid #fff;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="7" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="player-info">
                            <div class="player-name">
                                {{ $displayName }}
                                @if($player->team_flag)
                                    <img height="14" width="14" src="{{ $player->team_flag }}"
                                         alt="{{ $player->team_name }}" style="vertical-align:middle; margin-left:3px;">
                                @endif
                                @if($isMe)
                                    <span style="font-size:0.62rem; background:#ffc107; color:#5a3c00; padding:1px 6px; border-radius:99px; font-weight:700; margin-left:4px;">YOU</span>
                                @endif
                            </div>
                            <div class="player-meta">
                                <span class="player-dept">{{ $player->depart_name }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Points --}}
                    <div class="leaderboard-cell cell-pts">
                        <span class="pts-number">{{ $player->total_points }}</span>
                        <span class="pts-label">pts</span>
                    </div>

                    {{-- Goal Accuracy --}}
                    <div class="leaderboard-cell cell-acc">
                        <span class="mobile-pts-inline">{{ $player->total_points }}<small>pts</small></span>
                        <span class="acc-text {{ $accClass }}">{{ number_format($acc, 1) }}%</span>
                        <div class="acc-bar-wrap">
                            <div class="acc-bar-fill {{ $accClass }}" style="width:{{ min($acc, 100) }}%"></div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>

    {{-- Prediction detail modal --}}
    <div class="pred-modal-backdrop" id="predModal" onclick="closePredModal(event)">
        <div class="pred-modal">
            <div class="pred-modal-head">
                <h3 id="predModalTitle">Match Predictions</h3>
                <button class="pred-modal-close" onclick="closePredModal()">&#x2715;</button>
            </div>
            <div class="pred-modal-body" id="predModalBody">
                <div class="modal-loading">Loading...</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const buttons = document.querySelectorAll('.nav-tabs button');
    buttons.forEach(btn => btn.classList.remove('active'));
    if (buttons.length >= 3) {
        buttons[2].classList.add('active');
    }

    // Attach click to each row
    document.querySelectorAll('.leaderboard-row').forEach(row => {
        row.addEventListener('click', function (e) {
            // ignore avatar upload clicks
            if (e.target.closest('[onclick^="openAvatarModal"]')) return;
            const userId    = this.dataset.userId;
            const userName  = this.dataset.userName;
            const teamFlag  = this.dataset.teamFlag;
            openPredModal(userId, userName, teamFlag);
        });
    });

    function openPredModal(userId, userName, teamFlag) {
        document.getElementById('predModalTitle').textContent = userName + ' — Match Predictions';
        document.getElementById('predModalBody').innerHTML = '<div class="modal-loading">Loading...</div>';

        const head = document.querySelector('#predModal .pred-modal-head');
        if (teamFlag) {
            head.style.background = `linear-gradient(rgba(15,39,68,0.55), rgba(15,39,68,0.55)), url('${teamFlag}') center/cover no-repeat`;
        } else {
            head.style.background = '';
        }

        document.getElementById('predModal').classList.add('open');

        fetch(`/leaderboard/user/${userId}/predictions`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('predModalBody').innerHTML = buildTable(data);
            })
            .catch(() => {
                document.getElementById('predModalBody').innerHTML = '<div class="modal-empty">Failed to load data.</div>';
            });
    }

    function closePredModal(e) {
        if (e && e.target !== document.getElementById('predModal')) return;
        document.getElementById('predModal').classList.remove('open');
    }

    const CAL_SVG = `<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#6b7a8d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>`;

    function formatDate(dateStr) {
        if (!dateStr) return '';
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const d = new Date(dateStr);
        if (isNaN(d)) return dateStr;
        return String(d.getDate()).padStart(2,'0') + '-' + months[d.getMonth()] + '-' + d.getFullYear();
    }

    function matchParts(m) {
        const result = (m.actual_t1 !== null && m.actual_t2 !== null)
            ? `<span class="score-box">${m.actual_t1}<span class="score-sep">–</span>${m.actual_t2}</span>`
            : '<span style="color:#aab4c0">—</span>';

        const prediction = (m.pred_t1 !== null && m.pred_t2 !== null)
            ? `<span class="score-box">${m.pred_t1}<span class="score-sep">–</span>${m.pred_t2}</span>`
            : '<span style="color:#aab4c0">—</span>';

        const winnerBadge = m.winner_correct ? `<span style="display:inline-flex;align-items:center;gap:3px;background:#dcfce7;color:#15803d;padding:3px 9px;border-radius:99px;font-size:0.7rem;font-weight:700;"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Win</span>`
            : `<span style="display:inline-flex;align-items:center;gap:3px;background:#fee2e2;color:#b91c1c;padding:3px 9px;border-radius:99px;font-size:0.7rem;font-weight:700;"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Loss</span>`;

        const wp = m.winner_points ?? 0;
        const gp = m.goal_points ?? 0;
        const total = wp + gp;
        const totalClass = total >= 8 ? 'high' : (total > 0 ? 'mid' : 'zero');
        const wBadge = `<span class="pts-badge w-pts">W: ${wp}</span>`;
        const gBadge = `<span class="pts-badge ${gp > 0 ? 'g-pts' : 'zero'}">G: ${gp}</span>`;
        const ptsBreakdown = `<div class="pts-breakdown"><div class="pts-row">${wBadge}${gBadge}</div><div class="pts-total ${totalClass}">${total} pts</div></div>`;

        const t1flag = m.team1_flag ? `<img src="${m.team1_flag}" alt="">` : '';
        const t2flag = m.team2_flag ? `<img src="${m.team2_flag}" alt="">` : '';

        return { result, prediction, winnerBadge, ptsBreakdown, t1flag, t2flag, wp, gp, total, totalClass };
    }

    function buildTable(data) {
        if (!data || data.length === 0) {
            return '<div class="modal-empty">No completed predictions yet.</div>';
        }

        // ── Desktop table ──
        const tableRows = data.map(m => {
            const p = matchParts(m);
            return `<tr>
                <td>
                    <div class="match-teams">${p.t1flag}<span>${m.team1_name ?? '—'}</span><span style="color:#aab4c0;font-size:0.7rem">vs</span>${p.t2flag}<span>${m.team2_name ?? '—'}</span></div>
                    <div class="match-date"><span class="cal-icon">${CAL_SVG}</span>${formatDate(m.date)}</div>
                </td>
                <td>${p.prediction}</td>
                <td>${p.result}</td>
                <td>${p.winnerBadge}</td>
                <td>${p.ptsBreakdown}</td>
            </tr>`;
        }).join('');

        const table = `<div class="pred-table-wrap"><table class="pred-match-table">
            <thead><tr><th>Match</th><th>Prediction</th><th>Result</th><th>Winner</th><th>Points</th></tr></thead>
            <tbody>${tableRows}</tbody>
        </table></div>`;

        // ── Mobile cards ──
        const cards = data.map(m => {
            const p = matchParts(m);
            const wp = m.winner_points ?? 0;
            const gp = m.goal_points ?? 0;
            const total = wp + gp;
            const totalClass = total >= 8 ? 'high' : (total > 0 ? 'mid' : 'zero');
            return `<div class="pred-card">
                <div class="pred-card-head">
                    <div class="pred-card-teams">
                        ${p.t1flag}<span>${m.team1_name ?? '—'}</span>
                        <span style="color:#aab4c0;font-size:0.72rem;font-weight:400">vs</span>
                        ${p.t2flag}<span>${m.team2_name ?? '—'}</span>
                    </div>
                    <div class="pred-card-date"><span class="cal-icon">${CAL_SVG}</span>${formatDate(m.date)}</div>
                </div>
                <div class="pred-card-body">
                    <div class="pred-card-scores">
                        <div class="pred-card-score-col">
                            <span class="pred-card-score-label">Prediction</span>
                            ${p.prediction}
                        </div>
                        <div class="pred-card-divider"></div>
                        <div class="pred-card-score-col">
                            <span class="pred-card-score-label">Result</span>
                            ${p.result}
                        </div>
                    </div>
                    <div class="pred-card-right">
                        ${p.winnerBadge}
                        <div style="display:flex;align-items:center;gap:4px;margin-top:2px;">
                            <span class="pts-badge w-pts">W: ${wp}</span>
                            <span class="pts-badge ${gp > 0 ? 'g-pts' : 'zero'}">G: ${gp}</span>
                            <span class="pts-total ${totalClass}" style="border-top:none;margin-top:0;padding-top:0;">${total} pts</span>
                        </div>
                    </div>
                </div>
            </div>`;
        }).join('');

        return table + `<div class="pred-cards">${cards}</div>`;
    }
</script>
@endsection
