<!-- Header -->
<div class="header">
    <div class="header-title">
        <h1>Galaxy Bangladesh FIFA World Cup Prediction 2026</h1>
        <p id="headerSubtitle">Group stage • 48 matches remaining</p>
    </div>
    <div class="header-actions">
        <button onclick="showScreen('settings')">⚙️</button>
    </div>
</div>

<!-- Navigation -->
<div class="nav-tabs">
    <button onclick="showScreen('dashboard')" data-predictions-url="{{ route('dashboard') }}">Dashboard</button>
    <button onclick="showScreen('predictions')" data-predictions-url="{{ route('predictions') }}">My Predictions</button>
    <button onclick="showScreen('leaderboard')" data-predictions-url="{{ route('leaderboard') }}">Leaderboard</button>
    @if(Auth::user()->role_id == 1)
        <button onclick="showScreen('update_result')" data-predictions-url="{{ route('update_result') }}">Update Result</button>
    @endif
    <button onclick="showScreen('analytics')" data-predictions-url="{{ route('analytics') }}">Analytics</button>
</div>
