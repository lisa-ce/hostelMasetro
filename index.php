<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NustHostelMenu Predictor</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>
<body>

  <p class="main">
    NustHostelMenu <span class="predictor">Predictor</span>
  </p>

  <p class="tagline">
    Have an idea of what to expect for your next meal
  </p>

  <div class="current-cycle-box">
    <p id="currentCycle">Loading current cycle...</p>
  </div>

  <div class="btnrow">
    <button data-day="1">Mon</button>
    <button data-day="2">Tue</button>
    <button data-day="3">Wed</button>
    <button data-day="4">Thu</button>
    <button data-day="5">Fri</button>
    <button data-day="6">Sat</button>
    <button data-day="0">Sun</button>
  </div>

  <div class="menu-container" id="menuContainer"></div>

  <script src="script.js"></script>
</body>
</html>