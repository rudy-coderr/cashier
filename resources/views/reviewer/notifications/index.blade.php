<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>All Notifications — DAR Cashier</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body style="background:#f4f1eb;font-family:DM Sans, sans-serif;padding:28px;">
  <div class="container" style="max-width:980px;margin:0 auto;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
      <h2 style="margin:0">Notifications</h2>
      <a href="{{ route('reviewer') }}" class="btn btn-secondary">Back to Reviewer</a>
    </div>

    @if($notes->count() === 0)
      <div class="card"><div class="card-body text-center text-muted">No notifications yet.</div></div>
    @else
      @foreach($notes as $note)
        @php
          $d = $note->data ?? [];
          $raw = $d['status'] ?? 'waiting';
          if (in_array($raw, ['approved'])) { $status = 'approved'; $icon='bi-check-circle-fill'; $cls='text-success'; }
          elseif (in_array($raw, ['rejected','accountant_rejected'])) { $status='rejected'; $icon='bi-x-circle-fill'; $cls='text-danger'; }
          else { $status='waiting'; $icon='bi-hourglass-split'; $cls='text-warning'; }
          $message = 'Transaction for ' . ($d['name'] ?? ($d['op_number'] ?? 'Transaction')) . ' ' . ($status === 'approved' ? 'has been approved.' : ($status==='waiting' ? 'is awaiting your review.' : 'was rejected. Please review.'));
        @endphp
        <div class="card mb-2">
          <div class="card-body d-flex align-items-start">
            <div style="width:40px;height:40px;border-radius:8px;display:flex;align-items:center;justify-content:center;margin-right:12px;background:#f0f4f2;">
              <i class="bi {{ $icon }} {{ $cls }}" style="font-size:18px"></i>
            </div>
            <div style="flex:1;">
              <div style="font-weight:600">{!! e($message) !!}</div>
              <div style="color:#6b776d;font-size:.87rem;margin-top:6px;">{{ $note->created_at ? $note->created_at->diffForHumans() : '' }}</div>
            </div>
            <div style="margin-left:12px;display:flex;flex-direction:column;gap:8px">
              @if(! $note->read_at)
                <form method="POST" action="{{ route('notifications.read', ['id' => $note->id]) }}">
                  @csrf
                  <button class="btn btn-sm btn-primary">Mark read</button>
                </form>
              @else
                <span class="text-muted" style="font-size:.9rem">Read</span>
              @endif
            </div>
          </div>
        </div>
      @endforeach

      <div style="margin-top:12px">{{ $notes->links() }}</div>
    @endif
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
</body>
</html>
