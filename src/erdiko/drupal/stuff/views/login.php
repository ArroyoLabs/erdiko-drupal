<div id="signin-form" class="user-flow lightbox-step">
    <h1 class="modaltitle">Sign in</h1>
    <h2 class="modalsubtitle"></h2>
    <div class="error-line" style="visibility: hidden;"></div>
    <form class="signin-form" action="/ajax/login" method="post">
        <label>Email Address:</label>
        <input type="text" name="email" id="email" class="check-required check-email" />
        <label>Password:</label>
        <input type="password" name="password" id="password" class="check-required check-password" maxlength="12" />
        <input type="submit" value="START SHOPPING!" />
    </form>
    <div class="smalllinks">
        <span class="forgotpassword"><a href="#" class="toggle-to" rel="forgot">Forgot Password?</a></span>
        <span class="registration">Not a Member? <a href="#" class="toggle-to" rel="signup">Sign up</a></span>
    </div>
</div>