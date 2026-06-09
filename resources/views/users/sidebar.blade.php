<div class="table-responsive ">
    <table class="table table-sm table-hover align-middle mb-0">
        <thead class="table-header-custom">
            <tr>
                <th style="width:8%"><i class="fas fa-hashtag me-1"></i>Rank</th>
                <th style="width:32%">Player</th>
                <th style="width:12%" class="text-end"><i class="fas fa-chart-line me-1"></i>Pts</th>
            </tr>
        </thead>
        <tbody>

            <!-- Rank 1 -->
            <tr style="background:#fffbef;">
                <td class="text-center">
                    <span class="rank-badge rank-gold"><i class="fas fa-crown" style="font-size:0.65rem;"></i></span>
                </td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div>
                            <div class="player-name">Quazi Rizwan</div>
                            <div class="player-sub">Engineering</div>
                        </div>
                    </div>
                </td>

                <td class="text-end points-value">245</td>
            </tr>

            <!-- Rank 2 -->
            <tr>
                <td class="text-center"><span class="rank-badge rank-silver">2</span></td>
                <td>
                    <div class="d-flex align-items-center gap-2">

                        <div>
                            <div class="player-name">Shirajul Alam Khan</div>
                            <div class="player-sub">Product</div>
                        </div>
                    </div>
                </td>

                <td class="text-end points-value">228</td>

            </tr>

            <!-- Rank 3 -->
            <tr>
                <td class="text-center"><span class="rank-badge rank-bronze">3</span></td>
                <td>
                    <div class="d-flex align-items-center gap-2">

                        <div>
                            <div class="player-name">Imteaz Ahmed</div>
                            <div class="player-sub">Sales</div>
                        </div>
                    </div>
                </td>

                <td class="text-end points-value">215</td>

            </tr>


            <tr>
                <td class="text-center"><span class="rank-plain">4</span></td>
                <td>
                    <div class="d-flex align-items-center gap-2">

                        <div>
                            <div class="player-name">Zareen Bano</div>
                            <div class="player-sub">Human Resources</div>
                        </div>
                    </div>
                </td>

                <td class="text-end points-value">201</td>
            </tr>

            <tr>
                <td class="text-center"><span class="rank-plain">5</span></td>
                <td>
                    <div class="d-flex align-items-center gap-2">

                        <div>
                            <div class="player-name">Md. Feroj Iftekar</div>
                            <div class="player-sub">Finance</div>
                        </div>
                    </div>
                </td>
                <td class="text-end points-value">162</td>
            </tr>
        </tbody>
    </table>
</div>

@php
    $groupedTeams = $teams->groupBy('group');
    $colors = ['primary', 'success', 'danger', 'warning', 'info', 'dark', 'secondary'];
@endphp

@foreach ($groupedTeams as $groupName => $teamsInGroup)
    @php
        $randomColor = $colors[array_rand($colors)];
    @endphp
    <div class="card m-2">
        <div class="card-header p-1 m-1 bg-{{ $randomColor }} text-white">
            Group {{ $groupName }}
        </div>
        <div class="card-body p-1 m-1">
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-header-custom">
                        <tr>
                            <th style="width:8%"></i>No.</th>
                            <th style="width:8%"></i>Flag</th>
                            <th style="width:8%"></i>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teamsInGroup as $index => $team)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if ($team->flag)
                                        <img src="{{ $team->flag }}" alt="{{ $team->name }} flag"
                                            style="width: 30px; height: 20px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">No flag</span>
                                    @endif
                                </td>
                                <td>{{ $team->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endforeach

@if ($groupedTeams->isEmpty())
    <div class="alert alert-info m-2">
        No teams available.
    </div>
@endif
