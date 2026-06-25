<!-- Edit menu modal  -->
<div class="modal-overlay" id="editMenuOverlay-{{ $menu->id }}" aria-hidden="true">

    <div class="modal" id="editMenuModal-{{ $menu->id }}" role="dialog" aria-modal="true" aria-labelledby="editModalTitle-{{ $menu->id }}">

        <!-- Heading  -->
        <div class="modal-header">
            <h3 id="editModalTitle-{{ $menu->id }}">Edit Menu Item</h3>
            <button type="button" class="modal-close" id="editModalCloseBtn-{{ $menu->id }}">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Edit menu item form  -->
        <form action="{{ route('menu.update', $menu->id) }}" method="post" enctype="multipart/form-data" class="modal-form">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="edit_itemName-{{ $menu->id }}">Name</label>
                <input
                    type="text"
                    id="edit_itemName-{{ $menu->id }}"
                    name="itemName"
                    value="{{ old('itemName', $menu->item_name) }}"
                    required
                >
                <span class="error">
                    @error('itemName')
                        {{$message}}
                    @enderror
                </span>
            </div>

            <div class="form-group">
                <label for="edit_ingredients-{{ $menu->id }}">Ingredients</label>
                <input
                    type="text"
                    id="edit_ingredients-{{ $menu->id }}"
                    name="ingredients"
                    value="{{ old('ingredients', $menu->ingredients) }}"
                    required
                >
                <span class="error">
                    @error('ingredients')
                        {{$message}}
                    @enderror
                </span>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="edit_price-{{ $menu->id }}">Price</label>
                    <input
                        type="number"
                        id="edit_price-{{ $menu->id }}"
                        name="price"
                        value="{{ old('price', $menu->price) }}"
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
                    <label for="edit_category-{{ $menu->id }}">Category</label>
                    <div class="select-wrap">
                        <select id="edit_category-{{ $menu->id }}" name="category" required>
                            @foreach (['starters' => 'Starters', 'pizzas' => 'Pizzas', 'drinks' => 'Drinks', 'desserts' => 'Desserts'] as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    {{ old('category', $menu->category) === $value ? 'selected' : '' }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
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
                <label for="edit_item_image-{{ $menu->id }}" class="upload-label">
                    <i class="fa-solid fa-upload"></i>
                    <span id="editUploadText-{{ $menu->id }}">Change Image</span>
                    <input
                        type="file"
                        id="edit_item_image-{{ $menu->id }}"
                        name="image"
                        accept="image/*"
                        class="upload-input"
                    >
                </label>
                <p class="upload-hint" id="editUploadFileName-{{ $menu->id }}"></p>
                <span class="error">
                    @error('image')
                        {{$message}}
                    @enderror
                </span>
            </div>

            <!-- Action buttons  -->
            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="editModalCancelBtn-{{ $menu->id }}">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>

        </form>
    </div>
</div>
