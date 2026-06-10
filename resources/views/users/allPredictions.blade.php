<div class="row p-2">
    @foreach ($allPred as $pred)
        <div class="col-md-12 mt-2">
            <div class="cricket-card">
                <!-- RESULT header line -->
                <div class="result-header">
                    <span class="result-label">Total Predictions : {{ $pred->total_predictions($pred->fixture_id) }}</span>
                </div>

                <!-- Bangladesh row -->
                <div class="team-row">
                    <div class="team-name-group">
                        <span class="team-short"><img height="20" width="20" src="{{ $pred->fixture->team1->flag ?? '' }}" alt=""></span>
                        <span class="team-full">{{ $pred->fixture->team1->name ?? '' }}</span>
                    </div>
                    <div class="team-score-group">
                        <span class="runs">{{ $pred->total_win_predictions($pred->fixture_id,$pred->fixture->team1_id) }} </span>
                    </div>
                </div>

                <!-- Australia row -->
                <div class="team-row">
                    <div class="team-name-group">
                         <span class="team-short"><img height="20" width="20" src="{{ $pred->fixture->team2->flag ?? '' }}" alt=""></span>
                        <span class="team-full">{{ $pred->fixture->team2->name ?? '' }}</span>
                    </div>
                    <div class="team-score-group">
                        <span class="runs">{{ $pred->total_win_predictions($pred->fixture_id,$pred->fixture->team2_id) }}</span>
                    </div>
                </div>

                <!-- Result message -->
                <div class="result-message">
                    @if ($pred->total_win_predictions($pred->fixture_id,$pred->fixture->team1_id) > $pred->total_win_predictions($pred->fixture_id,$pred->fixture->team2_id))
                        {{ $pred->fixture->team1->name ?? "" }} won {{ $pred->total_win_predictions($pred->fixture_id,$pred->fixture->team1_id) }} of the predictions
                    @elseif ($pred->total_win_predictions($pred->fixture_id,$pred->fixture->team1_id) < $pred->total_win_predictions($pred->fixture_id,$pred->fixture->team2_id))
                        {{ $pred->fixture->team2->name ?? "" }} won {{ $pred->total_win_predictions($pred->fixture_id,$pred->fixture->team2_id) }} of the predictions
                    @else
                        Draw
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
