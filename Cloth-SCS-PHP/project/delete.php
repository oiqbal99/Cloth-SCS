<?php
require_once("common.php");
session_start();
use_common_page_header();
?>



<h1>Delete</h1>

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



<form style="display:none" id="form1" action="validate-delete.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="orderTableFields">
                <input type="text" name="tableSelect" value="Order" style="visibility:hidden"> </input>

                <label for="orderid"><b>Order ID</b></label>
                <input type="text" maxlength="11" name="orderid" required>

            </div>

            <div class="sign-multiple-column sign-end">
                <input type="submit" value="DELETE">
            </div>
        </div>
    </div>
</form>

<form style="display:none" id="form2" action="validate-delete.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="userTableFields">
                <input type="text" name="tableSelect" value="User" style="visibility:hidden"> </input>

                <label for="userId"><b>User ID</b></label>
                <input type="text" maxlength="11" name="userId" required>
    
            </div>

            <div class="sign-multiple-column sign-end">
                <input type="submit" value="DELETE">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form3" action="validate-delete.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="itemTableFields">
                <input type="text" name="tableSelect" value="Item" style="visibility:hidden"> </input>

                <label for="itemId"><b>Item ID</b></label>
                <input type="text" maxlength="11" name="itemId" required>
                
            </div>
            <div class="sign-multiple-column sign-end">
                <input type="submit" value="DELETE">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form4" action="validate-delete.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="shoppingTableFields">
                <input type="text" name="tableSelect" value="Shopping" style="visibility:hidden"> </input>

                <label for="shoppingId"><b>Shopping ID</b></label>
                <input type="text" maxlength="11" name="shoppingId" required>
            </div>

            <div class="sign-multiple-column sign-end">
                <input type="submit" value="DELETE">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form5" action="validate-delete.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="shoppingTableFields">

                <input type="text" name="tableSelect" value="Trip" style="visibility:hidden"> </input>

                <label for="tripId"><b>Trip ID</b></label>
                <input type="text" maxlength="11" name="tripId" required>
            </div>

            <div class="sign-multiple-column sign-end">
                <input type="submit" value="DELETE">
            </div>

        </div>
    </div>
</form>

<form style="display:none" id="form6" action="validate-delete.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="truckTableFields">
                <input type="text" name="tableSelect" value="Truck" style="visibility:hidden"> </input>

                <label for="truckId"><b>Truck ID</b></label>
                <input type="text" maxlength="11" name="truckId" required>
            </div>
            <div class="sign-multiple-column sign-end">
                <input type="submit" value="DELETE">
            </div>
        </div>
    </div>
</form>

<form style="display:none" id="form7" action="validate-delete.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <div id="shoppingTableFields">
                <input type="text" name="tableSelect" value="Review" style="visibility:hidden"> </input>

                <label for="reviewId"><b>Review ID</b></label>
                <input type="text" maxlength="11" name="reviewId" required>
            </div>

            <div class="sign-multiple-column sign-end">
                <input type="submit" value="DELETE">
            </div>
        </div>
    </div>
</form>


<?php
use_common_page_footer();
?>