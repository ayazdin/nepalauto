<?php
include('connection.php');

$posts = "SELECT * FROM nan_posts WHERE post_type ='post' and post_date >= '2018-04-14' and post_title !='Auto Draft'";

$result = mysqli_query($con, $posts);

$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<table width="100%" border="1">
    <tr>
        <td>ID</td>
        <td>post_author</td>
        <td>post_title</td>
        <td>post_excerpt</td>
        <td>post_content</td>
        <td>post_name</td>
        <td>post_type</td>
        <td>menu_order</td>
        <td>comment_count</td>
        <td>post_status</td>
        <td>post_date</td>
        <td>post_modified</td>
    </tr>

    <?php
    foreach ($rows as $row) {
        $id = $row['ID'];
        $attacment = "SELECT * FROM nan_posts where post_type ='attachment' and post_parent= $id ";

        $result = mysqli_query($con, $attacment);
        if (!$result)
            echo(mysqli_error($con));

        if (mysqli_num_rows($result) > 0) {
            $guids = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($guids as $guid) {
                $attachment = $guid['guid'];
            }
        } else {
            $attachment = '';
        }

        $id = $row['ID'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_excerpt = $row['post_excerpt'];
        $post_content = nl2br($row['post_content']);
        $slug = $row['post_name'];
        $post_type = $row['post_type'];
        $menu_order = $row['menu_order'];
        $comment_count = $row['comment_count'];
        $status = $row['post_status'];
        $added_date = $row['post_date'];
        $modified_date = $row['post_modified'];
    ?>
   <!-- <tr>
        <td><?php /*echo $id;*/?></td>
        <td><?php /*echo $post_author;*/?></td>
        <td><?php /*echo $post_title;*/?></td>
        <td><?php /*echo $post_excerpt;*/?></td>
        <td><?php /*echo $post_content;*/?></td>
        <td><?php /*echo $slug;*/?></td>
        <td><?php /*echo $post_type;*/?></td>
        <td><?php /*echo $menu_order;*/?></td>
        <td><?php /*echo $comment_count;*/?></td>
        <td><?php /*echo $status;*/?></td>
        <td><?php /*echo $added_date;*/?></td>
        <td><?php /*echo $modified_date;*/?></td>
    </tr> -->

    
    <?php 
        $insertsql = 'INSERT INTO posts (id, userid, title, name, excerpt, content, clean_url, ctype, image, menu_order, cmt_count, status, created_at, updated_at)
                        VALUES ("'.$id .'", 
                                "'.$post_author.'",
                                "'.$post_title.'" ,
                                "'.$post_title.'" ,
                                "'.$post_excerpt.'",
                                "'.$post_content.'",
                                "'.$slug.'",
                                "'.$post_type.'",
                               "'. $attachment.'",
                                "'.$menu_order.'" ,
                               "'. $comment_count.'",
                                "'.$status.'",
                               "'. $added_date.'",
                                "'.$modified_date.'")';
    
       

                if (mysqli_query($con2, $insertsql)) {
                    echo "New record created successfully";
                }
                else {
                    echo "Error: " . $insertsql . "<br>" . mysqli_error($con2);
                }

            }
            mysqli_close($con2);
    ?>
</table>