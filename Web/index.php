<?php
#error_reporting(E_ALL);
#ini_set('display_errors', '1');

define('zipPath', './files/zips/'); # the ziped files dir
define('filesPath', './files/zipable/'); # where the files to be ziped are
define('readme', 'Awesome you are for downloading our files.'); # use either a filepath or write a string # ./files/readme.txt / "Thank you for downloading our files for your own use.\nPlease let us know if you have problems with these files or if you want to give us a pat on the back."
define('prefix', 'YourSelection'); # zip file name prefix


$filesStr = NULL;
$filesFile = fopen('./zipableFilesDB.json', 'r')
  or die("unable to open file");
// add each line to string
while (!feof($filesFile)) {

  $filesStr .= fgets($filesFile);

}

fclose($filesFile);
$filesList = json_decode($filesStr, TRUE);

$hasERROR = FALSE;
$dataSent = FALSE;

// if data was sent to server
if (isset($_GET['s'])) {
    // VALIDATION
    // --get the requested files array--
  if (isset($_GET['files'][0]) && $_GET['files'][0] != '') {
    // blow it all up into an array
    $requestedFiles = explode(',', $_GET['files']);
  
  } elseif (isset($_GET['file'][0]) && $_GET['file'][0] != '') {
    // set requested files as get array file
    $requestedFiles = $_GET['file'];
  
  } else {
    // then there were no files requested
    $fileCheckedERROR = 'Select at least one file';
    $hasERROR = TRUE;

  }

  // if there are no errors do some real processing
  if ($hasERROR == FALSE) {
    // CREATE ZIP IF REQUESTED FILES IS SET
    if (isset($requestedFiles)) {
      
      for ($i = 0, $max = count($requestedFiles); $i < $max; $i++) {
      
        if ($requestedFiles[$i] == $filesList[$requestedFiles[$i]]['id']) {
          $validFilesList[] = $filesList[$requestedFiles[$i]]['id'];
        }
      
      }
      
      $zipName = prefix . '-' . implode('-', $validFilesList) . '.zip';


      if (!file_exists(zipPath . $zipName)) {
        // create new file for files to be added and ziped
        $newZipFile = fopen(zipPath . $zipName, 'w') or die('Could not create file');
        fclose($newZipFile);

        $zip = new ZipArchive();
        
        if ($zip->open(zipPath . $zipName, ZipArchive::CREATE)!==TRUE) {
        
            exit("cannot open <$zipName>\n");
        
        }
        
        foreach ($validFilesList as $id) {
        
          $zip->addFile(filesPath . $filesList[$id]['name'], $filesList[$id]['name']);
        
        }

        if (file_exists(readme)) {
          // reverse the filePath, split at first instance of delimiter, then only the first index in the array.
          $readmeFN = strrev(explode('/', strrev(readme), 2)[0]);
          $zip->addFile(readme, $readmeFN);
        
        } else {

          $zip->addFromString('README.txt', readme);
          
        }
        
        $zip->close();

        $createdZipFilesLog = json_decode(file_get_contents('./createdZipFiles.json'), TRUE);
        $date = new DateTime();
        $thisLog = array(
          'zipName' => $zipName,
          'timestamp' => $date->getTimestamp()
        );
        
        $createdZipFilesLog[] = $thisLog;
        file_put_contents('./createdZipFiles.json', json_encode($createdZipFilesLog, JSON_PRETTY_PRINT));
        $thingggggy = "zip file was created";
      
      } else {
      
        $thingggggy = "thing was already here";
      
      }
      
      function result($zipName) {
      
        return '<a href="'.zipPath.$zipName.'">'."\n".
               '  <svg id="svg12352" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" height="153.47" width="146.36" version="1.1" xmlns:cc="http://creativecommons.org/ns#" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:dc="http://purl.org/dc/elements/1.1/"><defs id="defs12354"><radialGradient id="radialGradient13512" gradientUnits="userSpaceOnUse" cy="656.26" cx="111.44" gradientTransform="matrix(1,0,0,0.17105488,0,544.00126)" r="23.593"><stop id="stop13427" stop-color="#000" offset="0"/><stop id="stop13437" stop-color="#000" stop-opacity="0.32478634" offset="0.5"/><stop id="stop13429" stop-color="#000" stop-opacity="0" offset="1"/></radialGradient><radialGradient id="radialGradient13514" gradientUnits="userSpaceOnUse" cy="710.1" cx="-32.943" r="45.908"><stop id="stop13174" stop-color="#0fafff" offset="0"/><stop id="stop13176" stop-color="#0082e7" offset="1"/></radialGradient></defs><metadata id="metadata12357"><rdf:RDF><cc:Work rdf:about=""><dc:format>image/svg+xml</dc:format><dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/><dc:title/></cc:Work></rdf:RDF></metadata><g id="layer1" transform="translate(3.084831,-0.40522121)"><g id="g13480" transform="translate(-41.705961,-598.80981)"><path id="path13482" fill-rule="evenodd" fill="#f4cf8f" d="m48.621,659.27,50.136,20.305,76.221-32.003-49.014-13.078z"/><path id="path13484" fill-rule="evenodd" fill="#f4cf8f" d="m98.758,742.68,0-63.105,76.221-32.003,0,49.94z"/><path id="path13486" fill-rule="evenodd" fill="#f2c676" d="m48.621,714.02,50.136,28.658,0-63.105-50.136-20.305z"/><path id="path13488" d="m49.265,659.68,49.429,19.139,75.729-31.009-74.996,32.161-0.71947,61.529-0.85161-61.634z" fill="#FFF"/><path id="path13490" opacity="0.36880008" fill="#2d2d2d" d="m77.468,671.04,76.567-28.949-5.174-1.3671-78.875,27.26-0.18169,11.909,7.9284,3.0392z"/><path id="path13492" d="m77.237,670.88,76.567-28.949-5.174-1.3671-78.875,27.26-0.18169,11.909,7.9284,3.0392z" fill="#f3af52"/><path id="path13494" d="m73.141,669.21,77.304-28.175,0.4817,0.12341-76.939,28.522-0.64271,10.031z" fill="#FFF"/><path id="path13496" d="m70.417,667.93-0.24453,0.42235,6.565,2.6681,0.37199-0.51665z" fill="#FFF"/><g id="g13498"><path id="path13500" opacity="0.48869162" d="m135.04,656.26c0,2.2288-10.563,4.0356-23.592,4.0356-13.03,0-23.592-1.8068-23.592-4.0356s10.563-4.0356,23.592-4.0356c13.03,0,23.592,1.8068,23.592,4.0356z" transform="matrix(1.0263158,0,0,1.4444444,-2.932719,-291.66989)" fill="url(#radialGradient13512)"/><g id="g13502" transform="matrix(0.51313953,0,0,0.51313953,128.97798,268.39001)"><path id="path13504" d="m12.965,710.1c0,25.354-20.554,45.908-45.908,45.908s-45.908-20.554-45.908-45.908,20.554-45.908,45.908-45.908,45.908,20.554,45.908,45.908z" fill="url(#radialGradient13514)"/><path id="path13506" opacity="0.36880008" d="m12.416,703.77c0,8.5101-25.929,24.54-48.614,23.668-22.685-0.87261-33.583-7.6547-40.144-24.033,28.769,12.391,60.78,11.505,88.758,0.36535z" transform="matrix(-0.76261769,-0.28384267,0.19368169,-1.1176248,-186.90374,1473.8127)" fill="#FFF"/><rect id="rect13508" height="37.838" width="18.257" y="681.04" x="-42.071" fill="#FFF"/><path id="path13510" d="m-56.464,707.31c-0.19493,0.14959,0.03167,0.73698,0.03167,0.73698l23.501,38.699,23.501-38.699s0.23316-0.53149-0.05474-0.82612c-0.2879-0.29464-1.2721,0.14344-1.2721,0.14344-13.958,8.0586-31.906,7.4427-44.797,0-0.68418-0.39501-0.71384-0.29303-0.90878-0.14344z" fill="#FFF"/></g></g></g></g></svg>'."\n".
               '</a>';
      
      }
      
      $dataSent = TRUE;
 
    }
 
  }

}
// if form was submitted with ajax($_GET['a']) respond with... 
if ($dataSent == TRUE && isset($_GET['a'])) {
  // just a little data
  echo result($zipName);
} // if the form was not submitted though ajax($_GET['a']) or form was not submitted
// we need the whole html page rendered
if (!isset($_GET['a']) || $dataSent == FALSE) { ?>
<html>
<head>
  <meta charset="utf-8">
  <title>fileZip2.0</title>
  <link rel="stylesheet" type="text/css" href="include/fileZipStyle.css"/>
</head>
<body>
  <p class="alert<?php if($hasERROR == FALSE){ echo ' hidden';}?>" id="alertionerr"><?php if($hasERROR == TRUE){ echo 'Error submitting the form' ;}?></p>
  <?php if (isset($thingggggy)){echo '<p>'.$thingggggy.'</p>';}?>
  <form action="index.php" onsubmit="return runner(this);" method="get">
    <table class="tableFancyHover">
      <tr>
        <td>
          <input type="checkbox" id="selectAll" />
        </td>
        <td>
          <label for="selectAll">Select All</label>
        </td>
      </tr>
      <?php
      foreach ($filesList as $file) { ?><tr>
        <td>
          <input type="checkbox" id="chkbx-<?php echo $file['id'] ?>" name="file[]" value="<?php echo $file['id'] ?>" />
        </td>
        <td>
          <label for="chkbx-<?php echo $file['id']?>"><?php echo $file['name']?></label>
        </td>
      </tr>
      <?php } ?>
    </table>
    <br /><span class="error<?php if(!isset($fileCheckedERROR)){ echo ' hidden';}?>" id="fileCheckederr"><?php if(isset($fileCheckedERROR)){ echo $fileCheckedERROR;}?></span>
    <!--hidden field to tell whether form was submitted or not-->
    <input type="hidden" name="s" value="1" />
    <input type="submit" name="submitButton" value="Zip Files" />
  </form>
  <div id="result" class="<?php if($dataSent == TRUE) { echo ' fadeIn';}?>"><?php if($dataSent == TRUE) { echo result($zipName); }?></div>
  <script type="text/javascript" src="include/fileZipScript.js"></script>
</body>
</html>
<?php } ?>