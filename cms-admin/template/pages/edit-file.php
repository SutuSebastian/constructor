<?php
if (empty($_GET['id'])) {
    echo "
    <div class='m-5 text-muted text-center'>
        <h1>Empty file ID</h1>
        <a href='css-js-files'>Go back</a>
    </div>
    ";
    die;
}

$page_ID = $_GET['id'];

$file_result = $conn->query("SELECT * FROM files WHERE id = $page_ID");
$file = $file_result->fetch_object();

if (empty($file->id)) {
    echo "
    <div class='m-5 text-muted text-center'>
        <h1>Wrong file ID</h1>
        <a href='css-js-files'>Go back</a>
    </div>
    ";
    die;
}

($file->status) ? $included = 'btn-light active'. $excluded=NULL : $excluded='btn-light active'.$included=NULL;

$file_path = "../template/assets/$file->type/$file->name.$file->type";

?>
<div class="d-flex justify-content-between">
    <h5 class="mb-4 text-secondary">
        <a class="text-dark" href="css-js-files">CSS & JS Files</a> > Edit > <?php echo $file->name . "." . $file->type ?>
    </h5>

    <a data-toggle="modal" data-target="#edit_file_modal" class="text-dark" href="#">
        <i class="far fa-edit"></i>
        Edit
    </a>

    <!-- Edit Page Modal -->
    <div class="modal fade" tabindex="-1" id="edit_file_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit File > <?php echo $file->name . "." . $file->type ?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="file_ID" value="<?php echo $file->id ?>">
                        <input type="hidden" name="old_file_name" value="<?php echo $file->name ?>">
                        <input type="hidden" name="file_type" value="<?php echo $file->type ?>">
                        <input type="hidden" name="file_author" value="<?php echo $file->author ?>">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" name="file_name" value="<?php echo $file->name ?>">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_file_submit" class="btn btn-dark">Edit File</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<div class="d-flex flex-column">

    <div id="editorSuccess"></div>

    <div class="page-actions d-flex justify-content-between">
        <a href="<?php echo $file_path ?>" class="btn btn-link text-primary" target="_blank">
            <i class="fas fa-external-link-alt"></i> View File
        </a>
        <div class="d-flex flex-column text-center">
            <div class="btn-group">
                <input id="file_ID" type="hidden" value="<?php echo $file->id ?>">
                <button style="border-radius: 2rem;" class="btn visible update_page_status <?php echo $included ?>">
                    <i class="fas fa-link"></i> Included
                </button>
                <button style="border-radius: 2rem;" class="btn hidden update_page_status <?php echo $excluded ?>">
                    Excluded <i class="fas fa-unlink"></i>
                </button>
            </div>
        </div>
        <form action="" method="POST">
            <input type="hidden" name="file_ID" value="<?php echo $file->id ?>">
            <input id="file_name" type="hidden" name="file_name" value="<?php echo $file->name ?>">
            <input id="file_type" type="hidden" name="file_type" value="<?php echo $file->type ?>">
            <input type="hidden" name="file_author" value="<?php echo $file->author ?>">
            <button type="submit" name="remove_file_submit" class="btn btn-link text-danger" onClick="return confirm('Delete this file?')">Delete File</button>
        </form>
    </div>

    <div class="mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white p-1">
                <h6 class="text-center m-0"><?php echo $file->name. "." .$file->type ?></h6>
                <button id="toggle_editor_fullscreen" class="btn btn-sm pr-2 text-muted">
                    Fullscreen
                    <i class="fas fa-compress"></i>
                </button>
            </div>
            <div id="current_fileEditor" class="editor"></div>
            <textarea id="fileVal" name="file_value" class="d-none"><?php readfile($file_path); ?></textarea>
            <button id="update_file" onclick="updateEditor('<?php echo $file->name ?>')" class="btn btn-dark border-top-radius-0">Update</button>
        </div>
    </div>

</div>
