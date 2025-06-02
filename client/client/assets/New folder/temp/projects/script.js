$(document).ready(function () {
  // Toggle menu on click
  $("#menu").click(function () {
    $(this).toggleClass("fa-times");
    $(".navbar").toggleClass("nav-toggle");
  });

  // Scroll and load event handler
  $(window).on("scroll", function () {
    if (window.scrollY > 60) {
      $("#scroll-top").addClass("active");
    } else {
      $("#scroll-top").removeClass("active");
    }
  });

  $(window).on("load", function () {
    // Ensure menu is closed on page load
    $("#menu").removeClass("fa-times");
    $(".navbar").removeClass("nav-toggle");
  });
});

// Handle document visibility changes (tab switching)
document.addEventListener("visibilitychange", function () {
  if (document.visibilityState === "visible") {
    document.title = "Projects | Portfolio Jigar Sable";
    $("#favicon").attr("href", "/assets/images/favicon.png");
  } else {
    document.title = "Come Back To Portfolio";
    $("#favicon").attr("href", "/assets/images/favhand.png");
  }
});

// Fetch projects from JSON
function getProjects() {
  return fetch("projects.json")
    .then((response) => {
      if (!response.ok) {
        throw new Error("Failed to fetch projects");
      }
      return response.json();
    })
    .catch((error) => {
      console.error(error);
      alert("Failed to load projects. Please try again later.");
      return [];
    });
}

// Display projects
function showProjects(projects) {
  const projectsContainer = document.querySelector(".work .box-container");
  let projectsHTML = "";

  projects.forEach((project) => {
    projectsHTML += `
      <div class="grid-item ${project.category}">
        <div class="box tilt" style="width: 380px; margin: 1rem">
          <img draggable="false" src="/assets/images/projects/${project.image}.png" alt="project" />
          <div class="content">
            <div class="tag">
              <h3>${project.name}</h3>
            </div>
            <div class="desc">
              <p>${project.desc}</p>
              <div class="btns">
                <a href="${project.links.view}" class="btn" target="_blank"><i class="fas fa-eye"></i> View</a>
                <a href="${project.links.code}" class="btn" target="_blank">Code <i class="fas fa-code"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>`;
  });

  projectsContainer.innerHTML = projectsHTML;

  // Initialize Isotope filtering
  const $grid = $(".box-container").isotope({
    itemSelector: ".grid-item",
    layoutMode: "fitRows",
    masonry: {
      columnWidth: 200
    }
  });

  // Filter projects based on button click
  $(".button-group").on("click", "button", function () {
    $(".button-group").find(".is-checked").removeClass("is-checked");
    $(this).addClass("is-checked");
    const filterValue = $(this).attr("data-filter");
    $grid.isotope({ filter: filterValue });
  });
}

// Fetch and display projects
getProjects().then((data) => {
  showProjects(data);
});

// Tawk.to Live Chat integration
(function () {
  var s1 = document.createElement("script"),
    s0 = document.getElementsByTagName("script")[0];
  s1.async = true;
  s1.src = "https://embed.tawk.to/60df10bf7f4b000ac03ab6a8/1f9jlirg6";
  s1.charset = "UTF-8";
  s1.setAttribute("crossorigin", "*");
  s0.parentNode.insertBefore(s1, s0);
})();

// Disable developer tools using key combinations
document.onkeydown = function (e) {
  const blockedKeys = [
    { key: 123 }, // F12
    { ctrl: true, shift: true, key: "I" },
    { ctrl: true, shift: true, key: "C" },
    { ctrl: true, shift: true, key: "J" },
    { ctrl: true, key: "U" }
  ];

  const isBlocked = blockedKeys.some(({ key, ctrl, shift }) => {
    return (
      (e.keyCode === key || e.key === key) &&
      (ctrl === undefined || e.ctrlKey === ctrl) &&
      (shift === undefined || e.shiftKey === shift)
    );
  });

  if (isBlocked) {
    return false;
  }
};
