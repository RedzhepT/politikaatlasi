/**
 * Template Name: Impact
 * Updated: Jan 09 2024 with Bootstrap v5.3.2
 * Template URL: https://bootstrapmade.com/impact-bootstrap-business-website-template/
 * Author: BootstrapMade.com
 * License: https://bootstrapmade.com/license/
 */
document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    /**
     * Preloader
     */
    const preloader = document.querySelector("#preloader");
    if (preloader) {
        window.addEventListener("load", () => {
            preloader.remove();
        });
    }

    /**
     * Sticky Header on Scroll
     */
    const selectHeader = document.querySelector("#header");
    if (selectHeader) {
        let headerOffset = selectHeader.offsetTop;
        let nextElement = selectHeader.nextElementSibling;

        const headerFixed = () => {
            if (headerOffset - window.scrollY <= 0) {
                selectHeader.classList.add("sticked");
                if (nextElement)
                    nextElement.classList.add("sticked-header-offset");
            } else {
                selectHeader.classList.remove("sticked");
                if (nextElement)
                    nextElement.classList.remove("sticked-header-offset");
            }
        };
        window.addEventListener("load", headerFixed);
        document.addEventListener("scroll", headerFixed);
    }

    /**
     * Mobile nav toggle
     */
    const mobileNavToggle = document.querySelector(".mobile-nav-toggle");
    const navbar = document.querySelector("#navbar");

    if (mobileNavToggle) {
        // Hamburger menü tıklama
        mobileNavToggle.addEventListener("click", function (e) {
            e.stopPropagation(); // Event'in document'a ulaşmasını engelle
            toggleMenu();
        });

        // Dokümana tıklandığında menüyü kapat
        document.addEventListener("click", function (e) {
            if (
                navbar.classList.contains("mobile-nav-active") &&
                !navbar.contains(e.target) &&
                !mobileNavToggle.contains(e.target)
            ) {
                toggleMenu();
            }
        });

        // Menü içindeki linklere tıklandığında menüyü kapat
        document.querySelectorAll("#navbar a").forEach((navbarlink) => {
            navbarlink.addEventListener("click", () => {
                if (window.innerWidth < 576) {
                    toggleMenu();
                }
            });
        });
    }

    // Menüyü aç/kapat
    function toggleMenu() {
        navbar.classList.toggle("mobile-nav-active");
        mobileNavToggle.classList.toggle("bi-list");
        mobileNavToggle.classList.toggle("bi-x");
    }

    // Dropdown kontrolü
    const dropdownElementList = document.querySelectorAll(".dropdown-toggle");
    if (dropdownElementList.length > 0) {
        dropdownElementList.forEach((dropdownToggle) => {
            dropdownToggle.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation(); // Event'in document'a ulaşmasını engelle
                const dropdownMenu = this.nextElementSibling;
                if (dropdownMenu.classList.contains("show")) {
                    dropdownMenu.classList.remove("show");
                } else {
                    // Diğer açık menüleri kapat
                    document
                        .querySelectorAll(".dropdown-menu.show")
                        .forEach((menu) => {
                            menu.classList.remove("show");
                        });
                    dropdownMenu.classList.add("show");
                }
            });
        });

        // Sayfa herhangi bir yerine tıklandığında menüyü kapat
        document.addEventListener("click", function (e) {
            // Dropdown toggle veya menü içine tıklanmadıysa kapat
            if (
                !e.target.closest(".dropdown") &&
                !e.target.closest(".dropdown-menu")
            ) {
                document
                    .querySelectorAll(".dropdown-menu.show")
                    .forEach((menu) => {
                        menu.classList.remove("show");
                    });
            }
        });

        // Mobil menüde dropdown tıklaması
        const mobileDropdown = document.querySelector("#mobileUserDropdown");
        if (mobileDropdown) {
            mobileDropdown.addEventListener("click", function (e) {
                if (window.innerWidth < 992) {
                    e.stopPropagation();
                }
            });
        }
    }

    // Mobil dropdown kontrolü
    const mobileDropdowns = document.querySelectorAll(
        ".mobile-dropdown-toggle"
    );
    mobileDropdowns.forEach((toggle) => {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            const menu = this.nextElementSibling;
            const isExpanded = menu.classList.contains("show");

            // Diğer açık menüleri kapat
            document
                .querySelectorAll(".mobile-dropdown-menu.show")
                .forEach((m) => m !== menu && m.classList.remove("show"));

            // Tıklanan menüyü aç/kapat
            menu.classList.toggle("show");
            this.setAttribute("aria-expanded", !isExpanded);
        });
    });

    // Mobil dropdown dışına tıklandığında kapat
    document.addEventListener("click", function (e) {
        if (!e.target.closest(".mobile-dropdown-toggle")) {
            document
                .querySelectorAll(".mobile-dropdown-menu.show")
                .forEach((menu) => menu.classList.remove("show"));
        }
    });
});
