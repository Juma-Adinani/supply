<?php

class Helper
{

    public static function alert_message($status, $message)
    {
        echo '<div class="alert alert-' . $status . ' border-0">' . $message . '</div>';
    }

    public static function input_validation($error)
    {
        echo  '<div class="invalid-feedback">
                        ' . $error . '
             </div>';
    }
}
