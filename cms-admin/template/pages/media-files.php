<h5 class="mb-4 text-secondary">
    Media Files
</h5>
<div class="mb-4">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="custom-file mb-2" style="max-width: 300px;">
            <input type="file" name="media_file[]" multiple="multiple" class="custom-file-input" id="customFile" required>
            <label class="custom-file-label justify-content-start" for="customFile"><i class="fas fa-upload"></i> Choose file</label>
        </div><br>
        <button class="btn btn-dark btn-sm" type="submit" name="media_file_upload_submit">
            Upload
        </button>
    </form>
</div>
<input id="search_table" class="mb-4 sticky-top form-control" placeholder="Search File">
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover bg-white text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-center">Type</th>
                    <th>Name</th>
                    <th class="text-center">Size</th>
                    <th class="text-center">Copy URL</th>
                    <th class="text-center">Download</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody id="search_tbody">
            <?php
            $dir = "../template/media/";
            $file_count = 1;
            function is_dir_empty($dir) {
                if (!is_readable($dir)) return NULL;
                return (count(scandir($dir)) == 2);
            }
            function human_filesize($bytes, $decimals = 2) {
                $sz = 'BKMGTP';
                $factor = floor((strlen($bytes) - 1) / 3);
                return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . " " . @$sz[$factor] . "B";
            }
            if ($dh = opendir($dir)) {
                if (is_dir_empty($dir)) {
                  echo "<tr><td colspan='7' class='text-center text-muted p-4'>There are no files</td></tr>";
                }

                while (($file = readdir($dh)) !== false) {
                    if ($file != "." && $file != "..") {
                        $fileExplode = explode('.', $file);
                        $extension = strtolower(end($fileExplode));
                        if ($extension == $file) {
                            $extension = "dir";
                        }
                        $file_size = filesize($dir.$file);
            ?>
                      <tr>
                          <td width="10"><?php echo $file_count++ ?></td>
                          <td width="10" class="text-center">
                              <img data-toggle="tooltip" title="<?php echo $extension ?>" height="30" src="template/assets/img/media-files/<?php echo $extension ?>.png" alt="">
                          </td>
                          <td>
                              <a href="../template/media/<?php echo $file ?>" data-toggle="tooltip" title="View" target="_blank"><?php echo $file ?></a>
                          </td>
                          <td width="100" class="text-center">
                              <?php echo human_filesize($file_size); ?>
                          </td>
                          <td width="100" class="text-center">
                              <button data-toggle="tooltip" title="Copy" class="btn btn-default copyToClipboard">
                                  <textarea class="d-none">template/media/<?php echo $file ?></textarea>
                                  <i class="fas fa-copy"></i>
                              </button>
                          </td>
                          <td width="100" class="text-center">
                              <a data-toggle="tooltip" title="Download" href="../template/media/<?php echo $file ?>" class="text-dark" download>
                                  <i class="fas fa-download"></i>
                              </a>
                          </td>
                          <td width="100" class="text-center">
                              <form action="" method="POST">
                                  <input type="hidden" name="media_file_name" value="<?php echo $file ?>">
                                  <button data-toggle="tooltip" title="Delete" class="btn btn-default text-danger p-0" type="submit" name="media_file_delete_submit" onclick="return confirm('Remove <?php echo $file ?>?')">
                                      <i class="fas fa-trash"></i>
                                  </button>
                              </form>
                          </td>
                      </tr>
                  <?php
                    }
                }
                closedir($dh);
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
