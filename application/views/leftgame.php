    <div class="vernav2 iconmenu">
        <ul>
            <?php
            //var_dump($menu);
            foreach ($menu as $mn) {
                echo '<li>';
                if (@$mn["shown"]) {
                    if ($mn["self"]["uri"] == "/") {
                        $flist = "<a class='editor'>" . $mn["self"]["title"] . "</a>";
                    } else {
                        // $flist = "<a href='#formsub' class='addons'>" . $mn["self"]["title"] . "</a>";
                        $flist = anchor($mn["self"]["uri"], $mn["self"]["title"], array('class' => 'editor'));
                    }
                    echo $flist;
                    echo "<span class='arrow'></span>";
                    echo " <ul class='formsub' style='display: block;'>";
                    if (isset($mn["child"])) {
                        foreach ($mn["child"] as $cmn) {
                            if (@$cmn["shown"]) {
                                if ($cmn["self"]["uri"] == "/") {
                                    $slist = "<a class='list-group-item'>&nbsp;&nbsp;&nbsp;&nbsp;<span class='glyphicon glyphicon-align-left'></span> " . $cmn["self"]["title"] . "</a>";
                                } else {
                                    $slist = anchor($cmn["self"]["uri"], '&nbsp;&nbsp;&nbsp;&nbsp;' . $cmn["self"]["title"], array('class' => 'list-group-item'));
                                }
                                echo $slist;
                                if (isset($cmn["child"])) {
                                    foreach ($cmn["child"] as $gcmn) {
                                        if (@$gcmn["shown"]) {
                                            $tlist = anchor($gcmn["self"]["uri"], "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $gcmn["self"]["title"]);
                                            echo $tlist;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    echo '</ul>';
                }
                echo '</li>';
            }
            ?>
        </ul>
        <br /><br />
    </div>