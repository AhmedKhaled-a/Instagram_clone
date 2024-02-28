
const fileInput = document.getElementById("images");
const token = document.querySelector(`meta[name=csrf-token]`).getAttribute('content');


const BASE_URL = "http://localhost:8000";

fileInput.addEventListener("change" ,(event) => {
    /**
     * 
     * reset preivew images
     */
    resetImages();
    /**
     * Count the number of files selected.
     */
    let imageFiles = event.target.files;

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
        preview.classList = "preview added-images"; 
        /**
         * Create an image
         */
        image = document.createElement("img");
        image.classList = "preview-selected-image";
        image.src = imageSrc;

        preview.insertAdjacentElement("afterbegin" , image);
        preview.style.display = "block";
        container.insertAdjacentElement("beforeend" , preview);
        imageCounter--;
    }
});

function imageClick (target) {
    let imageId = (target.children)[0].getAttribute("id"); 
    console.log(imageId);
    target.remove();
    if(imageId != undefined)
        sendDeleteReq(imageId);
}

function sendDeleteReq(imageId) {
    // await fetch(BASE_URL + '/api/images/' + imageId, {
    //     method: 'DELETE',
    // }).then((res) => {
    // console.log(res);
    // }); 
    
    $.ajax({
        type: "DELETE",
        url: `/api/images/${imageId}`,
        dataType: 'JSON',
        contentType: "application/json",
        headers: {'X-CSRF-TOKEN': token},
        cache: false,
        processData: false,
        success: function() {
            console.log("Done");
        }
      })
}

function resetImages() {
    let images = document.querySelectorAll(".added-images");
    images.forEach((image) => {
        image.remove();
    });
}

// function postClick(target) {
//     window.open(BASE_URL + '/posts/' + target.getAttribute("id"));
// }