<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter | Ballot</title>
    <link href="<?= base_url('public/static/css/bootstrap.min.css');?>" rel="stylesheet"/>
    <link href="<?php echo base_url('public/static/css/main.css'); ?>" rel="stylesheet"/>
    <script src="<?= base_url('public/static/js/axios.min.js');?>"></script>
</head>
<body>
    
    <div class="row p-0 m-0">
        <?php
          echo view('voter/partials/sidebar');
        ?>

      <div class="col-10 offset-2 mt-4 position-relative">
        <?php if(!$voter['voted']): ?>
        <h3 class="text-center border-bottom p-2">CAST YOUR VOTE NOW</h3>
        <div class="ballot p-3 border">
                <h3 class="text-center lead"><?= strtoupper($voter['election']['name']); ?></h3>
    
                <div class="d-flex justify-content-around p-2 mt-3">
                    <div id="errorDiv"></div>
                    <?php foreach($voter['election']['candidates'] as $candidate):?>
                        <div class="border vote-candidate col-3 rounded" id="<?= $candidate['id']; ?>">
                            <div class="border p-5">
                                <img src=""/>
                            </div>
                            <b class="text-center d-block"><?= ucfirst($candidate['firstname']); ?> <?= ucfirst($candidate['lastname']); ?></b>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-5 d-flex justify-content-center">
                    <button id="voteBtn" class="btn btn-custom d-none rounded-0 btn-lg">Vote</button>
                </div>
        </div>
        <?php else: ?>
            <h3 class="text-center lead border-bottom mt-4"><?= strtoupper($voter['election']['name']); ?></h3>
            <h4 class="text-center">YOU'VE VOTED IN THIS ELECTION</h4>
        <?php endif; ?>
      </div>
    </div>


    <script>
       
       let voteCandidateDiv = document.querySelectorAll(".vote-candidate");
       let voteBtn = document.querySelector("#voteBtn");
       let errorDiv = document.querySelector("#errorDiv");

       console.log(voteBtn);


       let voteObj = {
           voterId:'<?= $voter['id'];?>',
           electionId:'<?= $voter['election']['id']; ?>',
           candidateId:''
       }

       voteCandidateDiv?.forEach(v=>{
           v.addEventListener('click',()=>{
               voteCandidateDiv.forEach(v=>{
                   v.classList.remove('border-custom');
               })
               v.classList.add('border-custom');
               voteObj.candidateId = v.id;
               voteBtn.textContent = "vote for " + v.querySelector('b').textContent;
               voteBtn.classList.remove('d-none');
               console.log(voteObj);
           })
       })


       voteBtn?.addEventListener('click', async ()=>{
           
           let response = await axios.post('<?= base_url('voter/vote'); ?>',{
               ...voteObj,
           });

            console.log(response.data);
           if(response.data.error){
              errorDiv.innerHTML = `<div>${response.data.error}</div>`;
              console.log(response.data.error)
           }
           else{
               location.reload();
           }
       })

    </script>
</body>
</html>