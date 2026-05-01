<div class="modal-overlay" id="addMenuOverlay" aria-hidden="true">

    <div class="modal" id="addImageModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

        <div class="modal-header">
            <h3 id="modalTitle">Add Gallery Image</h3>
            <button class="modal-close" id="modalCloseBtn">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('gallery.add') }}" method="post" enctype="multipart/form-data" class="modal-form">
            @csrf

            <div class="form-group">
                <label>Upload Image</label>
                <label for="item_image" class="upload-label">
                    <i class="fa-solid fa-upload"></i>
                    <span id="uploadText">Choose a File</span>
                    <input
                        type="file"
                        id="item_image"
                        name="image"
                        accept="image/*"
                        class="upload-input"
                    >
                </label>
                <p class="upload-hint" id="uploadFileName"></p>
                <span class="error">
                    @error('image')
                        {{$message}}
                    @enderror
                </span>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="modalCancelBtn">Cancel</button>
                <button type="submit" class="btn-submit">Add Image</button>
            </div>
        </form>
    </div>
</div>
