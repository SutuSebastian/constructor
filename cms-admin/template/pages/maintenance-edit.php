<div id="editorSuccess"></div>
<h5 class="mb-4 text-secondary">
    <a class="text-dark" href="pages">Pages</a> > Maintenance Page
</h5>
<div class="card">
    <div class="card-header bg-dark text-white p-1">
        <h6 class="text-center m-0">Maintenance</h6>
        <button id="toggle_editor_fullscreen" class="btn btn-sm pr-2 text-muted">
            Fullscreen
            <i class="fas fa-compress"></i>
        </button>
    </div>
    <div id="maintenanceEditor" class="editor"></div>
    <textarea id="maintenanceVal" class="d-none"><?php readfile('../template/pages/maintenance.php'); ?></textarea>
    <button id="update_maintenance" onclick="updateEditor('maintenance')" class="btn btn-dark border-top-radius-0">Update</button>
</div>
