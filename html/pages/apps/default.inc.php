<?php

$graph_array['height'] = "100";
$graph_array['width']  = "220";
$graph_array['to']     = $config['time']['now'];
$graph_array['from']        = $config['time']['day'];
$graph_array_zoom           = $graph_array;
$graph_array_zoom['height'] = "150";
$graph_array_zoom['width']  = "400";
$graph_array['legend']      = "no";

echo('<h2>'.nicecase($vars['app']).'</h2>');
echo('<table cellpadding=5 cellspacing=0 class=devicetable width=100%>');
$app_devices = dbFetchRows("SELECT * FROM `devices` AS D, `applications` AS A WHERE D.device_id = A.device_id AND A.app_type = ?", array($vars['app']));

foreach ($app_devices as $app_device)
{
  echo('<tr class="list-device">');
  echo('<td class="device-head" width=300px>'.generate_device_link($app_device, shorthost($app_device['hostname']), array('tab'=>'apps','app'=>$vars['app'])).'</td>');
  echo('<td class="device-head" width=100px>'.$app_device['app_instance'].'</td>');
  echo('<td class="device-head" width=100px>'.$app_device['app_status'].'</td>');
  echo('<td></td>');
  echo('</tr>');
  echo('<tr class="list-device">');
  echo('<td colspan=4>');

  foreach ($graphs[$vars['app']] as $graph_type)
  {
    $graph_array['type']   = "application_".$vars['app']."_".$graph_type;
    $graph_array['id']     = $app_device['app_id'];
    $graph_array_zoom['type']   = "application_".$vars['app']."_".$graph_type;
    $graph_array_zoom['id']     = $app_device['app_id'];

    $link = generate_url(array('page' => 'device', 'device' => $app_device['device_id'],'tab'=>'apps','app'=>$vars['app']));

    echo(overlib_link($link, generate_graph_tag($graph_array), generate_graph_tag($graph_array_zoom),  NULL));
  }

  echo('</td>');
  echo('</tr>');
}

echo('</table>');

?>
