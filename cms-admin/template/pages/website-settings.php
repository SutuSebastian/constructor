<?php
(WEBSITE_ROBOTS === 'index, follow') ? $index='checked' : $index = null;
(WEBSITE_MAINTENANCE > 0) ? $maintenance='checked' : $maintenance = null;

$default_page_result = $conn->query("SELECT * FROM pages WHERE published = 1");
?>
<h5 class="mb-4 text-secondary">
    Website Settings
</h5>
<div class="card">
    <div class="card-header bg-dark text-light text-center p-1">
        <h6 class="m-0">WEBSITE</h6>
    </div>
    <div class="card-body">
        <h5>Favicon</h5>

        <?php if (empty(WEBSITE_FAVICON)) { ?>
            <!-- add profile image -->
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="custom-file mb-2" style="max-width: 400px;">
                    <input type="file" name="favicon" class="custom-file-input" id="customFile" required>
                    <label class="custom-file-label justify-content-start" for="customFile">Choose file</label>
                </div>
                <br>
                <button class="btn btn-dark btn-sm" type="submit" name="add_favicon_submit">Add Icon</button>
            </form>
        <?php } else { ?>
            <img style="max-height:100px" src="../template/assets/img/favicon/<?php if (empty(WEBSITE_FAVICON)) { echo 'default_profile_image.png'; } else { echo WEBSITE_FAVICON; } ?>" alt="user profile image">
            <!-- remove profile image-->
            <form action="" method="POST">
                <input type="hidden" name="favicon" value="<?php echo WEBSITE_FAVICON ?>">
                <button class="btn btn-danger btn-sm mt-2" type="submit" name="delete_favicon_submit" onClick="return confirm('Remove favicon?')">
                    Delete icon
                </button>
            </form>
        <?php } ?>

        <hr>
        <form action="" method="POST">
            <h5>Identity</h5>
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Title</span>
                </div>
                <input class="form-control" name="site_title" placeholder="Website Title" value="<?php echo WEBSITE_TITLE ?>" required>
            </div>
            <hr>
            <h5>META Tags</h5>
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Description</span>
                </div>
                <input class="form-control" name="site_description" placeholder="Meta Description" value="<?php echo WEBSITE_DESCRIPTION ?>">
            </div>
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Author</span>
                </div>
                <input class="form-control" name="site_author" placeholder="Author" value="<?php echo WEBSITE_AUTHOR ?>">
            </div>
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Keywords</span>
                </div>
                <input class="form-control" name="site_keywords" placeholder="Meta Keywords" value="<?php echo WEBSITE_KEYWORDS ?>">
            </div>
            <label class="text-muted">Must be separated by <code> , </code></label>
            <hr>
            <h5>SEO | Indexing</h5>
            <div class="form-group">
                <h6 class="text-muted">To be indexed by search engines</h6>
                <label class="switch">
                    <input name="site_robots" type="checkbox" value="index, follow"<?php echo $index ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <hr>
            <h5>Google Analytics</h5>
            <h6 class="text-muted">Example: UA-XXXXXXXXX-X</h6>
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Tracking Code</span>
                </div>
                <input class="form-control" name="ga_code" placeholder="UA-XXXXXXXXX-X" value="<?php echo WEBSITE_GA_CODE ?>">
            </div>
            <hr>
            <h5>Maintanance mode</h5>
            <div class="form-group">
                <h6 class="text-muted">Enabling this will make website display Maintenance-Mode</h6>
                <label class="switch">
                    <input name="maintenance_status" type="checkbox" value="1"<?php echo $maintenance ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <hr>
            <h5>Default home page</h5>
            <div class="form-group">
              <h6 class="text-muted">Only the public pages can be set to default.</h6>
                <select class="form-control form-control-sm" style="max-width: 8rem;" name="default_page">
                <?php
                if ($default_page_result->num_rows > 0) {
                    while ($default_page = $default_page_result->fetch_object()) {
                ?>
                    <option value="<?php echo $default_page->link ?>" <?php if (WEBSITE_DEFAULT_PAGE === $default_page->link) { echo 'selected'; } ?>><?php echo $default_page->name ?></option>
                <?php
                }}
                $default_page_result->close();
                ?>
                </select>
            </div>
            <button type="submit" class="btn btn-dark btn-sm" name="identity_submit">Submit</button>
        </form>
    </div>
</div>
