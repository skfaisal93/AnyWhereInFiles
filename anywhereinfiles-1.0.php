<?php
/***********************************************************************
 * @name  AnyWhereInFiles
 * @author Faisal Shaikh 
 * @abstract This project is to find out a part of string from anywhere in any folder
 * @version 1.0  
 * @package anywhereinfiles
 *
 *
 *
 *
 *************************************************************************/
session_start();

?>
<title>Any where In Files || AnyWhereInFiles.php</title>
<head>
    <style>
        h1{color:  #233E99;}
        td{ font-size:11px; font-family:arial;vertical-align:top;border:1px solid #fff;}
        a{font-size:11px; font-family:arial;}
        .me{font-size:11px; font-family:arial;color:#333;}
    </style>
</head>
<h1>AnyWhereInFiles.php</h1>
<form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">  
    <table>
        <tbody>
            <tr>
                <td><label for="search">String </label></td>
                <td><input id="search" type="text" name="search" placeholder="Enter your string" value="<?php
if (isset($_SESSION['searchString']) && $_SESSION['searchString'] != null)
    echo $_SESSION['searchString'];
?>" /></td>
            </tr>
            <tr>
                <td><label for="directory">Folder </label></td>
                <td><input id="directory" type="text" name="directory"  value="<?php
echo getcwd();
?>" /></td>
            </tr>
            <tr>
                <td><label for="case">Case Sensitive </label></td>
                <td><input type="checkbox" name="case" /></td>
            </tr>
            <tr>
                <td><label for="maxtime">Max Execution Time </label></td>
                <td><input type="text" name="maxtime" value="30"/></td>
                <td>Do not change the value if you do not have an idea about it.</td>
            </tr>
            <tr>
                <td><input type="submit" value="Search the string" /></td>
            </tr>
        </tbody>
    </table>
</form>

<?php

function getDirContents($dir, &$results = array())
{
    
    if ($_POST['search'] == null)
        exit;
    
    ini_set('max_execution_time', $_POST['maxtime']);
    
    $_SESSION['searchString'] = $_POST['search'];
    
    echo "<script>var elm = document.getElementById('search');elm.value='$_POST[search]';</script>";
    
    if (!isset($_POST['case']))
        $string = strtolower($_POST['search']);
    else
        $string = $_POST['search'];
    $files = scandir($dir);
    
    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $content = file_get_contents($path);
            if (!isset($_POST['case']))
                $content = strtolower(file_get_contents($path));
            if (strpos($content, $string) !== false) {
                echo $path . "<br>";
            }
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }
    return $results;
}
if (isset($_POST['directory']))
    getDirContents($_POST['directory']);

//---------------------------------------------------------------------------------------------------------------------------------//
//@endof file anywhereinfiles.php
//@note if you have query, need, idea, help; feel free to contact f.shaikh1993@gmail.com

?>

<br/>
<br/>
<span  class="me">"AnyWhereInFiles" is a Open Source Project, developed by <a href="mailto:f.shaikh1993@gmail.com">Faisal Shaikh</a> . 
<br /> 
<a href="https://github.com/skfaisal93/AnyWhereInFiles">https://github.com/skfaisal93/AnyWhereInFiles</a>
</span>
