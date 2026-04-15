<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>404 - Page introuvable</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .container {
            text-align: center;
            max-width: 500px;
        }

        .error-code {
            font-size: 120px;
            font-weight: bold;
            letter-spacing: 5px;
            animation: float 2s ease-in-out infinite;
        }

        .message {
            font-size: 22px;
            margin: 20px 0;
            opacity: 0.9;
        }

        .desc {
            font-size: 14px;
            margin-bottom: 30px;
            opacity: 0.7;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: #fff;
            color: #2a5298;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            background: #ddd;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>

<body>

<div class="container">
    <div class="error-code">404</div>

    <div class="message">Page introuvable</div>

    <div class="desc">
        Oups... La page que tu cherches n'existe pas ou a été déplacée.
    </div>

    <a href="/collect/public" class="btn">Retour à l'accueil</a>
</div>

</body>
</html>