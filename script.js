const dayNames = {
  0: "Sunday",
  1: "Monday",
  2: "Tuesday",
  3: "Wednesday",
  4: "Thursday",
  5: "Friday",
  6: "Saturday"
};

let allMenus = {};
let selectedDay = new Date().getDay();

function getSubtitle(dayNumber) {
  const today = new Date().getDay();
  const diff = (dayNumber - today + 7) % 7;

  if (diff === 0) return "Today's Estimate Menu";
  if (diff === 1) return "Tomorrow's Estimate Menu";
  return `Menu in ${diff} days`;
}

function updateActiveButton(day) {
  const buttons = document.querySelectorAll(".btnrow button");

  buttons.forEach(button => {
    button.classList.remove("active-day");

    if (Number(button.dataset.day) === Number(day)) {
      button.classList.add("active-day");
    }
  });
}

function formatMealItems(items) {
  if (!items || items.length === 0) {
    return `<p class="first-part">No items available</p>`;
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

function formatMealStatus(source, note) {
  if (source === "override") {
    return `
      <div class="meal-status updated">
        <p class="status-badge">Updated Today</p>
        ${note && note.trim() !== ""
          ? `<p class="chef-note">Chef Note: ${note}</p>`
          : `<p class="chef-note">Chef Note: Menu adjusted based on ingredient availability.</p>`
        }
      </div>
    `;
  }

  return `
    <div class="meal-status planned">
      <p class="planned-text">Planned Menu</p>
    </div>
  `;
}

function createMealSection(title, items, source, note) {
  return `
    <p class="${title.toLowerCase()}">${title}</p>
    ${formatMealStatus(source, note)}
    <div class="description">
      ${formatMealItems(items)}
    </div>
  `;
}

function createMenuCard(dayNumber, dayMenu) {
  return `
    <div class="menus" data-day="${dayNumber}">
      <div class="card-icon">
        <img src="calendar-regular-full.svg" alt="calendar icon">
      </div>

      <p class="day"><i class="fa-regular fa-calendar"></i>${dayNames[dayNumber]}</p>
      <p class="menu-subtitle">${getSubtitle(dayNumber)}</p>
      <p class="menu-date">${dayMenu.date || ""}</p>

      ${createMealSection(
        "Breakfast",
        dayMenu.breakfast,
        dayMenu.breakfast_source,
        dayMenu.breakfast_note
      )}

      ${createMealSection(
        "Lunch",
        dayMenu.lunch,
        dayMenu.lunch_source,
        dayMenu.lunch_note
      )}

      ${createMealSection(
        "Dinner",
        dayMenu.dinner,
        dayMenu.dinner_source,
        dayMenu.dinner_note
      )}
    </div>
  `;
}

function renderMenus(startDay) {
  const menuContainer = document.getElementById("menuContainer");
  menuContainer.innerHTML = "";

  for (let i = 0; i < 3; i++) {
    const dayToShow = (startDay + i) % 7;

    const dayMenu = allMenus[dayToShow] || {
      date: "",
      breakfast: [],
      lunch: [],
      dinner: [],
      breakfast_note: "",
      lunch_note: "",
      dinner_note: "",
      breakfast_source: "planned",
      lunch_source: "planned",
      dinner_source: "planned"
    };

    menuContainer.innerHTML += createMenuCard(dayToShow, dayMenu);
  }

  updateActiveButton(startDay);
}

async function loadMenus() {
  try {
    const response = await fetch("get_menus.php?v=8");
    const data = await response.json();

    allMenus = data.menus || {};

    document.getElementById("currentCycle").textContent = `Current cycle: ${data.cycle}`;

    selectedDay = new Date().getDay();
    renderMenus(selectedDay);
  } catch (error) {
    console.error("Error loading menus:", error);
    document.getElementById("currentCycle").textContent = "Failed to load menu data";
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll(".btnrow button");

  buttons.forEach(button => {
    button.addEventListener("click", () => {
      selectedDay = Number(button.dataset.day);
      renderMenus(selectedDay);
    });
  });

  loadMenus();
});