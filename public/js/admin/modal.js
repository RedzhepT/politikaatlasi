class Modal {
    constructor(modalId) {
        this.modal = document.getElementById(modalId);
        this.closeBtn = this.modal?.querySelector(".close");

        if (this.modal && this.closeBtn) {
            this.init();
        }
    }

    init() {
        // Close button click handler
        this.closeBtn.addEventListener("click", () => this.hide());

        // Click outside modal to close
        window.addEventListener("click", (e) => {
            if (e.target === this.modal) {
                this.hide();
            }
        });

        // ESC key to close
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape" && this.isVisible()) {
                this.hide();
            }
        });
    }

    show() {
        if (this.modal) {
            this.modal.style.display = "block";
            document.body.style.overflow = "hidden"; // Prevent background scrolling
        }
    }

    hide() {
        if (this.modal) {
            this.modal.style.display = "none";
            document.body.style.overflow = ""; // Restore scrolling
        }
    }

    isVisible() {
        return this.modal?.style.display === "block";
    }

    // Optional: Add content dynamically
    setContent(content) {
        const contentContainer = this.modal?.querySelector(".modal-content");
        if (contentContainer) {
            contentContainer.innerHTML = content;
        }
    }
}

// Usage example:
document.addEventListener("DOMContentLoaded", () => {
    // Initialize modals
    const imageModal = new Modal("imageModal");

    // Example: Show modal on button click
    const showModalBtn = document.querySelector('[data-command="image"]');
    if (showModalBtn) {
        showModalBtn.addEventListener("click", () => imageModal.show());
    }
});
