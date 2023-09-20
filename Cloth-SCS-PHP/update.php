<?php
require_once("common.php");
session_start();
use_common_page_header();
?>

<h1>Update</h1>

<script>
function displayCon(){
    var table = document.getElementById("tableSelect")
    var f1 = document.getElementById("form1");
    var f2 = document.getElementById("form2");
    var f3 = document.getElementById("form3");
    var f4 = document.getElementById("form4");
    var f5 = document.getElementById("form5");
    var f6 = document.getElementById("form6");
    var f7 = document.getElementById("form7");

    if(table.options[table.selectedIndex].value == "Order"){
        f1.style.display = "block";
        f2.style.display = "none";
        f3.style.display = "none";
        f4.style.display = "none";
        f5.style.display = "none";
        f6.style.display = "none";
        f7.style.display = "none";
    }

    if (table.options[table.selectedIndex].value == "User"){
       
        f2.style.display = "block";
        f1.style.display = "none";
        f3.style.display = "none";
        f4.style.display = "none";
        f5.style.display = "none";
        f6.style.display = "none";
        f7.style.display = "none";

    }

    if(table.options[table.selectedIndex].value == "Item"){
        
        f3.style.display = "block";
        f2.style.display = "none";
        f1.style.display = "none";
        f4.style.display = "none";
        f5.style.display = "none";
        f6.style.display = "none";
        f7.style.display = "none";

    }

    if(table.options[table.selectedIndex].value == "Shopping"){
        
        f4.style.display = "block";
        f2.style.display = "none";
        f3.style.display = "none";
        f1.style.display = "none";
        f5.style.display = "none";
        f6.style.display = "none";
        f7.style.display = "none";

    }

    if(table.options[table.selectedIndex].value == "Trip"){
        
        f5.style.display = "block";
        f2.style.display = "none";
        f3.style.display = "none";
        f4.style.display = "none";
        f1.style.display = "none";
        f6.style.display = "none";
        f7.style.display = "none";

    }

    if(table.options[table.selectedIndex].value == "Truck"){
        
        f6.style.display = "block";
        f2.style.display = "none";
        f3.style.display = "none";
        f4.style.display = "none";
        f5.style.display = "none";
        f1.style.display = "none";
        f7.style.display = "none";

    }

    if(table.options[table.selectedIndex].value == "Review"){
        
        f6.style.display = "none";
        f2.style.display = "none";
        f3.style.display = "none";
        f4.style.display = "none";
        f5.style.display = "none";
        f1.style.display = "none";
        f7.style.display = "block";

    }

}
</script>

<label for="tableSelect"><b>Select Table</b></label>
    <select id="tableSelect" name="tableSelect" oninput="displayCon()">
        <option selected disabled value="">Select Table</option>
        <option value="Order">Order</option>
        <option value="Item">Item</option>
        <option value="User">User</option>
        <option value="Truck">Truck</option>
        <option value="Trip">Trip</option>
        <option value="Shopping">Shopping</option>
        <option value="Review">Review</option>
    </select>

    <form style="display:none" id="form1" action="validate-update.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="orderTableFields">

                <input type="text" name="tableSelect" value="Order" style="visibility:hidden"> </input>

                <label for="orderId"><b>Order Id</b></label>
                <input type="text" name="orderId" required>

                <label for="DateIssued"><b>Date Issued</b></label>
                <input type="date" name="dateIssued">
                
                <label for="DateReceived"><b>Date Received</b></label>
                <input type="date" name="dateReceived">

                <label for="TotalPrice"><b>Total Price</b></label>
                <input type="text" name="totalPrice">

                <label for="Payment Code"><b>Payment Code</b></label>
                <input type="text" name="paymentCode">

                <label for="UserId"><b>User ID</b></label>
                <input type="text" maxlength="11" name="userId">

                <label for="TripId"><b>Trip ID</b></label>
                <input type="text" maxlength="11" name="tripId">

                <label for="ReceiptId"><b>Receipt ID</b></label>
                <input type="text" maxlength="11" name="receiptId">

                <label for="orderIsComp"><b>Completed</b></label>
                <select id="orderIsComp" name="orderIsComp" >
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>

              
            </div>
            
            <div class="sign-multiple-column sign-end">
                <input type="submit" value="UPDATE">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form2" action="validate-update.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="userTableFields">
                <input type="text" name="tableSelect" value="User" style="visibility:hidden"> </input>

                <label for="uUserId"><b>User ID</b></label>
                <input type="text" name="uUserId" required>

                <label for="loginId"><b>Login ID</b></label>
                <input type="text" name="loginId">
                
                <label for="userPass"><b>Password</b></label>
                <input type="text" name="userPass">

                <label for="userName"><b>Username</b></label>
                <input type="text" name="userName">

                <label for="userEmail"><b>Email</b></label>
                <input type="text" name="userEmail">
                
                <label for="userPhone"><b>Phone</b></label>
                <input type="text" name="userPhone">

                <label for="userAddress"><b>City Code</b></label>
                <input type="text" name="userAddress">

                <label for="userCC"><b>City Code</b></label>
                <input type="text" name="userCC">

                <label for="userBalance"><b>Balance</b></label>
                <input type="text" name="userBalance">

                <label for="userIsAdmin"><b>Is Is Admin</b></label>
                <select id="userIsAdmin" name="userIsAdmin" >
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
    
            </div>
            <div class="sign-multiple-column sign-end">
                <input type="submit" value="UPDATE">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form3" action="validate-update.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="itemTableFields">
                <input type="text" name="tableSelect" value="Item" style="visibility:hidden"> </input>

                
                <label for="iItemId"><b>Item Id</b></label>
                <input type="text" name="iItemId" required>

                <label for="itemName"><b>Name</b></label>
                <input type="text" name="itemName">
                
                <label for="itemPrice"><b>Price</b></label>
                <input type="text" name="itemPrice">

                <label for="itemSource"><b>Source</b></label>
                <input type="text" name="itemSource">

                <label for="itemDest"><b>Department</b></label>
                <input type="text" name="itemDest">

                <label for="itemUrl"><b>Image URL</b></label>
                <input type="text" name="itemUrl">
                
            </div>
            <div class="sign-multiple-column sign-end">
                <input type="submit" value="UPDATE">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form4" action="validate-update.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="shoppingTableFields">
                <input type="text" name="tableSelect" value="Shopping" style="visibility:hidden"> </input>

               
                <label for="sStoreId"><b>Store ID</b></label>
                <input type="text" name="sStoreId" required>

                <label for="storeCode"><b>Store Code</b></label>
                <input type="text" name="storeCode">
                
                <label for="shoppingPrice"><b>Price</b></label>
                <input type="text" name="shoppingPrice">
            </div>
            <div class="sign-multiple-column sign-end">
                <input type="submit" value="UPDATE">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form5" action="validate-update.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="shoppingTableFields">

                <input type="text" name="tableSelect" value="Trip" style="visibility:hidden"> </input>

                <label for="tTripId"><b>Trip ID</b></label>
                <input type="text" name="tTripId" required >

                <label for="srcCode"><b>Source Code</b></label>
                <input type="text" name="srcCode" >
                
                <label for="destCode"><b>Destination Code</b></label>
                <input type="text" name="destCode" >

                <label for="tripDist"><b>Distance</b></label>
                <input type="text" name="tripDist" >

                <label for="tripTruckId"><b>Truck ID</b></label>
                <input type="text" name="tripTruckId" >

                <label for="tripPrice"><b>Price</b></label>
                <input type="text" name="tripPrice" >
            </div>

            <div class="sign-multiple-column sign-end">
                <input type="submit" value="UPDATE">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form6" action="validate-update.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">

            <div id="truckTableFields">

                <input type="text" name="tableSelect" value="Truck" style="visibility:hidden"> </input>

                <label for="mTruckId"><b>Truck ID</b></label>
                <input type="text" name="mTruckId" required >
                
                <label for="tTruckCode"><b>Truck Code</b></label>
                <input type="text" name="tTruckCode" >
                
                <label for="truckAvailCode"><b>Availabilty Code</b></label>
                <input type="text" name="truckAvailCode">
            </div>

            <div class="sign-multiple-column sign-end">
                <input type="submit" value="UPDATE">
            </div>

        </div>
    </div>
</form>


<form style="display:none" id="form7" action="validate-update.php" method="post">
        <br></br>

        <input type="text" name="tableSelect" value="Review" style="display:none"> </input>
        
        <label for="mReviewId"><b>Review ID</b></label>
        <input type="text" name="mReviewId" required >
                
        <label for="mUserId"><b>User ID</b></label>
        <input type="text" name="mUserId" required >

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
        
        <div class="sign-multiple-column sign-end">
            <input type="submit" value="UPDATE">
        </div>
</form>


<?php
use_common_page_footer();
?>