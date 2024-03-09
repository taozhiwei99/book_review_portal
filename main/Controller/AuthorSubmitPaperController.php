<?php
    include_once("./Entity/PaperEntity.php");

    class AuthorSubmitPaperController {
        # Creates a new paper on author submission after checking if author is entered as co-author
        function create_paper($paperName, $paperContent, $authorID, $co_Author){
            $paper = new Paper();
            if ($co_Author != $authorID) {
                $bool = $paper->create_paper($paperName, $paperContent, $authorID, $co_Author);
                if ($bool != null) {
                    return true;
                }
                return false;
            }
            else {
                echo "<script> alert('Author submitting paper cannot be Co-Author.') </script>";
                return false;
            }
        }
    }
        
    
?>