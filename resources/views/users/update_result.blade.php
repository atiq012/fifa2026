@extends('dashboardLayout.main')

@section('content')
    <!-- update result Screen -->
    <div id="analytics" class="screen active">
        <h2 class="section-title">All Todays Fixtures</h2>
        @foreach ($fixtures as $fixture)
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

                <button class="primary" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#resultModal"
                    data-fixture-id="{{ $fixture->id }}"
                    data-team1-name="{{ $fixture->team1->name ?? $fixture->team1_name }}"
                    data-team1-rank="{{ $fixture->team1->rank ?? ($fixture->team1_rank ?? 'N/A') }}"
                    data-team2-name="{{ $fixture->team2->name ?? $fixture->team2_name }}"
                    data-team2-rank="{{ $fixture->team2->rank ?? ($fixture->team2_rank ?? 'N/A') }}"
                    data-date="{{ \Carbon\Carbon::parse($fixture->date)->format('M d, Y') }}"
                    data-time="{{ \Carbon\Carbon::parse($fixture->time)->format('g:i A') }}">
                    ✏️ Update Result
                </button>
            </div>
        @endforeach


        <div class="modal" id="resultModal" aria-labelledby="resultModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-4" id="resultModalLabel">Match Result</h2>
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



                        {{-- <div class="mb-3">
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
                        </div> --}}


                        <div class="mb-3">
                            <label class="form-label fw-semibold"><span id="winnerTeam1Label"></span>
                                Goal Scrore</label>
                            <input type="number" id="team1_goals" class="form-control" name="team1_goals" placeholder="0"
                                pattern="[0-9]*" inputmode="numeric">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold"><span id="winnerTeam2Label"></span>
                                Goal Scrore</label>

                            <input type="number" id="team2_goals" class="form-control" name="team2_goals" placeholder="0"
                                pattern="[0-9]*" inputmode="numeric">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="primary" onclick="saveResult()">✓ Save
                            Result</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        const buttons = document.querySelectorAll('.nav-tabs button');
        buttons.forEach(btn => btn.classList.remove('active'));
        if (buttons.length >= 4) {
            buttons[3].classList.add('active');
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

        const resultModal = document.getElementById('resultModal');
        if (resultModal) {
            resultModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const fixtureId = button.getAttribute('data-fixture-id');
                const team1Name = button.getAttribute('data-team1-name');
                const team1Rank = button.getAttribute('data-team1-rank');
                const team2Name = button.getAttribute('data-team2-name');
                const team2Rank = button.getAttribute('data-team2-rank');
                const date = button.getAttribute('data-date');
                const time = button.getAttribute('data-time');

                currentFixture = {
                    id: fixtureId,
                    team1_name: team1Name,
                    team1_rank: team1Rank,
                    team2_name: team2Name,
                    team2_rank: team2Rank,
                    date: date,
                    time: time
                };

                // Update modal content
                document.getElementById('modalDateTime').innerText = `${date} • ${time}`;
                document.getElementById('team1Name').innerText = team1Name;
                document.getElementById('team1Rank').innerText = `Rank #${team1Rank}`;
                document.getElementById('team2Name').innerText = team2Name;
                document.getElementById('team2Rank').innerText = `Rank #${team2Rank}`;

                // Update radio button labels
                document.getElementById('winnerTeam1Label').innerText = team1Name;
                document.getElementById('winnerTeam2Label').innerText = team2Name;
            });
        }

        function saveResult() {
            const team1_goals = document.getElementById('team1_goals').value;
            const team2_goals = document.getElementById('team2_goals').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const formData = new FormData();
            formData.append('fixture_id', currentFixture.id);
            formData.append('team2_goals', team2_goals);
            formData.append('team1_goals', team1_goals);
            formData.append('_token', csrfToken);



            fetch('{{ route('update_result_store') }}', {
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
                    showToast('Result saved successfully!', 'success');

                    const modal = bootstrap.Modal.getInstance(document.getElementById('resultModal'));
                    modal.hide();

                    // clear form
                    document.getElementById('team1_goals').value = '';
                    document.getElementById('team2_goals').value = '';

                })
                .catch(error => {
                    showToast('Failed to save changes. Please try again.', 'danger');
                });

        }
    </script>
@endsection
