<?php

echo "<ul class=\"pagination\">";

// button for first page
if($page>1){
    echo "<li><a href=' " . htmlspecialchars($_SERVER['PHP_SELF']) . " ' title='Go to the first page.'>";
    echo " << First ";
    echo "</a></li>";
}

// count all rows in the database
$total_rows = $user->countAll();

// Returns the next highest integer value by rounding up value if necessary. 18/5=3,6 ~ 4
$total_pages = ceil($total_rows / $records_per_page); //ceil — Round fractions up

// range of num of links to show
$range = 2;

// display number of link to 'range of pages' and wrap around 'current page'
$initial_num = $page - $range;
$condition_limit_num = ($page + $range) + 1;


for ($x=$initial_num; $x<$condition_limit_num; $x++) {

    // setting the current page
    if (($x > 0) && ($x <= $total_pages)) {

        // display current page
        if ($x == $page) {
            echo "<li class='active'><a href=\"#\">$x <span class=\"sr-only\">(current)</span></a></li>";
        }

        // not current page
        else {
            echo "<li><a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page=$x'>$x</a></li>";
        }
    }
}

// button for last page
if($page<$total_pages){
    echo "<li><a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page={$total_pages}' title='Last page is {$total_pages}.'>";
    echo "Last >> ";
    echo "</a></li>";
}

echo "</ul>";




