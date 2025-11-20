<?php
$dataFile = "/var/www/html/workouts.txt";
$message = "";

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // If Clear button pressed
    if (isset($_POST["clear"])) {
        if (file_exists($dataFile)) {
            file_put_contents($dataFile, ""); // empty the file
        }
        $message = "All workouts have been cleared.";
    } 
    // Normal add workout
    else if (isset($_POST["exercise"])) {
        $exercise = htmlspecialchars($_POST["exercise"]);
        $reps = htmlspecialchars($_POST["reps"]);
        $weight = htmlspecialchars($_POST["weight"]);

        $line = date("Y-m-d") . " | Exercise: $exercise | Reps: $reps | Weight: $weight kg" . PHP_EOL;
        file_put_contents($dataFile, $line, FILE_APPEND);

        $message = "Workout saved successfully!";
    }
}

// Load existing entries
$entries = file_exists($dataFile) ? file($dataFile, FILE_IGNORE_NEW_LINES) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workout Log – FitTrack</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial; margin: 0; background: #f4f4f4; }
        header { background: #5c2da8; padding: 25px; color: white; text-align: center; }
        nav { background: #eee; padding: 12px; text-align: center; }
        nav a { margin: 0 15px; text-decoration: none; color: #5c2da8; font-weight: bold; }
        section { max-width: 900px; margin: 20px auto; background: white; padding: 25px; border-radius: 8px; }
        h2 { color: #5c2da8; }
        input { padding: 8px; margin-right: 10px; }
        button { padding: 10px 15px; background: #5c2da8; color: white; border: none; cursor: pointer; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
        .message { background: #d5f8d5; padding: 10px; border-left: 5px solid green; margin-bottom: 15px; }
        .actions { margin-top: 20px; display: flex; gap: 10px; }
        .clear-btn { background: #d9534f; }  /* red button for clear */
        .summary-btn { background: #4CAF50; } /* green button for summary */
    </style>
</head>

<body>

<header>
    <h1>FitTrack – Workout Log</h1>
</header>

<nav>
    <a href="/">Home</a>
    <a href="/workout-log.php">Workout Log</a>
    <a href="/video-search.php">Videos</a>
    <a href="/about.html">About</a>
</nav>

<section>

    <h2>Add Workout Entry</h2>

    <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Form to add workouts -->
    <form method="POST">
        <input type="text" name="exercise" placeholder="Exercise" required>
        <input type="number" name="reps" placeholder="Reps" required>
        <input type="number" name="weight" placeholder="Weight (kg)" required>
        <button type="submit">Add</button>
    </form>

    <h2>Previous Workouts</h2>

    <?php if (count($entries) > 0): ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Exercise</th>
                <th>Reps</th>
                <th>Weight</th>
            </tr>

            <?php foreach ($entries as $line): ?>
                <?php
                preg_match('/(.*) \| Exercise: (.*) \| Reps: (.*) \| Weight: (.*) kg/', $line, $parts);
                ?>
                <tr>
                    <td><?php echo $parts[1] ?? ""; ?></td>
                    <td><?php echo $parts[2] ?? ""; ?></td>
                    <td><?php echo $parts[3] ?? ""; ?></td>
                    <td><?php echo isset($parts[4]) ? $parts[4] . " kg" : ""; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="actions">
            <!-- Workout Summary button (new tab) -->
            <button type="button" class="summary-btn" onclick="window.open('/summary.php', '_blank')">
                View Workout Summary
            </button>

            <!-- Clear workouts button -->
            <form method="POST" onsubmit="return confirm('Are you sure you want to clear all workouts?');">
                <button type="submit" name="clear" value="1" class="clear-btn">
                    Clear All Workouts
                </button>
            </form>
        </div>

    <?php else: ?>
        <p>No workouts added yet.</p>
    <?php endif; ?>

</section>

</body>
</html>
