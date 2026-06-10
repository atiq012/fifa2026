<div class="row p-2">
    @foreach ($allPred as $pred)
        <div class="col-md-12 mt-2">
            <div class="cricket-card">
                <!-- RESULT header line -->
                <div class="result-header">
                    <span class="result-label">Total Predictions :
                        {{ $pred->total_predictions($pred->fixture_id) }}</span>
                </div>

                <!-- Bangladesh row -->
                <div class="team-row">
                    <div class="team-name-group">
                        <span class="team-short"><img height="20" width="20"
                                src="{{ $pred->fixture->team1->flag ?? '' }}" alt=""></span>
                        <span class="team-full">{{ $pred->fixture->team1->name ?? '' }}</span>
                    </div>
                    <div class="team-score-group">
                        <span
                            class="runs">👑 {{ $pred->total_win_predictions($pred->fixture_id, $pred->fixture->team1_id) }}
                            People Predicted</span>
                    </div>
                </div>

                <!-- Australia row -->
                <div class="team-row">
                    <div class="team-name-group">
                        <span class="team-short"><img height="20" width="20"
                                src="{{ $pred->fixture->team2->flag ?? '' }}" alt=""></span>
                        <span class="team-full">{{ $pred->fixture->team2->name ?? '' }}</span>
                    </div>
                    <div class="team-score-group">
                        <span class="runs">👑
                            {{ $pred->total_win_predictions($pred->fixture_id, $pred->fixture->team2_id) }} People
                            Predicted</span>
                    </div>
                </div>

                <div class="team-row">
                    <div class="team-name-group">
                        {{-- <span class="team-short"><img height="20" width="20" src="{{ $pred->fixture->team2->flag ?? '' }}" alt=""></span> --}}
                        <span class="team-full">Draw</span>
                    </div>
                    <div class="team-score-group">
                        @if ($pred->total_draw_predictions($pred->fixture_id, $pred->is_draw) > 0)
                            <span class="runs"> {{ $pred->total_draw_predictions($pred->fixture_id, $pred->is_draw) }}
                                People Predicted</span>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <!-- Result message -->
                <div class="result-message">
                    @php
                        $team1Predictions = $pred->total_win_predictions($pred->fixture_id, $pred->fixture->team1_id);
                        $team2Predictions = $pred->total_win_predictions($pred->fixture_id, $pred->fixture->team2_id);
                        $totalPredictions = $team1Predictions + $team2Predictions;
                        $team1Percentage =
                            $totalPredictions > 0 ? round(($team1Predictions / $totalPredictions) * 100) : 0;
                        $team2Percentage =
                            $totalPredictions > 0 ? round(($team2Predictions / $totalPredictions) * 100) : 0;
                    @endphp
                    Winning Percentage
                    @if ($team1Predictions > $team2Predictions)
                        {{ $pred->fixture->team1->short_code ?? '' }} ({{ $team1Percentage }}%) - {{ $pred->fixture->team2->short_code ?? '' }} ({{ $team2Percentage }})%
                    @elseif ($team1Predictions < $team2Predictions)
                        {{ $pred->fixture->team2->short_code ?? '' }} ({{ $team2Percentage }}%) - {{ $pred->fixture->team1->short_code ?? '' }}({{ $team1Percentage }})%
                    @else
                        Draw (50% - 50%)
                    @endif
                </div>

                <!-- Schedule link at bottom -->
                <a href="{{ route('predictionDetails', $pred->fixture_id) }}" class="schedule-link">
                    Details
                    <svg width="12" height="12" viewBox="0 0 16 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    @endforeach
</div>
