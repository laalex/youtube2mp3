<div class="container center">
  <br /><br />

    <h1 class="oleo">Create a new account</h1>  

    <br />

    <div class="login-container">

      <?php if($message): ?>
      <div class="alert alert-danger"><?php echo $message;?></div>
      <?php endif; ?>

      <?php echo form_open("auth/register");?>

      <p>
        <h4 style="text-align:left;">Username</h4>
        <?php echo form_input($email);?>
      </p>

      <p>
        <h4 style="text-align:left;">Password</h4>
        <?php echo form_input($password);?>
      </p>

      <p>
        <h4 style="text-align:left;">Confirm Password</h4>
        <?php echo form_input($password_confirm);?>
      </p>

      <p><?php echo form_submit('submit', "Create account",'class="btn btn-success btn-block"');?></p>

      <?php echo form_close();?>


    </div>

</div>