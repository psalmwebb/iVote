
<?php echo view('header') ?>

<body class="bg-light">
    <form class="bg-white col-4 offset-4 mt-5 p-4" method="post">
       <?php if(isset($error)) : ?>
          <div class="alert alert-danger text-center">
              <?= $error ?>
          </div>
       <?php endif; ?>
       <div class="mt-3">
           <label>Email</label>
           <input type="text" name="email" class="form-control" value="<?= set_value('email'); ?>"/>
       </div>
       
       <div class="mt-3">
           <label>Password</label>
           <input type="password" name="password" class="form-control" value="<?= set_value('password'); ?>"/>
       </div>
       
       <div class="mt-3">
           <button class="btn btn-success rounded-0 col-12">Login</button>
       </div>
       <div class="mt-2">
           <div class="text-center"><a class="text-decoration-none" href="<?= base_url('admin/login')?>">Login as Admin</a></div>
           <div class="text-center"><a class="text-decoration-none" href="<?= base_url('candidate/login')?>">Login as a Candidate</a></div>
       </div>

    </form>
</body>


<?php echo view('footer') ?>