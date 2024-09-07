<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Page Not Found</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .title {
            font-size: 200px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #ff0000;
        }

        .subtitle {
            font-size: 24px;
            margin-bottom: 40px;
            color: #666;
        }

        .broken-image {
            width: 300px;
            height: auto;
            filter: blur(5px);
            transition: all 0.3s ease-in-out;
        }

        .broken-image:hover {
            transform: scale(1.05);
            filter: none;
        }

        button {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #ff4d4f;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out forwards;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">404</h1>
        <p class="subtitle">Oops! Image Not Found</p>
        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='%23000000'/%3E%3Cpath d='M50 50 m0 0 l0 0' stroke='%23FFFFFF' stroke-width='5'/%3E%3C/svg%3E" alt="Broken Image" class="broken-image">
        <!-- <button onclick="window.location.href='/'">Go Home</button> -->
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const title = document.querySelector('.title');
            
            title.classList.add('fade-in');
        });
    </script>
</body>
</html>