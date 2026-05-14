<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accountant — My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>

    <style>
        :root {
            --green-deep:   #0e2a1a;
            --green-mid:    #1a4a2e;
            --green-accent: #2d7a4f;
            --green-light:  #e8f4ee;
            --gold:         #c9992a;
            --gold-light:   #e8c46a;
            --cream:        #f5f0e8;
            --border:       #e2ddd5;
            --text-dark:    #0e2a1a;
            --text-mid:     #3d5045;
            --muted:        #8a9e90;
            --bg:           #f4f1eb;
            --surface:      #ffffff;
            --red:          #a0251c;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); min-height: 100vh; color: var(--text-dark); }

        .top-stripe { height: 4px; background: linear-gradient(90deg, var(--green-accent), var(--gold), var(--red)); }

        .page-header {
            background: var(--green-deep);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            gap: 14px;
            position: sticky;
            top: 0;
            z-index: 200;
        }
        .header-seal { width: 38px; height: 38px; border-radius: 50%; background: var(--gold); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
        .header-text .t1 { font-size: .58rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245,240,232,.35); font-weight: 300; }
        .header-text .t2 { font-size: .85rem; font-weight: 600; color: var(--cream); }
        .header-sep { width: 1px; height: 30px; background: rgba(245,240,232,.15); margin: 0 4px; }
        .header-page { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 700; color: var(--gold-light); }
        .header-actions { margin-left: auto; display: flex; align-items: center; gap: 10px; }
        .btn-logout {
            display: flex; align-items: center; gap: 6px; padding: 8px 16px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border: 1px solid rgba(201,153,42,.35); border-radius: 8px; color: var(--green-deep);
            font-family: 'DM Sans', sans-serif; font-weight: 700; font-size: .75rem; letter-spacing: .5px;
            cursor: pointer; transition: all .18s ease; box-shadow: 0 2px 6px rgba(0,0,0,.08);
        }
        .btn-logout:hover { background: linear-gradient(135deg, #d6a73b, #f0cf7b); transform: translateY(-1px); }

        .outer-wrapper { display: flex; min-height: calc(100vh - 72px); }

        .sidebar {
            width: 260px; flex-shrink: 0; background: var(--green-deep);
            border-right: 1px solid rgba(255,255,255,.07);
            position: sticky; top: 72px; height: calc(100vh - 72px);
            display: flex; flex-direction: column;
        }
        .sidebar-inner { flex: 1; overflow-y: auto; padding: 24px 0 0; }
        .sidebar-inner::-webkit-scrollbar { width: 3px; }
        .sidebar-inner::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }
        .sidebar-profile { padding: 0 22px 20px; display: flex; align-items: center; gap: 11px; }
        .profile-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem; font-weight: 700; color: var(--green-deep); flex-shrink: 0;
        }
        .profile-name { font-size: .83rem; font-weight: 600; color: var(--cream); }
        .profile-role { font-size: .63rem; color: rgba(245,240,232,.35); letter-spacing: 1px; text-transform: uppercase; margin-top: 2px; }
        .sidebar-divider { border: none; border-top: 1px solid rgba(255,255,255,.07); margin: 0 22px 16px; }
        .nav-section-label { padding: 0 22px; font-size: .6rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: rgba(245,240,232,.28); margin-bottom: 6px; margin-top: 12px; }
        .nav-item { display: flex; align-items: center; gap: 11px; padding: 10px 22px; cursor: pointer; transition: background .15s; border-left: 3px solid transparent; text-decoration: none; }
        .nav-item:hover { background: rgba(255,255,255,.04); }
        .nav-item.active { background: rgba(45,122,79,.18); border-left-color: var(--gold); }
        .nav-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: .88rem; flex-shrink: 0; transition: background .15s, color .15s; }
        .nav-item:not(.active) .nav-icon { background: rgba(255,255,255,.07); color: rgba(245,240,232,.55); }
        .nav-item.active .nav-icon { background: var(--gold); color: var(--green-deep); }
        .nav-label { font-size: .81rem; font-weight: 600; color: rgba(245,240,232,.7); }
        .nav-item.active .nav-label { color: var(--cream); }
        .nav-badge { margin-left: auto; background: #c2640a; color: #fff; font-size: .6rem; font-weight: 700; padding: 2px 7px; border-radius: 20px; }
        .sidebar-footer { padding: 14px 22px; border-top: 1px solid rgba(255,255,255,.07); flex-shrink: 0; }
        .sidebar-footer-label { font-size: .6rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,240,232,.3); margin-bottom: 4px; }
        .sidebar-footer-value { font-size: .73rem; color: rgba(245,240,232,.5); font-weight: 300; }

        .main-content { flex: 1; min-width: 0; }
        .page-body { max-width: 1100px; margin: 0 auto; padding: 36px 28px 60px; }

        .page-title-row { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
        .page-title { font-family: 'Cormorant Garamond', serif; font-size: 1.7rem; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; }
        .page-sub { font-size: .8rem; color: var(--muted); font-weight: 300; }

        .card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; padding: 18px; }
        label { display:block; margin-bottom:6px; font-weight:600; color:var(--text-mid); font-size:.88rem; }
        input, textarea { width:100%; padding:9px 12px; border:1.5px solid var(--border); border-radius:9px; background:var(--surface); }
        .row-3 { display:flex; gap:12px; }
        .col { flex:1; }
        .btn { padding:8px 12px; border-radius:8px; border:none; cursor:pointer; font-weight:700; }
        .btn-primary { background: linear-gradient(135deg, var(--gold), var(--gold-light)); color:var(--green-deep); }
        .btn-muted { background:#f3f3f3; color:var(--text-dark); }
        .messages { margin-bottom:12px; }
        .alert-success { background: var(--green-light); color: var(--green-accent); padding:10px 12px; border-radius:8px; }
        .alert-danger { background:#fdf0ef; color:var(--red); padding:10px 12px; border-radius:8px; }
        @media (max-width: 768px) { .row-3 { flex-direction:column; } }
    </style>
</head>
<body>

<div class="top-stripe"></div>

<header class="page-header">
    <div class="header-seal">🌾</div>
    <div class="header-text">
        <div class="t1">Republic of the Philippines</div>
        <div class="t2">Department of Agrarian Reform</div>
    </div>
    <div class="header-sep"></div>
    <div class="header-page">My Profile</div>
    <div class="header-actions">
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</header>

<div class="outer-wrapper">

    <aside class="sidebar">
        <div class="sidebar-inner">
            <div class="sidebar-profile">
                <div class="profile-avatar">AC</div>
                <div>
                    <div class="profile-name">{{ auth()->user()->name ?? 'Accountant' }}</div>
                    <div class="profile-role">Accountant</div>
                </div>
            </div>
            <hr class="sidebar-divider">

            <div class="nav-section-label" style="margin-top:16px;">Transactions</div>
            <a class="{{ request()->routeIs('accountant.approval') ? 'nav-item active' : 'nav-item' }}" href="{{ route('accountant.approval') }}">
                <div class="nav-icon"><i class="bi bi-hourglass-split"></i></div>
                <span class="nav-label">For Review</span>
                @php $pendingCount = \App\Models\Payment::whereIn('status', ['forwarded','under_review','submitted'])->count(); @endphp
                @if($pendingCount > 0)
                    <span class="nav-badge">{{ $pendingCount }}</span>
                @endif
            </a>
            <a class="{{ request()->routeIs('accountant.approved') ? 'nav-item active' : 'nav-item' }}" href="{{ route('accountant.approved') }}">
                <div class="nav-icon"><i class="bi bi-check2-circle"></i></div>
                <span class="nav-label">Approved Records</span>
            </a>

            <div class="nav-section-label" style="margin-top:16px;">Account</div>
            <a class="{{ request()->routeIs('accountant.profile') ? 'nav-item active' : 'nav-item' }}" href="{{ route('accountant.profile') }}">
                <div class="nav-icon"><i class="bi bi-person-badge"></i></div>
                <span class="nav-label">My Profile</span>
            </a>
        </div>
        <div class="sidebar-footer">
            <div class="sidebar-footer-label">System</div>
            <div class="sidebar-footer-value">DAR Cashier — Regional Office V</div>
        </div>
    </aside>

    <main class="main-content">
        <div class="page-body">

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="page-title-row" style="margin-bottom:12px">
                    <div>
                        <div class="page-title">My Profile</div>
                        <div class="page-sub">Manage your account details and change password</div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert-danger" style="margin-bottom:12px">
                        <ul style="margin:0;padding-left:18px">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('accountant.profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="row-3" style="margin-bottom:12px">
                        <div class="col">
                            <label for="first_name">First name</label>
                            <input id="first_name" name="first_name" value="{{ old('first_name', auth()->user()->first_name ?? '') }}" required />
                        </div>
                        <div class="col">
                            <label for="middle_name">Middle name</label>
                            <input id="middle_name" name="middle_name" value="{{ old('middle_name', auth()->user()->middle_name ?? '') }}" />
                        </div>
                        <div class="col">
                            <label for="last_name">Last name</label>
                            <input id="last_name" name="last_name" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required />
                        </div>
                    </div>

                    <div style="margin-bottom:12px">
                        <label for="username">Username</label>
                        <input id="username" name="username" value="{{ old('username', auth()->user()->username ?? '') }}" />
                    </div>

                    <div style="margin-bottom:12px">
                        <label for="email">Email (read-only)</label>
                        <input id="email" value="{{ auth()->user()->email ?? '' }}" disabled />
                    </div>

                    <div style="margin-bottom:12px">
                        <label for="phone_number">Phone number</label>
                        <input id="phone_number" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number ?? '') }}" />
                    </div>

                    <div style="margin-bottom:12px">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                    </div>

                    <div style="display:flex;gap:8px;align-items:center">
                        <button class="btn btn-primary" type="submit">Save profile</button>
                        <a class="btn btn-muted" href="{{ route('accountant.approval') }}">Back</a>
                    </div>
                </form>

                <hr style="margin:18px 0">

                <h3 style="margin-bottom:8px">Change password</h3>
                <form method="POST" action="{{ route('accountant.profile.password') }}">
                    @csrf
                    @method('PATCH')

                    <div style="margin-bottom:12px">
                        <label for="current_password">Current password</label>
                        <input id="current_password" name="current_password" type="password" required />
                    </div>

                    <div style="margin-bottom:12px">
                        <label for="password">New password</label>
                        <input id="password" name="password" type="password" required />
                    </div>

                    <div style="margin-bottom:12px">
                        <label for="password_confirmation">Confirm new password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required />
                    </div>

                    <div>
                        <button class="btn btn-primary" type="submit">Change password</button>
                    </div>
                </form>
            </div>

        </div>
    </main>
</div>

</body>
</html>