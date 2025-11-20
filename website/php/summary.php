<?php
$dataFile = "/var/www/html/workouts.txt";

// Load entries
$entries = file_exists($dataFile) ? file($dataFile, FILE_IGNORE_NEW_LINES) : [];

$totalWorkouts = count($entries);
$totalReps = 0;
$totalWeight = 0;
$exerciseCount = [];

foreach ($entries as $line) {
    // Extract values from the log line
    preg_match('/(.*) \| Exercise: (.*) \| Reps: (.*) \| Weight: (.*) kg/', $line, $parts);

    $exercise = $parts[2] ?? '';
    $reps = (int) ($parts[3] ?? 0);
    $weight = (int) ($parts[4] ?? 0);

    $totalReps += $reps;
    $totalWeight += $weight;

    if ($exercise !== '') {
        if (!isset($exerciseCount[$exercise])) {
            $exerciseCount[$exercise] = 0;
        }
        $exerciseCount[$exercise]++;
    }
}

// Calculate stats
$averageWeight = $totalWorkouts > 0 ? round($totalWeight / $totalWorkouts, 1) : 0;
$mostFrequentExercise = "None yet";

if ($totalWorkouts > 0 && !empty($exerciseCount)) {
    $mostFrequentExercise = array_search(max($exerciseCount), $exerciseCount);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workout Summary – FitTrack</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { background: #f4f4f4; font-family: Arial, sans-serif; margin: 0; }
        header { background: #5c2da8; padding: 25px; text-align: center; color: white; }
        nav { background: #eee; padding: 12px; text-align: center; }
        nav a { margin: 0 15px; text-decoration: none; color: #5c2da8; font-weight: bold; }
        section { max-width: 900px; margin: 30px auto; background: white; padding: 25px; border-radius: 8px; }
        h2 { color: #5c2da8; }
        .box { background: #f0f0f0; padding: 15px; border-left: 4px solid #5c2da8; margin-bottom: 20px; }
    </style>
</head>

<body>

<header>
    <h1>FitTrack – Workout Summary</h1>
</header>

<nav>
    <a href="/">Home</a>
    <a href="/workout-log.php">Workout Log</a>
    <a href="/video-search.php">Video Search</a>
    <a href="/summary.php">Workout Summary</a>
</nav>

<section>
    <h2>Your Workout Statistics</h2>

    <div class="box">
        <p><strong>Total Workouts Logged:</strong> <?= $totalWorkouts ?></p>
        <p><strong>Total Reps Completed:</strong> <?= $totalReps ?></p>
        <p><strong>Average Weight Used:</strong> <?= $averageWeight ?> kg</p>
        <p><strong>Most Frequent Exercise:</strong> <?= htmlspecialchars($mostFrequentExercise) ?></p>
    </div>

    <p>This summary gives a quick overview of your recorded training history. 
    It helps track performance trends and overall training volume over time.</p>

</section>

</body>
</html>
