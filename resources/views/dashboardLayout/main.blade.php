<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FIFA World Cup 2026 - Prediction Platform</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>

<body>
    <div class="container">
        <div class="row">
            {{-- <div class="col-md-8 offset-md-2"> --}}
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-body">
                        @include('dashboardLayout.header')
                        @yield('content')
                        @include('dashboardLayout.settings')
                    </div>
                </div>
            </div>
        </div>
        <!-- Toast Notification -->
        <div id="toast" class="toast"></div>
    </div>
    <!-- Add this in the head section or before your custom scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // function showScreen(screenId) {
        //     // Hide all screens
        //     document.querySelectorAll('.screen').forEach(screen => {
        //         screen.classList.remove('active');
        //     });


        //     // ajax call to load screen data if needed
        //     if (screenId === 'predictions') {
        //         const url = event.target.getAttribute('data-predictions-url');
        //         if (url) {
        //             window.location.href = url;
        //         }

        //         document.getElementById(screenId).classList.add('active');
        //         document.querySelectorAll('.nav-tabs button').forEach(btn => {
        //             btn.classList.remove('active');
        //         });
        //         event.target.classList.add('active');
        //     }
        //     if (screenId === 'dashboard') {
        //         const url = event.target.getAttribute('data-predictions-url');
        //         if (url) {
        //             window.location.href = url;
        //         }

        //     }
        //     if (screenId === 'leaderboard') {
        //         const url = event.target.getAttribute('data-predictions-url');
        //         if (url) {
        //             window.location.href = url;
        //         }
        //     }
        //     if (screenId === 'update_result') {
        //         const url = event.target.getAttribute('data-predictions-url');
        //         if (url) {
        //             window.location.href = url;
        //         }
        //     }
        //     if (screenId === 'analytics') {
        //         const url = event.target.getAttribute('data-predictions-url');
        //         if (url) {
        //             window.location.href = url;
        //         }
        //     }

        //     document.getElementById(screenId).classList.add('active');
        //     document.querySelectorAll('.nav-tabs button').forEach(btn => {
        //         btn.classList.remove('active');
        //     });
        //     event.target.classList.add('active');
        // }
        function showScreen(screenId, el) {
            // Hide all screens
            document.querySelectorAll('.screen').forEach(screen => {
                screen.classList.remove('active');
            });

            // Get URL from the clicked element
            const url = el ? el.getAttribute('data-predictions-url') : null;

            if (['dashboard', 'leaderboard', 'update_result', 'analytics'].includes(screenId)) {
                if (url) {
                    window.location.href = url;
                    return; // Stop here — page will navigate
                }
            }

            if (screenId === 'predictions') {
                if (url) {
                    window.location.href = url;
                    return;
                }
                document.getElementById(screenId).classList.add('active');
            }

            // Update active tab UI
            const screen = document.getElementById(screenId);
            if (screen) screen.classList.add('active');

            document.querySelectorAll('.nav-tabs button').forEach(btn => {
                btn.classList.remove('active');
            });
            if (el) el.classList.add('active');
        }

        let toastTimeout;

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');

            // Clear any existing timeout
            if (toastTimeout) {
                clearTimeout(toastTimeout);
            }

            // Remove existing type classes
            toast.classList.remove('success', 'warning', 'danger', 'info');

            // Set duration based on message type (in milliseconds)
            let duration;
            switch (type) {
                case 'success':
                    duration = 3000; // 3 seconds
                    break;
                case 'warning':
                    duration = 8000; // 5 seconds
                    break;
                case 'danger':
                    duration = 8000; // 8 seconds
                    break;
                case 'info':
                    duration = 4000; // 4 seconds
                    break;
                default:
                    duration = 3000;
            }

            // Set message and type class
            toast.textContent = message;
            toast.classList.add(type);
            toast.classList.add('active');

            // Auto hide after duration
            toastTimeout = setTimeout(() => {
                toast.classList.remove('active');
            }, duration);
        }

        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.leaderboard-row');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchInput) ? '' : 'none';
            });
        }

        function filterLeaderboard(filter) {
            showToast('This is under development', 'warning');
        }


        // Store current fixture data
        let currentFixture = null;

        // Modal element listener for Bootstrap 5
        const predictionModal = document.getElementById('predictionModal');

        if (predictionModal) {
            predictionModal.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract data from button attributes
                const fixtureId = button.getAttribute('data-fixture-id');
                const team1Name = button.getAttribute('data-team1-name');
                const team1Rank = button.getAttribute('data-team1-rank');
                const team2Name = button.getAttribute('data-team2-name');
                const team2Rank = button.getAttribute('data-team2-rank');
                const date = button.getAttribute('data-date');
                const time = button.getAttribute('data-time');

                // Store current fixture
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
                document.getElementById("team1_name").innerText = team1Name;
                document.getElementById("team2_name").innerText = team2Name;
                // Reset selected option to team1
                // document.getElementById('winnerTeam1').checked = true;

                // Update option box highlights
                document.querySelectorAll('#winnerOptions > div').forEach(div => {
                    div.style.background = '';
                    div.style.borderColor = '#dee2e6';
                });
                // document.querySelector('.option-team1').style.background = '#e6f1fb';
                // document.querySelector('.option-team1').style.borderColor = '#378add';
            });
        }

        // Save prediction function
        function savePrediction() {
            if (!currentFixture) {
                showToast('No fixture selected', 'warning');
                return;
            }

            // Get selected winner
            const selectedWinner = document.querySelector('input[name="winner"]:checked');
            if (!selectedWinner) {
                showToast('Please select a winner / draw', 'warning');
                return;
            }

            if (!selectedWinner) {
                console.error('No winner selected');
                return;
            }

            let predictionValue = '';
            let predictionText = '';

            if (selectedWinner.value === 'team1') {
                predictionValue = currentFixture.team1_name;
                predictionText = currentFixture.team1_name;
            } else if (selectedWinner.value === 'team2') {
                predictionValue = currentFixture.team2_name;
                predictionText = currentFixture.team2_name;
            } else {
                predictionValue = 'draw';
                predictionText = 'Draw';
            }

            const team1_goals = document.getElementById('team1_goals').value;
            const team2_goals = document.getElementById('team2_goals').value;

            // Validation
            let isValid = true;
            let errorMessage = '';

            if (selectedWinner.value === 'draw') {
                if (team1_goals !== team2_goals) {
                    isValid = false;
                    errorMessage = 'For a draw prediction, both teams must have the same number of goals.';
                }
            } else if (selectedWinner.value === 'team1') {
                if (parseInt(team1_goals) <= parseInt(team2_goals)) {
                    isValid = false;
                    errorMessage =
                        `${currentFixture.team1_name} must have more goals than ${currentFixture.team2_name} to win.`;
                }
            } else if (selectedWinner.value === 'team2') {
                if (parseInt(team2_goals) <= parseInt(team1_goals)) {
                    isValid = false;
                    errorMessage =
                        `${currentFixture.team2_name} must have more goals than ${currentFixture.team1_name} to win.`;
                }
            }

            if (!isValid) {
                // alert(errorMessage);
                showToast(errorMessage, 'warning');
                return false;
            }

            const formData = new FormData();
            formData.append('fixture_id', currentFixture.id);
            formData.append('prediction', predictionValue);
            formData.append('team2_goals', team2_goals || 0);
            formData.append('team1_goals', team1_goals || 0);

            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append('_token', csrfToken);

            fetch('{{ route('predictions.store') }}', {
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
                    showToast('Prediction saved successfully!', 'success');

                    const modal = bootstrap.Modal.getInstance(document.getElementById('predictionModal'));
                    modal.hide();

                    // clear form
                    document.getElementById('team1_goals').value = '';
                    document.getElementById('team2_goals').value = '';
                    document.getElementById('winnerTeam1').checked = true;
                    document.getElementById('winnerTeam2').checked = false;
                    document.getElementById('winnerDraw').checked = false;


                    // const buttons = document.querySelectorAll(`button[data-fixture-id="${currentFixture.id}"]`);
                    // buttons.forEach(btn => {
                    //     btn.innerHTML = '✏️ Edit Prediction';
                    //     btn.classList.remove('btn-primary');
                    //     btn.classList.add('btn-warning');
                    // });

                })
                .catch(error => {
                    showToast('Failed to save changes. Please try again.', 'danger');
                });
        }
    </script>
    @yield('scripts')
</body>

</html>
