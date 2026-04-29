<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f172a;
        }

        .btn-pay {
            padding: 14px 40px;
            background: #4ade80;
            border: none;
            border-radius: 10px;
            color: #fff;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 1.8px;
            cursor: pointer;
            transition: background .2s, transform .1s, box-shadow .2s;
            box-shadow: 0 4px 16px rgba(74, 222, 128, .38);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-pay:hover {
            background: #22c55e;
            transform: translateY(-2px);
            box-shadow: 0 7px 22px rgba(74, 222, 128, .48);
        }

        .btn-pay:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <a href="{{ route('login') }}" class="btn-pay">
        <i class="bi bi-credit-card"></i>
        PAY NOW
    </a>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>