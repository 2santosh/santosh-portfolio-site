document.addEventListener("DOMContentLoaded", () => {
  initNavOpener();
  initSkillsSlider();
  initCVDownload();
  initCopyButtons();
});

function initNavOpener() {
  const navOpener = document.querySelector(".nav-opener");
  navOpener?.addEventListener("click", () => {
    document
      .querySelector(".header .container")
      ?.classList.toggle("nav-active");
  });
}

function initSkillsSlider() {
  const prevBtn = document.querySelector(".prev");
  const nextBtn = document.querySelector(".next");
  const skillsContainer = document.querySelector(".skills-container");
  const skillsItems = document.querySelectorAll(".skill");

  let currentIndex = 0;
  const totalItems = skillsItems.length;
  const itemsPerSlide = 3;
  const itemWidth = skillsItems[0]?.offsetWidth + 20;

  let autoSlideInterval = setInterval(nextSlide, 3000);

  function updateSlider() {
    if (itemWidth && skillsContainer) {
      const offset = -(currentIndex * itemWidth);
      skillsContainer.style.transform = `translateX(${offset}px)`;
    }
  }

  function nextSlide() {
    currentIndex =
      currentIndex < totalItems / itemsPerSlide - 1 ? currentIndex + 1 : 0;
    updateSlider();
  }

  function prevSlide() {
    currentIndex =
      currentIndex > 0
        ? currentIndex - 1
        : Math.floor(totalItems / itemsPerSlide) - 1;
    updateSlider();
  }

  nextBtn?.addEventListener("click", () => {
    clearInterval(autoSlideInterval);
    nextSlide();
    autoSlideInterval = setInterval(nextSlide, 3000);
  });

  prevBtn?.addEventListener("click", () => {
    clearInterval(autoSlideInterval);
    prevSlide();
    autoSlideInterval = setInterval(nextSlide, 3000);
  });

  let isMouseDown = false,
    startX,
    scrollLeft;

  skillsContainer?.addEventListener("mousedown", (e) => {
    isMouseDown = true;
    startX = e.pageX - skillsContainer.offsetLeft;
    scrollLeft = skillsContainer.scrollLeft;
  });

  skillsContainer?.addEventListener("mouseleave", () => (isMouseDown = false));
  skillsContainer?.addEventListener("mouseup", () => (isMouseDown = false));
  skillsContainer?.addEventListener("mousemove", (e) => {
    if (!isMouseDown) return;
    e.preventDefault();
    const x = e.pageX - skillsContainer.offsetLeft;
    const walk = (x - startX) * 2;
    skillsContainer.scrollLeft = scrollLeft - walk;
  });

  let touchStartX = 0,
    touchEndX = 0;

  skillsContainer?.addEventListener("touchstart", (e) => {
    touchStartX = e.changedTouches[0].pageX;
  });

  skillsContainer?.addEventListener("touchend", (e) => {
    touchEndX = e.changedTouches[0].pageX;
    if (touchStartX > touchEndX + 50) nextSlide();
    else if (touchStartX < touchEndX - 50) prevSlide();
  });

  updateSlider();
}

function initCVDownload() {
  const downloadCVBtn = document.getElementById("downloadCVBtn");
  downloadCVBtn?.addEventListener("click", (event) => {
    event.preventDefault();
    const link = document.createElement("a");
    link.href = "/assets/files/cv.pdf";
    link.download = "My_CV.pdf";
    link.click();
  });
}

function initCopyButtons() {
  document.querySelectorAll(".copy-btn").forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();
      const textToCopy = document.getElementById(this.dataset.copy)?.innerText;

      if (textToCopy) {
        navigator.clipboard
          .writeText(textToCopy)
          .then(() => {
            alert("Copied to clipboard: " + textToCopy);
          })
          .catch((err) => {
            console.error("Failed to copy text: ", err);
          });
      }
    });
  });
}
