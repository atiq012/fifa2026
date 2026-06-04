@extends('dashboardLayout.main')

@section('content')

    <!-- Analytics Screen -->
    <div id="analytics" class="screen active">
        <h2 class="section-title">Your Statistics</h2>

        <div class="stats-grid mb-2">
            <div class="stat-card">
                <div class="stat-label">Total Predictions</div>
                <div class="stat-value">42</div>
                <div class="stat-subtitle">Matches predicted</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Correct Predictions</div>
                <div class="stat-value" style="color: #1d9e75;">22</div>
                <div class="stat-subtitle">52% accuracy</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Current Streak</div>
                <div class="stat-value">5 🔥</div>
                <div class="stat-subtitle">Consecutive correct</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Points Earned</div>
                <div class="stat-value">185</div>
                <div class="stat-subtitle">From predictions</div>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Accuracy by Stage</div>
            <div class="bar-chart">
                <div class="bar-item">
                    <div class="bar" style="height: 60px;"></div>
                    <div class="bar-label">Group</div>
                    <div class="bar-value">56%</div>
                </div>
                <div class="bar-item">
                    <div class="bar" style="height: 30px;"></div>
                    <div class="bar-label">R32</div>
                    <div class="bar-value">0%</div>
                </div>
                <div class="bar-item">
                    <div class="bar" style="height: 20px;"></div>
                    <div class="bar-label">R16</div>
                    <div class="bar-value">TBD</div>
                </div>
                <div class="bar-item">
                    <div class="bar-label">QF</div>
                    <div class="bar-value">TBD</div>
                </div>
                <div class="bar-item">
                    <div class="bar-label">SF</div>
                    <div class="bar-value">TBD</div>
                </div>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Most Predicted Teams</div>
            <div class="progress-bar-container">
                <label>Argentina</label>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 90%;"></div>
                </div>
                <div class="progress-value">36</div>
            </div>
            <div class="progress-bar-container">
                <label>France</label>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 85%;"></div>
                </div>
                <div class="progress-value">34</div>
            </div>
            <div class="progress-bar-container">
                <label>Brazil</label>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 72%;"></div>
                </div>
                <div class="progress-value">29</div>
            </div>
            <div class="progress-bar-container">
                <label>Spain</label>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 68%;"></div>
                </div>
                <div class="progress-value">27</div>
            </div>
            <div class="progress-bar-container">
                <label>England</label>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 58%;"></div>
                </div>
                <div class="progress-value">23</div>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Recent Predictions</div>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 0.5px solid #d3d1c7;">
                    <div>
                        <p style="margin: 0; font-size: 13px; font-weight: 500; color: #2c2c2a;">
                            Argentina
                            vs
                            Canada</p>
                        <p style="margin: 4px 0 0; font-size: 12px; color: #888780;">Your
                            prediction:
                            Argentina</p>
                    </div>
                    <span class="match-status">✓ Correct</span>
                </div>
                <div
                    style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 0.5px solid #d3d1c7;">
                    <div>
                        <p style="margin: 0; font-size: 13px; font-weight: 500; color: #2c2c2a;">
                            Brazil vs
                            Serbia
                        </p>
                        <p style="margin: 4px 0 0; font-size: 12px; color: #888780;">Your
                            prediction:
                            Brazil</p>
                    </div>
                    <span class="match-status">✓ Correct</span>
                </div>
                <div
                    style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 0.5px solid #d3d1c7;">
                    <div>
                        <p style="margin: 0; font-size: 13px; font-weight: 500; color: #2c2c2a;">
                            France vs
                            Peru</p>
                        <p style="margin: 4px 0 0; font-size: 12px; color: #888780;">Your
                            prediction:
                            France</p>
                    </div>
                    <span class="match-status">✓ Correct</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                    <div>
                        <p style="margin: 0; font-size: 13px; font-weight: 500; color: #2c2c2a;">
                            England vs
                            Iran
                        </p>
                        <p style="margin: 4px 0 0; font-size: 12px; color: #888780;">Your
                            prediction:
                            England Draw
                        </p>
                    </div>
                    <span class="match-status wrong">✗ Wrong</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const buttons = document.querySelectorAll('.nav-tabs button');
        buttons.forEach(btn => btn.classList.remove('active'));
        if (buttons.length >= 5) {
            buttons[4].classList.add('active');
        }
    </script>
@endsection
