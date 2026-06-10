@extends('dashboardLayout.main')

@section('content')
    <div id="predictions" class="screen active">
        <h2 class="section-title">All Predictions</h2>
        <div class="row">
            @foreach ($predictions as $prediction)
                <div class="col-md-4">
                    <div class="prediction-card" style="opacity: 0.8;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                            @php
                                $emp = DB::table('emps')->where('id', $prediction->createdBy->emp_id)->first();
                            @endphp
                            <div>
                                @isset($emp)
                                    <span class=" ">
                                        <img height="30" width="30"
                                            src="https://myportal.galaxybd.com/public/{{ $emp->image_path ?? 'default-avatar.png' }}"
                                            alt="image" style="border-radius: 50%; object-fit: cover">
                                    </span>
                                @endisset
                                <span class="status-badge pending" style="font-size: 11px; color: #888780; background: #f1efe8; padding: 4px 8px; border-radius: 6px;">{{ $prediction->createdBy->name }}</span>

                            </div>

                        </div>

                        <h3 style="margin: 0 0 1rem; font-size: 15px; font-weight: 500; color: #2c2c2a;">
                            <img height="20" width="20" src="{{ $prediction->fixture->team1->flag }}" alt="">
                            {{ $prediction->fixture->team1->name }}
                            <span style="margin: 0 0 1rem; font-size: 15px; font-weight: 500; color: #2c2c2a;">
                                <br>
                            </span>

                            <img height="20" width="20" src="{{ $prediction->fixture->team2->flag }}" alt="">
                            {{ $prediction->fixture->team2->name }}
                        </h3>

                        <div class="prediction-info">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="font-size: 12px; font-weight: 500;">Your Prediction</span>

                            </div>
                            <div class="prediction-boxes">
                                <div class="prediction-box">👑
                                    {{ $prediction->winningTeam->short_code ?? '' }} Wins
                                </div>
                                <div class="prediction-box secondary">Predict Score:
                                    {{ $prediction->predictiondetails->team1_goals ?? '' }}-{{ $prediction->predictiondetails->team2_goals ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


@section('scripts')
@endsection
