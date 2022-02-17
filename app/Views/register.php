
<?php echo view('header') ?>

<body class="bg-light">
    <form class="bg-white col-4 offset-4 mt-5 p-4" method="post">
       <?php if(isset($error)) : ?>
          <div class="alert alert-danger text-center">
              <?= $error ?>
          </div>
       <?php endif; ?>
       <div class="mt-3">
           <label>First Name</label>
           <input type="text" name="firstname" class="form-control" value="<?= set_value('firstname'); ?>"/>
           <?php if(isset($validator) && $validator->hasError('firstname')): ?>
            <small><?= $validator->getError('firstname'); ?></small>
           <?php endif; ?>
       </div>

       <div class="mt-3">
           <label>Last Name</label>
           <input type="text" name="lastname" class="form-control" value="<?= set_value('lastname'); ?>"/>
           <?php if(isset($validator) && $validator->hasError('lastname')): ?>
            <small><?= $validator->getError('lastname'); ?></small>
           <?php endif; ?>
       </div>

       <div class="mt-3">
           <label>Email</label>
           <input type="text" name="email" class="form-control" value="<?= set_value('email'); ?>"/>
           <?php if(isset($validator) && $validator->hasError('email')): ?>
            <small><?= $validator->getError('email'); ?></small>
           <?php endif; ?>
       </div>

       <div class="mt-3">
           <label>Password</label>
           <input type="password" name="password" class="form-control" value="<?= set_value('password'); ?>"/>
           <?php if(isset($validator) && $validator->hasError('password')): ?>
            <small><?= $validator->getError('password'); ?></small>
           <?php endif; ?>
       </div>

       <div class="mt-3">
           <label>Confirm Password</label>
           <input type="password" name="confpassword" class="form-control" value="<?= set_value('confpassword'); ?>"/>
           <?php if(isset($validator) && $validator->hasError('confpassword')): ?>
            <small><?= $validator->getError('confpassword'); ?></small>
           <?php endif; ?>
       </div>

       <div class="mt-3">
           <button class="btn btn-success rounded-0 col-12">Register</button>
       </div>
    </form>
</body>


<?php echo view('footer') ?>