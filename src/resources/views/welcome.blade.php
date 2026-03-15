<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fakturomat - Start</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d6efd 0%, #003d99 100%);
            overflow: hidden;
        }

        /* Dekoracyjne koła w tle */
        .circle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 0;
        }
        .circle-1 { width: 300px; height: 300px; top: -100px; left: -100px; }
        .circle-2 { width: 200px; height: 200px; bottom: -50px; right: -50px; }

        .card {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: #e7f0ff;
            color: #0d6efd;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
        }

        h1 {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        p {
            color: #666;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .btn-start {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #0d6efd;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            border: none;
            cursor: pointer;
        }

        .btn-start:hover {
            background: #0056b3;
            box-shadow: 0 8px 15px rgba(13, 110, 253, 0.3);
            gap: 15px; /* Efekt wysunięcia strzałki */
        }

        .footer-text {
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>

    <div class="card">
        <div class="icon-box">
            <i class="fas fa-file-invoice"></i>
        </div>
        <h1>Witaj w Fakturomacie</h1>
        <p>Zarządzaj swoimi fakturami i klientami w jednym, bezpiecznym miejscu.</p>
        
        <a href="/pdf" class="btn-start">
            Uruchom system <i class="fas fa-arrow-right"></i>
        </a>

        @guest
        <div class="footer-text">
            System generowania faktur PDF v3.0
        </div>
          <div class="footer-text">
            <a href="/login">Login</a>
        </div>
          <div class="footer-text">
              <a href="/register">Register</a>
        </div>
        @endguest
    </div>
</body>
</html>