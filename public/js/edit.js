


const previewImage = (event) => {
    /**
     * Get the selected files.
     */
    const imageFiles = event.target.files;
    console.log(imageFiles);
    /**
     * Count the number of files selected.
     */
    const imageFilesLength = imageFiles.length;
    /**
     * If at least one image is selected, then proceed to display the preview.
     */
    let image = null;
    let preview = null;
    let container = document.querySelector(".image-preview-container");
    let imageCounter = imageFilesLength;
    while(imageCounter > 0) {
        /**
         * Get the image path.
         */
        const imageSrc = URL.createObjectURL(imageFiles[imageFilesLength - imageCounter]);

        /**
         * Create a div
         */
        preview = document.createElement("div");
        preview.classList = "preview"; 
        /**
         * Create an image
         */
        let image = document.createElement("img");
        image.id = "preview-selected-image";
        image.src = imageSrc;
        preview.insertAdjacentElement("afterbegin" , image);
        preview.style.display = "block";
        container.insertAdjacentElement("beforeend" , preview);
        imageCounter--;
    }
};