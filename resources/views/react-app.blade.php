<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paksayur - Fresh Groceries Mobile App</title>
    <style>
        /* Critical CSS for loading */
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen',
                'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #f8f9fa;
        }

        #root {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e9ecef;
            border-top: 4px solid #00b894;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div id="root">
        <div class="loading">
            <div class="loading-spinner"></div>
            <p style="color: #666; font-size: 14px;">Loading Paksayur Mobile App...</p>
        </div>
    </div>

    <!-- React will replace this loading content -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
