<?php
require ('vendor/autoload.php');

echo "<html lang='ru'>";
echo "<head>";
echo \IntrovertTest\Assets::getAssets()['css'];
echo \IntrovertTest\Assets::getAssets()['js'][0];
echo \IntrovertTest\Assets::getAssets()['js'][1];
echo "</head>";
echo "<body>";

?>
  <input type="text" id="mydate" gldp-id="mydate" />
  <div gldp-el="mydate"
        style="width:400px; height:300px; position:absolute; top:70px; left:100px;">
    </div>
<?php
$data=new \IntrovertTest\IntrovertApi('testDate2','2025-05-15',[24374824,57202302,247654035]);

?>

<script>
$(window).on('load', function() {
    $('#mydate').glDatePicker(
        {
            selectableDateRange: [
                { from: new Date(2025, 4, 1),
                    to: new Date(2025, 4, 15) },
            ],
            showAlways: true,
        });

});
</script>
<?php
echo "</body>";
echo "</html>";

?>