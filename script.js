const dayNames = {
  0: "Sunday",
  1: "Monday",
  2: "Tuesday",
  3: "Wednesday",
  4: "Thursday",
  5: "Friday",
  6: "Saturday"
};

let menuData = {};
let selectedDay = new Date().getDay();

function getSubtitle(dayNumber) {
  const today = new Date().getDay();
  const diff = (dayNumber - today + 7) % 7;

  if (diff === 0) return "Today's Menu";
  if (diff === 1) return "Tomorrow's Menu";
  return `Menu in ${diff} days`;
}

function formatMealItems(items) {
  if (!items || items.length === 0) {
    return `<p class="description-ofbreakfast">No items available</p>`;
  }

  return items.map(item => {
    return `
      <p class="first-part">${item.item_name}</p>
      ${item.item_description && item.item_description.trim() !== ""
        ? `<p class="description-ofbreakfast">${item.item_description}</p>`
        : ""}
    `;
  }).join("");
}

function createMenuCard(dayNumber, dayMenu) {
  return `
    <div class="menus" data-day="${dayNumber}">
      <img src="calendar-regular-full.svg" alt="calendar icon" class="limeicon">

      <div class="monday">
        <p class="day"><i class="fa-regular fa-calendar"></i>${dayNames[dayNumber]}</p>
        <p class="menu-subtitle">${getSubtitle(Number(dayNumber))}</p>

        <p class="breakfast">Breakfast</p>
        <div class="description">
          ${formatMealItems(dayMenu.breakfast)}
        </div>

        <p class="lunch">Lunch</p>
        <div class="description">
          ${formatMealItems(dayMenu.lunch)}
        </div>

        <p class="dinner">Dinner</p>
        <div class="description">
          ${formatMealItems(dayMenu.dinner)}
        </div>
      </div>
    </div>
  `;
}

function renderMenus(clickedDay) {
  const container = document.getElementById("menuContainer");
  container.innerHTML = "";

  for (let i = 0; i < 3; i++) {
    const dayToShow = (clickedDay + i) % 7;
    const dayMenu = menuData[dayToShow] || {
      breakfast: [],
      lunch: [],
      dinner: []
    };

    container.innerHTML += createMenuCard(dayToShow, dayMenu);
  }
}

async function loadMenus() {
  try {
    const response = await fetch("get_menus.php");
    const data = await response.json();

    menuData = data.menus || {};
    document.getElementById("currentCycle").textContent = `Current cycle: ${data.cycle}`;

    renderMenus(selectedDay);
  } catch (error) {
    console.error("Error loading menus:", error);
    document.getElementById("currentCycle").textContent = "Failed to load menu data.";
  }
}

document.querySelectorAll(".btnrow button").forEach(button => {
  button.addEventListener("click", () => {
    selectedDay = Number(button.dataset.day);
    renderMenus(selectedDay);
  });
});

loadMenus();