<div id="editorSuccess"></div>
<h5 class="mb-4 text-secondary">
    CSS & JS Libraries
</h5>
<div class="card">
    <div class="card-header bg-dark text-white p-1">
        <h6 class="text-center m-0">Styles</h6>
    </div>
    <div id="link_styleEditor" style="height: 40vh;"></div>
    <xmp id="link_styleVal" class="d-none"><?php readfile('../template/inc/link-style.php'); ?></xmp>

    <div class="card-header bg-dark text-white p-1">
        <h6 class="text-center m-0">Scripts</h6>
    </div>
    <div id="link_scriptEditor" style="height: 40vh;"></div>
    <xmp id="link_scriptVal" class="d-none"><?php readfile('../template/inc/link-script.php'); ?></xmp>
    <button id="update_resources" onclick="updateEditor()" class="btn btn-dark border-top-radius-0">Update</button>
</div>
