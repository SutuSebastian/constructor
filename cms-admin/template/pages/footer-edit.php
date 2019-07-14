<div id="editorSuccess"></div>
<h5 class="mb-4 text-secondary">
    Footer
</h5>
<div class="card">
    <div class="card-header bg-dark text-white p-1">
        <h6 class="text-center m-0">Footer</h6>
        <button id="toggle_editor_fullscreen" class="btn btn-sm pr-2 text-muted">
            Fullscreen
            <i class="fas fa-compress"></i>
        </button>
    </div>
    <div id="footerEditor" class="editor"></div>
    <xmp id="footerVal" class="d-none"><?php readfile('../template/inc/footer.php'); ?></xmp>
    <button id="update_footer" onclick="updateEditor('footer')" class="btn btn-dark border-top-radius-0">Update</button>
</div>
