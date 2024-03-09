<?php 
include_once("./Entity/PaperEntity.php");

class acceptAndRejectPaperList {
    function get_acceptedOrRejectedPaper() {
        $data = new Paper();
        $row =  $data->get_acceptedOrRejectedPaper();
        return $row;
    }
}

?>