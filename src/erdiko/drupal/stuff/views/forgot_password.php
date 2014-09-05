<div id="forgot-form" class="user-flow lightbox-step">
    <h1 class="modaltitle">Forgot Password</h1>
    <h2 class="modalsubtitle"></h2>
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
    <form class="forgot-form" action="/ajax/forgot" method="post">
        <label>Submit your email address below to reset your password</label>
        <label>Email Address</label>
        <input type="text" name="email" id="email" class="check-required check-email" />
        <input type="submit" value="SUBMIT" />        
    </form>
    <div class="smalllinks">
        <span class="forgotpassword"><a href="#" class="toggle-to" rel="signin">Login</a></span>
        <span class="registration">Not a Member? <a href="#" class="toggle-to" rel="signup">Sign up</a></span>
    </div>
</div>
<!--<a href="#" class="toggle-to" rel="size">Edit Measurements</a>-->