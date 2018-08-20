<?php
include('connection.php');

$categories = "SELECT nan_terms.* , nan_term_taxonomy.count from nan_terms
              JOIN nan_term_taxonomy
                on nan_term_taxonomy.term_id = nan_terms.term_id
              WHERE nan_term_taxonomy.taxonomy = 'category'
              ORDER BY nan_terms.name ASC
              ";
$cat2  = "SELECT * FROM postcats";
$result=mysqli_query($con,$categories);

$result2 = mysqli_query($con2,$cat2);

$rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
$rows2 = mysqli_fetch_all($result2,MYSQLI_ASSOC);

?>
<table width="100%">
    <tr>
        <th colspan="4">Old table</th>
    </tr>
    <tr>
        <th width="20%">Id</th>
        <th width="40%">Name</th>
        <th width="20%">Slug</th>
        <th width="20%">Count</th>
    </tr>
    <?php
    foreach($rows as $row){
        echo '<tr><td>'.$row['term_id'].'</td><td>'.$row['name'].'</td><td>'.$row['slug'].'</td> <td>'.$row['count'].'</td>    </tr>';
    }
    ?>
</table>


<table width="100%">
    <tr>
        <th colspan="4">New table</th>
    </tr>
    <tr>
        <th width="20%">Id</th>
        <th width="40%">Name</th>
        <th width="20%">Slug</th>
        <th width="20%">type</th>
    </tr>
    <?php
    foreach($rows2 as $row2){
        echo '<tr><td>'.$row2['id'].'</td><td>'.$row2['name'].'</td><td>'.$row2['slug'].'</td> <td>'.$row2['type'].'</td>    </tr>';
    }
    ?>
</table>


