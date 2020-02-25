<?php

// fetch website settings and info
$website_result = $conn->query("SELECT * FROM website WHERE id = 1");
$website = $website_result->fetch_object();
$website_result->close();

define ("GET_PAGE", isset($_GET['page']) ? $_GET['page'] : null);
define ("LOGGED_IN", isset($_SESSION['id']) ? true : false);

define ("WEBSITE_TITLE", $website->title);
define ("WEBSITE_DESCRIPTION", $website->description);
define ("WEBSITE_KEYWORDS", $website->keywords);
define ("WEBSITE_AUTHOR", $website->author);
define ("WEBSITE_ROBOTS", $website->robots);
define ("WEBSITE_FAVICON", $website->favicon);
define ("WEBSITE_MAINTENANCE", $website->maintenance);
define ("WEBSITE_DEFAULT_PAGE", $website->default_page);
define ("WEBSITE_GA_CODE", $website->ga_code);

// get page variable or set it to NULL if is not set
$page_url = GET_PAGE;
// path of the page for INDEX
$page_path = "template/pages/". GET_PAGE .".php";

$page_url = !empty(GET_PAGE) ? GET_PAGE : WEBSITE_DEFAULT_PAGE;

// fetch current page info
$current_page_result = $conn->query("SELECT * FROM pages WHERE link='$page_url'");
$current_page = $current_page_result->fetch_object();

if ($current_page_result->num_rows > 0) {
    define ("PAGE_ID", $current_page->id);
    define ("PAGE_NAME", $current_page->name);
    define ("PAGE_PUBLISHED", $current_page->published);
    define ("PAGE_URL", $current_page->link);
    define ("PAGE_LAST_UPDATE", $current_page->last_update);
    define ("PAGE_CREATED", $current_page->created);
    define ("PAGE_DESCRIPTION", $current_page->description);
    define ("PAGE_KEYWORDS", $current_page->keywords);
    define ("PAGE_ROBOTS", $current_page->robots);
}
$current_page_result->close();

?>
