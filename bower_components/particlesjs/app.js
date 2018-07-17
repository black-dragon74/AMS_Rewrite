/* -----------------------------------------------
/* How to use? : Check the GitHub README
/* ----------------------------------------------- */

/* To load a config file (particles.json) you need to host this demo (MAMP/WAMP/local)... */
/*
particlesJS.load('particles-js', 'particles.json', function() {
  console.log('particles.js loaded - callback');
});
*/

/* Otherwise just put the config content (json): */

particlesJS('particles-js',
  
  {
  "retina_detect": true,
  "interactivity": {
    "modes": {
      "push": {
        "particles_nb": 4
      },
      "bubble": {
        "size": 0,
        "opacity": 0,
        "speed": 3,
        "distance": 250,
        "duration": 2
      },
      "repulse": {
        "distance": 400,
        "duration": 0.40000000000000002
      },
      "grab": {
        "line_linked": {
          "opacity": 1
        },
        "distance": 400
      },
      "remove": {
        "particles_nb": 2
      }
    },
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": true,
        "mode": "bubble"
      },
      "onclick": {
        "enable": true,
        "mode": "repulse"
      },
      "resize": true
    }
  },
  "particles": {
    "number": {
      "value": 160,
      "density": {
        "enable": true,
        "value_area": 800
      }
    },
    "line_linked": {
      "opacity": 0.40000000000000002,
      "enable": false,
      "width": 1,
      "distance": 150,
      "color": "#ffffff"
    },
    "color": {
      "value": "#606060"
    },
    "size": {
      "value": 3,
      "anim": {
        "size_min": 0.29999999999999999,
        "enable": false,
        "speed": 4,
        "sync": false
      },
      "random": true
    },
    "move": {
      "random": true,
      "enable": true,
      "speed": 1,
      "bounce": false,
      "attract": {
        "enable": false,
        "rotateX": 600,
        "rotateY": 600
      },
      "out_mode": "out",
      "straight": false,
      "direction": "none"
    },
    "shape": {
      "polygon": {
        "nb_sides": 5
      },
      "stroke": {
        "width": 0,
        "color": "#000000"
      },
      "type": "circle",
      "image": {
        "src": "img/github.svg",
        "width": 100,
        "height": 100
      }
    },
    "opacity": {
      "value": 1,
      "anim": {
        "enable": true,
        "speed": 1,
        "opacity_min": 0,
        "sync": false
      },
      "random": true
    }
  }
}

);