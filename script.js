
  const buttons = document.querySelectorAll(".btnrow button");
  const menus = document.querySelectorAll(".menus");

  function showThreeDays(startDay) {
    menus.forEach(menu => menu.classList.remove("show"));
    buttons.forEach(button => button.classList.remove("active-day"));

    const activeButton = document.querySelector(`.btnrow button[data-day="${startDay}"]`);
    if (activeButton) {
      activeButton.classList.add("active-day");
    }

    for (let offset = 0; offset < 3; offset++) {
      const dayIndex = (startDay + offset) % menus.length;
      const menuToShow = document.querySelector(`.menus[data-day="${dayIndex}"]`);
      if (menuToShow) {
        menuToShow.classList.add("show");
      }
    }
  }

  buttons.forEach(button => {
    button.addEventListener("click", () => {
      const clickedDay = Number(button.dataset.day);
      showThreeDays(clickedDay);
    });
  });

  showThreeDays(0);
