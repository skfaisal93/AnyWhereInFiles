<?php
$version = 1.3;
/***********************************************************************
 * @name  AnyWhereInFiles
 * @author Faisal Shaikh
 * @abstract This project is to find out a part of string from anywhere in any folder
 * @version 1.1
 * @package anywhereinfiles
 *
 *
 *
 *
 *************************************************************************/
function sanitize($text) {
    $temp = $text;
    $text = sanitize_core($text);
    $text = $text . " ";
    $text = str_replace('&amp;', '&', $text);
    $search = "/((?#Email)(?:\S+\@)?(?#Protocol)(?:(?:ht|f)tp(?:s?)\:\/\/|~\/|\/)?(?#Username:Password)(?:\w+:\w+@)?(?#Subdomains)(?:(?:[-\w]+\.)+(?#TopLevel Domains)(?:com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum|travel|a[cdefgilmnoqrstuwz]|b[abdefghijmnorstvwyz]|c[acdfghiklmnoruvxyz]|d[ejkmnoz]|e[ceghrst]|f[ijkmnor]|g[abdefghilmnpqrstuwy]|h[kmnrtu]|i[delmnoqrst]|j[emop]|k[eghimnprwyz]|l[abcikrstuvy]|m[acdghklmnopqrstuvwxyz]|n[acefgilopruz]|om|p[aefghklmnrstwy]|qa|r[eouw]|s[abcdeghijklmnortuvyz]|t[cdfghjkmnoprtvwz]|u[augkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw]|aero|arpa|biz|com|coop|edu|info|int|gov|mil|museum|name|net|org|pro))(?#Port)(?::[\d]{1,5})?(?#Directories)(?:(?:(?:\/(?:[-\w~!$+|.,=]|%[a-f\d]{2})+)+|\/)+|#)?(?#Query)(?:(?:\?(?:[-\w~!$+|\/.,*:]|%[a-f\d{2}])+=?(?:[-\w~!$+|.,*:=]|%[a-f\d]{2})*)(?:&(?:[-\w~!$+|.,*:]|%[a-f\d{2}])+=?(?:[-\w~!$+|.,*:=]|%[a-f\d]{2})*)*)*(?#Anchor)(?:#(?:[-\w~!$+|\/.,*:=]|%[a-f\d]{2})*)?)([^[:alpha:]]|\?)/i";
    return trim($text);
}
function sanitize_core($text) {
    $text = htmlspecialchars($text, ENT_NOQUOTES);
    $text = str_replace("\n\r", "\n", $text);
    $text = str_replace("\r\n", "\n", $text);
    $text = str_replace("\n", " <br> ", $text);
    $text = trim($text);
    return $text;
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'getFileContent' && isset($_REQUEST['filePath'])) {
    echo sanitize(file_get_contents($_REQUEST['filePath']));
    exit;
}
session_start();
?>
<title>Any where In Files || AnyWhereInFiles.php</title>
<head>
    <style>
        button {border-radius: 45px;}
        h1{color:  #233E99;}
        td{ font-size:11px; font-family:arial;vertical-align:top;border:1px solid #fff;}
        a{font-size:11px; font-family:arial;}
        .path{text-indent:50px;text-align:justify;letter-spacing:3px;}
        .me{font-size:11px; font-family:arial;color:#333;}
        .indicate{font-weight: bold;}
        .label{border-radius: 45px;background-color: #DCDCDC;padding: 1px 10px 1px 10px}
    </style>
    <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script>

    	$( document ).ready(function() {

    		if ($.cookie('directory') != "" && $.cookie('directory') != null)
    			$("[name='directory']").val($.cookie('directory'));

  			if ($.cookie('case') == 1)
  				$("[name='case']").prop('checked', true);
  			else if ($.cookie('case') == 0)
  				$("[name='case']").prop('checked', false);

  			if ($.cookie('content') == 1)
  				$("[name='content']").prop('checked', true);
  			else if ($.cookie('content') == 0)
  				$("[name='content']").prop('checked', false);

  			if ($.cookie('file') == 1)
  				$("[name='file']").prop('checked', true);
  			else if ($.cookie('file') == 0)
  				$("[name='file']").prop('checked', false);

  			if ($.cookie('occurrences') == 1)
  				$("[name='occurrences']").prop('checked', true);
  			else if ($.cookie('occurrences') == 0)
  				$("[name='occurrences']").prop('checked', false);

  			if ($.cookie('showLabel') == 1)
  				$("[name='showLabel']").prop('checked', true);
  			else if ($.cookie('showLabel') == 0)
  				$("[name='showLabel']").prop('checked', false);
		});

        var searchElements = [];
        function openFile(object) {
            $.ajax( 
               {
                   url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                   data: {'action': 'getFileContent', 'filePath': object.value},
                   type: 'GET',
                   success: function(result) 
                   {
                   		if (object.value.indexOf("\\") >= 0)
                   			var title = object.value.substr(object.value.lastIndexOf("\\") + 1);
                   		else 
                   			var title = object.value.substr(object.value.lastIndexOf("/") + 1);
                        var w = window.open();
                        $(w.document.body).html(result);
                        w.document.title = title;
                   }
                }
            );
        }


        function validateSitec() {

        	if ($("[name='directory']").val().trim().length == 0 || $("[name='search']").val().trim().length == 0) { 
        		return false;
        	}

        	if ($("[name='directory']").val().trim().length != 0) 
				$.cookie("directory", $("[name='directory']").val());
			else
				$.cookie("directory", "");

			if ($("[name='case']").is(':checked'))
				$.cookie("case", 1);
			else
				$.cookie("case", 0);

			if ($("[name='content']").is(':checked'))
				$.cookie("content", 1);
			else
				$.cookie("content", 0);

			if ($("[name='file']").is(':checked'))
				$.cookie("file", 1);
			else
				$.cookie("file", 0);

			if ($("[name='occurrences']").is(':checked'))
				$.cookie("occurrences", 1);
			else
				$.cookie("occurrences", 0);

			if ($("[name='showLabel']").is(':checked'))
				$.cookie("showLabel", 1);
			else
				$.cookie("showLabel", 0);

			return true;

			/****
			string
			directory
			case
			content
			file
			occurrences
			showLabel
			max
			*****/
		}



        function addSearchBox() {
            if($("#addBoxButton").prev().val().trim() != "") {
                $("#addBoxButton").remove();
                $("#searchBoxes").append('<input class="inputvalue" style="margin-left:3px;" id="search" type="text" name="search" placeholder="Enter your string" />');
                $("#searchBoxes").append('<input style="margin-left:3px;margin-top:3px" id="addBoxButton" type="button" value="+" onclick="addSearchBox()" />');
            }
        }
        function submit_form() {
            var inputs = $(".inputvalue");
            for(var i = 0; i < inputs.length; i++) {
                if($(inputs[i]).val().trim() !="")
                    searchElements.push($(inputs[i]).val());
                else if (inputs.size()!=1)
                    $(inputs[i]).remove();
            }
            $("#searchStrings").val(JSON.stringify(searchElements));
            if (validateSitec())
            	$("#searchForum").submit();
        }
    </script>
</head>
<h1>AnyWhereInFiles.php</h1>
<form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST" id="searchForum">  
    <table>
        <tbody>
            <tr>
                <td><label for="search">String </label></td>
                <td id="searchBoxes" >
                    <input hidden id="searchStrings" name="searchStrings" />
                    <input id="search" class="inputvalue" style="margin-right:-3px" type="text" name="search" placeholder="Enter your string" value="<?php if (isset($_SESSION['searchString']) && $_SESSION['searchString'] != null) echo $_SESSION['searchString']; ?>" />
                    <input id="addBoxButton" style="margin-left:3px;margin-top:3px" type="button" value="+" onclick="addSearchBox()" />
                </td>
            </tr>
            <tr>
                <td><label for="directory">Folder </label></td>
                <td><input id="directory" type="text" name="directory" value="<?php echo getcwd(); ?>" /></td>
            </tr>
            <tr>
                <td><label for="case">Case Sensitive </label></td>
                <td><input type="checkbox" name="case" /></td>
            </tr>
            <tr>
                <td><label for="content">Search String </label></td>
                <td><input type="checkbox" name="content" checked /></td>
            </tr>
            <tr>
                <td><label for="file">Search File Names </label></td>
                <td><input type="checkbox" name="file" checked /></td>
            </tr>
            <tr>
                <td><label for="occurrences">Count The Number Of Occurrences </label></td>
                <td><input type="checkbox" name="occurrences" checked /></td>
            </tr>
            <tr>
                <td><label for="showLabel">Show Label </label></td>
                <td><input type="checkbox" name="showLabel" checked /></td>
            </tr>
            <tr>
                <td><label for="maxtime">Max Execution Time </label></td>
                <td>
                    <input type="text" name="maxtime" value="30"/>
                    <span>Do not change the value if you do not have an idea about it.</span>
                </td>
            </tr>
            <tr>
                <td><input type="button" onclick="submit_form();" value="Search the string" /></td>
            </tr>
        </tbody>
    </table>
</form>
<span id='resultCount' class='path'></span>
<?php
$count = 0;
function getDirContents($dir, &$results = array()) {
	global $count;
    $searchStrings = array();

    if(isset($_POST['searchStrings'])) 
        $searchStrings = json_decode($_POST['searchStrings'], true);
    
    if ($_POST['search'] == null) { echo "1"; exit;}
    
    ini_set('max_execution_time', $_POST['maxtime']);
    
    $_SESSION['searchString'] = $_POST['search'];
    
    echo "<script>var elm = document.getElementById('search');elm.value='$_POST[search]';</script>";
    
    if (!isset($_POST['case'])) $string = strtolower($_POST['search']);
    else $string = $_POST['search'];
    $files = scandir($dir);
    
    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            
            if (!isset($_POST['case'])) $content = strtolower(file_get_contents($path));
            else $content = file_get_contents($path);
            $label = null;
            $fileName = basename($path, '?' . $_SERVER['QUERY_STRING']);
            foreach ($searchStrings as $tmp) {
            	if(isset($_POST['content'])){
	                if (strpos($content, $tmp) !== false) {
	                    if (isset($_POST['occurrences'])) {
	                        $label = $label."&nbsp&nbsp <label class='label'>".$tmp."</label>&nbsp&nbsp" .substr_count($content, $tmp). "&nbsp&nbsp&nbsp";
	                    } else 
	                        $label = $label."&nbsp&nbsp <label class='label'>".$tmp."</label>&nbsp&nbsp";
	                    $count++;
	                }
	            }
                if (isset($_POST['file'])) {
                    if (strpos($fileName, $tmp) !== false) {
                        echo "<span class='indicate'>file-</span><span class='path'>" . $path . "</span>".$label."</label> <button value='" . $path . "' onclick='openFile(this)'>Open</button>" . "<br>";
                        $results[] = $path;
                        $count++;
                    }   
                }
            }
            if ($label) {
                if (!isset($_POST['showLabel'])) 
                    $label = "";
                echo "<span class='path'>" . $path . "</span>".$label."<button value='" . $path . "' onclick='openFile(this)'>Open</button><br>";
                $results[] = $path;
            }
        } 
        else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }
}
if (isset($_POST['directory'])) {
    getDirContents($_POST['directory']);
    if(!$count) 
        echo "<span class='path'>Sorry No Result Found.</span><br /><br />";
    else 
        echo "<script>$('#resultCount').append('".$count." search results found<br /><br />')</script>";

    sleep(1);
    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    echo "Process Time: {$time}";
}

//---------------------------------------------------------------------------------------------------------------------------------//
//@endof file anywhereinfiles.php
//@note if you have query, need, idea, help; feel free to contact f.shaikh1993@gmail.com || https://www.facebook.com/Skfaisal93
$newVer = file_get_contents("https://raw.githubusercontent.com/skfaisal93/AnyWhereInFiles/master/latest-version.txt");
if($newVer > $version)
	echo "<a href='https://raw.githubusercontent.com/skfaisal93/AnyWhereInFiles/master/anywhereinfiles-$newVer.php' download hidden id='download'></a>
	<script>
		if(confirm('New version is available. Download now?')){
        	document.getElementById('download').click();
    	} else {
			
    	}
	</script>";

?>
<br/>
<br/>
<span  class="me">"AnyWhereInFiles" is a Open Source Project, developed by <a href="https://www.facebook.com/Skfaisal93">Faisal Shaikh (f.shaikh1993@gmail.com)</a>. 

<br /> 
<a href="https://github.com/skfaisal93/AnyWhereInFiles">https://github.com/skfaisal93/AnyWhereInFiles</a>
</span>
