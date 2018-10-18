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

