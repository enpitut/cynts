<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script>
 var coordinate_id0;
 var coordinate_id1;
 function img_update(obj, coordinate_id, dislike_id){
     var data = {id : coordinate_id, d_id: dislike_id};
         $.ajax({
         type: "POST",
         url: "send",
         data: data,
         success: function(data, dataType)
         {
             data = (new Function("return " + data))();
             if (obj.id[5] == "0") {
                 $("#" + "photo1").attr("src", data["url"]);
                 coordinate_id1 = data["id"];
             } else {
                 $("#" + "photo0").attr("src", data["url"]);
                 coordinate_id0 = data["id"];
             }
         },
         error: function(XMLHttpRequest, textStatus, errorThrown)
         {
             alert('Error : ' + errorThrown);
         }
     });
 }
</script>

<?php
$photo_id = 0;
foreach ($coordinates as $coordinate){
    echo "<script>coordinate_id" . $photo_id . " = " . $coordinate->id . "</script>";
    echo $this->Html->image($coordinate->photos,
                            array(
                                'height' => '300px',
                                'onClick' => 'img_update(
this, coordinate_id' . $photo_id . ', coordinate_id' . (($photo_id+1)%2) . ')',
                                'id' => "photo" . $photo_id++
                            ));
}
$photo_id = 0;
?>
