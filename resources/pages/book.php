<?php
    $title = "Book Now";
    include __DIR__ . '/head.php';
    include __DIR__ . '/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Now</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">

<h1>Book Now</h1>

<div id="knob-container">
    <div id="knob">
        <div id="pointer"></div>
    </div>
</div>

<div class="radial-menu">
  <div id="knob1" class="knob1">☀️</div>
  <div id="radial-items"></div>
</div>

<form method="POST" action="/book">
    <input type="hidden" name="_token" value="<?= csrf_token(); ?>">

    <p>
        <label>Name</label><br>
        <input type="text" name="name" required>
    </p>

    <p>
        <label>Email</label><br>
        <input type="email" name="email" required>
    </p>
    <p>
        <label>Booking Date</label><br>
        <input type="hidden" id="booking_date" name="booking_date" required>
        <div>
            <button type="button" id="prevMonth">&lt; Prev</button>
            <span id="monthYear"></span>
            <button type="button" id="nextMonth">Next &gt;</button>
            <P>We only work on weekend<P>
        </div>
        <div id="calendar"></div>
    </p>
    <p>
        <label>Time:</label><br>
        <input type="time" name="booking_time" required>
    </p>

    <p>
        <label>Notes:</label><br>
        <textarea name="notes"></textarea>
    </p>

    <button type="submit">Submit Booking</button>
</form>

<style>
    #calendar { display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; margin-top: 10px; }
    .day { padding: 10px; border: 1px solid #ccc; text-align: center; cursor: pointer; }
    .booked { background-color: red; color: white; cursor: not-allowed; }
    .today { border: 2px solid #000; }
</style>

<script>
  // Pass PHP bookedDates to JS
  const bookedDates = <?php echo json_encode($bookedDates); ?>;

  // Calendar Rendering
  const calendarEl = document.getElementById("calendar");
  const today = new Date();
  let currentMonth = today.getMonth();
  let currentYear = today.getFullYear();

  function renderCalendar(month, year) {
    calendarEl.innerHTML = "";
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month+1, 0).getDate();

    for (let i=0; i<firstDay; i++) {
      calendarEl.innerHTML += `<div class="day empty"></div>`;
    }

    for (let day=1; day<=daysInMonth; day++) {
      const dateStr = new Date(year, month, day).toISOString().split("T")[0];
      const booked = bookedDates.includes(dateStr);
      const todayCheck = (day === today.getDate() && month===today.getMonth() && year===today.getFullYear());

      let classes = "day";
      if (booked) classes += " booked";
      if (todayCheck) classes += " today";

      calendarEl.innerHTML += `<div class="${classes}" data-date="${dateStr}">${day}</div>`;
    }

    document.querySelectorAll(".day").forEach(dayEl=>{
      if (!dayEl.classList.contains("booked") && !dayEl.classList.contains("empty")) {
        dayEl.addEventListener("click", ()=>{
          document.getElementById("booking_date").value = dayEl.dataset.date;
          alert("Selected: " + dayEl.dataset.date);
        });
      }
    });
  }
  renderCalendar(currentMonth, currentYear);

  // --- Radial Menu ---
  const knob1 = document.getElementById("knob1");
  const radialItems = document.getElementById("radial-items");
  let radialOpen = false;

  function getWeekendDays(month, year) {
    const weekends = [];
    const daysInMonth = new Date(year, month+1, 0).getDate();
    for (let d=1; d<=daysInMonth; d++) {
      const dateObj = new Date(year, month, d);
      const dow = dateObj.getDay();
      if (dow===0 || dow===6) {
        const dateStr = dateObj.toISOString().split("T")[0];
        weekends.push({ label: d, date: dateStr, booked: bookedDates.includes(dateStr) });
      }
    }
    return weekends;
  }

  function buildRadialMenu(month, year) {
    radialItems.innerHTML = "";
    const weekends = getWeekendDays(month, year);
    weekends.forEach((day, i)=>{
      const div = document.createElement("div");
      div.classList.add("menu-item");
      div.textContent = day.label;
      if (day.booked) {
        div.classList.add("booked");
      } else {
        div.classList.add("free");
        div.addEventListener("click", ()=>{
          document.getElementById("booking_date").value = day.date;
          alert("Selected: " + day.date);
        });
      }
      radialItems.appendChild(div);
    });
  }

  knob1.addEventListener("click", ()=>{
    radialOpen = !radialOpen;
    const items = document.querySelectorAll(".menu-item");
    items.forEach((item, i)=>{
      const angle = (i/items.length) * (2*Math.PI);
      const radius = 100;
      if (radialOpen) {
        const x = Math.cos(angle)*radius;
        const y = Math.sin(angle)*radius;
        item.style.transform = `translate(${x}px, ${y}px)`;
        item.style.opacity = "1";
        item.style.pointerEvents = "auto";
      } else {
        item.style.transform = `translate(-50%, -50%)`;
        item.style.opacity = "0";
        item.style.pointerEvents = "none";
      }
    });
  });

  buildRadialMenu(currentMonth, currentYear);
</script>

</body>
</html>

<?php include __DIR__ . '/footer.php'; ?>
