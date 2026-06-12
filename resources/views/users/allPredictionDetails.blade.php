@extends('dashboardLayout.main')

@section('content')
    <div id="predictions" class="screen active">
        <h2 class="section-title">All Predictions</h2>

        {{-- Avatar Upload Modal --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
        <style>
            #avatarCropStep .cropper-view-box,
            #avatarCropStep .cropper-face {
                border-radius: 50%;
            }
            #avatarCropStep .cropper-view-box {
                outline: 2px solid #3b82f6;
                outline-color: rgba(59,130,246,0.75);
            }
        </style>
        <div class="modal fade" id="avatarModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title fw-semibold">Upload Profile Photo</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" id="avatarFileInput" accept="image/*" style="display:none;">

                        {{-- Step 1: select file --}}
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

                        {{-- Step 2: crop --}}
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

        <div class="row">
            @foreach ($predictions as $prediction)
                @php
                    $emp = DB::table('emps')->where('id', $prediction->createdBy->emp_id)->first();
                    $userId = $prediction->createdBy->id;
                    $myTeamRow = DB::table('my_teams')->where('user_id', $userId)->first();
                    $favFlag = $myTeamRow ? DB::table('teams')->where('id', $myTeamRow->team_id)->value('flag') : null;
                    $imgPath = $emp ? ($emp->image_path ?? null) : null;
                    if ($imgPath) {
                        $localPath = str_starts_with($imgPath, 'public/') ? substr($imgPath, 7) : $imgPath;
                        $avatarSrc = file_exists(public_path($localPath))
                            ? asset($localPath)
                            : 'https://myportal.galaxybd.com/public/' . $imgPath;
                    } else {
                        $avatarSrc = null;
                    }
                @endphp
                <div class="col-md-4">
                    <div class="prediction-card" style="opacity: 0.8; overflow: hidden; position: relative;">
                        @if($favFlag)
                            <div style="position:absolute;inset:0;background-image:url('{{ $favFlag }}');background-size:cover;background-position:center;opacity:0.07;z-index:0;pointer-events:none;"></div>
                        @endif
                        <div style="position:relative;z-index:1;">
                        <div style="display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #f8f9fb 0%, #eef1f6 100%); border-radius: 10px 10px 0 0; padding: 10px 1rem; margin: -1rem -1rem 1rem -1rem;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="position:relative;width:32px;height:32px;flex-shrink:0;cursor:pointer;" onclick="openAvatarModal({{ $userId }})">
                                    <img height="32" width="32"
                                        src="{{ $avatarSrc ?? asset('images/default-avatar.svg') }}"
                                        alt="avatar"
                                        style="border-radius:50%;object-fit:cover;width:32px;height:32px;display:block;"
                                        onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                                    <div style="position:absolute;bottom:-1px;right:-1px;width:14px;height:14px;background:#3b82f6;border-radius:50%;display:flex;align-items:center;justify-content:center;border:1.5px solid #fff;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                                        </svg>
                                    </div>
                                </div>
                                <span style="font-size: 11px; color: #3d3d3b; background: #e8e5dc; padding: 4px 8px; border-radius: 6px; font-weight: 500;">{{ $prediction->createdBy->name }}</span>
                            </div>
                            @if($favFlag)
                                <img height="22" width="22" src="{{ $favFlag }}" alt="fav team" style="border-radius:3px;flex-shrink:0;">
                            @endif
                        </div>

                        <div class="mb-3">
                            <div style="display:flex;align-items:center;width:100%;margin-bottom:8px;">
                                <div style="flex:1;min-width:0;display:flex;align-items:center;gap:6px;font-size:15px;font-weight:500;color:#2c2c2a;">
                                    <img height="20" width="20" src="{{ $prediction->fixture->team1->flag }}" alt="" style="flex-shrink:0;">
                                    <span style="flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $prediction->fixture->team1->name }}</span>
                                    @if ($prediction->winning_team == $prediction->fixture->team1->id)
                                        <i class="fas fa-trophy" style="color:goldenrod;flex-shrink:0;font-size:12px;"></i>
                                    @endif
                                </div>
                                <div style="flex-shrink:0;display:flex;align-items:center;gap:4px;padding-left:8px;">
                                    <img src="{{ asset('images/football.svg') }}" width="15" height="15" alt="">
                                    <span class="badge bg-success" style="min-width:22px;text-align:center;">{{ $prediction->predictiondetails->team1_goals ?? '' }}</span>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;width:100%;">
                                <div style="flex:1;min-width:0;display:flex;align-items:center;gap:6px;font-size:15px;font-weight:500;color:#2c2c2a;">
                                    <img height="20" width="20" src="{{ $prediction->fixture->team2->flag }}" alt="" style="flex-shrink:0;">
                                    <span style="flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $prediction->fixture->team2->name }}</span>
                                    @if ($prediction->winning_team == $prediction->fixture->team2->id)
                                        <i class="fas fa-trophy" style="color:goldenrod;flex-shrink:0;font-size:12px;"></i>
                                    @endif
                                </div>
                                <div style="flex-shrink:0;display:flex;align-items:center;gap:4px;padding-left:8px;">
                                    <img src="{{ asset('images/football.svg') }}" width="15" height="15" alt="">
                                    <span class="badge bg-success" style="min-width:22px;text-align:center;">{{ $prediction->predictiondetails->team2_goals ?? '' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="prediction-info">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="font-size: 12px; font-weight: 500;">Prediction</span>

                            </div>
                            <div class="prediction-boxes">
                                <div class="prediction-box">
                                    @if ($prediction->winningTeam)
                                        👑 {{ $prediction->winningTeam->short_code }} wins
                                    @else
                                        Draw
                                    @endif
                                </div>
                                <div class="prediction-box secondary">Predict Score:
                                    {{ $prediction->predictiondetails->team1_goals ?? '' }}-{{ $prediction->predictiondetails->team2_goals ?? '' }}
                                </div>
                            </div>
                        </div> --}}
                        </div>{{-- /position:relative z-index:1 --}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
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
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.8,
                restore: false,
                guides: false,
                center: false,
                highlight: false,
                cropBoxMovable: false,
                cropBoxResizable: false,
                toggleDragModeOnDblclick: false,
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
@endsection
