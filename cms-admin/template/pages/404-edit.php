<div id="editorSuccess"></div>
<h5 class="mb-4 text-secondary">
    <a class="text-dark" href="pages">Pages</a> > 404 Page
</h5>
<div class="card">
    <div class="card-header bg-dark text-white p-1">
        <h6 class="text-center m-0">404 (Error Page)</h6>
        <button id="toggle_editor_fullscreen" class="btn btn-sm pr-2 text-muted">
            Fullscreen
            <i class="fas fa-compress"></i>
        </button>
    </div>
    <div id="404Editor" class="editor"></div>
    <xmp id="404Val" class="d-none"><?php readfile('../template/pages/404.php'); ?></xmp>
    <button id="update_404" onclick="updateEditor('404')" class="btn btn-dark border-top-radius-0">Update</button>
</div>
