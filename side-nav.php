<?php
//show sidebar on everypage except login
    $page_name = basename($_SERVER['PHP_SELF'], ".php");      
            if ($page_name !== "login" && $page_name !== "register"){

                echo '<div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="tracklist.php"><i class="fa fa-twitter fa-fw"></i> Tracklist</a>
                        </li>
                        <li>
                            <a href="analysis.php"><i class="fa fa-bar-chart-o fa-fw"></i> Analysis</a>
                        </li>
                        <li>
                            <a href="review-export.php"><i class="fa fa-table fa-fw"></i> Review & Export</a>
                        </li>';
                        if ($_SESSION['account']['userRole']=='Super Admin')echo'<li>
                            <a href="system-admin.php"><i class="fa fa-dashboard fa-fw"></i> System Admin</a>
                        </li>';                        
                    echo'</ul>
                </div>
            
            </div>';}?>

