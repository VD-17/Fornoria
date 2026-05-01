<div class="modal-overlay" id="addMenuOverlay" aria-hidden="true">

    <div class="modal" id="addMenuModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

        <div class="modal-header">
            <h3 id="modalTitle">Add Menu Item</h3>
            <button class="modal-close" id="modalCloseBtn">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ url('menu') }}" method="post" enctype="multipart/form-data" class="modal-form">
            @csrf

            <div class="form-group">
                <label for="itemName">Name</label>
                <input
                    type="text"
                    id="itemName"
                    name="itemName"
                    placeholder="Pizza Name"
                    required
                >
                <span class="error">
                    @error('itemName')
                        {{$message}}
                    @enderror
                </span>
            </div>

            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <input type="text" id="ingredients" name="ingredients" placeholder="e.g. Tomato, Mozzarella, Basil" required>
                <span class="error">
                    @error('ingredients')
                        {{$message}}
                    @enderror
                </span>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price</label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        value="0.00"
                        step="0.01"
                        min="0"
                        required
                    >
                    <span class="error">
                        @error('price')
                            {{$message}}
                        @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <div class="select-wrap">
                        <select id="item_category" name="category" required>
                            <option value="starters">Starters</option>
                            <option value="pizzas">Pizzas</option>
                            <option value="drinks">Drinks</option>
                            <option value="dessert">Desserts</option>
                        </select>
                        <i class="fa-solid fa-chevron-down select-icon"></i>
                    </div>
                    <span class="error">
                        @error('category')
                            {{$message}}
                        @enderror
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label>Image</label>
                <label for="item_image" class="upload-label">
                    <i class="fa-solid fa-upload"></i>
                    <span id="uploadText">Upload Image</span>
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
                <button type="submit" class="btn-submit">Add Item</button>
            </div>

        </form>
    </div>
</div>
