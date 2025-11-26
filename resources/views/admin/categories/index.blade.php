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

    <!-- Categories Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="categoriesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Slug</th>
                            <th>Items Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample Data - We'll make this dynamic later -->
                        <tr>
                            <td>1</td>
                            <td>Cocktails</td>
                            <td>Signature mixed drinks and cocktails</td>
                            <td>cocktails</td>
                            <td><span class="badge bg-primary">3</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Wines</td>
                            <td>Fine selection of wines</td>
                            <td>wines</td>
                            <td><span class="badge bg-primary">2</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Appetizers</td>
                            <td>Perfect starters and snacks</td>
                            <td>appetizers</td>
                            <td><span class="badge bg-primary">2</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name *</label>
                        <input type="text" class="form-control" id="categoryName" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="categoryDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="categorySlug" class="form-label">Slug *</label>
                        <input type="text" class="form-control" id="categorySlug" required>
                        <div class="form-text">URL-friendly version of the name (auto-generated)</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save Category</button>
            </div>
        </div>
    </div>
</div>

<style>
.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}
</style>
@endsection