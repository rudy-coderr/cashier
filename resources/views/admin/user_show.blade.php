<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Details — DAR Cashier</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body { font-family: 'DM Sans', sans-serif; background: #f4f1eb; color: #0e2a1a; padding: 28px; }
    .card { max-width: 800px; margin: 24px auto; border-radius: 12px; padding: 18px; background: #fff; border: 1.5px solid #e2ddd5; }
    .back { margin-bottom: 12px; }
    .label { color: #3d5045; font-weight: 700; font-size: .9rem; }
    .value { color: #0e2a1a; font-size: .95rem; }
  </style>
</head>
<body>
  <div class="card">
    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-secondary back"><i class="bi bi-arrow-left"></i> Back to users</a>
    <h3>{{ $user->name }}</h3>
    <p class="text-muted" style="margin-top: -6px;">{{ $user->email }}</p>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:18px;">
      <div>
        <div class="label">Role</div>
        <div class="value">{{ ucfirst($user->role ?? '—') }}</div>
      </div>
      <div>
        <div class="label">Status</div>
        <div class="value">{{ ($user->status ?? 'active') }}</div>
      </div>
      <div>
        <div class="label">Last login</div>
        <div class="value">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : '—' }}</div>
      </div>
      <div>
        <div class="label">Created</div>
        <div class="value">{{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}</div>
      </div>
    </div>

    <div style="margin-top:18px;display:flex;gap:8px;">
      <a href="{{ route('admin.users') }}" class="btn btn-secondary">Back</a>
      <button class="btn btn-primary" onclick="window.location.href='{{ url('/admin/users') }}'">Users List</button>
    </div>
  </div>
</body>
</html>
