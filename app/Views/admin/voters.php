<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMin | Voter</title>
    <link href="<?php echo base_url('public/static/css/bootstrap.min.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo base_url('public/static/css/main.css'); ?>" rel="stylesheet"/>
    <script src="<?php echo base_url('public/static/js/axios.min.js')?>"></script>
</head>
<body>

<div class="p-0 m-0 row">
       <?= view('admin/partials/sidebar') ?>

       <div class="col-10 offset-2 mt-5 position-relative">
            <div class="d-flex justify-content-end">
               <button class="btn btn-custom rounded-0" onclick="addVoterForm.classList.remove('d-none');">New Voter</button>
            </div>

            <?php foreach($admin['elections'] as $election): ?>

               <?php if(count($election['voters'])):?>
                    <table class="table border table-striped mt-3">
                        <h4 class="text-center">Election Name : <?= ucfirst($election['name']);?></h4>
                        <tr>
                            <th>S/N</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                        </tr>

                        <?php foreach($election['voters'] as $key=>$voter): ?>
                            <tr>
                                <td><?= $key + 1?></td>
                                <td><?= $voter['firstname'];?></td>
                                <td><?= $voter['lastname']; ?></td>
                                <td><?= $voter['email']; ?></td>  
                            </tr>
                        <?php endforeach; ?>
                    </table>
               <?php endif; ?>
            <?php endforeach; ?>


            <form class="d-none position-absolute bg-white border rounded" id="addVoterForm" style="top:10%;width:35%;left:30%;">
                <div class="p-3 border d-flex justify-content-end rounded" style="background-color:rgb(0,36,54);">
                    <button type="button" onclick="this.parentElement.parentElement.classList.add('d-none');" class="btn text-white">Close</button>
                </div>
                <div class="p-3">
                    <div id="errorDiv"></div>
                    <div class="mt-2">
                        <label>First name</label>
                        <input type="text" name="firstname" class="form-control"/>
                    </div>

                    <div class="mt-2">
                        <label>Last name</label>
                        <input type="text" name="lastname" class="form-control"/>
                    </div class="mt-2">

                    <div class="mt-2">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control"/>
                    </div>

                    <div class="mt-2">
                        <label>Password</label>
                        <input type="text" name="password" class="form-control"/>
                    </div>

                    <div class="mt-2">
                        <label>Election</label>
                        <select name="electionId" class="form-select">
                            <option></option>
                            <?php foreach($admin['elections'] as $election): ?>
                                <option value="<?= $election['id'] ?>"><?= $election['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mt-3">
                        <button class="col-12 btn btn-custom">ADD VOTER</button>
                    </div>
                </div>
            </form>
       </div>
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

          let response = await axios.post('<?= base_url('admin/create-voter') ?>',{
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