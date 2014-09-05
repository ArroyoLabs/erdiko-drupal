<div id="change-password-form" class="user-flow lightbox-step">
    <h1 class="modaltitle">Change Password</h1>

    <?php if( isset($data['success']) ): ?>
        <div class="success-line" style="visibility: visible;"><?php echo $data['success']; ?></div>
    <?php else: ?>
        <div class="success-line" style="visibility: hidden;"></div>
    <?php endif; ?>

    <?php if( isset($data['error']) ): ?>
        <div class="error-line" style="visibility: visible;"><?php echo $data['error']; ?></div>
    <?php else: ?>
        <div class="error-line" style="visibility: hidden;"></div>
    <?php endif; ?>

    <form class="change-password-form" action="/user/submitPassword" method="post">
        <label>Please enter your new password</label>
		<input type="password" name="password" id="password" class="check-required check-email" />
		<br />
        <label>Please re-enter your new password</label>
		<input type="password" name="reenter_password" id="reenter_password" class="check-required check-email" />
		<br />
		<input type="hidden" name="userid" id="userid" value="<?php echo $data['uid'] ?>" />
        <input type="submit" value="SUBMIT" />        
    </form>
<!--    <div class="smalllinks">
        <span class="changepassword"><a href="#" class="toggle-to" rel="signin">Login</a></span>
		<span class="registration">Not a Member? <a href="#" class="toggle-to" rel="signup">Sign up</a></span> 
    </div>-->
</div>