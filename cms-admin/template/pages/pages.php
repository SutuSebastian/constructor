<?php
    $sql="SELECT id, name, link, published, created, last_update, author FROM pages";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $link, $published, $created, $last_update, $author);
?>
<h5 class="mb-4 text-secondary">Pages</h5>

<button data-toggle="modal" data-target="#add_page_modal" class="btn btn-dark btn-sm" type="button" name="add_page_submit">
    <i class="fas fa-plus"></i>
    Add Page
</button>

<!-- Edit Page Modal -->
<div class="modal fade" tabindex="-1" id="add_page_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Page</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" type="text" name="page_name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <label>URL</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">/</span>
                            </div>
                            <input class="form-control" type="text" name="page_link" placeholder="TITLE" required>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label>Public</label> <br>
                        <label class="switch">
                            <input name="page_published_status" type="checkbox" value="1" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark" type="submit" name="add_page_submit">Add Page</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-xl-9">
        <div class="card mb-4">
            <div class="card-header bg-dark text-light text-center p-1">
                <h6 class="m-0">Public Pages</h6>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover cursor-pointer">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th style="width: 1em;">URL</th>
                            <th class="text-center" style="width: 1em;">Status</th>
                            <th class="text-center" style="width: 1em;">Author</th>
                            <th style="width: 1em;">Created</th>
                            <th style="width: 1em;">Modified</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $page_count = 1;
                    if($stmt->num_rows > 0) {
                        while ($stmt->fetch()) {
                            switch ($published) {
                                case '0':
                                    $published = '<i class="far fa-eye-slash"></i>';
                                    $status = 'unpublished';
                                break;
                                case '1':
                                    $published = '<i class="fas fa-eye"></i>';
                                    $status = 'published';
                                break;
                            }
                    ?>
                        <tr class="<?php echo $status ?>">
                            <td style="width: 10px;"><?php echo $page_count++; ?></td>
                            <td onclick="location.href='edit-page?id=<?php echo $id ?>'">
                                <a data-toggle="tooltip" title="Edit" href="edit-page?id=<?php echo $id ?>"><?php echo $name;?></a>
                                <?php
                                    if (WEBSITE_DEFAULT_PAGE == $link) {
                                      echo "<small class='text-muted small-text'> — <i class='fas fa-home'></i> </small>";
                                    }
                                ?>
                            </td>
                            <td>
                                <a data-toggle="tooltip" title="View" href="../<?php echo $link ?>" target="_blank">/<?php echo $link ?></a>
                            </td>
                            <td class="text-center"><span data-toggle="tooltip" title="<?php if ($status === 'published') { echo "Public"; } else { echo "Private";}?>"><?php echo $published ?></span></td>
                            <td><?php echo $author ?></td>
                            <td><?php echo $created ?></td>
                            <td><?php echo $last_update ?></td>
                        </tr>
                    <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header bg-dark text-light text-center p-1">
                <h6 class="m-0">Template Pages</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover cursor-pointer">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 10px;">
                                1
                            </td>
                            <td onclick="location.href='404-edit'">
                                <a data-toggle="tooltip" title="Edit" href="404-edit">404</a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 10px;">
                                2
                            </td>
                            <td onclick="location.href='maintenance-edit'">
                                <a data-toggle="tooltip" title="Edit" href="maintenance-edit">Maintenance</a>
                                <?php
                                if (WEBSITE_MAINTENANCE) {
                                  echo "<small class='text-muted small-text'> — Enabled </small>";
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
