<?php
$UserId = $this->session->userdata('user_id');

$ExistingDocs = $this->getlist_model->getFieldsMultipleConditions('tbl_documents', '*', "WHERE Reference='Properties' AND ReferenceId='$PropertyId'", 0);
if (!is_array($ExistingDocs)) $ExistingDocs = [];

$existingImages = [];
$existingVideos = [];
foreach ($ExistingDocs as $doc) {
    $ext = strtolower(pathinfo($doc->FileName, PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        $existingImages[] = $doc;
    } else if (in_array($ext, ['mp4', 'webm', 'ogg', 'mov', 'avi'])) {
        $existingVideos[] = $doc;
    }
}
?>

<style>
    .upload-box {
        border: 2px dashed #a5b4fc;
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        background-color: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .upload-box:hover, .upload-box.dragover {
        background-color: #e0e7ff;
        border-color: #6366f1;
    }
    .upload-icon {
        font-size: 48px;
        color: #818cf8;
        margin-bottom: 15px;
    }
    .upload-text {
        color: #4f46e5;
        font-weight: 600;
        font-size: 16px;
    }
    .upload-subtext {
        color: #64748b;
        font-size: 13px;
        margin-top: 5px;
    }
    .file-item {
        background: #f1f5f9;
        border-radius: 8px;
        padding: 12px 15px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #e2e8f0;
    }
    .file-item-left {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
        min-width: 0;
    }
    .file-icon {
        color: #6366f1;
        font-size: 24px;
        width: 30px;
        text-align: center;
    }
    .file-info {
        flex: 1;
        min-width: 0;
    }
    .file-name {
        font-weight: 600;
        color: #334155;
        margin-bottom: 2px;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .file-meta {
        font-size: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .file-item-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .hidden-file-input {
        display: none !important;
    }
    .feature-radio {
        transform: scale(1.2);
        cursor: pointer;
    }
</style>

<div class="dashboard-container pt-4">
    <div class="dashboard-card">
        <div class="card-header">
            <h2 class="section-title">Media Uploads</h2>
        </div>
        <div class="card-body p-4 property-form" id="divContent">
            <?= form_open_multipart('Documents/UploadDocuments/Properties/'.$PropertyId, ['id' => 'frmUploadMedia']) ?>
                
                <div class="row g-4">
                    <!-- Images Upload Section -->
                    <div class="col-md-6">
                        <label class="fw-bold mb-3 fs-5"><i class="fa-regular fa-image me-2 text-primary"></i>Upload Images <span class="text-danger">(atleast 1 image is required)</span></label>
                        
                        <div class="upload-box" id="imageDropzone">
                            <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                            <div class="upload-text">Browse files to upload</div>
                            <div class="upload-subtext">Drag and drop images here</div>
                        </div>
                        <input type="file" id="imageInput" name="images[]" accept="image/*" multiple class="hidden-file-input" <?= count($existingImages) > 0 ? '' : 'required data-parsley-required-message="At least one image is required"' ?>>
                        <input type="hidden" class="form-control" name="txtReferenceId" value="<?= $UserId; ?>">
                        <div id="preview-container-image" class="file-list mt-4">
                            <?php foreach($existingImages as $idx => $img): ?>
                                <div class="file-item" id="doc_<?= $img->DocumentId ?>">
                                    <div class="file-item-left">
                                        <img src="<?= base_url('uploads/Properties/'.$PropertyId.'/images/'.$img->FileName) ?>" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                        <div class="file-info">
                                            <div class="file-name" title="<?= $img->FileName ?>"><?= $img->FileName ?></div>
                                            <div class="file-meta">
                                                <span><?= number_format($img->FileSize, 2) ?> KB</span>
                                                <span class="text-success"><i class="fa-solid fa-check me-1"></i> Uploaded</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="file-item-right">
                                        <button type="button" class="btn btn-sm btn-light text-danger remove-existing-doc" data-id="<?= $img->DocumentId ?>"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Videos Upload Section -->
                    <div class="col-md-6">
                        <label class="fw-bold mb-3 fs-5"><i class="fa-solid fa-video me-2 text-primary"></i>Upload Videos</label>
                        
                        <div class="upload-box" id="videoDropzone">
                            <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                            <div class="upload-text">Browse files to upload</div>
                            <div class="upload-subtext">Drag and drop videos here</div>
                        </div>
                        <input type="file" id="videoInput" name="videos[]" accept="video/*" multiple class="hidden-file-input">
                        <div id="preview-container-video" class="file-list mt-4">
                            <?php foreach($existingVideos as $idx => $vid): ?>
                                <div class="file-item" id="doc_<?= $vid->DocumentId ?>">
                                    <div class="file-item-left">
                                        <div class="file-icon"><i class="fa-solid fa-file-video"></i></div>
                                        <div class="file-info">
                                            <div class="file-name" title="<?= $vid->FileName ?>"><?= $vid->FileName ?></div>
                                            <div class="file-meta">
                                                <span><?= number_format($vid->FileSize, 2) ?> KB</span>
                                                <span class="text-success"><i class="fa-solid fa-check me-1"></i> Uploaded</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="file-item-right">
                                        <button type="button" class="btn btn-sm btn-light text-danger remove-existing-doc" data-id="<?= $vid->DocumentId ?>"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center gap-5 mt-5">
                    <button type="button" class="btn btn-primary py-3 px-5 my-4 fw-bold animated fadeIn actSubmitForm" frm="frmUploadMedia" ref="urlResponse" href="Documents/UploadDocuments/Properties/<?= $PropertyId;?>">Save & Next</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>

    <!-- Cropper Modal -->
    <div class="modal fade" id="cropModal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Crop Image</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center">
            <img id="cropImage" style="max-width: 100%; max-height: 75vh;" class="img-fluid">
          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="cropAndSave" class="btn btn-success">Crop & Save</button>
          </div>
        </div>
      </div>
    </div>
</div>


<script type="text/javascript">
    console.log('document loaded');

    // Setup Drag and Drop functionality
    function setupDropzone(dropzoneId, inputId) {
        var dropzone = document.getElementById(dropzoneId);
        var input = document.getElementById(inputId);

        dropzone.addEventListener('click', () => input.click());

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
            if (e.dataTransfer.files.length > 0) {
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            }
        });
    }

    setupDropzone('imageDropzone', 'imageInput');
    setupDropzone('videoDropzone', 'videoInput');

    // Video Logic
    var videoInput = document.getElementById('videoInput');
    var previewContainerVideo = document.getElementById('preview-container-video');
    var selectedVideoFiles = [];

    videoInput.addEventListener('change', function (e) {
        // Append to existing files instead of overwriting
        Array.from(e.target.files).forEach(f => selectedVideoFiles.push(f));
        updateVideoFileInput();
        renderVideoPreviews();
    });

    function renderVideoPreviews() {
        previewContainerVideo.innerHTML = '';

        selectedVideoFiles.forEach((file, index) => {
            var fileSize = (file.size / 1024).toFixed(2) + ' KB';
            if (file.size > 1024 * 1024) fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';

            var item = document.createElement('div');
            item.className = 'file-item';
            item.innerHTML = `
                <div class="file-item-left">
                    <div class="file-icon"><i class="fa-solid fa-file-video"></i></div>
                    <div class="file-info">
                        <div class="file-name" title="${file.name}">${file.name}</div>
                        <div class="file-meta">
                            <span>${fileSize}</span>
                            <span class="text-success"><i class="fa-solid fa-check me-1"></i> Ready</span>
                        </div>
                    </div>
                </div>
                <div class="file-item-right">
                    <div class="form-check m-0 d-flex align-items-center gap-2" title="Set as Feature Video">
                        <input class="form-check-input feature-radio" type="radio" name="featureVideo" id="featVid${index}" value="${file.name}" ${index === 0 ? 'checked' : ''}>
                        <label class="form-check-label small text-muted mb-0" for="featVid${index}">Feature</label>
                    </div>
                    <button type="button" class="btn btn-sm btn-light text-danger remove-video" data-index="${index}"><i class="fa-solid fa-trash"></i></button>
                </div>
            `;
            previewContainerVideo.appendChild(item);
        });

        document.querySelectorAll('.remove-video').forEach(btn => {
            btn.addEventListener('click', function () {
                var idx = parseInt(this.dataset.index);
                selectedVideoFiles.splice(idx, 1);
                updateVideoFileInput();
                renderVideoPreviews();
            });
        });
    }

    function updateVideoFileInput() {
        var dt = new DataTransfer();
        selectedVideoFiles.forEach(file => dt.items.add(file));
        videoInput.files = dt.files;
    }


    // Image Logic & Cropping
    var cropper;
    var currentFile;
    var currentItemElement;
    var previewIndex = 0;
    var imageFileTransfer = new DataTransfer();

    document.getElementById('imageInput').addEventListener('change', function (e) {
        var files = Array.from(e.target.files);
        if (files.length > 0) {
            files.forEach(file => {
                imageFileTransfer.items.add(file);
                previewIndex++;
                showImagePreview(URL.createObjectURL(file), file, previewIndex);
            });
            document.getElementById('imageInput').files = imageFileTransfer.files;
        }
    });

    function openCropperForFile(file, itemElement) {
        currentFile = file;
        currentItemElement = itemElement;
        var reader = new FileReader();

        reader.onload = function (event) {
            var image = document.getElementById('cropImage');
            image.src = event.target.result;

            var cropModalElement = document.getElementById('cropModal');
            if (!cropModalElement) {
                console.error("Modal element not found!");
            }

            var cropModal = new bootstrap.Modal(cropModalElement);
            cropModal.show();

            var handleShown = function () {
                cropModalElement.removeEventListener('shown.bs.modal', handleShown);
                if (cropper) cropper.destroy();

                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                    ready() {
                        var containerData = cropper.getContainerData();
                        cropper.setCropBoxData({
                            width: containerData.width * 0.6,
                            height: containerData.height * 0.6,
                            left: (containerData.width - containerData.width * 0.6) / 2,
                            top: (containerData.height - containerData.height * 0.6) / 2
                        });
                    }
                });
            };
            cropModalElement.addEventListener('shown.bs.modal', handleShown);
        };

        reader.readAsDataURL(file);
    }

    function showImagePreview(src, file, idx) {
        var fileSize = (file.size / 1024).toFixed(2) + ' KB';
        if (file.size > 1024 * 1024) fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
        var isFirst = document.querySelectorAll('input[name="featureImage"]').length === 0;

        var item = document.createElement('div');
        item.className = 'file-item';
        item.dataset.filename = file.name;
        
        item.innerHTML = `
            <div class="file-item-left">
                <img src="${src}" class="rounded preview-img" style="width: 40px; height: 40px; object-fit: cover;">
                <div class="file-info">
                    <div class="file-name" title="${file.name}">${file.name}</div>
                    <div class="file-meta">
                        <span class="file-size-text">${fileSize}</span>
                        <span class="text-success"><i class="fa-solid fa-check me-1"></i> Ready</span>
                    </div>
                </div>
            </div>
            <div class="file-item-right">
                <div class="form-check m-0 d-flex align-items-center gap-2" title="Set as Feature Image">
                    <input class="form-check-input feature-radio" type="radio" name="featureImage" id="featImg${idx}" value="${file.name}" ${isFirst ? 'checked' : ''}>
                    <label class="form-check-label small text-muted mb-0" for="featImg${idx}">Feature</label>
                </div>
                <button type="button" class="btn btn-sm btn-light text-primary crop-image" title="Crop Image"><i class="fa-solid fa-crop"></i></button>
                <button type="button" class="btn btn-sm btn-light text-danger remove-image" title="Remove Image"><i class="fa-solid fa-trash"></i></button>
            </div>
        `;
        
        item.querySelector('.remove-image').addEventListener('click', function () {
            document.getElementById('preview-container-image').removeChild(item);

            var dt = new DataTransfer();
            Array.from(imageFileTransfer.files).forEach(f => {
                if (f.name !== item.dataset.filename) {
                    dt.items.add(f);
                }
            });
            imageFileTransfer.items.clear();
            Array.from(dt.files).forEach(f => imageFileTransfer.items.add(f));
            document.getElementById('imageInput').files = imageFileTransfer.files;
            
            if (item.querySelector('.feature-radio').checked) {
                var firstRadio = document.querySelector('input[name="featureImage"]');
                if (firstRadio) firstRadio.checked = true;
            }
            
            checkImageRequired();
        });

        item.querySelector('.crop-image').addEventListener('click', function() {
            var fileName = item.dataset.filename;
            var fileToCrop = null;
            Array.from(imageFileTransfer.files).forEach(f => {
                if(f.name === fileName) fileToCrop = f;
            });
            
            if (fileToCrop) {
                openCropperForFile(fileToCrop, item);
            }
        });

        document.getElementById('preview-container-image').appendChild(item);
        checkImageRequired();
    }
    
    function checkImageRequired() {
        var count = document.querySelectorAll('#preview-container-image .file-item').length;
        var input = $('#imageInput');
        if(input.length && input.parsley()) {
            input.parsley().destroy();
        }
        
        if(count > 0) {
            input.removeAttr('required');
            input.removeAttr('data-parsley-required-message');
        } else {
            input.attr('required', 'required');
            input.attr('data-parsley-required-message', 'At least one image is required');
        }
    }

    document.getElementById('cropAndSave').addEventListener('click', function () {
        if (!cropper || !currentFile || !currentItemElement) return;

        var canvas = cropper.getCroppedCanvas();
        var mimeType = currentFile.type || 'image/png';

        canvas.toBlob(blob => {
            var croppedFile = new File([blob], currentFile.name, { type: mimeType });
            
            // Replace in imageFileTransfer
            var dt = new DataTransfer();
            Array.from(imageFileTransfer.files).forEach(f => {
                if (f.name === currentFile.name) {
                    dt.items.add(croppedFile);
                } else {
                    dt.items.add(f);
                }
            });
            imageFileTransfer.items.clear();
            Array.from(dt.files).forEach(f => imageFileTransfer.items.add(f));
            document.getElementById('imageInput').files = imageFileTransfer.files;

            // Update preview card
            var newSrc = URL.createObjectURL(croppedFile);
            currentItemElement.querySelector('.preview-img').src = newSrc;
            
            var fileSize = (croppedFile.size / 1024).toFixed(2) + ' KB';
            if (croppedFile.size > 1024 * 1024) fileSize = (croppedFile.size / (1024 * 1024)).toFixed(2) + ' MB';
            currentItemElement.querySelector('.file-size-text').innerText = fileSize;

            bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();
        }, mimeType);
    });

    document.querySelectorAll('.remove-existing-doc').forEach(btn => {
        btn.addEventListener('click', function () {
            if(!confirm("Are you sure you want to delete this media?")) return;
            var docId = this.dataset.id;
            
            fetch('<?= base_url("Documents/DeleteDocument/") ?>' + docId, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if(data.Status) {
                    var item = document.getElementById('doc_' + docId);
                    if(item) {
                        item.remove();
                        checkImageRequired();
                    }
                } else {
                    alert('Error deleting file');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error deleting file');
            });
        });
    });
</script>