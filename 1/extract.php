<?php

    $file = $_GET['file'];
 
    if (isset($file)){

        $dir = preg_replace('/(.epub)/', '', $file);
 
        system('unzip -q -o ' . $file . ' -d ' . $dir);

        $manifest = $dir."/OEBPS/content.opf";

        $f = file($manifest);
        $c = 0;
        for ($i=0;$i<count($f);$i++){
            if ( preg_match('(<itemref)', $f[$i]) ) {
                $c++;
                $val = trim($f[$i]);
                $val = preg_replace('(<itemref\sidref=\")', '', $val);
                $val = preg_replace('("/>)', '', $val);
                $link = $dir . "/OEBPS/" . $val . ".xhtml";
                echo('<a href="'.$link.'">'.$val.'</a><br />');
            }
        }

        exit;

    }
 ?>
<form action="extract.php" method="GET">
<?php
    $handler = opendir("."); 
    while ($file = readdir($handler)) {
        if (preg_match ("/.epub$/i", $file)){
            echo '<input type="radio" name="file" value=' . $file . '> ' . $file . '<br>';
        }
    }
    closedir($handler);
 ?>
<br />
<input type="submit" value="Extract" style="width:100px;" />


