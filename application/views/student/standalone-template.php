
<?php 
    $folderinfo = $folder[0];


?>


<!DOCTYPE html>
<html>
<head>
	<title> Learn it Standalone </title>
    <style>
            *, ::after, ::before {
            box-sizing: border-box;
        }
        body{
            background : #f9f9f9;
            font-family: arial;
            font-size: 14px;
        }

        .container{
            width: 90%;
            max-width: 1100px;
            margin: auto;
            
        }

        .panel{
            margin-top: 50px;
            box-shadow: 1px 1px 1px #000;
            border: 1px solid #d5d5d5;
            background: #fff;
            border-top-right-radius: 40px;
            border-bottom-left-radius: 40px;
            overflow: hidden;
        }
        

        .panel-heading{
            padding: 10px 40px;
            background: #7897e1;
                color: #fff;
                background: linear-gradient( 
            100deg
            , rgb(75 125 244) 25%, #6e99ff 56%);
                border-top-right-radius: inherit;
        }

        .panel-heading{
            font-size: 2em;
            font-weight: 800;
        }
        
        .class-lessons-items .file-item {
                /* padding: 15px 40px; */
                background: #fff;
                display: flex;
                width: 100%;
        }

        .class-lessons-items .file-item a {
                padding: 15px 40px;
                text-decoration: none;
                background: #6e99ff24;
                width: 100%;
        }
        .class-lessons-items .file-item:not(:last-child) a{
            border-bottom: 2px solid #d9d9d9;
        }

        .class-lessons-items .file-item a:hover{
            background: #6e99ff59;
        }

    </style>
</head>
<body>
                <?php  //var_dump(  );  ?>
                <?php  //var_dump( $files );  ?>
    <div class="container"> 
        <div class="panel">
            <div class="panel-heading"> <h1> <?php echo $folderinfo['lf_name']; ?> </h1> </div>
           
           <div class="class-lessons-items">
           <?php $filesnames = array(); ?>
                <?php foreach( $files as $file ):
                        $fileto = $file['file_path'];

                        $fileto = explode('\\',$fileto);
                        $fileto = end($fileto);    
                ?>

                    <div class="file-item">
                        <a href="<?php echo $fileto; ?>"  > <?php echo $file['file_name']; ?> </a>
                    </div>
                <?php 
                $filesnames[] = $file['file_name'];
            endforeach; ?>
           </div>
        </div>
        
    </div>

    <script>

        const files = <?php echo json_encode($filesnames); ?>;
  
    </script>
</body>
</html>