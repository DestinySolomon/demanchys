@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Menu Categories</h1>
        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-circle me-2"></i>Add New Category
        </button>
    </div>


    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Categories Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Categories ({{ $categories->count() }})</h6>
        </div>
        <div class="card-body">
            @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" id="categoriesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Slug</th>
                            <th>Items Count</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td class="text-center">
                                @if($category->image)
                                    <img src="{{ Storage::url($category->image) }}" 
                                         alt="{{ $category->name }}" 
                                         class="rounded" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
    

                            <td>
                                <strong>{{ $category->name }}</strong>
                            </td>
                            <td>{{ $category->description ?? 'No description' }}</td>
                            <td>
                                <code>{{ $category->slug }}</code>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $category->items_count }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $category->created_at->format('M j, Y') }}</small>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1 edit-category" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editCategoryModal"
                                        data-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}"
                                        data-description="{{ $category->description }}"
                                        data-image="{{ $category->image }}"
                                        title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-category" 
                                        data-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}"
                                        title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="text-muted mt-3">No Categories Found</h4>
                <p class="text-muted">Get started by creating your first menu category.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="bi bi-plus-circle me-2"></i>Create First Category
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="categoryName" name="name" required 
                                       value="{{ old('name') }}" placeholder="e.g., Cocktails, Appetizers, Main Courses">
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="categoryDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="categoryDescription" name="description" 
                                          rows="3" placeholder="Brief description of this category">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categoryImage" class="form-label">Category Image</label>
                                <input type="file" class="form-control" id="categoryImage" name="image" 
                                       accept="image/*">
                                @error('image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Recommended: 400x400px, JPG, PNG or GIF (max 2MB)
                                </div>
                                <div class="mt-2 text-center">
                                    <img id="imagePreview" src="#" alt="Image preview" 
                                         class="img-thumbnail mt-2" style="display: none; max-height: 150px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                     <input type="hidden" name="_method" value="PUT">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editCategoryName" class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="editCategoryName" name="name" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="editCategoryDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editCategoryDescription" name="description" rows="3"></textarea>
                                @error('description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editCategoryImage" class="form-label">Category Image</label>
                                <input type="file" class="form-control" id="editCategoryImage" name="image" 
                                       accept="image/*">
                                @error('image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Leave empty to keep current image
                                </div>
                                <div class="mt-2 text-center">
                                    <img id="editImagePreview" src="#" alt="Image preview" 
                                         class="img-thumbnail mt-2" style="max-height: 150px;">
                                    <div id="currentImageInfo" class="small text-muted mt-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete "<strong id="deleteCategoryName"></strong>"?</p>
                <p class="text-danger small">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    This action cannot be undone. Any menu items in this category will need to be reassigned.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteCategoryForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete Category
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
    


       

@push('scripts')

{{-- FIXED SCRIPT --}}
       <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete Category
        document.querySelectorAll('.delete-category').forEach(function(button) {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                
                document.getElementById('deleteCategoryName').textContent = name;
                document.getElementById('deleteCategoryForm').action = '/admin/categories/' + id;
                
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
                deleteModal.show();
            });
        });

        // Edit Category
        document.querySelectorAll('.edit-category').forEach(function(button) {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const description = this.getAttribute('data-description');
                const image = this.getAttribute('data-image');
                
                document.getElementById('editCategoryName').value = name;
                document.getElementById('editCategoryDescription').value = description || '';
                document.getElementById('editCategoryForm').action = '/admin/categories/' + id;
                
                // Handle image preview
                const preview = document.getElementById('editImagePreview');
                const imageInfo = document.getElementById('currentImageInfo');
                
                if (image) {
                    preview.src = '/storage/' + image;
                    preview.style.display = 'block';
                    imageInfo.textContent = 'Current image';
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                    imageInfo.textContent = 'No image set';
                }
            });
        });

        // Image preview for add form
        document.getElementById('categoryImage')?.addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
    });
</script>


@endpush

<style>
.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}
.btn-sm {
    padding: 0.25rem 0.5rem;
}


.delete-category {
    border: 2px solid red !important;
    background: #ff4444 !important;
    color: white !important;
}
</style>
@endsection