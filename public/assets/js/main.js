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
});
