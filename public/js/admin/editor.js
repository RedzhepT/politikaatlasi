class Editor {
    constructor(options = {}) {
        this.contentField = document.getElementById(
            options.contentFieldId || "articleContent"
        );
        this.hiddenContent = document.getElementById(
            options.hiddenContentId || "hiddenContent"
        );
        this.titleField = document.getElementById(
            options.titleFieldId || "title"
        );
        this.hiddenTitle = document.getElementById(
            options.hiddenTitleId || "hiddenTitle"
        );
        this.authorField = document.getElementById(
            options.authorFieldId || "author"
        );
        this.hiddenAuthor = document.getElementById(
            options.hiddenAuthorId || "hiddenAuthor"
        );
        this.toolbar = document.getElementById(options.toolbarId || "toolbar");
        this.imageModal = document.getElementById(
            options.imageModalId || "imageModal"
        );
        this.uploadForm = document.getElementById(
            options.uploadFormId || "imageUploadForm"
        );
        this.uploadProgress = document.getElementById(
            options.uploadProgressId || "uploadProgress"
        );

        this.init();
    }

    init() {
        if (this.contentField && this.hiddenContent) {
            this.setupEventListeners();
            this.setupToolbar();
            this.setupImageUpload();
            this.syncContent();
        }

        if (this.titleField && this.hiddenTitle) {
            this.titleField.addEventListener("input", () => this.syncTitle());
        }

        if (this.authorField && this.hiddenAuthor) {
            this.authorField.addEventListener("input", () => this.syncAuthor());
        }
    }

    setupEventListeners() {
        this.contentField.addEventListener("input", () => this.syncContent());
        this.contentField.addEventListener("keydown", (e) =>
            this.handleKeyPress(e)
        );
    }

    setupToolbar() {
        if (this.toolbar) {
            this.toolbar.addEventListener("click", (e) => {
                const button = e.target.closest("button");
                if (!button) return;

                e.preventDefault();
                const command = button.dataset.command;
                const value = button.dataset.value || null;

                if (command === "image") {
                    this.showImageModal();
                } else if (command === "createLink") {
                    const url = prompt("Link URL giriniz:", "http://");
                    if (url) {
                        document.execCommand(command, false, url);
                    }
                } else {
                    document.execCommand(command, false, value);
                }

                this.contentField.focus();
            });
        }
    }

    setupImageUpload() {
        if (this.uploadForm) {
            this.uploadForm.addEventListener("submit", async (e) => {
                e.preventDefault();
                await this.handleImageUpload();
            });
        }
    }

    syncContent() {
        if (this.hiddenContent) {
            this.hiddenContent.value = this.contentField.innerHTML;
        }
    }

    syncTitle() {
        if (this.hiddenTitle) {
            this.hiddenTitle.value = this.titleField.textContent;
        }
    }

    syncAuthor() {
        if (this.hiddenAuthor) {
            this.hiddenAuthor.value = this.authorField.textContent;
        }
    }

    handleKeyPress(e) {
        if (e.key === "Tab") {
            e.preventDefault();
            document.execCommand(
                "insertHTML",
                false,
                "&nbsp;&nbsp;&nbsp;&nbsp;"
            );
        }
    }

    showImageModal() {
        if (this.imageModal) {
            this.imageModal.style.display = "block";
        }
    }

    hideImageModal() {
        if (this.imageModal) {
            this.imageModal.style.display = "none";
        }
    }

    async handleImageUpload() {
        const formData = new FormData(this.uploadForm);
        const file = formData.get("image");

        if (!file) {
            alert("Lütfen bir resim seçin");
            return;
        }

        try {
            this.uploadProgress.textContent = "Yükleniyor...";

            const response = await fetch("/admin/upload-image", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            });

            if (!response.ok) {
                throw new Error("Yükleme başarısız");
            }

            const data = await response.json();

            if (data.url) {
                const imgHtml = `<figure><img src="${data.url}" alt="Uploaded image"><figcaption>Resim açıklaması</figcaption></figure>`;
                document.execCommand("insertHTML", false, imgHtml);
                this.syncContent();
                this.hideImageModal();
                this.uploadForm.reset();
            }
        } catch (error) {
            console.error("Yükleme hatası:", error);
            this.uploadProgress.textContent =
                "Yükleme başarısız: " + error.message;
        }
    }
}

// Usage:
document.addEventListener("DOMContentLoaded", () => {
    const editor = new Editor({
        contentFieldId: "articleContent",
        hiddenContentId: "hiddenContent",
        titleFieldId: "title",
        hiddenTitleId: "hiddenTitle",
        authorFieldId: "author",
        hiddenAuthorId: "hiddenAuthor",
        toolbarId: "toolbar",
        imageModalId: "imageModal",
        uploadFormId: "imageUploadForm",
        uploadProgressId: "uploadProgress",
    });
});
