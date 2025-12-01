// wrap everything in an IIFE so loading the same script multiple times won't cause duplicate-top-level-declaration errors
(function () {
    // Carousel Initialization (guarded)
    document.addEventListener("DOMContentLoaded", function () {
        const loungeCarousel = document.querySelector("#loungeCarousel");
        if (loungeCarousel) {
            try {
                // attempt to initialize the carousel (Bootstrap will handle duplicates)
                new bootstrap.Carousel(loungeCarousel, {
                    interval: 3000,
                    ride: "carousel",
                    pause: false,
                    wrap: true,
                });
            } catch (e) {
                // swallow init errors so a failing carousel doesn't break other scripts
                console.warn("Carousel init failed:", e);
            }
        }
    });

    // floating bubbles — defensive: check both known IDs
    var container =
        document.getElementById("gold-bubbles") ||
        document.getElementById("floating-bubbles");

    function createBubble() {
        var bubble = document.createElement("span");
        var size = Math.random() * 40 + 10; // 10px–50px

        bubble.classList.add("bubble");
        bubble.style.width = size + "px";
        bubble.style.height = size + "px";
        bubble.style.left = Math.random() * 100 + "vw";
        bubble.style.animationDuration = Math.random() * 5 + 5 + "s";

        if (container) {
            container.appendChild(bubble);
            setTimeout(function () {
                bubble.remove();
            }, 10000);
        }
    }

    setInterval(function () {
        if (container) createBubble();
    }, 400);
})();
