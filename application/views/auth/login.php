<div class="container center">
  <br /><br />

    <h1 class="oleo">Login to your account</h1>

    <br />

    <div class="login-container">

      <?php if($message): ?>
      <div class="alert alert-info"><?php echo $message;?></div>
      <?php endif; ?>

      <?php echo form_open("auth/login");?>

      <p>
        <?php echo form_input($identity);?>
      </p>

      <p>
        <?php echo form_input($password);?>
      </p>

      <p>
        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
        <?php echo lang('login_remember_label', 'remember');?>
      </p>


      <p><?php echo form_submit('submit', lang('login_submit_btn'),'class="btn btn-primary btn-block"');?></p>

      <?php echo form_close();?>


    </div>

</div>