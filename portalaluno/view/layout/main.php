<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!empty($_SESSION['flash'])) {
    ?>
<div class="formee-msg-success" style="margin-left: 20px"><h3><?php echo $_SESSION['flash']; ?></h3></div>
    <?php
    $_SESSION['flash'] = null;
}

if (!empty($_SESSION['error'])) {
    ?>
    <div class="formee-msg-error" style="margin-left: 20px"><h3><?php echo $_SESSION['error']; ?></h3></div>
    <?php
    $_SESSION['error'] = null;
}
?>
