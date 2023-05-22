<!DOCTYPE html>

<html>
  <head>
    <title>OA Sequence Comparator</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,300;1,400&display=swap" rel="stylesheet">

    <style>
        body {
          font-family: Roboto, Arial;
          background-color: rgb(235, 234, 234);
          margin: 0px;
          
        }

        .tool-title {
          background-color: rgb(151, 150, 150);
          margin: 0px;
          text-align: center;
          font-size: 20px;
          font-weight: 500;
          color: rgb(61, 61, 61);
          padding-top: 5px;
          padding-bottom: 6px;
        }

        .assay-id {
          padding-top: 4px;
        }
        

        .assay-id-title {
          padding-left: 15px;
          display: inline-block;
          font-size: 18px;
          padding-right: 15px;
          font-weight: 500;
        }

        .assay-id-input, .result-filepath-input {
          vertical-align: top;
          margin-top: 14px;
          height: 24px;
          padding-left: 5px;
          width: 200px;
          
        }

        .upload-title, .result-filepath-title {
          padding-left: 15px;
          font-size: 18px;
          margin-top: 5px;
          font-weight: 500;
        }

        .upload-button, .submit-button {
          margin-left: 15px;
          padding-top: 8px;
          padding-bottom: 8px;
          padding-left: 30px;
          padding-right: 30px;
          background-color: rgb(86, 86, 86);
          color: lightgray;
          border: 0px;
          border-radius: 16px;
          font-size: 16px;
          font-weight: 700;
          cursor: pointer;
          transition: 0.2s;
        }

        .upload-button:hover, .submit-button:hover {
          opacity: 0.7;
        }

        .result-filepath-title {
          margin-top: 15px;
        }

        .result-filepath-input {
          margin-left: 15px;
          margin-top: 0px;
          width: 300px;
          display: block;
          margin-bottom: 20px;
          
        }
      
    </style>
  </head>
  <body>

    <form method="post" action="seq-comp.php">
      <div class="tool-title">Open Array Sequence Comparator Tool</div>

      <div class="assay-id">
        <p class="assay-id-title">Assay ID</p>

        <input class="assay-id-input" placeholder="Enter Assay ID here" type="text" name="assayid">

      </div>
      

      <p class="upload-title">Upload .xml files</p>

      <div class="uploaded-files"></div>

      <button class="upload-button">Upload</button>

      <p class="result-filepath-title">Input filepath of results folder</p>

      <input class="result-filepath-input" placeholder="Enter filepath of results folder here" type="text" name="result-filepath">

      <input class="submit-button" type="Submit">
    
    </form>

    <?php
    $assayids = $_POST['assayid'];

    $resultpath = $_POST['result-filepath'];

    

    

    $command = escapeshellcmd('c:/MAMP/htdocs/openarray/Scripts/python.exe seq-comparision.py "'.$assayids.'" "'.$resultpath.'"');
    $output = shell_exec($command);
    echo $output;

    ?>

  </body>
</html>