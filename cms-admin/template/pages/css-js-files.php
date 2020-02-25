<?php
    $sql = "SELECT id, name, type, status, created, modified, author FROM files WHERE type='css'";
    $stmt = $conn->prepare($sql);
    $stmt -> execute();
    $stmt -> store_result();
    $stmt -> bind_result($id, $name, $type, $status, $created, $modified, $author);

    $css_count = 1;
    $js_count = 1;
?>

<h5 class="mb-4 text-secondary">
    CSS & JavaScript Files
</h5>

<button data-toggle="modal" data-target="#add_file_modal" class="btn btn-dark btn-sm" type="button" name="add_page_submit">
    <i class="fas fa-plus"></i>
    Add File
</button>

<!-- Add CSS / JS File Modal -->
<div class="modal fade" tabindex="-1" id="add_file_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add New File</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>File name</label>
                        <input class="form-control" type="text" name="file_name" placeholder="File Name" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="css_radio" name="file_type" value="css" checked>
                          <label class="custom-control-label" for="css_radio">CSS</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="js_radio" name="file_type" value="js">
                          <label class="custom-control-label" for="js_radio">JS</label>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label>Include in website</label><br>
                        <label class="switch">
                            <input name="file_status" type="checkbox" value="1" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="modal-footer ">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark" type="submit" name="add_file_submit">Add File</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-xl-6 col-lg-12 mb-4">
        <div class="card">
            <div class="card-header bg-dark text-light text-center p-1">
                <h6 class="m-0">.CSS</h6>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover cursor-pointer">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th class="text-center" style="width: 1em;">Status</th>
                            <th style="width: 1em;">Author</th>
                            <th style="width: 1em;">Created</th>
                            <th style="width: 1em;">Modified</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($stmt->num_rows > 0) {
                        while ($stmt->fetch()) {
                            switch ($status) {
                                case '0':
                                    $status_icon = '<i class="fas fa-unlink"></i>';
                                    $status_color = 'unpublished';
                                break;
                                case '1':
                                    $status_icon = '<i class="fas fa-link"></i>';
                                    $status_color = 'published';
                                break;
                            }
                    ?>
                        <tr class="<?php echo $status_color ?>">
                            <td style="width: 10px;"><?php echo $css_count++; ?></td>
                            <td onclick="location.href='edit-file?id=<?php echo $id ?>'">
                                <a data-toggle="tooltip" title="Edit" href="edit-file?id=<?php echo $id ?>"><?php echo $name.".".$type?></a>
                            </td>
                            <td class="text-center">
                                <span data-toggle="tooltip" title="<?php if ($status == 1) { echo "Included"; } else { echo "Excluded";}?>"><?php echo $status_icon ?></span>
                            </td>
                            <td><?php echo $author ?></td>
                            <td><?php echo $created ?></td>
                            <td><?php echo $modified ?></td>
                        </tr>
                    <?php }} else {
                        echo "<td class='text-center' colspan='10'> no CSS files </td>";
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12">
      <?php
          $sql = "SELECT id, name, type, status, created, modified, author FROM files WHERE type='js'";
          $stmt = $conn->prepare($sql);
          $stmt -> execute();
          $stmt -> store_result();
          $stmt -> bind_result($id, $name, $type, $status, $created, $modified, $author);
      ?>
        <div class="card">
            <div class="card-header bg-dark text-light text-center p-1">
                <h6 class="m-0">.JS</h6>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover cursor-pointer">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th class="text-center" style="width: 1em;">Status</th>
                            <th style="width: 1em;">Author</th>
                            <th style="width: 1em;">Created</th>
                            <th style="width: 1em;">Modified</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($stmt->num_rows > 0) {
                        while ($stmt->fetch()) {
                            switch ($status) {
                                case '0':
                                    $status_icon = '<i class="fas fa-unlink"></i>';
                                    $status_color = 'unpublished';
                                break;
                                case '1':
                                    $status_icon = '<i class="fas fa-link"></i>';
                                    $status_color = 'published';
                                break;
                            }
                    ?>
                        <tr class="<?php echo $status_color ?>">
                            <td style="width: 10px;"><?php echo $js_count++; ?></td>
                            <td onclick="location.href='edit-file?id=<?php echo $id ?>'">
                                <a data-toggle="tooltip" title="Edit" href="edit-file?id=<?php echo $id ?>"><?php echo $name.".".$type?></a>
                            </td>
                            <td class="text-center">
                                <span data-toggle="tooltip" title="<?php if ($status == 1) { echo "Included"; } else { echo "Excluded";}?>"><?php echo $status_icon ?></span>
                            </td>
                            <td><?php echo $author ?></td>
                            <td><?php echo $created ?></td>
                            <td><?php echo $modified ?></td>
                        </tr>
                    <?php }} else { echo "<td class='text-center' colspan='10'> no JS files </td>"; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
