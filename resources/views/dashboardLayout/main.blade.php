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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <style>
        #avatarCropStep .cropper-view-box,
        #avatarCropStep .cropper-face { border-radius: 50%; }
        #avatarCropStep .cropper-view-box { outline: 2px solid #3b82f6; outline-color: rgba(59,130,246,0.75); }
    </style>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    {{-- Global Avatar Upload Modal --}}
    <div class="modal fade" id="avatarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-semibold">Upload Profile Photo</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="file" id="avatarFileInput" accept="image/*" style="display:none;">
                    <div id="avatarSelectStep" style="text-align:center;padding:24px 0;">
                        <div onclick="document.getElementById('avatarFileInput').click()"
                            style="width:90px;height:90px;border-radius:50%;border:2px dashed #cbd5e1;display:flex;align-items:center;justify-content:center;cursor:pointer;margin:0 auto 12px;background:#f8fafc;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                        </div>
                        <p class="text-muted small mb-1">Click to choose photo</p>
                        <p class="text-muted" style="font-size:11px;">JPG, PNG — max 2MB</p>
                    </div>
                    <div id="avatarCropStep" style="display:none;">
                        <div style="width:100%;max-height:280px;overflow:hidden;background:#f1f5f9;border-radius:8px;">
                            <img id="avatarCropImg" src="" alt="" style="max-width:100%;display:block;">
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:10px;font-size:11px;color:#64748b;">
                            <span>Original: <strong id="origSize">—</strong></span>
                            <span>Crop: <strong id="cropSize">—</strong></span>
                        </div>
                        <p class="text-muted mt-2 mb-0" style="font-size:11px;text-align:center;">Drag to reposition · Scroll to zoom</p>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content:space-between;">
                    <button type="button" id="avatarChangeBtn" style="display:none;font-size:12px;color:#64748b;background:none;border:none;padding:0;cursor:pointer;" onclick="document.getElementById('avatarFileInput').click()">Choose different</button>
                    <div style="margin-left:auto;display:flex;gap:8px;">
                        <button type="button" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="primary" id="avatarSaveBtn" disabled onclick="uploadAvatar()">Save Photo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let _avatarUserId = null;
        let _cropper = null;

        function openAvatarModal(userId) {
            _avatarUserId = userId;
            document.getElementById('avatarFileInput').value = '';
            document.getElementById('avatarSelectStep').style.display = 'block';
            document.getElementById('avatarCropStep').style.display = 'none';
            document.getElementById('avatarSaveBtn').disabled = true;
            document.getElementById('avatarChangeBtn').style.display = 'none';
            if (_cropper) { _cropper.destroy(); _cropper = null; }
            new bootstrap.Modal(document.getElementById('avatarModal')).show();
        }

        document.getElementById('avatarFileInput').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById('avatarCropImg');
                if (_cropper) { _cropper.destroy(); _cropper = null; }
                img.src = e.target.result;
                document.getElementById('avatarSelectStep').style.display = 'none';
                document.getElementById('avatarCropStep').style.display = 'block';
                document.getElementById('avatarChangeBtn').style.display = 'inline-block';
                document.getElementById('avatarSaveBtn').disabled = false;
                const origW = document.createElement('img');
                origW.onload = () => {
                    document.getElementById('origSize').textContent =
                        origW.naturalWidth + '×' + origW.naturalHeight + 'px · ' + (file.size / 1024).toFixed(0) + 'KB';
                };
                origW.src = e.target.result;
                _cropper = new Cropper(img, {
                    aspectRatio: 1, viewMode: 1, dragMode: 'move', autoCropArea: 0.8,
                    restore: false, guides: false, center: false, highlight: false,
                    cropBoxMovable: false, cropBoxResizable: false, toggleDragModeOnDblclick: false,
                    ready() {
                        const data = _cropper.getCropBoxData();
                        document.getElementById('cropSize').textContent =
                            Math.round(data.width) + '×' + Math.round(data.height) + 'px';
                    },
                    crop(event) {
                        document.getElementById('cropSize').textContent =
                            Math.round(event.detail.width) + '×' + Math.round(event.detail.height) + 'px';
                    }
                });
            };
            reader.readAsDataURL(file);
        });

        document.getElementById('avatarModal').addEventListener('hidden.bs.modal', function () {
            if (_cropper) { _cropper.destroy(); _cropper = null; }
        });

        function uploadAvatar() {
            if (!_cropper || !_avatarUserId) return;
            const canvas = _cropper.getCroppedCanvas({ width: 300, height: 300, imageSmoothingQuality: 'high' });
            const saveBtn = document.getElementById('avatarSaveBtn');
            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving…';
            canvas.toBlob(blob => {
                const formData = new FormData();
                formData.append('avatar', blob, 'avatar.jpg');
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                fetch(`/user/${_avatarUserId}/avatar`, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('avatarModal')).hide();
                        location.reload();
                    }
                })
                .catch(() => {
                    saveBtn.disabled = false;
                    saveBtn.textContent = 'Save Photo';
                });
            }, 'image/jpeg', 0.92);
        }
    </script>

    <script>
        function showScreen(screenId) {
            const btn = event.target.closest('button');

            // Hide all screens
            document.querySelectorAll('.screen').forEach(screen => {
                screen.classList.remove('active');
            });

            const url = btn ? btn.getAttribute('data-predictions-url') : null;
            if (url) {
                const icon = btn.querySelector('.nav-tab-icon');
                if (icon) {
                    const ball = document.createElement('img');
                    ball.src = '/images/football.svg';
                    ball.className = 'football-icon-3d nav-tab-loading';
                    ball.style.width = '16px';
                    ball.style.height = '16px';
                    icon.replaceWith(ball);
                }
                window.location.href = url;
                return;
            }

            document.getElementById(screenId).classList.add('active');
            document.querySelectorAll('.nav-tabs button').forEach(b => {
                b.classList.remove('active');
            });
            if (btn) btn.classList.add('active');
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
                    document.getElementById('winnerTeam1').checked = false;
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
