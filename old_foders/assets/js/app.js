particlesJS(
  "particles-js",

  {
    particles: {
      number: {
        value: 100, // Keep the same number of particles
        density: {
          enable: true,
          value_area: 800
        }
      },
      color: {
        value: "#ff6347" // Keep vibrant color for particles
      },
      shape: {
        type: "star", // Star-shaped particles for a cool effect
        stroke: {
          width: 0,
          color: "#ff6347"
        },
        polygon: {
          nb_sides: 5
        },
        image: {
          src: "img/github.svg", // Optional: replace with your own image or logo
          width: 50,
          height: 50
        }
      },
      opacity: {
        value: 0.8, // Slightly opaque particles
        random: true, // Random opacity for more variation
        anim: {
          enable: true,
          speed: 1, // Speed up opacity change
          opacity_min: 0.3,
          sync: false
        }
      },
      size: {
        value: 6, // Larger particles
        random: true, // Random size for variation
        anim: {
          enable: true,
          speed: 2, // Faster speed for size changes
          size_min: 3,
          sync: false
        }
      },
      line_linked: {
        enable: true,
        distance: 150,
        color: "#ff6347", // Consistent line color
        opacity: 0.4, // Slightly more visible lines
        width: 1,
        anim: {
          enable: true,
          speed: 2, // Faster speed for line linking
          opacity: 0.4,
          sync: false
        }
      },
      move: {
        enable: true,
        speed: 2, // Increased speed for particle movement
        direction: "random",
        random: true,
        straight: false,
        out_mode: "out",
        attract: {
          enable: false
        }
      }
    },
    interactivity: {
      detect_on: "canvas",
      events: {
        onhover: {
          enable: true,
          mode: "bubble" // Bubble effect on hover for interaction
        },
        onclick: {
          enable: true,
          mode: "push" // Push particles on click
        },
        resize: true
      },
      modes: {
        grab: {
          distance: 400,
          line_linked: {
            opacity: 1
          }
        },
        bubble: {
          distance: 200,
          size: 40, // Bubble effect size
          duration: 2, // Faster bubble expansion
          opacity: 0.8,
          speed: 2 // Faster speed for bubble effect
        },
        repulse: {
          distance: 100
        },
        push: {
          particles_nb: 4
        },
        remove: {
          particles_nb: 2
        }
      }
    },
    retina_detect: true,
    config_demo: {
      hide_card: false,
      background_color: "#222222", // Dark background for contrast
      background_image: "linear-gradient(to right, #ff7e5f, #feb47b)", // Smooth gradient background
      background_position: "50% 50%",
      background_repeat: "no-repeat",
      background_size: "cover"
    }
  }
);
