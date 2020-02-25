<?php

$date_today = date('Y-m-d');
$unique_visitors = $conn->query("SELECT id FROM unique_visits WHERE visit_date='$date_today'");
$total_clicks    = $conn->query("SELECT id FROM total_visits WHERE visit_date='$date_today'");
$public_pages    = $conn->query("SELECT id FROM pages WHERE published = 1");

($unique_visitors->num_rows > 0) ? $unique_visitors_per_day=$unique_visitors->num_rows : $unique_visitors_per_day = "-";
($total_clicks->num_rows > 0) ? $total_clicks_per_day=$total_clicks->num_rows : $total_clicks_per_day = "-";
($public_pages->num_rows > 0) ? $total_public_pages=$public_pages->num_rows : $total_public_pages = "-";

?>
<h5 class="mb-4 text-secondary">
   Dashboard
</h5>

<h3><u></u></h3>
<div class="row mb-3">
    <div class="col-xl-4 col-lg-6 py-2">
        <div class="card">
            <div class="card-body">
                <i class="fas  fa-mouse-pointer fa-4x"></i>
                <h6 class="text-muted">Total Clicks <span class="text-muted">/ day</span></h6>
                <h1 class="display-5"><?php echo $total_clicks_per_day ?></h1>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 py-2">
        <div class="card">
            <div class="card-body">
                <i class="fas fa-users fa-4x"></i>
                <h6 class="text-muted">Unique Visits <span class="text-muted">/ day</span></h6>
                <h1 class="display-5"><?php echo $unique_visitors_per_day ?></h1>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 py-2">
        <div class="card">
            <div class="card-body">
                <i class="fas fa fa-copy fa-4x"></i>
                <h6 class="text-muted">Public Pages</h6>
                <h1 class="display-5"><?php echo $total_public_pages; ?></h1>
            </div>
        </div>
    </div>

</div>
