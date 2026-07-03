@extends('dashboardLayout.main')

@section('content')
    <!-- My Predictions Screen -->
    <div id="predictions" class="screen active">
        <h2 class="section-title">My Predictions</h2>
        {{-- <p class="page-subtitle">42 predictions • 22 correct • 52% accuracy</p> --}}

        {{-- <div class="filter-buttons">
            <button class="primary" onclick="filterPredictions('all')">All (42)</button>
            <button onclick="filterPredictions('correct')">Correct (22)</button>
            <button onclick="filterPredictions('wrong')">Wrong (8)</button>
            <button onclick="filterPredictions('pending')">Pending (12)</button>
        </div> --}}

        {{-- <div style="display: flex; gap: 8px; margin-bottom: 1.5rem;">
            <select style="flex: 1;">
                <option>All Stages</option>
                <option>Group Stage</option>
                <option>Round of 32</option>
                <option>Round of 16</option>
            </select>
            <select style="flex: 1;">
                <option>Sort by: Date</option>
                <option>Sort by: Points</option>
                <option>Sort by: Accuracy</option>
            </select>
        </div> --}}

        <!-- Correct Prediction -->
        @foreach ($predictions as $prediction)
            <div class="prediction-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <span class="status-badge {{ $prediction->is_correct == 1 ? 'correct' : 'wrong' }}">
                            {{ $prediction->is_correct == 1 ? '✓ Correct' : '✗ Wrong' }}</span>
                        <span
                            style="font-size: 11px; color: #888780; background: #f1efe8; padding: 4px 8px; border-radius: 6px;">Group
                            {{ $prediction->fixture->team1->group }}</span>
                        <span style="font-size: 11px; color: #888780; margin-left: 4px;">
                            {{ date('F j', strtotime($prediction->fixture->date)) }},
                            {{ date('g:i A', strtotime($prediction->fixture->time)) }}</span>
                        </span>
                    </div>

                </div>

                <h3 style="margin: 0 0 1rem; font-size: 15px; font-weight: 500; color: #2c2c2a;">
                    {{ $prediction->fixture->team1->name }} {{ $prediction->fixture->actual_team1_goals }} -
                    {{ $prediction->fixture->actual_team2_goals }} {{ $prediction->fixture->team2->name }} </h3>

                <div class="prediction-info">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="font-size: 12px; font-weight: 500;">Your Prediction</span>

                    </div>
                    <div class="prediction-boxes">
                        @if ($prediction->winningTeam)
                            <div class="prediction-box">👑 {{ $prediction->winningTeam->name }} wins </div>
                        @else
                            <div class="prediction-box">Draw</div>
                        @endif
                        <div class="prediction-box secondary">Predict Score:
                            {{ $prediction->predictiondetails->team1_goals ?? '0' }} -
                            {{ $prediction->predictiondetails->team2_goals ?? '0' }}</div>
                    </div>
                </div>

                <div class="footer-info">
                    <div>Made: <strong>{{ date('F j, g:i A', strtotime($prediction->created_at)) }}</strong></div>
                    {{-- <div>Result: <strong class="text-success">Confirmed</strong></div> --}}
                </div>

                {{-- <div class="card-actions">
                    <button>View Details</button>
                    <button>Share</button>
                </div> --}}
            </div>
        @endforeach

        <!-- Pending Prediction -->
        @foreach ($pendingFixtures as $pending)
            <div class="prediction-card" style="opacity: 0.8;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <span class="status-badge pending">⏱ Pending</span>
                        <span
                            style="font-size: 11px; color: #888780; background: #f1efe8; padding: 4px 8px; border-radius: 6px;">Group
                            {{ $pending->team1->group }}</span>
                        <span style="font-size: 11px; color: #ba7517; margin-left: 4px;"> Starting in
                            @php
                                $date = $pending->date;
                                $time = $pending->time;
                                $datetime = DateTime::createFromFormat('Y-m-d g:i a', $date . ' ' . $time);
                                $result = $datetime->format('Y-m-d H:i:s');

                                $target = \Carbon\Carbon::parse($result, 'Asia/Dhaka');
                                $now = \Carbon\Carbon::now('Asia/Dhaka');

                                $diff = $target->diff($now);
                                $totalHours = $diff->days * 24 + $diff->h;
                            @endphp
                            Starts in
                            {{ $totalHours . ' hours ' . $diff->i . ' minutes' }}
                            {{-- {{ \Carbon\Carbon::parse($pending->date)->diffForHumans(now(), ['parts' => 2]) }}</span> --}}
                    </div>

                </div>

                <h3 style="margin: 0 0 1rem; font-size: 15px; font-weight: 500; color: #2c2c2a;">
                    {{ $pending->team1->name ?? '' }} vs {{ $pending->team2->name ?? '' }}
                </h3>

                <div class="prediction-info">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="font-size: 12px; font-weight: 500;">Your Prediction</span>

                    </div>
                    <div class="prediction-boxes">
                        @if ($pending->predictions->where('user_id', auth()->id())->first()->winning_team)
                            <div class="prediction-box">👑
                                {{ $pending->predictions->where('user_id', auth()->id())->first()->winningTeam->name ?? '' }}
                                wins
                            </div>
                        @else
                            <div class="prediction-box">Draw</div>
                        @endif
                        <div class="prediction-box secondary">Predict Score:
                            {{ $pending->predictions->where('user_id', auth()->id())->first()->predictiondetails->team1_goals ?? '' }}-{{ $pending->predictions->where('user_id', auth()->id())->first()->predictiondetails->team2_goals ?? '' }}
                        </div>
                    </div>
                </div>

                <div class="footer-info">
                    <div>Made:
                        <strong>{{ date('F j, g:i A', strtotime($pending->predictions->where('user_id', auth()->id())->first()->created_at)) }}</strong>
                    </div>
                    <div>Status: <strong class="text-warning">Awaiting Match</strong></div>
                </div>

                <div class="card-actions">

                    {{-- @if ($pending->date >= now()->setTimezone('Asia/Dhaka')->format('Y-m-d'))
                        @if (Carbon\Carbon::parse($pending->time)->format('H:i') > now()->setTimezone('Asia/Dhaka')->format('H:i'))
                            <button class="secondary" style="width: 100%;" data-bs-toggle="modal"
                                data-bs-target="#predictionModal" data-fixture-id="{{ $pending->id }}"
                                data-team1-name="{{ $pending->team1->name ?? $pending->team1_name }}"
                                data-team1-rank="{{ $pending->team1->rank ?? ($pending->team1_rank ?? 'N/A') }}"
                                data-team2-name="{{ $pending->team2->name ?? $pending->team2_name }}"
                                data-team2-rank="{{ $pending->team2->rank ?? ($pending->team2_rank ?? 'N/A') }}"
                                data-date="{{ \Carbon\Carbon::parse($pending->date)->format('M d, Y') }}"
                                data-time="{{ \Carbon\Carbon::parse($pending->time)->format('g:i A') }}">
                                Edit Prediction
                            </button>
                        @endif
                    @endif --}}
                    @php
                        // Combine date + time into one Carbon instant in Dhaka timezone
                        $matchDateTime = \Carbon\Carbon::parse(
                            $pending->date . ' ' . \Carbon\Carbon::parse($pending->time)->format('H:i'),
                            'Asia/Dhaka',
                        );

                        $cutoff = now('Asia/Dhaka')->addMinutes(5);
                    @endphp

                    @if ($matchDateTime->gt($cutoff))
                        <button class="secondary" style="width: 100%;" data-bs-toggle="modal"
                            data-bs-target="#predictionModal" data-fixture-id="{{ $pending->id }}"
                            data-team1-name="{{ $pending->team1->name ?? $pending->team1_name }}"
                            data-team1-rank="{{ $pending->team1->rank ?? ($pending->team1_rank ?? 'N/A') }}"
                            data-team2-name="{{ $pending->team2->name ?? $pending->team2_name }}"
                            data-team2-rank="{{ $pending->team2->rank ?? ($pending->team2_rank ?? 'N/A') }}"
                            data-date="{{ $matchDateTime->format('M d, Y') }}"
                            data-time="{{ $matchDateTime->format('g:i A') }}">
                            Edit Prediction
                        </button>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="modal" id="predictionModal" aria-labelledby="predictionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-4" id="predictionModalLabel">Match Prediction</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Who will win?</label>
                            <div class="d-flex flex-column gap-2" id="winnerOptions">
                                <div class="border rounded-3 p-2" style="background: #e6f1fb; border-color: #378add;">
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
                                {{-- <div class="border rounded-3 p-2">
                                    <div class="form-check d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="winner" id="winnerDraw"
                                                value="draw">
                                            <label class="form-check-label fw-medium" for="winnerDraw">Draw</label>
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
                                placeholder="0" value="0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold"><span id="team2_name"></span>
                                Goal Scrore</label>

                            <input type="number" id="team2_goals" class="form-control" name="team2_goals"
                                placeholder="0" value="0">
                        </div>

                        <div class="alert alert-info small mb-0" role="alert">
                            <i class="bi bi-info-circle"></i> You can edit your prediction anytime
                            until the match starts.
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="primary" onclick="savePrediction()">✓ Update
                            Prediction</button>
                    </div>
                </div>
            </div>
        </div>

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
        if (buttons.length >= 2) {
            buttons[1].classList.add('active');
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
