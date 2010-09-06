<?php
/*
    Memo is a simple class to aide an application communicate with itself.

*/

class Memo {

    // we're going to set the message to something, could bo nothing (meaning we want the message cleared), or something to else.
    function set($message = '') {
        if (setcookie('memo', $message, time() + 60, '/')) {
            return false;
        } else {
            return true;
        }
    }
    
    // we're retrieving the message, also setting it blank.
    function get() {
        //$memo = file_get_contents($this->storage);
        $memo = $_COOKIE["memo"];
        Memo::delete();
        if ($memo != '') {
            return stripslashes($memo);
        } else {
            return false;
        }
    }
    
    // different from set, as we delete it
    function delete() {
        setcookie('memo', '', time() - 60, '/');
    }
    
}
?>
