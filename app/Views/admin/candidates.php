<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMin | Candidate</title>
    <script src="<?php echo base_url('public/static/js/axios.min.js')?>"></script>
</head>
<body>

   <?= view('admin/partials/sidebar') ?>

   <?php
    
     echo "<pre>";
       print_r($admin);
     echo "</pre>";
   ?>
   <form>
       <div id="errorDiv"></div>
       <div>
           <label>First name</label>
           <input type="text" name="firstname"/>
       </div>

       <div>
           <label>Last name</label>
           <input type="text" name="lastname"/>
       </div>

       <div>
           <label>Email</label>
           <input type="text" name="email"/>
       </div>

       <div>
           <label>Password</label>
           <input type="text" name="password"/>
       </div>

       <div>
           <label>Election</label>
           <select name="electionId">
              <?php foreach($admin['elections'] as $election): ?>
                 <option value="<?= $election['id'] ?>"><?= $election['name']; ?></option>
              <?php endforeach; ?>
           </select>
       </div>

       <div>
           <button>ADD CANDIDATE</button>
       </div>
   </form>


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

          let response = await axios.post('<?= base_url('admin/create-candidate') ?>',{
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