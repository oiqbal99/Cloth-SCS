<?php
require_once("common.php");
session_start();
use_common_page_header();
?>

<style>
    th {
        margin: 10px;
        border-style: solid;
        text-align: left;
        word-wrap: break-word;
        min-width: 150px;
    }
</style>

<body>
    <h1>New Review</h1>
    <div class="signin-wrapper">
        <div class="signin-container">
            <form id="reviewForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                <label for="ratingNumber"><b>Rating</b></label>
                <select id="ratingNumber" name="ratingNumber">
                    <option value="1">1: Very Bad</option>
                    <option value="2">2: Bad</option>
                    <option value="3">3: Ok</option>
                    <option value="4">4: Good</option>
                    <option value="5">5: Very Good</option>
                </select>
                <label for="itemNumber"><b>Item <b></label>
                <select id="itemNumber" name="itemNumber">
                    <?php 
                            $result = Query::run("SELECT * FROM Item");
                            while($row = $result->fetch_assoc()) {
                                echo <<<ITEM
                                    <option value="{$row["id"]}"> {$row["id"]} : {$row["name"]}</option>   
                                ITEM;         
                            }
                        ?>
                </select>

                <label for="reviewText"><b>Review</b></label>
                <input tyle="height:200px;font-size:14pt;" type="Text" name="reviewText" required>


                <input type="submit" value="Submit">
            </form>

            <h1>Previous Reviews</h1>

            <table>
                <tr>
                    <th>User ID </th>
                    <th>Review </th>
                    <th>Rank Number </th>
                    <th>Item </th>
                </tr>
                <tr>
                    <td>
                        <?php
                        
                $result = Query::run("SELECT * FROM Review INNER JOIN User WHERE {$_SESSION['user_login_id']} = review.user_id");
                while($row = $result->fetch_assoc()) {
                        if($row['id'] == $_SESSION["user_login_id"]){
                            echo <<<USERNAME
                            {$row["login_id"]}
                            <br></br>
                        USERNAME;
                        }                            
                        
                }
            ?>
                    </td>

                    <td>
                        <?php
                $result = Query::run("SELECT * FROM Review WHERE {$_SESSION['user_login_id']}= review.user_id");
                while($row = $result->fetch_assoc()) {
                        echo <<<REVIEW
                            {$row["review_text"]}
                            <br></br>
                        REVIEW;
                }
                ?>
                    </td>
                    <td>
                        <?php
                    $result = Query::run("SELECT * FROM Review WHERE {$_SESSION['user_login_id']}= review.user_id");
                    while($row = $result->fetch_assoc()) {
                        echo <<<RATINGNUMBER
                            {$row["rating_number"]}
                            <br></br>
                        RATINGNUMBER;
                    }
                ?>
                    </td>
                    <td>
                        <?php
                $result = Query::run("SELECT * FROM Review INNER JOIN Item WHERE item.id = review.item_id AND {$_SESSION['user_login_id']}= review.user_id");
                while($row = $result->fetch_assoc()) {
                echo <<<ITEM
                    {$row["name"]}
                    <br></br>
                ITEM;
                }
            ?>
                    </td>
                </tr>
        </div>
    </div>

</body>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Check which table to insert into
    $rating_number = $_POST["ratingNumber"];
    $review_text = trim($_POST["reviewText"]);
    $item_number = trim($_POST["itemNumber"]);
    $user_id = trim($_SESSION["user_login_id"]);
    require_once("classes/query.php");
        $insert_query = <<<QUERY
            INSERT INTO REVIEW
            (user_id, item_id, rating_number, review_text)
            VALUES
            ('$user_id', '$item_number', '$rating_number', '$review_text')
        QUERY;
        Query::run($insert_query);
    }
?>

<?php
use_common_page_footer();
?>