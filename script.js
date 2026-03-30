const buttons = document.querySelectorAll(".btnrow button");
const menus = document.querySelectorAll(".menus");
const menuContainer = document.querySelector(".menu-container");

function getMenuLabel(cardDay, today) {
  const diff = (cardDay - today + 7) % 7;

  if (diff === 0) return "Today's Menu";
  if (diff === 1) return "Tomorrow's Menu";
  if (diff === 2) return "Menu in 2 days";
  return `Menu in ${diff} days`;
}

function updateSubtitles() {
  const today = new Date().getDay();

  menus.forEach(menu => {
    const cardDay = Number(menu.dataset.day);
    const subtitle = menu.querySelector(".menu-subtitle");

    if (subtitle) {
      subtitle.textContent = getMenuLabel(cardDay, today);
    }
  });
}

function showThreeDays(startDay) {
  menus.forEach(menu => menu.classList.remove("show"));
  buttons.forEach(button => button.classList.remove("active-day"));

  const activeButton = document.querySelector(`.btnrow button[data-day="${startDay}"]`);
  if (activeButton) {
    activeButton.classList.add("active-day");
  }

  const daysToShow = [];

  for (let offset = 0; offset < 3; offset++) {
    const dayIndex = (startDay + offset) % 7;
    const menuToShow = document.querySelector(`.menus[data-day="${dayIndex}"]`);

    if (menuToShow) {
      menuToShow.classList.add("show");
      daysToShow.push(menuToShow);
    }
  }

  daysToShow.forEach(menu => {
    menuContainer.appendChild(menu);
  });
}

buttons.forEach(button => {
  button.addEventListener("click", () => {
    const clickedDay = Number(button.dataset.day);
    showThreeDays(clickedDay);
  });
});

updateSubtitles();

const today = new Date().getDay();
showThreeDays(today);