<?php
 $start = microtime(true);
require_once(dirname(__FILE__).'/config.php');
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->libdir .'/filelib.php');


// Output the data

require_login();
// End profiling
$login_duration = (microtime(true) - $start);
 
// Output the data
echo "Config & login check took: ".number_format($login_duration, 12);


$PAGE->set_url('/', $urlparams);
$PAGE->set_pagelayout('frontpage');
$PAGE->set_other_editing_capability('moodle/course:update');
$PAGE->set_other_editing_capability('moodle/course:manageactivities');
$PAGE->set_other_editing_capability('moodle/course:activityvisibility');
// Prevent caching of this page to stop confusion when changing page after making AJAX changes.
$PAGE->set_cacheable(false);


$start = microtime(true);
$PAGE->set_pagetype('site-index');
$PAGE->set_docs_path('');
$editing = $PAGE->user_is_editing();
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);
$courserenderer = $PAGE->get_renderer('core', 'course');
echo $OUTPUT->header();

// End profiling
$header_duration = (microtime(true) - $start);

// Output the data
echo "Header took: ".number_format($header_duration, 12);


$other_duration = microtime(true);

// Trigger event.
course_view(context_course::instance(SITEID));
// If the hub plugin is installed then we let it take over the homepage here.
if (file_exists($CFG->dirroot.'/local/hub/lib.php') and get_config('local_hub', 'hubenabled')) {
    require_once($CFG->dirroot.'/local/hub/lib.php');
    $hub = new local_hub();
    $continue = $hub->display_homepage();
    // Function display_homepage() returns true if the hub home page is not displayed
    // ...mostly when search form is not displayed for not logged users.
    if (empty($continue)) {
        exit;
    }
}
$PAGE->set_pagetype('site-index');
$PAGE->set_docs_path('');
$editing = $PAGE->user_is_editing();
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);
$courserenderer = $PAGE->get_renderer('core', 'course');
echo $OUTPUT->header();
$siteformatoptions = course_get_format($SITE)->get_format_options();
$modinfo = get_fast_modinfo($SITE);
$modnamesused = $modinfo->get_used_module_names();
// Print Section or custom info.
if (!empty($CFG->customfrontpageinclude)) {
    // Pre-fill some variables that custom front page might use.
    $modnames = get_module_types_names();
    $modnamesplural = get_module_types_names(true);
    $mods = $modinfo->get_cms();
    include($CFG->customfrontpageinclude);
} else if ($siteformatoptions['numsections'] > 0) {
    echo $courserenderer->frontpage_section1();
}
// Include course AJAX.
include_course_ajax($SITE, $modnamesused);
echo $courserenderer->frontpage();
if ($editing && has_capability('moodle/course:create', context_system::instance())) {
    echo $courserenderer->add_new_course_button();
}
echo $OUTPUT->footer();

$other_duration_end = (microtime(true) - $other_duration);

// Output the data
echo "fullpage took: ".number_format($other_duration_end, 12);




