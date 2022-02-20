<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="<?php echo base_url('public/static/css/bootstrap.min.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo base_url('public/static/css/main.css'); ?>" rel="stylesheet"/>
    <script src="<?php echo base_url('public/static/js/axios.min.js')?>"></script>
</head>
<body>

   <div class="row p-0 m-0">
       <?= view('admin/partials/sidebar') ?>

 
       <div class="col-10 offset-2 mt-4 position-relative">
            <div class="d-flex justify-content-end">
               <button class="btn btn-custom rounded-0" onclick="addElectionForm.classList.remove('d-none');">New Election</button>
            </div>
            <form class="d-none position-absolute bg-white border rounded" id="addElectionForm" style="top:10%;width:35%;left:30%;">
                    <div class="p-3 border d-flex justify-content-end rounded" style="background-color:rgb(0,36,54);">
                        <button type="button" onclick="this.parentElement.parentElement.classList.add('d-none');" class="btn text-white">Close</button>
                    </div>
                    <div class="p-3">
                        <div id="errorDiv"></div>
                        <div>
                            <input type="hidden" name="adminId" value="<?= $admin['id'] ?>"/>
                            <label>Name : </label>
                            <input type="text" name="name" class="form-control"/>
                        </div>

                        <div class="mt-3">
                            <button class="col-12 btn btn-custom">CREATE</button>
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

          let response = await axios.post('<?= base_url('admin/create-election') ?>',{
              ...payload
          })

          if(response.data.success){
              location.reload();
          }
          else{
              console.log(response.data);
              errorDiv.innerHTML = `<div class='alert alert-danger text-center'>${response.data.error}</div>`;
          }
        })

    </script>
</body>
</html>