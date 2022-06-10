<?php
include("connection.php");
$last_no = $sql->prepare("SELECT * FROM `music` ORDER BY `sno` DESC");
$last_no->execute();
$last_no_result = $last_no->get_result();
$total = $last_no_result->num_rows;
$lastdata = $last_no_result->fetch_assoc();
$lastno = $lastdata['sno'];
if (isset($_POST['data'])) {
    if($_POST['index'] == 1){
         $mid = 1;
    }elseif($_POST['index'] == $lastno){
         $mid = $lastno;
    }elseif($_POST['index'] == 0){
         $mid = $lastno;
    }elseif($_POST['index'] == $lastno+1){
         $mid = 1;
    }
    else{
         $mid = $_POST['index'];
}
    $load_data = $sql->prepare("SELECT * FROM `music` WHERE `sno` = ?");
    $load_data->bind_param('s', $mid);
    $load_data->execute();
    $load_data_result = $load_data->get_result();
    if ($load_data_result->num_rows > 0) {
        $load_data_data = $load_data_result->fetch_assoc();
?>
<script>
    
     done = [{
            name: "<?php echo $load_data_data['song_title']; ?>",
            path: "<?php echo $load_data_data['song']; ?>",
            img: "<?php echo $load_data_data['thumbnail']; ?>",
            singer: "<?php echo $load_data_data['artist_name']; ?>"   
         }]  ;
         lno = <?php echo $total;?>;
         sno = <?php echo $mid;?>;
         load_track(t,sno,lno);
         if(psong == true){
            playsong();
         }else{
            pausesong();
         }
</script>
            
<?php
    }else{
         ?>
         <script>
              if(pres == 1){
               sno = <?php echo $mid - 1 ;?>;
              }else{
              sno = <?php echo $mid + 1 ;?>;
          }
              console.log(sno);
              loadData(sno);
         </script>
         <?php
    }
}
?>