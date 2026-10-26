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

?>
