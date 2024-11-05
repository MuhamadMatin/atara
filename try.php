<form method="post" autocomplete="off" id="password_form">
    <p>old password<br />
        <input type="password" name="old_password" />
    </p>
    <p>New password<br />
        <input type="password" name="password" id="password" class="ser" />
    </p>
    <p align="center">
        <input name="submit" type="submit" value="Save Password" class="submit" />
    </p>
    <div class="<?= (@$msg_sucess == "") ? 'error' : 'green'; ?>" id="logerror">
        <?php echo @$error; ?><?php echo @$msg_sucess; ?>
    </div>
</form