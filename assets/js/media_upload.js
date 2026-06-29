const fileInput = document.getElementById('browsemedia');
const videoFileInput = document.getElementById('browsevideos');
const imageCroppingArea = document.getElementById('image-cropping-area');
const croppedImages = document.getElementById('cropped-images');
const videoPreview = document.getElementById('video-preview');
const dragDropArea = document.getElementById('drag-drop-area');
let croppers = [];

// Hide cropping areas initially
window.onload = function () {
    imageCroppingArea.classList.add('d-none');
    croppedImages.classList.add('d-none');
};

// Function to initialize Cropper.js
function initializeCropper(imageElement, container) {
    const cropper = new Cropper(imageElement, {
        aspectRatio: 1.5,
        autoCropArea: 1,
        viewMode: 1,
    });
    croppers.push({ cropper, container });
}

// Function to handle cropping
function handleCrop(index) {
    const { cropper, container } = croppers[index];
    if (cropper) {
        const croppedCanvas = cropper.getCroppedCanvas();
        if (croppedCanvas) {
            const croppedImageURL = croppedCanvas.toDataURL('image/png');

            // Create a container for the cropped image
            const croppedImageContainer = document.createElement('div');
            croppedImageContainer.classList.add('position-relative', 'm-2', 'd-inline-block');

            // Create the cropped image element
            const croppedImage = document.createElement('img');
            croppedImage.src = croppedImageURL;
            croppedImage.classList.add('m-2', 'rounded', 'w-100');

            // Create the Remove button
            const removeButton = document.createElement('button');
            removeButton.textContent = 'Remove';
            removeButton.classList.add('btn', 'btn-danger', 'position-absolute', 'top-0', 'end-0', 'm-2');

            // Add remove functionality
            removeButton.addEventListener('click', () => croppedImageContainer.remove());

            // Append to CroppedImages
            croppedImageContainer.appendChild(croppedImage);
            croppedImageContainer.appendChild(removeButton);
            croppedImages.appendChild(croppedImageContainer);

            // Cleanup cropper instance and remove the original container
            cropper.destroy();
            container.remove();
        }
    }
}

// Function to skip cropping
function skipCrop(index) {
    const { cropper, container } = croppers[index];
    if (cropper) {
        const originalImageContainer = document.createElement('div');
        originalImageContainer.classList.add('position-relative', 'm-2', 'd-inline-block');

        const originalImage = document.createElement('img');
        originalImage.src = container.querySelector('img').src;
        originalImage.classList.add('m-2', 'rounded', 'w-100');

        // Create the Remove button
        const removeButton = document.createElement('button');
        removeButton.textContent = 'Remove';
        removeButton.classList.add('btn', 'btn-danger', 'position-absolute', 'top-0', 'end-0', 'm-2');

        // Add remove functionality
        removeButton.addEventListener('click', () => originalImageContainer.remove());

        // Append to CroppedImages
        originalImageContainer.appendChild(originalImage);
        originalImageContainer.appendChild(removeButton);
        croppedImages.appendChild(originalImageContainer);

        // Cleanup cropper instance and remove the original container
        cropper.destroy();
        container.remove();
    }
}

// Function to handle Image Preview and Cropping
function handleFileInput(files) {
    for (const file of files) {
        if (!file.type.startsWith("image/")) {
            alert("Invalid file type. Please select an image.");
            continue;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const imgContainer = document.createElement('div');
            imgContainer.classList.add('m-2', 'position-relative', 'border', 'p-2', 'rounded');

            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('w-100');

            const cropButton = document.createElement('button');
            const skipButton = document.createElement('button');
            cropButton.textContent = 'Crop';
            skipButton.textContent = 'Skip';

            cropButton.classList.add('btn', 'btn-primary', 'position-absolute', 'top-0', 'end-0', 'm-2');
            skipButton.classList.add('btn', 'btn-secondary', 'position-absolute', 'top-0', 'start-0', 'm-2');

            const currentIndex = croppers.length;
            cropButton.addEventListener('click', () => handleCrop(currentIndex));
            skipButton.addEventListener('click', () => skipCrop(currentIndex));

            img.onload = () => {
                imageCroppingArea.classList.remove('d-none');
                croppedImages.classList.remove('d-none');

                imgContainer.appendChild(img);
                imgContainer.appendChild(cropButton);
                imgContainer.appendChild(skipButton);
                imageCroppingArea.appendChild(imgContainer);
                initializeCropper(img, imgContainer);
            };
        };
        reader.readAsDataURL(file);
    }
}

// Function to handle Video Preview
function handleVideoFileInput(files) {
    for (const file of files) {
        if (!file.type.startsWith("video/")) {
            alert("Invalid file type. Please select a video.");
            continue;
        }

        const videoContainer = document.createElement('div');
        videoContainer.classList.add('m-2', 'p-2', 'border', 'rounded', 'position-relative');

        const videoElement = document.createElement('video');
        videoElement.src = URL.createObjectURL(file);
        videoElement.controls = true;
        videoElement.classList.add('w-100', 'rounded');

        const removeButton = document.createElement('button');
        removeButton.textContent = 'Remove';
        removeButton.classList.add('btn', 'btn-danger', 'position-absolute', 'top-0', 'end-0', 'm-2');

        removeButton.addEventListener('click', () => {
            URL.revokeObjectURL(videoElement.src);
            videoContainer.remove();
        });

        videoContainer.appendChild(videoElement);
        videoContainer.appendChild(removeButton);
        videoPreview.appendChild(videoContainer);
    }
}

// Event handlers
fileInput.addEventListener('change', () => handleFileInput(fileInput.files));
videoFileInput.addEventListener('change', () => handleVideoFileInput(videoFileInput.files));

// Drag and Drop
dragDropArea.addEventListener('dragover', (e) => e.preventDefault());
dragDropArea.addEventListener('drop', (event) => {
    event.preventDefault();
    handleFileInput(event.dataTransfer.files);
});
