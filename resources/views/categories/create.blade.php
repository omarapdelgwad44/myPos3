            <!-- Modal -->
            <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryModalLabel">{{ @trans('adminlte::adminlte.add_category') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('dashboard.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="categoryName" class="form-label">{{ @trans('adminlte::adminlte.name') }}</label>
                                    <input type="text" class="form-control" id="categoryName" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="categoryImage" class="form-label">{{ @trans('adminlte::adminlte.image') }}</label>
                                    <input type="file" class="form-control" id="categoryImage" name="image">
                                </div>
                                <div class="mb-3">
                                <img id="imagePreview" src="#" alt="{{ @trans('adminlte::adminlte.image_preview') }}" style="display: none; max-width: 100%; height: auto;" />
                            </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ @trans('adminlte::adminlte.cancel') }}</button>
                                <button type="submit" class="btn btn-primary">{{ @trans('adminlte::adminlte.save') }}</button>
                        </div>
                    </div>
                    <script>
                        document.getElementById('categoryImage').addEventListener('change', function(event) {
                            const [file] = event.target.files;
                            const preview = document.getElementById('imagePreview');
                            if (file) {
                                preview.src = URL.createObjectURL(file);
                                preview.style.display = 'block';
                            } else {
                                preview.style.display = 'none';
                            }
                        });
                    </script>
                </div>           </form>
                    </div>
                </div>
            </div>
