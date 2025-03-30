<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">{{ trans('adminlte::adminlte.edit_category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editCategoryId" name="category_id">

                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label">{{ trans('adminlte::adminlte.name') }}</label>
                        <input type="text" class="form-control" id="editCategoryName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editCategoryImage" class="form-label">{{ trans('adminlte::adminlte.image') }}</label>
                        <input type="file" class="form-control" id="editCategoryImage" name="image">
                    </div>

                    <div class="mb-3">
                        <img id="editImagePreview" src="" alt="{{ trans('adminlte::adminlte.image_preview') }}" style="display: none; max-width: 20%; height: auto;" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('adminlte::adminlte.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('adminlte::adminlte.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('editCategoryImage').addEventListener('change', function(event) {
        const [file] = event.target.files;
        const preview = document.getElementById('editImagePreview');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });

    function openEditModal(categoryId, categoryName, categoryImage) {
        document.getElementById('editCategoryId').value = categoryId;
        document.getElementById('editCategoryName').value = categoryName;

        const preview = document.getElementById('editImagePreview');
        if (categoryImage) {
            preview.src = categoryImage;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }

        document.getElementById('editCategoryForm').action = `/dashboard/categories/${categoryId}`;
        new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
    }
</script>
