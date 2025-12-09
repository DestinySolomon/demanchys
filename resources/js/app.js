require("dotenv").config(); // This must be at the very top

console.log(
    "Paystack Secret Key:",
    process.env.PAYSTACK_SECRET_KEY ? "Loaded ✓" : "NOT LOADED ✗"
);
console.log(
    "Key preview:",
    process.env.PAYSTACK_SECRET_KEY?.substring(0, 15) + "..."
);

import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
