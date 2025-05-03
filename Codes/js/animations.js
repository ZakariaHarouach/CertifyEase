// Register the ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger);

// Typing animation for the hero title
function typeHeroTitle() {
  const heroTitle = document.querySelector(".hero-title");
  const textArray = [
    "Welcome to CertiFy-Ease!",
    "Communicate with administration with ease and simplicity!!",
    "Your perfect solution for your educational needs!!",
    "More and more is coming soon!!",
  ];

  let currentTextIndex = 0;
  let currentIndex = 0;
  let fullText = textArray[currentTextIndex];

  function typeLetter() {
    if (currentIndex < fullText.length) {
      heroTitle.textContent += fullText[currentIndex];
      currentIndex++;
      setTimeout(typeLetter, 130);
    } else {
      setTimeout(() => {
        heroTitle.textContent = "";
        currentIndex = 0;
        currentTextIndex = (currentTextIndex + 1) % textArray.length;
        fullText = textArray[currentTextIndex];
        typeLetter();
      }, 2000);
    }
  }

  typeLetter();
}

// Trigger the hero title typing animation
ScrollTrigger.create({
  trigger: ".hero-section",
  start: "top 80%",
  onEnter: () => {
    typeHeroTitle();
  },
});

// Typing animation for the username
function typeUsername() {
  const username = document.querySelector(".username");
  const fullName = username.getAttribute("data-name");

  username.textContent = ""; // Clear initially

  // Create a scoped GSAP timeline for the username animation
  let usernameTimeline = gsap.timeline();

  for (let i = 0; i < fullName.length; i++) {
    usernameTimeline.to(username, {
      textContent: fullName.substring(0, i + 1),
      duration: 0.2,
      ease: "none",
    });
  }
}

// Trigger the username typing animation
ScrollTrigger.create({
  trigger: ".hello-msg",
  start: "top 80%",
  onEnter: () => {
    typeUsername();
  },
});

// Define animations for large screens
gsap.matchMedia().add("(min-width: 768px)", () => {
  // About Us Section Animation
  gsap.from("#aboutUS", {
    scrollTrigger: {
      trigger: "#aboutUS",
      start: "top 80%",
      end: "top 50%",
      scrub: 1,
    },
    opacity: 0,
    y: 50,
    duration: 1.5,
    ease: "power3.out",
  });

  // Animate the "About Us" section image (from left to right)
  gsap.from("#about-img", {
    scrollTrigger: {
      trigger: "#aboutUS",
      start: "center 90%",
      end: "center 50%",
      scrub: 1,
    },
    x: -100, // Move from the left
    opacity: 0,
    duration: 6,
    ease: "power3.out",
  });

  // Animate the "About Us" section title (from top to bottom)
  gsap.from("#about-title", {
    scrollTrigger: {
      trigger: "#aboutUS",
      start: "center 85%",
      end: "top 50%",
      scrub: 1,
    },
    y: -50, // Move from the top
    opacity: 0,
    duration: 6,
    ease: "power3.out",
  });

  // Animate the "About Us" section paragraphs (from bottom to top)
  gsap.from("#aboutUS p", {
    scrollTrigger: {
      trigger: "#aboutUS",
      start: "center 80%",
      end: "top 50%",
      scrub: 1,
    },
    y: 50, // Move from the bottom
    opacity: 0,
    stagger: 0.2, // Stagger animations for paragraphs
    duration: 6,
    ease: "power3.out",
  });
});

// Disable animations for small screens
gsap.matchMedia().add("(max-width: 767px)", () => {
  console.log("Animations disabled for small screens");
});

// Animate the footer section
gsap.from(".footer-bar", {
  scrollTrigger: {
    trigger: ".footer-bar",
    start: "center 95%",
    end: "center 30%",
    scrub: 1,
  },
  y: 50,
  opacity: 0,
  duration: 6,
  ease: "power3.out",
});

gsap.from(".footer .col-md-4", {
  scrollTrigger: {
    trigger: ".footer",
    start: "top 90%", // Animation starts when the footer is near the viewport
    end: "top 50%", // Animation ends as the footer moves up
    scrub: 1, // Smooth scrolling effect
  },
  y: 50, // Move from the bottom
  opacity: 0, // Start with invisible
  duration: 30, // Animation duration
  ease: "power3.out", // Smooth easing
  stagger: 30, // Delay between each column animation
});

