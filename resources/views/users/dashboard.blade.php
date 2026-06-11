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
            align-items: baseline;
            /* padding: 12px 16px; */
            padding: 8px 18px;
            border-bottom: 1px solid #EDF2F7;
        }

        .team-name-group {
            display: flex;
            align-items: baseline;
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
        }

        .team-score-group {
            display: flex;
            align-items: baseline;
            gap: 1px;
        }

        .runs {
            font-size: 13px;
            font-weight: 500;
            color: #0F172A;
            letter-spacing: -0.5px;
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
    </style>
@endsection
@section('content')
    <div id="dashboard" class="screen active">
        <div class="row m-1">
            <div class="col-md-8 ">

                <h2 class="section-title mt-1">Top Standings</h2>
                <div class="medals mb-2">
                    <div class="medal-card gold">
                        <div class="medal-icon">🥇</div>
                        <div class="medal-label">1st Place</div>
                        <div class="medal-name">Be the first!</div>
                    </div>
                    <div class="medal-card silver">
                        <div class="medal-icon">🥈</div>
                        <div class="medal-label">2nd Place</div>
                        <div class="medal-name">Be the first!</div>
                    </div>
                    <div class="medal-card bronze">
                        <div class="medal-icon">🥉</div>
                        <div class="medal-label">3rd Place</div>
                        <div class="medal-name">Be the first!</div>
                    </div>
                </div>

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

                <h2 class="section-title">Upcoming Matches</h2>

                @foreach ($nextThreeMatches as $fixture)
                    <div class="match-card">
                        <div class="match-header">
                            <span class="match-time urgent">
                                {{ \Carbon\Carbon::parse($fixture->date)->format('M d, Y') }}
                                {{ \Carbon\Carbon::parse($fixture->time)->format('g:i A') }}
                            </span>
                            <span class="text-muted" style="font-size: 12px;">
                                @php
                                    $date = $fixture->date;
                                    $time = $fixture->time;
                                    $datetime = DateTime::createFromFormat('Y-m-d g:i a', $date . ' ' . $time);
                                    $result = $datetime->format('Y-m-d H:i:s');

                                    $target = \Carbon\Carbon::parse($result, 'Asia/Dhaka');
                                    $now = \Carbon\Carbon::now('Asia/Dhaka');

                                    $diff = $target->diff($now);
                                    $totalHours = $diff->days * 24 + $diff->h;
                                @endphp
                                Starts in
                                {{
                                $totalHours . ' hours ' . $diff->i . ' minutes';
                                }}
                            </span>
                        </div>
                        <div class="match-body">
                            <div class="team">
                                <div class="team-name"> <img height="8%" width="8%"
                                        src="{{ $fixture->team1->flag ?? '' }}" alt="">
                                    {{ $fixture->team1->name ?? $fixture->team1_name }}
                                </div>
                                <div class="team-rank">Rank
                                    #{{ $fixture->team1->rank ?? ($fixture->team1_rank ?? 'N/A') }}</div>
                            </div>
                            <div class="vs-text">vs</div>
                            <div class="team">
                                <div class="team-name"><img height="8%" width="8%"
                                        src="{{ $fixture->team2->flag ?? '' }}" alt="">
                                    {{ $fixture->team2->name ?? $fixture->team2_name }}
                                </div>
                                <div class="team-rank">Rank
                                    #{{ $fixture->team2->rank ?? ($fixture->team2_rank ?? 'N/A') }}</div>
                            </div>
                        </div>
                        @if ($myPr->contains($fixture->id))
                            {{-- <button class="secondary" style="width: 100%;" data-bs-toggle="modal"
                            data-bs-target="#predictionModal" data-fixture-id="{{ $fixture->id }}"
                            data-team1-name="{{ $fixture->team1->name ?? $fixture->team1_name }}"
                            data-team1-rank="{{ $fixture->team1->rank ?? ($fixture->team1_rank ?? 'N/A') }}"
                            data-team2-name="{{ $fixture->team2->name ?? $fixture->team2_name }}"
                            data-team2-rank="{{ $fixture->team2->rank ?? ($fixture->team2_rank ?? 'N/A') }}"
                            data-date="{{ \Carbon\Carbon::parse($fixture->date)->format('M d, Y') }}"
                            data-time="{{ \Carbon\Carbon::parse($fixture->time)->format('g:i A') }}">
                            Prediction Submitted
                        </button> --}}
                        @else
                            <button class="primary" style="width: 100%;" data-bs-toggle="modal"
                                data-bs-target="#predictionModal" data-fixture-id="{{ $fixture->id }}"
                                data-team1-name="{{ $fixture->team1->name ?? $fixture->team1_name }}"
                                data-team1-rank="{{ $fixture->team1->rank ?? ($fixture->team1_rank ?? 'N/A') }}"
                                data-team2-name="{{ $fixture->team2->name ?? $fixture->team2_name }}"
                                data-team2-rank="{{ $fixture->team2->rank ?? ($fixture->team2_rank ?? 'N/A') }}"
                                data-date="{{ \Carbon\Carbon::parse($fixture->date)->format('M d, Y') }}"
                                data-time="{{ \Carbon\Carbon::parse($fixture->time)->format('g:i A') }}">
                                ✏️ Make Prediction
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
                                                    <input class="form-check-input" type="radio" name="winner"
                                                        id="winnerTeam1" value="team1">
                                                    <label class="form-check-label fw-medium" id="winnerTeam1Label"
                                                        for="winnerTeam1">Argentina</label>
                                                </div>
                                                <span class="small text-success fw-semibold">+5 pts</span>
                                            </div>
                                        </div>
                                        <div class="border rounded-3 p-2">
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div>
                                                    <input class="form-check-input" type="radio" name="winner"
                                                        id="winnerDraw" value="draw">
                                                    <label class="form-check-label fw-medium"
                                                        for="winnerDraw">Draw</label>
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



                <h2 class="section-title" style="margin-top: 2rem;">Quick Links</h2>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <button style="flex: 1; min-width: 150px;" onclick="showScreen('predictions')"
                        data-predictions-url="{{ route('predictions') }}">📋 My Predictions</button>
                    <button style="flex: 1; min-width: 150px;" onclick="showScreen('leaderboard')"
                        data-predictions-url="{{ route('leaderboard') }}">🏆 Leaderboard</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    @if ($allPred->count() > 0)
                        <div class="col-md-12">
                            <div class="card p-1 m-1">
                                <div class="card-header">
                                    Predictions
                                </div>
                                <div class="card-body">
                                    @include('users.allPredictions')

                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- <div class="col-md-12">
                        <div class="card p-2">
                            <div class="card-body" style="min-height: 300px;">
                                @include('users.sidebar')
                            </div>
                        </div>
                    </div> --}}
                </div>

            </div>
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
