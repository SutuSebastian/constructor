<?php
if (empty($_GET['id'])) {
    echo "
    <div class='m-5 text-muted text-center'>
        <h1>Empty page ID</h1>
        <a href='pages'>Go back</a>
    </div>
    ";
    die;
}

$page_ID = $_GET['id'];

$sql = "SELECT id, name, link, published, description, keywords, robots, author FROM pages WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt -> bind_param('i', $page_ID);
$stmt -> execute();
$stmt -> bind_result($id, $name, $link, $published, $description, $keywords, $robots, $author);
$stmt -> fetch();
$stmt -> close();

if (empty($id)) {
  echo "
  <div class='m-5 text-muted text-center'>
      <h1>Wrong page ID</h1>
      <a href='pages'>Go back</a>
  </div>
  ";
  die;
}

(WEBSITE_DEFAULT_PAGE === $link) ? $disabled='disabled' : $disabled = null;
$robots = ($robots === 'index, follow') ? 'checked' : null;

switch ($published) {
    case '0':
        $unpublished_status = 'btn-light active';
        $published_status = null;
    break;
    case '1':
        $published_status = 'btn-light active';
        $unpublished_status = null;
    break;
}

$page_path = "../template/pages/".$link.".php";
?>
<div class="d-flex justify-content-between">
    <h5 class="mb-4 text-secondary">
        <a class="text-dark" href="pages">Pages</a> > <?php echo $name ?>
    </h5>

    <!-- Edit Page Modal -->
    <div class="modal fade" tabindex="-1" id="edit_page_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Page > <?php echo $name ?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="page_ID" value="<?php echo $id ?>">
                        <input type="hidden" name="old_page_title" value="<?php echo $name ?>">
                        <input type="hidden" name="old_page_url" value="<?php echo $link ?>">
                        <input type="hidden" name="page_author" value="<?php echo $author ?>">
                        <div class="form-group">
                            <label>Title</label>
                            <input class="form-control" type="text" name="page_title" value="<?php echo $name ?>">
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">/</span>
                                </div>
                                <input class="form-control" type="text" name="page_url" value="<?php echo $link ?>">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="page_description"><?php echo $description ?></textarea>
                            <small class="text-muted">between 50–160 characters</small>
                        </div>
                        <div class="form-group">
                            <label>Keywords</label>
                            <input class="form-control" type="text" name="page_keywords" value="<?php echo $keywords ?>">
                            <small class="text-muted">Must be separated by <code> , </code> </small>
                        </div>
                        <div class="form-group">
                            <label>Indexed by search engines</label><br>
                            <label class="switch">
                                <input name="page_robots" type="checkbox" value="1" <?php echo $robots ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_page_submit" class="btn btn-dark">Edit Page</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<div class="d-flex flex-column">

    <div id="editorSuccess"></div>

    <div class="page-actions d-flex justify-content-between">
        <div class="btn-group">
            <a href="../<?php echo $link ?>" target="_blank" class="btn btn-dark"><i class="fas fa-external-link-alt"></i> View</a>
            <a href="<?php echo $page_path ?>" download data-toggle="tooltip" title="Download" class="btn btn-light active"><i class="fas fa-download"></i></a>
        </div>
        <div class="d-flex flex-column text-center">
        <?php if (WEBSITE_DEFAULT_PAGE == $link) { echo "<h5 class='text-muted text-light'>Homepage</h5>"; } else { ?>
            <div class="btn-group">
                <input id="page_ID" type="hidden" value="<?php echo $id ?>">
                <button style="border-radius: 2rem;" class="btn visible status_submit <?php echo $published_status ?>">
                    <i class="fas fa-eye"></i> Public
                </button>
                <button style="border-radius: 2rem;" class="btn hidden status_submit <?php echo $unpublished_status ?>">
                    Private <i class="far fa-eye-slash"></i>
                </button>
            </div>
        <?php } ?>
        </div>
        <div class="btn-group">
            <button type="button" data-toggle="modal" data-target="#edit_page_modal" class="btn btn-light active"><i class="far fa-edit"></i> Edit</button>
            <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
            <div class="dropdown-menu">
                <form action="" method="POST">
                    <input type="hidden" name="page_ID" value="<?php echo $id ?>">
                    <input type="hidden" name="page_link" value="<?php echo $link ?>">
                    <input type="hidden" name="published_status" value="<?php echo $published ?>">
                    <input type="hidden" name="page_author" value="<?php echo $author ?>">
                    <button type="submit" name="remove_page_submit" class="btn btn-link text-danger dropdown-item" <?php echo $disabled; ?> onClick="return confirm('Delete this page?')">Delete Page</button>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white p-1">
                <h6 class="text-center m-0"><?php echo $name ?></h6>
                <button id="toggle_editor_fullscreen" class="btn btn-sm pr-2 text-muted">
                    Fullscreen
                    <i class="fas fa-compress"></i>
                </button>
            </div>
            <div id="current_pageEditor" class="editor"></div>
            <xmp id="editorVal" name="editor_value" class="d-none"><?php readfile($page_path); ?></xmp>
            <button id="update_page" onclick="updateEditor('<?php echo $link ?>')" class="btn btn-dark border-top-radius-0">Update</button>
        </div>
    </div>

</div>
