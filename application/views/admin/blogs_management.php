<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Blogs Management'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
    <style>
        .page-header {
            background: linear-gradient(135deg, #1F509A 0%, #153a75 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(31, 80, 154, 0.2);
            position: relative;
            overflow: hidden;
        }
        .table > :not(caption) > * > * { padding: 1rem 1rem; }
    </style>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">
            <!-- Navigation Tabs & Actions -->
            <div class="nav-modern justify-content-between">
                <div class="nav-items-wrapper">
                    <button class="nav-link active" id="published-tab" onclick="filterTable('Published')">
                        <i class="fa-solid fa-check-circle me-2"></i>Published
                    </button>
                    <button class="nav-link" id="draft-tab" onclick="filterTable('Draft')">
                        <i class="fa-solid fa-file-signature me-2"></i>Drafts
                    </button>
                </div>
                <div>
                    <button class="btn btn-primary px-4 fw-bold shadow-sm rounded-pill" onclick="openBlogModal()">
                        <i class="fa-solid fa-plus me-2"></i>Create Blog
                    </button>
                </div>
            </div>

            <!-- Table Card -->
            <div class="modern-card">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table id="blogsTable" class="table table-hover align-middle">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th class="fw-semibold">ID</th>
                                    <th class="fw-semibold">Image</th>
                                    <th class="fw-semibold w-25">Title</th>
                                    <th class="fw-semibold">Status</th>
                                    <th class="fw-semibold">Date</th>
                                    <th class="fw-semibold text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data populated via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Add/Edit Blog Modal -->
<div class="modal fade" id="blogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="blogModalTitle">Create New Blog</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="blogForm">
                    <input type="hidden" id="BlogId" name="BlogId">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Blog Title</label>
                        <input type="text" class="form-control" id="Title" name="Title" required placeholder="Enter an engaging title...">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Short Description (For Cards)</label>
                        <textarea class="form-control" id="Description" name="Description" rows="2" required placeholder="A brief summary..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Content</label>
                        <textarea class="form-control" id="Content" name="Content" rows="5" placeholder="Write your full article here..."></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="Status" name="Status" required>
                                <option value="Draft">Draft</option>
                                <option value="Published">Published</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Cover Image</label>
                            <input class="form-control" type="file" id="BlogImage" name="BlogImage" accept="image/*">
                            <div class="form-text">Recommended size: 800x600px</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary shadow-sm px-4" onclick="saveBlog()">Save Blog</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/components/footer'); ?>
<?php $this->load->view('admin/components/js_links'); ?>

<script>
let blogsData = [];
let currentFilter = 'Published';
let dataTable;

$(document).ready(function() {
    dataTable = $('#blogsTable').DataTable({
        "pageLength": 10,
        "ordering": true,
        "info": true,
        "dom": '<"row align-items-center mb-3"<"col-md-6"l><"col-md-6 text-end"f>>rt<"row align-items-center mt-3"<"col-md-6"i><"col-md-6 text-end"p>>',
        "language": {
            search: "_INPUT_",
            searchPlaceholder: "Search blogs..."
        }
    });

    loadBlogs();
});

function loadBlogs() {
    $.post('<?= site_url("Admin/api_get_blogs") ?>', function(res) {
        if(res.data) {
            blogsData = res.data;
            renderTable();
        }
    }, 'json');
}

function filterTable(status) {
    currentFilter = status;
    renderTable();
}

function renderTable() {
    dataTable.clear();
    
    const filtered = blogsData.filter(b => b.Status === currentFilter);
    
    filtered.forEach(b => {
        let imageUrl = '<?= base_url("uploads/blogs/") ?>' + b.ImageName;
        // Check if it's dummy data using generic images
        if(b.ImageName.includes('property-')) imageUrl = '<?= base_url("assets/images/") ?>' + b.ImageName;

        let imgHtml = `<img src="${imageUrl}" class="rounded object-fit-cover shadow-sm" style="width:60px; height:60px;" onerror="this.src='<?= base_url("assets/images/property-placeholder.jpg") ?>'">`;
        
        let statusBadge = b.Status === 'Published' 
            ? '<span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill">Published</span>' 
            : '<span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1 rounded-pill">Draft</span>';
            
        let date = new Date(b.CreatedAt).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        
        let actions = `
            <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-sm btn-light border text-primary shadow-sm" onclick="editBlog(${b.BlogId})" title="Edit">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-light border text-danger shadow-sm" onclick="deleteBlog(${b.BlogId})" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        
        dataTable.row.add([
            `#${b.BlogId}`,
            imgHtml,
            `<span class="fw-bold text-dark">${b.Title}</span><br><small class="text-muted text-truncate d-inline-block" style="max-width:250px;">${b.Description}</small>`,
            statusBadge,
            date,
            actions
        ]);
    });
    
    dataTable.draw();
}

function openBlogModal() {
    $('#blogForm')[0].reset();
    $('#BlogId').val('');
    $('#blogModalTitle').text('Create New Blog');
    $('#blogModal').modal('show');
}

function editBlog(id) {
    const blog = blogsData.find(b => b.BlogId == id);
    if(blog) {
        $('#BlogId').val(blog.BlogId);
        $('#Title').val(blog.Title);
        $('#Description').val(blog.Description);
        $('#Content').val(blog.Content);
        $('#Status').val(blog.Status);
        $('#blogModalTitle').text('Edit Blog');
        $('#blogModal').modal('show');
    }
}

function saveBlog() {
    if(!$('#Title').val() || !$('#Description').val()) {
        Swal.fire('Error', 'Title and Description are required!', 'error');
        return;
    }

    let formData = new FormData($('#blogForm')[0]);
    
    $.ajax({
        url: '<?= site_url("Admin/api_save_blog") ?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(res) {
            let response = JSON.parse(res);
            if(response.success) {
                $('#blogModal').modal('hide');
                Swal.fire('Success!', 'Blog saved successfully.', 'success');
                loadBlogs();
            } else {
                Swal.fire('Error', 'Failed to save blog.', 'error');
            }
        }
    });
}

function deleteBlog(id) {
    Swal.fire({
        title: 'Delete this blog?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('<?= site_url("Admin/api_delete_blog") ?>', { BlogId: id }, function(res) {
                if(res.success) {
                    Swal.fire('Deleted!', 'Blog has been deleted.', 'success');
                    loadBlogs();
                }
            }, 'json');
        }
    });
}
</script>
</body>
</html>
