// Carousel Initialization
  document.addEventListener("DOMContentLoaded", function () {
    const loungeCarousel = document.querySelector("#loungeCarousel");
    const carousel = new bootstrap.Carousel(loungeCarousel, {
      interval: 3000,  // Change every 3 seconds
      ride: "carousel", // Auto-starts
      pause: false,     // Keeps running even on hover (optional)
      wrap: true        // Loops back to first slide
    });
  });


    // floating bubbles

   
    const container = document.getElementById("floating-bubbles");

    function createBubble() {
        const bubble = document.createElement("span");
        const size = Math.random() * 40 + 10; // 10px–50px

        bubble.classList.add("bubble");
        bubble.style.width = size + "px";
        bubble.style.height = size + "px";

        bubble.style.left = Math.random() * 100 + "vw";

        bubble.style.animationDuration = (Math.random() * 5 + 5) + "s";

        container.appendChild(bubble);

        setTimeout(() => bubble.remove(), 10000);
    }

    setInterval(createBubble, 400);


 