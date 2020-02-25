<?php
function space_disk_usage() {
	$disktotal = disk_total_space ('/');
	$diskfree  = disk_free_space  ('/');
	$diskuse   = round (100 - (($diskfree / $disktotal) * 100)) .'%';

	return $diskuse;
}

?>

<h5 class="mb-4 text-secondary">
    Statistics
</h5>

<div class="row mb-3">
    <div class="col-xl-4 col-lg-6 py-2">
        <div class="card">
            <div class="card-body">
                <i class="fas fa-globe fa-4x"></i>
                <h6 class="text-muted">Your IP</h6>
                <h1 class="display-5"><?php echo $_SERVER['REMOTE_ADDR'] ?></h1>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 py-2">
        <div class="card">
            <div class="card-body">
                <i class="fas fa-server fa-4x"></i>
                <h6 class="text-muted">Server's IP</h6>
                <h1 class="display-5"><?php echo $_SERVER['SERVER_ADDR'] ?></h1>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 py-2">
        <div class="card">
            <div class="card-body">
                <i class="fas fa-hdd fa-4x"></i>
                <h6 class="text-muted">Server's Storage</h6>
                <h1 class="display-5"><?php echo space_disk_usage(); ?></h1>
            </div>
        </div>
    </div>
		<div class="col-xl-4 col-lg-6 py-2">
        <div class="card">
            <div class="card-body">
                <i class="fab fa-php fa-4x"></i>
                <h6 class="text-muted">PHP VERSION</h6>
                <h1 class="display-5"><?php echo phpversion(); ?></h1>
            </div>
        </div>
    </div>
</div>
