<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// instantiate database and customer object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$customer = new Customer($db);
 
// query customers
$stmt = $customer->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // customers array
    $customers_arr=array();
    $customers_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $customer_item=array(
            "id" => $id,
            "companyname" => $companyname,
            "address" => $description,
            "email" => $email,
            "createdat" => $createdat,
            "createdby" => $createdby,
            "updatedat" => $updatedat,
            "updatedby" => $updatedby
        );
 
        array_push($customers_arr["records"], $customer_item);
    }
 
    echo json_encode($customers_arr);
}
 
else{
    echo json_encode(
        array("message" => "No customers found.")
    );
}
?>