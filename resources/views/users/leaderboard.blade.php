@extends('dashboardLayout.main')

@section('content')
    <!-- Leaderboard Screen -->
    <div id="leaderboard" class="screen active">
        <h2 class="section-title">Global Rankings</h2>

        <div class="medals mb-2">
            <div class="medal-card gold">
                <div class="medal-icon">🥇</div>
                <div class="medal-label">1st Place</div>
                <div class="medal-name">Rahul Kumar</div>
            </div>
            <div class="medal-card silver">
                <div class="medal-icon">🥈</div>
                <div class="medal-label">2nd Place</div>
                <div class="medal-name">Priya Singh</div>
            </div>
            <div class="medal-card bronze">
                <div class="medal-icon">🥉</div>
                <div class="medal-label">3rd Place</div>
                <div class="medal-name">Ahmed Hassan</div>
            </div>
        </div>

        <div class="form-group">
            <select onchange="filterLeaderboard(this.value)">
                <option value="all">All Employees</option>
                <option value="dept">My Department</option>
                <option value="week">This Week</option>
            </select>
        </div>

        <div class="search-bar">
            <input type="search" placeholder="Search player..." id="searchInput" onkeyup="filterTable()">
            <button>🔍</button>
        </div>

        <div class="leaderboard">
            <div class="leaderboard-header">
                <div class="leaderboard-cell">Rank</div>
                <div class="leaderboard-cell">Player</div>
                <div class="leaderboard-cell">Dept</div>
                <div class="leaderboard-cell leaderboard-points">Points</div>
                <div class="leaderboard-cell leaderboard-accuracy">Accuracy</div>
            </div>
            <div class="leaderboard-row highlight">
                <div class="leaderboard-cell leaderboard-rank">1</div>
                <div class="leaderboard-cell">Rahul Kumar</div>
                <div class="leaderboard-cell">Eng</div>
                <div class="leaderboard-cell leaderboard-points">245</div>
                <div class="leaderboard-cell leaderboard-accuracy">58%</div>
            </div>
            <div class="leaderboard-row">
                <div class="leaderboard-cell leaderboard-rank">2</div>
                <div class="leaderboard-cell">Priya Singh</div>
                <div class="leaderboard-cell">Prod</div>
                <div class="leaderboard-cell leaderboard-points">228</div>
                <div class="leaderboard-cell leaderboard-accuracy">56%</div>
            </div>
            <div class="leaderboard-row">
                <div class="leaderboard-cell leaderboard-rank">3</div>
                <div class="leaderboard-cell">Ahmed Hassan</div>
                <div class="leaderboard-cell">Sales</div>
                <div class="leaderboard-cell leaderboard-points">215</div>
                <div class="leaderboard-cell leaderboard-accuracy">53%</div>
            </div>
            <div class="leaderboard-row">
                <div class="leaderboard-cell leaderboard-rank">4</div>
                <div class="leaderboard-cell">Lisa Wong</div>
                <div class="leaderboard-cell">HR</div>
                <div class="leaderboard-cell leaderboard-points">201</div>
                <div class="leaderboard-cell leaderboard-accuracy">49%</div>
            </div>
            <div class="leaderboard-row">
                <div class="leaderboard-cell leaderboard-rank">5</div>
                <div class="leaderboard-cell">Carlos Mendez</div>
                <div class="leaderboard-cell">Ops</div>
                <div class="leaderboard-cell leaderboard-points">195</div>
                <div class="leaderboard-cell leaderboard-accuracy">51%</div>
            </div>
            <div class="leaderboard-row">
                <div class="leaderboard-cell leaderboard-rank">6</div>
                <div class="leaderboard-cell">Sofia Martinez</div>
                <div class="leaderboard-cell">Eng</div>
                <div class="leaderboard-cell leaderboard-points">188</div>
                <div class="leaderboard-cell leaderboard-accuracy">47%</div>
            </div>
            <div class="leaderboard-row">
                <div class="leaderboard-cell leaderboard-rank">7</div>
                <div class="leaderboard-cell">James Chen</div>
                <div class="leaderboard-cell">Prod</div>
                <div class="leaderboard-cell leaderboard-points">175</div>
                <div class="leaderboard-cell leaderboard-accuracy">46%</div>
            </div>
            <div class="leaderboard-row">
                <div class="leaderboard-cell leaderboard-rank">8</div>
                <div class="leaderboard-cell">Nadia Patel</div>
                <div class="leaderboard-cell">Fin</div>
                <div class="leaderboard-cell leaderboard-points">162</div>
                <div class="leaderboard-cell leaderboard-accuracy">44%</div>
            </div>
        </div>

        <div class="pagination">
            <button>←</button>
            <button class="active">1</button>
            <button>2</button>
            <button>3</button>
            <button>→</button>
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
    </script>
@endsection
