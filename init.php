 <?php
    // Directories
        // Paths Data
        $Uploads = 'Data/Uploads/'; //Uploads Folder
        // Paths Includes
        $DirFunc = 'Includes/Functions/'; //Function Folder
        $DirTemp = 'Includes/Temp/'; //Temp Folder
        // Paths Layout
        $DirCss  = 'Layout/Css/'; //Css folder
        $DirFont = 'Layout/Fonts/'; //Fonts folder
        $DirJs   = 'Layout/Js/'; //Js folder

    //Includes Important Files
        include $DirFunc . 'Functions.php';//Include Func Page
        include $DirTemp . 'Header.php';//Include Header Page

    // include navbar To Pages Exepect Pages Have Variable [$noNav]
        if(!isset($noNav)){ include $DirTemp . 'Navbar.php';}

    // Connect To DB
        include 'Admin/config.php';
?>
