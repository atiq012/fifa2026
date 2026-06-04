@extends('dashboardLayout.main')

@section('content')
    <div id="dashboard" class="screen active">
        <h2 class="section-title">Your Performance</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Your Rank</div>
                <div class="stat-value">#1</div>
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
                <div class="stat-value">10 🔥</div>
                <div class="stat-subtitle">Keep it going!</div>
            </div>
        </div>

        <h2 class="section-title">Upcoming Matches</h2>



        @foreach ($nextThreeMatches as $fixture)
            <div class="match-card">
                <div class="match-header">
                    <span class="match-time urgent">
                        {{ \Carbon\Carbon::parse($fixture->date)->format('M d, Y') }}
                        {{ \Carbon\Carbon::parse($fixture->time)->format('g:i A') }}
                    </span>
                    <span class="text-muted" style="font-size: 12px;">
                        {{ \Carbon\Carbon::parse($fixture->date)->diffForHumans(now(), ['parts' => 2]) }}
                    </span>
                </div>
                <div class="match-body">
                    <div class="team">
                        <div class="team-name">{{ $fixture->team1->name ?? $fixture->team1_name }}
                        </div>
                        <div class="team-rank">Rank
                            #{{ $fixture->team1->rank ?? ($fixture->team1_rank ?? 'N/A') }}</div>
                    </div>
                    <div class="vs-text">vs</div>
                    <div class="team">
                        <div class="team-name">{{ $fixture->team2->name ?? $fixture->team2_name }}
                        </div>
                        <div class="team-rank">Rank
                            #{{ $fixture->team2->rank ?? ($fixture->team2_rank ?? 'N/A') }}</div>
                    </div>
                </div>

                <button class="primary" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#predictionModal"
                    data-fixture-id="{{ $fixture->id }}"
                    data-team1-name="{{ $fixture->team1->name ?? $fixture->team1_name }}"
                    data-team1-rank="{{ $fixture->team1->rank ?? ($fixture->team1_rank ?? 'N/A') }}"
                    data-team2-name="{{ $fixture->team2->name ?? $fixture->team2_name }}"
                    data-team2-rank="{{ $fixture->team2->rank ?? ($fixture->team2_rank ?? 'N/A') }}"
                    data-date="{{ \Carbon\Carbon::parse($fixture->date)->format('M d, Y') }}"
                    data-time="{{ \Carbon\Carbon::parse($fixture->time)->format('g:i A') }}">
                    ✏️ Make Prediction
                </button>
            </div>
        @endforeach

        <!-- Bootstrap 5 Prediction Modal -->
        <div class="modal" id="predictionModal" aria-labelledby="predictionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-4" id="predictionModalLabel">Match Prediction</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="text-center mb-3 pb-2 border-bottom">
                            <p class="mb-1 small text-secondary" id="modalMatchGroup">Group A •
                                Match 5</p>
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
                                            <input class="form-check-input" type="radio" name="winner" id="winnerTeam1"
                                                value="team1">
                                            <label class="form-check-label fw-medium" id="winnerTeam1Label"
                                                for="winnerTeam1">Argentina</label>
                                        </div>
                                        <span class="small text-success fw-semibold">+5 pts</span>
                                    </div>
                                </div>
                                <div class="border rounded-3 p-2">
                                    <div class="form-check d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="winner" id="winnerDraw"
                                                value="draw">
                                            <label class="form-check-label fw-medium" for="winnerDraw">Draw</label>
                                        </div>
                                        <span class="small text-success fw-semibold">+5 pts</span>
                                    </div>
                                </div>
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


                        <div class="mb-3">
                            <label class="form-label fw-semibold"><span id="team1_name"></span>
                                Goal Scrore</label>
                            <input type="number" id="team1_goals" class="form-control" name="team1_goals"
                                placeholder="0" pattern="[0-9]*" inputmode="numeric">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold"><span id="team2_name"></span>
                                Goal Scrore</label>

                            <input type="number" id="team2_goals" class="form-control" name="team2_goals"
                                placeholder="0" pattern="[0-9]*" inputmode="numeric">
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


        {{-- Next 3 upcoming matches --}}
        {{-- @foreach ($nextThreeAfterThat as $fixture)
            <div class="match-card">
                <div class="match-header">
                    <span class="match-time">
                        {{ \Carbon\Carbon::parse($fixture->date)->format('M d, Y') }}
                        {{ \Carbon\Carbon::parse($fixture->time)->format('g:i A') }}
                    </span>
                    <span class="text-muted" style="font-size: 12px;">
                        {{ \Carbon\Carbon::parse($fixture->date)->diffForHumans(now(), ['parts' => 2]) }}
                    </span>
                </div>
                <div class="match-body">
                    <div class="team">
                        <div class="team-name">{{ $fixture->team1->name ?? $fixture->team1_name }}
                        </div>
                        <div class="team-rank">Rank
                            #{{ $fixture->team1->rank ?? ($fixture->team1_rank ?? 'N/A') }}
                        </div>
                    </div>
                    <div class="vs-text">vs</div>
                    <div class="team">
                        <div class="team-name">{{ $fixture->team2->name ?? $fixture->team2_name }}
                        </div>
                        <div class="team-rank">Rank
                            #{{ $fixture->team2->rank ?? ($fixture->team2_rank ?? 'N/A') }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach --}}



        <h2 class="section-title" style="margin-top: 2rem;">Quick Links</h2>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <button style="flex: 1; min-width: 150px;" onclick="showScreen('predictions')"
                data-predictions-url="{{ route('predictions') }}">📋 My Predictions</button>
            <button style="flex: 1; min-width: 150px;" onclick="showScreen('leaderboard')"
                data-predictions-url="{{ route('leaderboard') }}">🏆 Leaderboard</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const buttons = document.querySelectorAll('.nav-tabs button');
        buttons.forEach(btn => btn.classList.remove('active'));
        if (buttons.length >= 1) {
            buttons[0].classList.add('active');
        }
        preventNumberInputScroll('team1_goals');
        preventNumberInputScroll('team2_goals');
        function preventNumberInputScroll(inputId) {
            const input = document.getElementById(inputId);
            if (input) {
                input.addEventListener('wheel', (e) => {
                    e.target.blur();
                    e.preventDefault();
                });
            }
        }
    </script>
@endsection
