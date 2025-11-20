<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Video Search – FitTrack</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; }
        header { background: #5c2da8; padding: 25px; color: white; text-align: center; }
        nav { background: #eee; padding: 12px; text-align: center; }
        nav a { 
            margin: 0 15px; 
            text-decoration: none; 
            color: #5c2da8; 
            font-weight: bold; 
        }
        nav a:hover { text-decoration: underline; }
        section { 
            max-width: 800px; 
            background: white; 
            padding: 25px; 
            margin: 30px auto; 
            border-radius: 8px; 
        }
        input { 
            width: 70%; 
            padding: 10px; 
            margin-right: 10px; 
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button { 
            padding: 10px 20px; 
            background: #5c2da8; 
            color: white; 
            border: none; 
            cursor: pointer; 
            border-radius: 5px; 
        }
        button:hover { background: #4a2088; }
        p { color: #555; }
    </style>
</head>
<body>

<header>
    <h1>FitTrack – Video Search</h1>
</header>

<nav>
    <a href="/">Home</a>
    <a href="/workout-log.php">Workout Log</a>
    <a href="/video-search.php">Video Search</a>
</nav>

<section>
    <h2>Search Workout Videos</h2>
    <p>Type the workout, muscle group, or exercise name you want to learn. This will open YouTube search results in a new tab.</p>

    <form action="https://www.youtube.com/results" method="get" target="_blank">
        <input type="text" name="search_query" placeholder="e.g. chest workout, deadlift form, leg day routine" required>
        <button type="submit">Search on YouTube</button>
    </form>
</section>

</body>
</html>
