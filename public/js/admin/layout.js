document.addEventListener("DOMContentLoaded", () => {
    // Sidebar toggle functionality
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");
    const content = document.getElementById("content");

    if (sidebarToggle && sidebar && content) {
        sidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            content.classList.toggle("expanded");

            // Save state to localStorage
            const isCollapsed = sidebar.classList.contains("collapsed");
            localStorage.setItem("sidebarCollapsed", isCollapsed);
        });

        // Restore sidebar state from localStorage
        const isCollapsed = localStorage.getItem("sidebarCollapsed") === "true";
        if (isCollapsed) {
            sidebar.classList.add("collapsed");
            content.classList.add("expanded");
        }
    }

    // Mobile sidebar functionality
    const mobileToggle = document.getElementById("mobileToggle");
    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener("click", () => {
            sidebar.classList.toggle("active");
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener("click", (e) => {
            if (window.innerWidth <= 768) {
                const isClickInside =
                    sidebar.contains(e.target) ||
                    mobileToggle.contains(e.target);

                if (!isClickInside && sidebar.classList.contains("active")) {
                    sidebar.classList.remove("active");
                }
            }
        });
    }

    // Handle window resize
    let resizeTimer;
    window.addEventListener("resize", () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (window.innerWidth > 768) {
                sidebar?.classList.remove("active");
            }
        }, 250);
    });

    // Active menu item highlighting
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll("#sidebar .nav-link");

    menuItems.forEach((item) => {
        const href = item.getAttribute("href");
        if (href && currentPath.startsWith(href)) {
            item.classList.add("active");
            // Expand parent menu item if exists
            const parentMenu = item.closest(".nav-item.has-submenu");
            if (parentMenu) {
                parentMenu.classList.add("show");
            }
        }
    });

    // Submenu toggle functionality
    const submenus = document.querySelectorAll(".has-submenu");
    submenus.forEach((menu) => {
        const toggle = menu.querySelector(".submenu-toggle");
        if (toggle) {
            toggle.addEventListener("click", (e) => {
                e.preventDefault();
                menu.classList.toggle("show");
            });
        }
    });
});
