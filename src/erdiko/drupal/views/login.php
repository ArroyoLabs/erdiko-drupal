<form role="form" action="/user/login" method="post" id="user-login" accept-charset="UTF-8">
  <div class="form-group">
    <label for="exampleInputEmail1">Username</label>
    <input type="text" class="form-control form-text required" placeholder="Username" id="edit-name" name="name" value="" maxlength="60">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control form-text required" id="edit-pass" name="pass" size="60" maxlength="128" placeholder="Password">
  </div>

  <input type="hidden" name="form_build_id" value="<?php echo $data['build_id'] ?>">
  <input type="hidden" name="form_id" value="user_login">
  
  <button type="submit" class="btn btn-default" id="edit-submit" name="op">Login</button>
</form>
