document.addEventListener("DOMContentLoaded", () => {
    const hamburger = document.querySelector(".hamburger");
    const navLinks = document.querySelector(".nav-links");
    const dropdownToggles = document.querySelectorAll(".services > a, .autotransport > a");

    // Toggle Mobile Menu
    const toggleMobileMenu = (event) => {
        navLinks.classList.toggle("active");
        hamburger.setAttribute("aria-expanded", navLinks.classList.contains("active"));
        event.stopPropagation();
    };

    // Toggle Dropdown Menus
    const toggleDropdown = (event) => {
        event.preventDefault();
        const parent = event.target.closest("li");

        document.querySelectorAll(".nav-links li.active").forEach((item) => {
            if (item !== parent) item.classList.remove("active");
        });

        parent.classList.toggle("active");
        event.stopPropagation();
    };

    // Close Mobile Menu on Outside Click (Preserve Current Page Highlight)
    const closeMobileMenu = (event) => {
        if (!navLinks.contains(event.target) && !hamburger.contains(event.target)) {
            navLinks.classList.remove("active");
            hamburger.setAttribute("aria-expanded", "false");

            document.querySelectorAll(".nav-links li.active").forEach(item => {
                if (!item.classList.contains("current-page")) {
                    item.classList.remove("active");
                }
            });
        }
    };

    // Close Submenus When Clicking Outside (Preserve Current Page Highlight)
    const closeSubmenusOutside = (event) => {
        if (!navLinks.contains(event.target) && !event.target.closest(".services > a, .autotransport > a")) {
            document.querySelectorAll(".nav-links li.active").forEach(item => {
                if (!item.classList.contains("current-page")) {
                    item.classList.remove("active");
                }
            });
        }
    };

    // Detect Current Page and Highlight It
    document.querySelectorAll(".nav-links li a").forEach(link => {
        if (link.href === window.location.href) {
            link.parentElement.classList.add("current-page");
        }
    });

    // Event Listeners
    hamburger.addEventListener("click", toggleMobileMenu);
    dropdownToggles.forEach(toggle => toggle.addEventListener("click", toggleDropdown));
    document.addEventListener("click", closeMobileMenu);
    document.addEventListener("click", closeSubmenusOutside);

    /* ============================
        Real-time Form Validation
    ============================ */

    const form = document.getElementById("contact-form");
    if (form) {
        const inputs = form.querySelectorAll("input[required], textarea[required]");

        inputs.forEach(input => {
            input.addEventListener("input", function () {
                if (this.checkValidity()) {
                    this.classList.remove("error");
                    this.classList.add("valid");
                } else {
                    this.classList.remove("valid");
                    this.classList.add("error");
                }
            });

            input.addEventListener("blur", function () {
                if (!this.checkValidity()) {
                    this.classList.add("error");
                }
            });
        });
    }
});

