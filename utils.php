<?php
    class FontStyle {
        public const ITALIC = "italic";
    }

    function showMsgErreur(?string $msg, ?string $color = 'red', ?string $style = null) : void {
        if($msg === null){
            return;
        }
        echo "<span style='color:$color'>"
            . ($style === FontStyle::ITALIC ? '<i>' : '')
            . $msg. ($style === FontStyle::ITALIC ? '</i>' : '')
            . "</span>";
    }

    function emailValide() : bool {
        if( isset($_POST['email']) && !empty($_POST['email']) ) {
            if(mb_strlen($_POST['email']) > 12 ) { // (@gmail.com = 10 | 3 = nom)
                if(str_contains($_POST['email'], "@gmail.com")) {
                    return true;
                }
            }
        }
        return false;
    }

?>
