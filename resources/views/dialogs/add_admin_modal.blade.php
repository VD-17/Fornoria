<div class="modal-overlay" id="addAdminOverlay" aria-hidden="true">
    <div class="modal" id="addAdminModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

        <div class="modal-header">
            <h3 id="modalTitle">Add New Admin</h3>
            <button class="modal-close" id="modalCloseBtn" type="button">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('admin.store') }}" method="POST" class="modal-form">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Full Name"
                    value="{{ old('name') }}" required>
                <span class="error">
                    @error('name') {{ $message }} @enderror
                </span>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email"
                    value="{{ old('email') }}" required>
                <span class="error">
                    @error('email') {{ $message }} @enderror
                </span>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="e.g. 0721234567"
                    value="{{ old('phone') }}">
                <span class="error">
                    @error('phone') {{ $message }} @enderror
                </span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Min. 8 characters" required>
                <span class="error">
                    @error('password') {{ $message }} @enderror
                </span>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="modalCancelBtn">Cancel</button>
                <button type="submit" class="btn-submit">Add Admin</button>
            </div>
        </form>
    </div>
</div>
