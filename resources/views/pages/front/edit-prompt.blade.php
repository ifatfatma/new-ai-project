                                    <div class="image-preview-size">Choose a new image above to replace it.</div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <small class="field-hint">Leave this field empty to keep the existing image. Removing the image from this preview only clears a newly selected file; it does not delete the saved image.</small>
                </section>

                <div class="form-footer">
                    <a href="{{ route('user.prompts') }}" class="btn-cancel"><i class="bi bi-x-lg me-1"></i>Cancel</a>
                    <button type="submit" id="updatePromptBtn" class="btn-update">
                        <span id="updatePromptSpinner" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" style="display:none"></span>
                        <i id="updatePromptIcon" class="bi bi-send me-1"></i>
                        <span id="updatePromptText">Update Prompt</span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="text-center mt-auto">
        <div class="p-3 small" style="background:rgba(0,0,0,.2)">© {{ date('Y') }} Copyright: <a class="text-white fw-bold text-decoration-none" href="{{ route('home') }}">AI Prompt Hub</a>. All rights reserved.</div>
    </footer>

    <div class="toast-container position-fixed top-0 end-0 p-3" id="editToastContainer" aria-live="polite" aria-atomic="true"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('editPromptForm');
        const submitBtn = document.getElementById('updatePromptBtn');
        const spinner = document.getElementById('updatePromptSpinner');
        const submitIcon = document.getElementById('updatePromptIcon');
        const submitText = document.getElementById('updatePromptText');
        let submitting = false;

        form.addEventListener('submit', function (event) {
            if (submitting) { event.preventDefault(); return; }
            if (!form.checkValidity()) { form.reportValidity(); return; }
            submitting = true;
            submitBtn.disabled = true;
            spinner.style.display = 'inline-block';
            submitIcon.style.display = 'none';
            submitText.textContent = 'Updating Prompt...';
        });

        const dropdown = document.getElementById('aiToolsDropdown');
        const dropdownBtn = document.getElementById('aiToolsDropdownBtn');
        const selectedText = document.getElementById('selectedToolsText');
        const badges = document.getElementById('selectedToolBadges');
        const checkboxes = Array.from(dropdown.querySelectorAll('input[name="ai_tools[]"]'));

        function updateToolsDisplay() {
            const selected = checkboxes.filter(cb => cb.checked).map(cb => ({value: cb.value, label: cb.closest('label').querySelector('span').textContent.trim()}));
            selectedText.textContent = selected.length ? selected.length + ' tool' + (selected.length === 1 ? '' : 's') + ' selected' : 'Select AI Tools';
            badges.innerHTML = '';
            selected.forEach(tool => {
                const badge = document.createElement('span');
                badge.className = 'tool-badge';
                badge.textContent = tool.label;
                badges.appendChild(badge);
            });
        }
        dropdownBtn.addEventListener('click', function () {
            const isOpen = dropdown.classList.toggle('open');
            dropdownBtn.setAttribute('aria-expanded', String(isOpen));
        });
        checkboxes.forEach(cb => cb.addEventListener('change', updateToolsDisplay));
        document.addEventListener('click', function (event) {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('open');
                dropdownBtn.setAttribute('aria-expanded', 'false');
            }
        });
        updateToolsDisplay();

        const fileInput = document.getElementById('image');
        const previewBox = document.getElementById('imagePreviewBox');
        const preview = document.getElementById('imagePreview');
        const fileName = document.getElementById('imageFileName');
        const fileSize = document.getElementById('imageFileSize');
        const removeBtn = document.getElementById('removeImageBtn');
        const changeBtn = document.getElementById('changeImageBtn');
        const existingImageBox = document.getElementById('existingImageBox');
        let previewUrl = null;

        function formatBytes(bytes) {
            return bytes < 1024 * 1024 ? (bytes / 1024).toFixed(1) + ' KB' : (bytes / (1024 * 1024)).toFixed(2) + ' MB';
        }
        function clearNewImage() {
            fileInput.value = '';
            if (previewUrl) URL.revokeObjectURL(previewUrl);
            previewUrl = null;
            previewBox.style.display = 'none';
            preview.removeAttribute('src');
            if (existingImageBox) existingImageBox.style.display = '';
        }
        fileInput.addEventListener('change', function () {
            const file = fileInput.files && fileInput.files[0];
            if (!file) return;
            const allowedTypes = ['image/jpeg','image/png','image/gif','image/webp'];
            if (!allowedTypes.includes(file.type)) {
                fileInput.value = '';
                showEditToast('Please select a JPG, PNG, GIF or WEBP image.', 'danger');
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                fileInput.value = '';
                showEditToast('Image size must be 2 MB or less.', 'danger');
                return;
            }
            if (previewUrl) URL.revokeObjectURL(previewUrl);
            previewUrl = URL.createObjectURL(file);
            preview.src = previewUrl;
            fileName.textContent = file.name;
            fileSize.textContent = formatBytes(file.size);
            previewBox.style.display = 'block';
            if (existingImageBox) existingImageBox.style.display = 'none';
        });
        changeBtn.addEventListener('click', () => fileInput.click());
        removeBtn.addEventListener('click', clearNewImage);

        function showEditToast(message, type) {
            const container = document.getElementById('editToastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast align-items-center text-bg-' + (type || 'success') + ' border-0';
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            toast.innerHTML = '<div class="d-flex"><div class="toast-body"></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>';
            toast.querySelector('.toast-body').textContent = message;
            container.appendChild(toast);
            const toastInstance = new bootstrap.Toast(toast, {delay: 3500});
            toastInstance.show();
            toast.addEventListener('hidden.bs.toast', () => toast.remove());
        }
    });
    </script>
</body>
</html>
