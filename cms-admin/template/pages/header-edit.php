<div id="editorSuccess"></div>
<h5 class="mb-4 text-secondary">
    Header
</h5>
<div class="card">
    <div class="card-header bg-dark text-white p-1">
        <h6 class="text-center m-0">Header</h6>
        <button id="toggle_editor_fullscreen" class="btn btn-sm pr-2 text-muted">
            Fullscreen
            <i class="fas fa-compress"></i>
        </button>
    </div>
    <div id="navbarEditor" class="editor"></div>
    <xmp id="navbarVal" class="d-none"><?php readfile('../template/inc/navbar.php'); ?></xmp>
    <button id="update_navbar" onclick="updateEditor('navbar')" class="btn btn-dark border-top-radius-0">Update</button>
</div>
