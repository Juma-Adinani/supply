<?php

class Util
{

    public static function redirectTo($route)
    {
?>
        <script>
            window.location.href = "<?= $route ?>";
        </script>
<?php
    }
}
