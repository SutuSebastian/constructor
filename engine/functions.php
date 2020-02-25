<?php

// get unique visitor IP and DATE
$visitor_IP          = $_SERVER['REMOTE_ADDR'];
$visitor_access_date = date('Y-m-d');

$visitor_click_add = $conn->prepare("INSERT INTO total_visits (ip_address,visit_date) VALUES (?,?)");
$visitor_click_add->bind_param("ss", $visitor_IP, $visitor_access_date);
if (!$visitor_click_add->execute()) {
    echo "There was an error adding visitor clicks! ** CHECK DATABASE STRUCTURE **";
}

$unique_visitor_check = $conn->query("SELECT * FROM unique_visits WHERE ip_address='$visitor_IP' AND visit_date='$visitor_access_date'");
if ($unique_visitor_check->num_rows == 0) {
    $unique_visitor_add = $conn->prepare("INSERT INTO unique_visits (ip_address,visit_date) VALUES (?,?)");
    $unique_visitor_add->bind_param("ss", $visitor_IP, $visitor_access_date);
    if (!$unique_visitor_add->execute()) {
        echo "There was an error adding unique visitor! ** CHECK DATABASE STRUCTURE **";
    }
    $unique_visitor_add->close();
}

// get base href
function get_base_href() {
    $_SERVER['SCRIPT_NAME'] = preg_replace('/index.php/', '', $_SERVER['SCRIPT_NAME']);

    if (isset($_SERVER['HTTPS'])) {
        if ($_SERVER['SERVER_NAME'] == "127.0.0.1" || $_SERVER['SERVER_NAME'] == "localhost") {
            echo "https://". $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
        } else {
            echo "https://". $_SERVER['SERVER_NAME'];
        }
    } else {
        if ($_SERVER['SERVER_NAME'] == "127.0.0.1" || $_SERVER['SERVER_NAME'] == "localhost") {
            echo "http://". $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
        } else {
            echo "http://". $_SERVER['SERVER_NAME'];
        }
    }
}

// get Google Analytics Code
function get_ga_code() {
    if (!empty(WEBSITE_GA_CODE)) {
    ?><!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo WEBSITE_GA_CODE ?>"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '<?php echo WEBSITE_GA_CODE ?>');
    </script><?php
    }
}

// get CSS
function get_css() {
    global $conn;

    $css_result = $conn->query("SELECT name FROM files WHERE type = 'css' AND status = 1");
    if ($css_result->num_rows > 0) {
        while ($included_css = $css_result->fetch_object()) {
            echo "<link rel='stylesheet' href='template/assets/css/$included_css->name.css'>"."\r\n";
        }
    }
}

// get JS
function get_js() {
    global $conn;

    $js_result = $conn->query("SELECT name FROM files WHERE type = 'js' AND status = 1");
    if ($js_result->num_rows > 0) {
        while ($included_js = $js_result->fetch_object()) {
            echo "<script src='template/assets/js/$included_js->name.js'></script>"."\r\n";
        }
    }
}

// check if page is published
function is_published($page_link) {
    global $conn;

    $pages_sql = "SELECT published FROM pages WHERE link=?";
    $pages = $conn->prepare($pages_sql);
    $pages->bind_param('s', $page_link);

    if ($pages->execute()) {
        $pages->bind_result($published);
        $pages->fetch();
        $pages->close();
        if ($published) {
            return true;
        } else {
            return false;
        }
    }
}

function get_title() {
    if (LOGGED_IN) {
        if (!GET_PAGE || empty(GET_PAGE) || GET_PAGE == WEBSITE_DEFAULT_PAGE) {
            echo WEBSITE_TITLE;
            return;
        }
        // if page doesn't exist => page not found
        if (!file_exists("template/pages/". GET_PAGE .".php")) {
            echo "Page not found - ". WEBSITE_TITLE;
            return;
        }
        // display title
        echo PAGE_NAME ." - ". WEBSITE_TITLE;
    } else {
        // if maintenance is enabled => we will be back..
        if (WEBSITE_MAINTENANCE) {
            echo "We will be back soon! - ". WEBSITE_TITLE;
            return;
        }
        if (!GET_PAGE || empty(GET_PAGE) || GET_PAGE == WEBSITE_DEFAULT_PAGE) {
            echo WEBSITE_TITLE;
            return;
        }
        // if page is not public => page not found
        if (!is_published(GET_PAGE)) {
            echo "Page not found - ". WEBSITE_TITLE;
            return;
        }
        // display title
        echo PAGE_NAME ." - ". WEBSITE_TITLE;
    }
}


function get_description() {
    if (LOGGED_IN) {
        if (!GET_PAGE || !file_exists("template/pages/". GET_PAGE .".php")) {
            if (!empty(WEBSITE_DESCRIPTION)) { echo WEBSITE_DESCRIPTION; }
        } else {
            if (!empty(PAGE_DESCRIPTION)) { echo PAGE_DESCRIPTION; } else { echo WEBSITE_DESCRIPTION; }
        }
    } else {
        if (!GET_PAGE || WEBSITE_MAINTENANCE || !file_exists("template/pages/". GET_PAGE .".php")) {
            if (!empty(WEBSITE_DESCRIPTION)) { echo WEBSITE_DESCRIPTION; }
        } else {
            if (!empty(PAGE_DESCRIPTION)) { echo PAGE_DESCRIPTION; } else { echo WEBSITE_DESCRIPTION; }
        }
    }
}
function get_author() {
    if (!empty(WEBSITE_AUTHOR)) { echo WEBSITE_AUTHOR; }
}
function get_keywords() {
    if (LOGGED_IN) {
        if (!GET_PAGE || !file_exists("template/pages/". GET_PAGE .".php")) {
            if (!empty(WEBSITE_KEYWORDS)) { echo WEBSITE_KEYWORDS; }
        } else {
            if (!empty(PAGE_KEYWORDS)) { echo PAGE_KEYWORDS; } else { echo WEBSITE_KEYWORDS; }
        }
    } else {
        if (!GET_PAGE || WEBSITE_MAINTENANCE || !file_exists("template/pages/". GET_PAGE .".php")) {
            if (!empty(WEBSITE_KEYWORDS)) { echo WEBSITE_KEYWORDS; }
        } else {
            if (!empty(PAGE_KEYWORDS)) { echo PAGE_KEYWORDS; } else { echo WEBSITE_KEYWORDS; }
        }
    }
}
function get_robots() {
    if (LOGGED_IN) {
        if (!GET_PAGE) {
            echo WEBSITE_ROBOTS;
            return;
        }
        if (!file_exists("template/pages/". GET_PAGE .".php")) {
            echo "noindex, nofollow";
        } else {
            echo PAGE_ROBOTS;
        }
    } else {
        if (!GET_PAGE || WEBSITE_MAINTENANCE || !file_exists("template/pages/". GET_PAGE .".php")) {
            echo WEBSITE_ROBOTS;
        } else {
            echo PAGE_ROBOTS;
        }
    }
}
function get_icon() {
    if (!empty(WEBSITE_FAVICON)) { echo "template/assets/img/favicon/". WEBSITE_FAVICON; } else { echo "#";}
}


?>
