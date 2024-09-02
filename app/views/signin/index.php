<!-- <?= $_SESSION["user"] ?> -->
<div class="row justify-content-center align-content-center align-items-center h-100 bg-dark" style="gap: 20px;">
  <form id="form-signin" class="contact-form needs-validation d-flex flex-column" style="gap: 20px;" novalidate method="post">
    <h2 class="text-white">Authorization</h2>
    <div class="input-group has-validation">
      <input class="form-control rounded-pill" type="text" name="login" id="login" placeholder="Your login" required>
      <div class="invalid-feedback">
          Login should be more then 4 fymbolds and include a-Z A-Z 0-9
      </div>
    </div>
    <div class="input-group has-validation">
      <input class="form-control rounded-pill" type="password" name="password" placeholder="Your password" id="password">
      <div class="invalid-feedback">
        Password should be more then 4 fymbolds and include a-Z A-Z 0-9
      </div>
    </div>
    <button type="submit" class="site-btn">Sign in</button>
  </form>
  <?php if ($data->signin_fail) : ?>
    <br>
    <p class="text-danger col-12 text-center"><?= $data->signin_fail ?></p>
  <?php endif; ?>
</div>