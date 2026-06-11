<div id="settings" class="screen">
    <h2 class="section-title">Settings</h2>

    <div class="form-group">
        <label class="form-label">Full Name</label>
        <input type="text"  disabled value="{{ Auth::user()->name }}" />
    </div>

    <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" disabled value="{{ Auth::user()->email }}" />
    </div>

    @isset($favorite_team)
    <div class="form-group">
        <label class="form-label">My Favourite Team</label>
        <img height="15%" width="15%" class="wc-flag" src="{{ $favorite_team->team->flag ?? '' }}"
                        alt="img">
    </div>
    @endisset
    {{-- <div class="form-group">
        <label class="form-label">
            <input type="checkbox" checked /> Receive match reminders
        </label>
    </div>

    <div class="form-group">
        <label class="form-label">
            <input type="checkbox" checked /> Receive leaderboard updates
        </label>
    </div> --}}

    {{-- <button class="primary" style="width: 100%; margin-bottom: 1rem;">Save Changes</button> --}}

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button class="secondary" type="submit" href="{{ route('logout') }}" style="width: 100%">Sign
            Out</button>
    </form>
</div>
