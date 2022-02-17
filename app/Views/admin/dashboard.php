<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="<?php echo base_url('public/static/js/axios.min.js')?>"></script>
</head>
<body>

   <?= view('admin/partials/sidebar') ?>

   <?php 
   
   echo "<pre>";
   print_r($admin);

   echo "</pre>";
   
   ?>
    <div class="main">
        <?php if(count($admin['elections'])): ?>
        <div>
            Candidates
            <p>0</p>
        </div>

        <div>
            Voters
            <p>0</p>
        </div>

        <div>
            Votes
            <p>0</p>
        </div>
       <?php else: ?>
          <div>
              <button>Create election</button>
          </div>
       <?php endif; ?>

       <form>
           <div id="errorDiv"></div>
           <div>
               <input type="hidden" name="adminId" value="<?= $admin['id'] ?>"/>
               <label>Name : </label>
               <input type="text" name="name"/>
           </div>
           <div>
               <button>CREATE</button>
           </div>
       </form>
    </div>


    <script>
        let form = document.forms[0];

        let errorDiv = form.querySelector('#errorDiv');

        form.addEventListener("submit", async (e)=>{
           e.preventDefault();
           let inputs = [
               ...form.querySelectorAll('input'),
               ...form.querySelectorAll('select'),
               ...form.querySelectorAll('textarea')
           ]

          let payload = {};

          inputs.forEach(input=>{
             payload[input.name] = input.value;
          })

          let response = await axios.post('<?= base_url('admin/create-election') ?>',{
              ...payload
          })

          if(response.data.success){
              location.reload();
          }
          else{
              console.log(response.data);
              errorDiv.innerHTML = response.data.error;
          }
        })

    </script>
</body>
</html>