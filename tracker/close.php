<?php
require __DIR__.'/vendor/autoload.php';
$client = new \GuzzleHttp\Client([
    'base_uri' => 'https://api.close.com/api/v1/',
    'auth' => ['api_3Jw5m4AgEfVlybZ5NgHgZ6.76YlrJjkYTNifmBAljSheN', '']
]);
//$response = $client->get('lead/?query=custom.Industry:"Air Conditioning"&_limit=15&_skip=5'); //gets leads by country field
//$response = $client->get('lead/?query=lead_status:"Potential"&_limit=200&_skip=5'); //gets leads by status_label
//$response = $client->get('lead/?query=custom.Industry:"Fireplaces"&_limit=10&_skip=5');
$response = $client->get('lead/?query=lead_status:MirkaDone limit:1');
//$response = $client->get('lead/?&_limit=10&_skip=0'); //gets all leads more or less
$data = null;
if ($response->getStatusCode() === 200) {
    $body = $response->getBody();
    $data = json_decode($body, JSON_PRETTY_PRINT);
}
// COnnection na db
$connection = null;
?>

<table>
    <tr>
        <th>Lead name</th>
        <th>Name</th>
    </tr>

<?php foreach ($data['data'] as $lead ) {?>
    <tr>
        <td>
            <?php echo $lead['display_name']; ?>
        </td>
        <td>
            <?php echo $lead['status_label']; ?>
        </td>
        <td>
            <?php 
                $var = $lead['custom'];
                echo $lead ["Industry"];
                var_dump($var);
            ?>
        </td>
    </tr>
<?php } ?>
</table>