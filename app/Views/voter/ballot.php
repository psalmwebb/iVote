<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter | Ballot</title>
    <link href="<?= base_url('public/static/css/bootstrap.min.css');?>" rel="stylesheet"/>
    <script src="<?= base_url('public/static/js/axios.min.js');?>"></script>
</head>
<body>
    
    <?php
       echo view('voter/partials/sidebar');

       echo "<pre>";
       print_r($voter);

       echo "</pre>";
    ?>



   <?php if(!$voter['voted']): ?>
    <div class="ballot">
         <h3>CAST YOUR VOTE NOW</h3>
         <h3><?= strtoupper($voter['election']['name']); ?></h3>
         
        <div>
            <div id="errorDiv"></div>
            <?php foreach($voter['election']['candidates'] as $candidate):?>
                <div class="border vote-candidate" id="<?= $candidate['id']; ?>">
                    <div>
                        <img src=""/>
                    </div>
                    <h4><?= $candidate['firstname'] ?> <?= $candidate['lastname']?></h4>
                </div>
            <?php endforeach; ?>
            <div>
                <button id="voteBtn" class="btn btn-success d-none">Vote</button>
            </div>
        </div>
    </div>
   <?php else: ?>
      <h4>YOU'VE VOTED IN THIS ELECTION</h4>
   <?php endif; ?>


    <script>
       
       let voteCandidateDiv = document.querySelectorAll(".vote-candidate");
       let voteBtn = document.querySelector("#voteBtn");
       let errorDiv = document.querySelector("#errorDiv");


       let voteObj = {
           voterId:'<?= $voter['id'];?>',
           electionId:'<?= $voter['election']['id']; ?>',
           candidateId:''
       }

       voteCandidateDiv.forEach(v=>{
           v.addEventListener('click',()=>{
               voteCandidateDiv.forEach(v=>{
                   v.classList.remove('border-success');
               })
               v.classList.add('border-success');
               voteObj.candidateId = v.id;
               voteBtn.textContent = "vote for " + v.querySelector('h4').textContent;
               voteBtn.classList.remove('d-none');
               console.log(voteObj);
           })
       })


       voteBtn.addEventListener('click', async ()=>{
           
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