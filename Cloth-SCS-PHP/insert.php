<?php
require_once("common.php");
session_start();
use_common_page_header();
?>

<h1>Insert</h1>

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

<form style="display:none" id="form1" action="validate-insert.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="orderTableFields">

                <input type="text" name="tableSelect" value="Order" style="visibility:hidden"> </input>

                <label for="DateIssued"><b>Date Issued</b></label>
                <input type="date" name="dateIssued" required>
                
                <label for="DateReceived"><b>Date Received</b></label>
                <input type="date" name="dateReceived" required>

                <label for="TotalPrice"><b>Total Price</b></label>
                <input type="text" name="totalPrice" required>

                <label for="Payment Code"><b>Payment Code</b></label>
                <input type="text" name="paymentCode" required>

                <label for="UserId"><b>User ID</b></label>
                <input type="text" maxlength="11" name="userId" required>

                <label for="TripId"><b>Trip ID</b></label>
                <input type="text" maxlength="11" name="tripId" required>

                <label for="ReceiptId"><b>Receipt ID</b></label>
                <input type="text" maxlength="11" name="receiptId" required>

                <label for="orderIsComp"><b>Completed</b></label>
                <select id="orderIsComp" name="orderIsComp" >
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            
            <div class="sign-multiple-column sign-end">
                <input type="submit" value="INSERT">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form2" action="validate-insert.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="userTableFields">
                <input type="text" name="tableSelect" value="User" style="visibility:hidden"> </input>

                <label for="loginId"><b>Login ID</b></label>
                <input type="text" name="loginId" required>
                
                <label for="userName"><b>Username</b></label>
                <input type="text" name="userName" required>

                <label for="userPass"><b>Password</b></label>
                <input type="text" name="userPass" required>

                <label for="userEmail"><b>Email</b></label>
                <input type="text" name="userEmail" required>
                
                <label for="userPhone"><b>Phone</b></label>
                <input type="text" name="userPhone" required>

                <label for="userAddress"><b>User Address</b></label>
                <input type="text" name="userAddress" required>

                <label for="userCC"><b>City Code</b></label>
                <input type="text" name="userCC" required>


                <label for="userBalance"><b>Balance</b></label>
                <input type="text" name="userBalance">

                <label for="userIsAdmin"><b>Is Is Admin</b></label>
                <select id="userIsAdmin" name="userIsAdmin" >
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
    
            </div>
            <div class="sign-multiple-column sign-end">
                <input type="submit" value="INSERT">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form3" action="validate-insert.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="itemTableFields">
                <input type="text" name="tableSelect" value="Item" style="visibility:hidden"> </input>

                
                <label for="itemName"><b>Name</b></label>
                <input type="text" name="itemName" required>
                
                <label for="itemPrice"><b>Price</b></label>
                <input type="text" name="itemPrice" required>

                <label for="itemSource"><b>Source</b></label>
                <input type="text" name="itemSource" required>

                <label for="itemDest"><b>Destination</b></label>
                <input type="text" name="itemDest" required>

                <label for="itemUrl"><b>Image Url</b></label>
                <input type="text" name="itemUrl" required>
                
            </div>
            <div class="sign-multiple-column sign-end">
                <input type="submit" value="INSERT">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form4" action="validate-insert.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="shoppingTableFields">
                <input type="text" name="tableSelect" value="Shopping" style="visibility:hidden"> </input>

                <label for="storeCode"><b>Store Code</b></label>
                <input type="text" name="storeCode" required>
                
                <label for="shoppingPrice"><b>Price</b></label>
                <input type="text" name="shoppingPrice" required>
            </div>
            <div class="sign-multiple-column sign-end">
                <input type="submit" value="INSERT">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form5" action="validate-insert.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="shoppingTableFields">

                <input type="text" name="tableSelect" value="Trip" style="visibility:hidden"> </input>

                <label for="srcCode"><b>Source Code</b></label>
                <input type="text" name="srcCode" required>
                
                <label for="destCode"><b>Destination Code</b></label>
                <input type="text" name="destCode" required>

                <label for="tripDist"><b>Distance</b></label>
                <input type="text" name="tripDist" required>

                <label for="tripTruckId"><b>Truck ID</b></label>
                <input type="text" name="tripTruckId" required>

                <label for="tripPrice"><b>Price</b></label>
                <input type="text" name="tripPrice" required>
            </div>

            <div class="sign-multiple-column sign-end">
                <input type="submit" value="INSERT">
            </div>

        </div>
    </div>
</form>


<form style="display:none" id="form6" action="validate-insert.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="truckTableFields">
                <input type="text" name="tableSelect" value="Truck" style="visibility:hidden"> </input>

                <label for="truckCode"><b>Truck Code</b></label>
                <input type="text" name="truckCode" required>
                
                <label for="truckAvailCode"><b>Availabilty Code</b></label>
                <input type="text" name="availCode" required>
            </div>

            <div class="sign-multiple-column sign-end">
                <input type="submit" value="INSERT">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form7" action="validate-insert.php" method="post">
        <br></br>

        <input type="text" name="tableSelect" value="Review" style="display:none"> </input>
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
            <input type="submit" value="INSERT">
        </div>
</form>



<?php
use_common_page_footer();
?>