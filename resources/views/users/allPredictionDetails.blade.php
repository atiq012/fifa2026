@extends('dashboardLayout.main')

@section('content')
    <div id="predictions" class="screen active">
        <h2 class="section-title">All Predictions</h2>

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
                            <div style="position:absolute;inset:0;background-image:url('{{ $favFlag }}');background-size:cover;background-position:center;opacity:0.1;z-index:0;pointer-events:none;"></div>
                        @endif
                        <div style="position:relative;z-index:1;">
                        <div style="display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #f8f9fb 0%, #eef1f6 100%); border-radius: 10px 10px 0 0; padding: 10px 1rem; margin: -1rem -1rem 1rem -1rem;">
                            <div class="d-flex align-items-center gap-2">
                                @php $canEditAvatar = auth()->id() === 1 || auth()->id() === $userId; @endphp
                                <div style="position:relative;width:32px;height:32px;flex-shrink:0;{{ $canEditAvatar ? 'cursor:pointer;' : '' }}"
                                     {{ $canEditAvatar ? 'onclick=openAvatarModal(' . $userId . ')' : '' }}>
                                    <img height="32" width="32"
                                        src="{{ $avatarSrc ?? asset('images/default-avatar.svg') }}"
                                        alt="avatar"
                                        style="border-radius:50%;object-fit:cover;width:32px;height:32px;display:block;"
                                        onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                                    @if($canEditAvatar)
                                        <div style="position:absolute;bottom:-1px;right:-1px;width:14px;height:14px;background:#3b82f6;border-radius:50%;display:flex;align-items:center;justify-content:center;border:1.5px solid #fff;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                                            </svg>
                                        </div>
                                    @endif
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
