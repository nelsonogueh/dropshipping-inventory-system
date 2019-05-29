<?php
/**
 * Created by PhpStorm.
 * User: Nelson
 * Date: 11/3/2018
 * Time: 2:49 PM
 */
    if (isset($_SESSION['response_code']) && $_SESSION['response_code'] == "0") { ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['response_message'];
            ?></div>
    <?php
        unset($_SESSION['response_code']);
        unset($_SESSION['response_message']);
    }

    if (isset($_SESSION['response_code']) && $_SESSION['response_code'] == "1") { ?>
        <div class="alert alert-success"><?php echo $_SESSION['response_message']; ?></div>
        <?php

        unset($_SESSION['response_code']);
        unset($_SESSION['response_message']);
    }

?>