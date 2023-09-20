async function runPageScriptIndex() {}

function runPageScriptHome() {
    initMap();
    var minDate = new Date();
    $('#datetime').datetimepicker({
      format: 'Y-M-d H:m:s',
      icons: {
        time: 'fa fa-clock-o',
        date: 'fa fa-calendar',
        up: 'fa fa-chevron-up',
        down: 'fa fa-chevron-down',
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
      },
      minDate: minDate + 3,
      // Set the maximum date to 3 days after today
      maxDate: moment().add(7, 'days').toDate()
    });
    Cart.initialize();

    $('#ccnumber').on('input', (evt) => {
        const inputValue = $(evt.target).val();
        let acc_sanitized = "";
        for (let i = 0; i < inputValue.length; i++) {
            if (inputValue[i] !== "-") {
                acc_sanitized += inputValue[i];
            }
            const acc_size = acc_sanitized.length;
            if (acc_size > 0 && (acc_size + 1) % 5 === 0 && acc_size < inputValue.length) {
                acc_sanitized += "-";
            }
        }
        if (acc_sanitized.length > 0 && !'0123456789'.includes(acc_sanitized.at(-1))) {
            acc_sanitized = acc_sanitized.substring(0, acc_sanitized.length - 1);
        }
        acc_sanitized = acc_sanitized.substring(0, 19);
        $(evt.target).val(acc_sanitized);
        $(evt.target).attr("value", acc_sanitized);
        attemptEnableInvoiceProceed();
    });

    $('#cvvcvccode').on('input', (evt) => {
        const inputValue = $(evt.target).val();
        let acc_sanitized = inputValue;
        if (acc_sanitized.length > 0 && !'0123456789'.includes(acc_sanitized.at(-1))) {
            acc_sanitized = acc_sanitized.substring(0, acc_sanitized.length - 1);
        }
        acc_sanitized = acc_sanitized.substring(0, 3);
        $(evt.target).val(acc_sanitized);
        $(evt.target).attr("value", acc_sanitized);
        attemptEnableInvoiceProceed();
    });

    $('#cardholder').on('input', (evt) => {
        const inputValue = $(evt.target).val();
        let acc_sanitized = inputValue;
        acc_sanitized = acc_sanitized.substring(0, 32);
        $(evt.target).val(acc_sanitized);
        $(evt.target).attr("value", acc_sanitized);
        attemptEnableInvoiceProceed();
    });

    $('#instituteno').on('input', (evt) => {
        const inputValue = $(evt.target).val();
        let acc_sanitized = inputValue;
        if (acc_sanitized.length > 0 && !'0123456789'.includes(acc_sanitized.at(-1))) {
            acc_sanitized = acc_sanitized.substring(0, acc_sanitized.length - 1);
        }
        acc_sanitized = acc_sanitized.substring(0, 3);
        $(evt.target).val(acc_sanitized);
        $(evt.target).attr("value", acc_sanitized);
        attemptEnableInvoiceProceed();
    });
    

    const productList = document.querySelector('.product-list');

    Query.run("SELECT * FROM Item", function (response) {
        const result = response;
        result.forEach((row) => {
            const productBox = document.createElement('div');
            productBox.className = 'product-box';
            productBox.draggable = true;
            productBox.ondragstart = dragProduct;

            const productImage = document.createElement('img');
            productImage.src = row["image_url"];
            productImage.alt = row["name"];
            productImage.draggable = false;
            productImage.className = 'no-user-select';
            productBox.appendChild(productImage);

            const productDescription = document.createElement('div');
            productDescription.className = 'product-description';

            const productName = document.createElement('span');
            productName.innerHTML = '<b>' + row["name"] + '</b>';
            productDescription.appendChild(productName);

            const breakerNode = document.createElement('br');
            productDescription.appendChild(breakerNode);

            const productPrice = document.createElement('span');
            productPrice.innerHTML = '$' + row["price"];
            productDescription.appendChild(productPrice);

            productBox.appendChild(productDescription);

            const productObject = document.createElement('object');
            productObject.data = row["id"];
            productBox.appendChild(productObject);

            productList.appendChild(productBox);
        });
    });

    const priceMatchWrapper = document.createElement('div');
    priceMatchWrapper.className = 'price-match-wrapper';

    const priceMatchHeading = document.createElement('h1');
    priceMatchHeading.innerHTML = 'Optional Service: Price Matching';
    priceMatchWrapper.appendChild(priceMatchHeading);

    const priceMatchList = document.createElement('div');
    priceMatchList.className = 'product-list';

    priceMatchWrapper.appendChild(priceMatchList);
    productList.after(priceMatchWrapper);

    Query.run("SELECT * FROM pricematch", function (response) {
        const result = response;
        result.forEach((row) => {
            const productBox = document.createElement('div');
            productBox.className = 'product-box';
            productBox.draggable = true;
            productBox.ondragstart = dragProduct;

            const productImage = document.createElement('img');
            productImage.src = row["image_url"];
            productImage.alt = row["name"];
            productImage.draggable = false;
            productImage.className = 'no-user-select';
            productBox.appendChild(productImage);

            const productDescription = document.createElement('div');
            productDescription.className = 'product-description';

            const productName = document.createElement('span');
            productName.innerHTML = '<b>' + row["name"] + '</b>';
            productDescription.appendChild(productName);

            const breakerNode = document.createElement('br');
            productDescription.appendChild(breakerNode);

            const productPrice = document.createElement('span');
            productPrice.innerHTML = '$' + row["price"];
            productDescription.appendChild(productPrice);

            productBox.appendChild(productDescription);

            const productObject = document.createElement('object');
            productObject.data = row["id"];
            productBox.appendChild(productObject);

            priceMatchList.appendChild(productBox);
        });
    });

    const form = document.querySelector('form');
    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        $('#invoice-sum-redir').prop("style", "display: none");

        ["datetime", "branch", "address", "distance"].forEach(k => 
        {sessionStorage.setItem(k, document.querySelector(`[name='${k}']`).value);});

        let item = Cart.as_dict(); 
        let inv_subtotal = await Cart.get_cost();
        //console.log("inv-subtotal"+inv_subtotal);

        let inv_distance_fee = parseFloat(sessionStorage.getItem("distance")) / 10;
        inv_distance_fee = Math.round(inv_distance_fee * 100) / 100;
        let inv_hst = Math.round(0.13 * (inv_subtotal + inv_distance_fee) * 100) / 100;
        let inv_total = Math.round((inv_subtotal + inv_distance_fee + inv_hst) * 100) / 100;

        let disp_subtotal = inv_subtotal.toFixed(2);
        let disp_distance_fee = inv_distance_fee.toFixed(2);
        let disp_hst = inv_hst.toFixed(2);
        let disp_total = inv_total.toFixed(2);

        sessionStorage.setItem("invoice_total", inv_total);
        sessionStorage.setItem("subtotal", inv_subtotal);
        sessionStorage.setItem("distance_fee", inv_distance_fee);

        const newId = await new Promise((resolve) => {
            Query.run(`SELECT * FROM \`Order\``, function(result) {
                resolve(`${result.length + 1}`);
            });
        });

        const invoiceNum = newId.padStart(5, "0");
        const invoiceDateYMD = new Date().toISOString().slice(0, 10);

        document.getElementById("invoiceResult").innerHTML = `
            <div class="invoice-wrapper">
        <div class="invoice-container">
        <h1>Invoice Summary</h1>
        <b>Invoice #</b>
        <p>${invoiceNum}</p>
        <b>Invoice Date</b>
        <p>${invoiceDateYMD}</p>
        <b>Cardholder Name</b>
        <p>${$("#cardholder").val()}</p>
        <b>Credit Card No.</b>
        <p>${obfuscate_card_no($("#ccnumber").val())}</p>
        <b>Institution No.</b>
        <p>${$("#instituteno").val()}</p>
        <b>Address</b>
        <p>${sessionStorage.getItem("address")}</p>
        <b>Branch</b>
        <p>${sessionStorage.getItem("branch")}</p>
        <b>Delivery Date</b>
        <p>${sessionStorage.getItem("datetime")}</p>
        <hr>
        <table class="item-table">
        <tr>
            <th width="55%">Item</th>
            <th>Quantity</th>
            <th>Unit Cost</th>
            <th>Amount</th>
        </tr>
        <tr ng-repeat="item in items">
        </tr>
        </table>
        <br clear="all">
        <div class="invoice-multiple-column invoice-end">
        <input type="submit" value="Place Order" onclick="confirmPurchase()">
        <div>
            <table class="sum-table">
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td><b>Subtotal:</b></td>
                <td width="10%"></td>
                <td>${disp_subtotal}</td>
            </tr>
            <tr>
                <td><b>Distance Fee ($1 / 10km):</b></td>
                <td width="10%"></td>
                <td>${disp_distance_fee}</td>
            </tr>
            <tr>
                <td><b>HST (13%):</b></td>
                <td width="10%"></td>
                <td>${disp_hst}</td>
            </tr>
            <tr>
                <td colspan="3">--</td>
            </tr>
            <tr>
                <td><b>Total:</b></td>
                <td width="10%"></td>
                <td>${disp_total}</td>
            </tr>`;

        for (const [key, value] of Object.entries(item)) {
            console.log(key, value);
            Query.run(`SELECT * FROM \`Item\` WHERE id = ${key}`, function (result) {
                const response = result;
                response.forEach((row) => {
                    $(".item-table").append(`
                    <tr ng-repeat="item in items">
                        <td>${row.name}</td>
                        <td>${value}</td>
                        <td>${row.price}</td>
                        <td>${value * row.price}</td>
                    </tr>`);
                });
            })
        }

        window.scrollBy(0, 1000);
    });

}

async function loadItems(){
    const mySelect = document.getElementById('itemNumber');
    Query.run(`SELECT * FROM Item`, function (result) {
        const response = result;
        response.forEach((row) => {
           var option = document.createElement("option");
           option.value = row["id"];
           option.text = row["name"];
           mySelect.appendChild(option);
        });
    });
}

async function runPageScriptReview(){
    const mySelect = document.getElementById('itemNumber');
    Query.run(`SELECT * FROM Item`, function (result) {
        const response = result;
        response.forEach((row) => {
           var option = document.createElement("option");
           option.value = row["id"];
           option.text = row["name"];
           mySelect.appendChild(option);
        });
    });

    const form = document.querySelector('form');
    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        const ratingNumber = parseInt(document.querySelector('[name="ratingNumber"]').value);
        const itemNumber = parseInt(document.querySelector('[name="itemNumber"]').value);
        const reviewText = document.querySelector('[name="reviewText"]').value;
        const { result: auth_result } = await HTTPRequest.post("./api/auth.php", {
            function: "get_session_user",
        });
        const user_id = auth_result["id"];
        await Query.run(`INSERT INTO Review (user_id, item_id, rating_number, review_text) VALUES (${user_id}, ${itemNumber}, '${ratingNumber}', '${reviewText}')`, () => {});
        window.location.reload();
    });

    const prevDisplay = document.getElementById("previousDisplay");
    Query.run(`SELECT * FROM REVIEW`, function (result) {
        const response = result;
        response.forEach((row) => {

           var nRow = document.createElement("tr");
           var nCol1 = document.createElement("td");
           var t1 = document.createTextNode(row["user_id"]);
           nCol1.appendChild(t1);
           nRow.appendChild(nCol1);

           var nCol2 = document.createElement("td");
           var t2 = document.createTextNode(row["review_text"]);
           nCol2.appendChild(t2);

           var nCol3 = document.createElement("td");
           var t3 = document.createTextNode(row["rating_number"]);
           nCol3.appendChild(t3);
           
           var nCol4 = document.createElement("td");
           var t4 = document.createTextNode(row["item_id"]);
           nCol4.appendChild(t4);

           
           nRow.appendChild(nCol2);
           nRow.appendChild(nCol3);
           nRow.appendChild(nCol4);
        
           prevDisplay.appendChild(nRow);

           
        });
    });


}

async function runPageScriptInsert(){

    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const tablename = document.querySelector('[name="tableSelect"]').value.trim();

        if(tablename.localeCompare("Order") == 0){

            const dateIssued = document.querySelector('[name="dateIssued"]').value.trim();
            const dateReceived = document.querySelector('[name="dateReceived"]').value.trim();
            const totalPrice = document.querySelector('[name="totalPrice"]').value.trim();
            const paymentCode = document.querySelector('[name="paymentCode"]').value.trim();
            const userId = document.querySelector('[name="userId"]').value;
            const tripId = document.querySelector('[name="tripId"]').value;
            const receiptId = document.querySelector('[name="receiptId"]').value.trim();
            const completed = document.querySelector('[name="orderIsComp"]').value;

            Query.run(`INSERT INTO \`Order\`(date_issued, date_received, total_price, payment_code, user_id, trip_id, receipt_id, completed) 
            VALUES ('${dateIssued}', '${dateReceived}', '${totalPrice}', '${paymentCode}', '${userId}', '${tripId}', '${receiptId}', '${completed}')`, function (result) {
                const response = result;
                console.log(response);
            });
           
        }

        if(tablename.localeCompare("Item") == 0){

            const itemName = document.querySelector('[name="itemName"]').value.trim();
            const itemPrice = document.querySelector('[name="itemPrice"]').value.trim();
            const itemSource = document.querySelector('[name="itemSource"]').value.trim();
            const itemDepart = document.querySelector('[name="itemDest"]').value.trim();
            const itemUrl = document.querySelector('[name="itemUrl"]').value.trim();
           

            Query.run(`INSERT INTO Item (name, source, department, image_url) 
            VALUES ('${itemName}', '${itemPrice}', '${itemSource}', '${itemDepart}', '${itemUrl}'`, function (result) {
                const response = result;
                console.log(response);
            });
            
        }

        if(tablename.localeCompare("Truck") == 0){

            const truckCode = document.querySelector('[name="truckCode"]').value.trim();
            const truckAvail = document.querySelector('[name="availCode"]').value.trim();

            Query.run(`INSERT INTO Truck (truck_code, availability_code) 
            VALUES ('${truckCode}', '${truckAvail}'`, function (result) {
                const response = result;
                console.log(response);
            });
            
        }

        if(tablename.localeCompare("User") == 0){

            
            const loginId = document.querySelector('[name="loginId"]').value.trim();
            const userPass = document.querySelector('[name="userPass"]').value.trim();
            const userName = document.querySelector('[name="userName"]').value.trim();
            const userEmail = document.querySelector('[name="userEmail"]').value.trim();
            const userPhone = document.querySelector('[name="userPhone"]').value;
            const userAddress = document.querySelector('[name="userAddress"]').value;
            const userCC = document.querySelector('[name="userCC"]').value.trim();
            const isAdmin = document.querySelector('[name="userIsAdmin"]').value.trim();
            const balance = document.querySelector('name=["userBalance"]').value.trim();

            Query.run(`INSERT INTO \`User\` (login_id, password, name, email, address, phone, city_code, balance, is_admin) VALUES ('${loginId}', '${userPass}', '${userName}', '${userEmail}', '${userAddress}', '${userPhone}', '${userCC}', ${balance},'${isAdmin}')`, function (result) {
                const response = result;
                console.log(response);
            });
            
        }

        if(tablename.localeCompare("Shopping") == 0){

            
            const storeCode= document.querySelector('[name="storeCode"]').value.trim();
            const shoppingPrice = document.querySelector('[name="shoppingPrice"]').value.trim();

            Query.run(`INSERT INTO Shopping
            (store_code, total_price)
            VALUES ('${storeCode}', '${shoppingPrice}')`, function (result) {
                const response = result;
                console.log(response);
            });
           
        }

        if(tablename.localeCompare("Trip") == 0){

            
            const srcCode= document.querySelector('[name="srcCode"]').value.trim();
            const destCode = document.querySelector('[name="destCode"]').value.trim();
            const tripDist= document.querySelector('[name="tripDist"]').value.trim();
            const tripTruckId = document.querySelector('[name="tripTruckId"]').value.trim();
            const tripPrice= document.querySelector('[name="tripPrice"]').value.trim();

            Query.run(`INSERT INTO $tableName
            (source_code, destination_code, distance, truck_id, price)
            VALUES
            ('${srcCode}', '${destCode}', '${tripDist}', '${tripTruckId}', '${tripPrice}')`, function (result) {
                const response = result;
                console.log(response);
            });
            window.location.replace("#!/insert");
        }
    });
}

async function runPageScriptSelect(){
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const tablename = document.querySelector('[name="tableSelect"]').value.trim();

        if(tablename.localeCompare("Order") == 0){
        
            const orderId = document.querySelector('[name="orderid"]').value.trim();
            const prevDisplay = document.getElementById("previousDisplay");
            Query.run(`SELECT * FROM \`Order\` WHERE id='${orderId}'`, function (result) {
                const response = result;
                response.forEach((row) => {

                    var nRow = document.createElement("tr");
                    var nCol1 = document.createElement("td");
                    var t1 = document.createTextNode(row["id"]);
                    nCol1.appendChild(t1);
                    nRow.appendChild(nCol1);

                    var nCol2 = document.createElement("td");
                    var t2 = document.createTextNode(row["date_issued"]);
                    nCol2.appendChild(t2);

                    var nCol3 = document.createElement("td");
                    var t3 = document.createTextNode(row["date_received"]);
                    nCol3.appendChild(t3);
                    
                    var nCol4 = document.createElement("td");
                    var t4 = document.createTextNode(row["total_price"]);
                    nCol4.appendChild(t4);
                    nRow.appendChild(nCol2);
                    nRow.appendChild(nCol3);
                    nRow.appendChild(nCol4);
                    
                    prevDisplay.appendChild(nRow);

                });
            });
        }

        if(tablename.localeCompare("Item") == 0){
            const itemId = document.querySelector('[name="itemId"]').value.trim();
            const prevDisplay = document.getElementById("previousDisplay");
            Query.run(`SELECT * FROM ${tablename} WHERE id='${itemId}'`, function (result) {
                const response = result;
                response.forEach((row) => {

                    var nRow = document.createElement("tr");
                    var nCol1 = document.createElement("td");
                    var t1 = document.createTextNode(row["id"]);
                    nCol1.appendChild(t1);
                    nRow.appendChild(nCol1);

                    var nCol2 = document.createElement("td");
                    var t2 = document.createTextNode(row["name"]);
                    nCol2.appendChild(t2);

                    var nCol3 = document.createElement("td");
                    var t3 = document.createTextNode(row["source"]);
                    nCol3.appendChild(t3);
                    
                    var nCol4 = document.createElement("td");
                    var t4 = document.createTextNode(row["price"]);
                    nCol4.appendChild(t4);
                    nRow.appendChild(nCol2);
                    nRow.appendChild(nCol3);
                    nRow.appendChild(nCol4);
                    
                    prevDisplay.appendChild(nRow);

                });
            });
        }

        if(tablename.localeCompare("Truck") == 0){

            const truckId = document.querySelector('[name="truckId"]').value.trim();
            const prevDisplay = document.getElementById("previousDisplay");
            Query.run(`SELECT * FROM ${tablename} WHERE id='${truckId}'`, function (result) {
                const response = result;
                response.forEach((row) => {

                    var nRow = document.createElement("tr");
                    
                    var nCol1 = document.createElement("td");
                    var t1 = document.createTextNode(row["id"]);
                    nCol1.appendChild(t1);
                    nRow.appendChild(nCol1);

                    var nCol2 = document.createElement("td");
                    var t2 = document.createTextNode(row["truck_code"]);
                    nCol2.appendChild(t2);

                    var nCol3 = document.createElement("td");
                    var t3 = document.createTextNode(row["availability_code"]);
                    nCol3.appendChild(t3);
                    
                    var nCol4 = document.createElement("td");
                    var t4 = document.createTextNode("");

                    nCol4.appendChild(t4);
                    nRow.appendChild(nCol2);
                    nRow.appendChild(nCol3);
                    nRow.appendChild(nCol4);
                    
                    prevDisplay.appendChild(nRow);

                });
            });
           
        }

        if(tablename.localeCompare("User") == 0){

            const userId = document.querySelector('[name="userId"]').value.trim();
            const prevDisplay = document.getElementById("previousDisplay");
            Query.run(`SELECT * FROM ${tablename} WHERE id='${userId}'`, function (result) {
                const response = result;
                response.forEach((row) => {

                    var nRow = document.createElement("tr");
                    
                    var nCol1 = document.createElement("td");
                    var t1 = document.createTextNode(row["login_id"]);
                    nCol1.appendChild(t1);
                    nRow.appendChild(nCol1);

                    var nCol2 = document.createElement("td");
                    var t2 = document.createTextNode(row["name"]);
                    nCol2.appendChild(t2);

                    var nCol3 = document.createElement("td");
                    var t3 = document.createTextNode(row["password"]);
                    nCol3.appendChild(t3);
                    
                    var nCol4 = document.createElement("td");
                    var t4 = document.createTextNode(row["email"]);

                    nCol4.appendChild(t4);
                    nRow.appendChild(nCol2);
                    nRow.appendChild(nCol3);
                    nRow.appendChild(nCol4);
                    
                    prevDisplay.appendChild(nRow);

                });
            });
           
        }

        if(tablename.localeCompare("Shopping") == 0){
            const shoppingId = document.querySelector('[name="shoppingId"]').value.trim();
            const prevDisplay = document.getElementById("previousDisplay");
            Query.run(`SELECT * FROM ${tablename} WHERE id='${shoppingId}'`, function (result) {
                const response = result;
                response.forEach((row) => {

                    var nRow = document.createElement("tr");
                    
                    var nCol1 = document.createElement("td");
                    var t1 = document.createTextNode(row["id"]);
                    nCol1.appendChild(t1);
                    nRow.appendChild(nCol1);

                    var nCol2 = document.createElement("td");
                    var t2 = document.createTextNode(row["store_code"]);
                    nCol2.appendChild(t2);

                    var nCol3 = document.createElement("td");
                    var t3 = document.createTextNode(row["total_price"]);
                    nCol3.appendChild(t3);
                    
                    var nCol4 = document.createElement("td");
                    var t4 = document.createTextNode("");

                    nCol4.appendChild(t4);
                    nRow.appendChild(nCol2);
                    nRow.appendChild(nCol3);
                    nRow.appendChild(nCol4);
                    
                    prevDisplay.appendChild(nRow);

                });
            });
        }

        if(tablename.localeCompare("Trip") == 0){
            const tripId = document.querySelector('[name="tripId"]').value.trim();
            const prevDisplay = document.getElementById("previousDisplay");
            Query.run(`SELECT * FROM ${tablename} WHERE id='${tripId}'`, function (result) {
                const response = result;
                response.forEach((row) => {

                    var nRow = document.createElement("tr");
                    
                    var nCol1 = document.createElement("td");
                    var t1 = document.createTextNode(row["id"]);
                    nCol1.appendChild(t1);
                    nRow.appendChild(nCol1);

                    var nCol2 = document.createElement("td");
                    var t2 = document.createTextNode(row["source_code"]);
                    nCol2.appendChild(t2);

                    var nCol3 = document.createElement("td");
                    var t3 = document.createTextNode(row["destination_code"]);
                    nCol3.appendChild(t3);
                    
                    var nCol4 = document.createElement("td");
                    var t4 = document.createTextNode(row["distance"]);

                    nCol4.appendChild(t4);
                    nRow.appendChild(nCol2);
                    nRow.appendChild(nCol3);
                    nRow.appendChild(nCol4);
                    
                    prevDisplay.appendChild(nRow);

                });
            });
        }
    });
}


async function runPageScriptDelete(){
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const tablename = document.querySelector('[name="tableSelect"]').value.trim();

        if(tablename.localeCompare("Order") == 0){
        
            const orderId = document.querySelector('[name="orderid"]').value.trim();
            const prevDisplay = document.getElementById("previousDisplay");
            Query.run(`DELETE FROM \`Order\` WHERE id='${orderId}'`, function (result) {
                const response = result;
                response.forEach((row) => {

                    var nRow = document.createElement("tr");
                    var nCol1 = document.createElement("td");
                    var t1 = document.createTextNode(row["id"]);
                    nCol1.appendChild(t1);
                    nRow.appendChild(nCol1);

                    var nCol2 = document.createElement("td");
                    var t2 = document.createTextNode(row["date_issued"]);
                    nCol2.appendChild(t2);

                    var nCol3 = document.createElement("td");
                    var t3 = document.createTextNode(row["date_received"]);
                    nCol3.appendChild(t3);
                    
                    var nCol4 = document.createElement("td");
                    var t4 = document.createTextNode(row["total_price"]);
                    nCol4.appendChild(t4);
                    nRow.appendChild(nCol2);
                    nRow.appendChild(nCol3);
                    nRow.appendChild(nCol4);
                    
                    prevDisplay.appendChild(nRow);

                });
            });
        }

        if(tablename.localeCompare("Item") == 0){
            const itemId = document.querySelector('[name="itemId"]').value.trim();
            const prevDisplay = document.getElementById("previousDisplay");
            Query.run(`DELETE FROM ${tablename} WHERE id='${itemId}'`, function (result) {
                const response = result;
                response.forEach((row) => {

                    var nRow = document.createElement("tr");
                    var nCol1 = document.createElement("td");
                    var t1 = document.createTextNode(row["id"]);
                    nCol1.appendChild(t1);
                    nRow.appendChild(nCol1);

                    var nCol2 = document.createElement("td");
                    var t2 = document.createTextNode(row["name"]);
                    nCol2.appendChild(t2);

                    var nCol3 = document.createElement("td");
                    var t3 = document.createTextNode(row["source"]);
                    nCol3.appendChild(t3);
                    
                    var nCol4 = document.createElement("td");
                    var t4 = document.createTextNode(row["price"]);
                    nCol4.appendChild(t4);
                    nRow.appendChild(nCol2);
                    nRow.appendChild(nCol3);
                    nRow.appendChild(nCol4);
                    
                    prevDisplay.appendChild(nRow);

                });
            });
        }

        if(tablename.localeCompare("Truck") == 0){

            const truckId = document.querySelector('[name="truckId"]').value.trim();
            const prevDisplay = document.getElementById("previousDisplay");
            Query.run(`DELETE FROM ${tablename} WHERE id='${truckId}'`, function (result) {
                const response = result;
                response.forEach((row) => {

                    var nRow = document.createElement("tr");
                    
                    var nCol1 = document.createElement("td");
                    var t1 = document.createTextNode(row["id"]);
                    nCol1.appendChild(t1);
                    nRow.appendChild(nCol1);

                    var nCol2 = document.createElement("td");
                    var t2 = document.createTextNode(row["truck_code"]);
                    nCol2.appendChild(t2);

                    var nCol3 = document.createElement("td");
                    var t3 = document.createTextNode(row["availability_code"]);
                    nCol3.appendChild(t3);
                    
                    var nCol4 = document.createElement("td");
                    var t4 = document.createTextNode("");

                    nCol4.appendChild(t4);
                    nRow.appendChild(nCol2);
                    nRow.appendChild(nCol3);
                    nRow.appendChild(nCol4);
                    
                    prevDisplay.appendChild(nRow);

                });
            });
           
        }

        if(tablename.localeCompare("User") == 0){

            const userId = document.querySelector('[name="userId"]').value.trim();
            const prevDisplay = document.getElementById("previousDisplay");
            Query.run(`DELETE FROM ${tablename} WHERE id='${userId}'`, function (result) {
                const response = result;
                response.forEach((row) => {

                    var nRow = document.createElement("tr");
                    
                    var nCol1 = document.createElement("td");
                    var t1 = document.createTextNode(row["login_id"]);
                    nCol1.appendChild(t1);
                    nRow.appendChild(nCol1);

                    var nCol2 = document.createElement("td");
                    var t2 = document.createTextNode(row["name"]);
                    nCol2.appendChild(t2);

                    var nCol3 = document.createElement("td");
                    var t3 = document.createTextNode(row["password"]);
                    nCol3.appendChild(t3);
                    
                    var nCol4 = document.createElement("td");
                    var t4 = document.createTextNode(row["email"]);

                    nCol4.appendChild(t4);
                    nRow.appendChild(nCol2);
                    nRow.appendChild(nCol3);
                    nRow.appendChild(nCol4);
                    
                    prevDisplay.appendChild(nRow);

                });
            });
           
        }

        if(tablename.localeCompare("Shopping") == 0){
            const shoppingId = document.querySelector('[name="shoppingId"]').value.trim();
            const prevDisplay = document.getElementById("previousDisplay");
            Query.run(`DELETE FROM ${tablename} WHERE id='${shoppingId}'`, function (result) {
                const response = result;
                response.forEach((row) => {

                    var nRow = document.createElement("tr");
                    
                    var nCol1 = document.createElement("td");
                    var t1 = document.createTextNode(row["id"]);
                    nCol1.appendChild(t1);
                    nRow.appendChild(nCol1);

                    var nCol2 = document.createElement("td");
                    var t2 = document.createTextNode(row["store_code"]);
                    nCol2.appendChild(t2);

                    var nCol3 = document.createElement("td");
                    var t3 = document.createTextNode(row["total_price"]);
                    nCol3.appendChild(t3);
                    
                    var nCol4 = document.createElement("td");
                    var t4 = document.createTextNode("");

                    nCol4.appendChild(t4);
                    nRow.appendChild(nCol2);
                    nRow.appendChild(nCol3);
                    nRow.appendChild(nCol4);
                    
                    prevDisplay.appendChild(nRow);

                });
            });
        }

        if(tablename.localeCompare("Trip") == 0){
            const tripId = document.querySelector('[name="tripId"]').value.trim();
            const prevDisplay = document.getElementById("previousDisplay");
            Query.run(`DELETE FROM ${tablename} WHERE id='${tripId}'`, function (result) {
                const response = result;
                response.forEach((row) => {

                    var nRow = document.createElement("tr");
                    
                    var nCol1 = document.createElement("td");
                    var t1 = document.createTextNode(row["id"]);
                    nCol1.appendChild(t1);
                    nRow.appendChild(nCol1);

                    var nCol2 = document.createElement("td");
                    var t2 = document.createTextNode(row["source_code"]);
                    nCol2.appendChild(t2);

                    var nCol3 = document.createElement("td");
                    var t3 = document.createTextNode(row["destination_code"]);
                    nCol3.appendChild(t3);
                    
                    var nCol4 = document.createElement("td");
                    var t4 = document.createTextNode(row["distance"]);

                    nCol4.appendChild(t4);
                    nRow.appendChild(nCol2);
                    nRow.appendChild(nCol3);
                    nRow.appendChild(nCol4);
                    
                    prevDisplay.appendChild(nRow);

                });
            });
        }
    });
}

async function runPageScriptUpdate(){
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const tablename = document.querySelector('[name="tableSelect"]').value.trim();

        if(tablename.localeCompare("Order") == 0){

            const orderId = document.querySelector('[name="orderId"]').value.trim();
            var dateIssued = "";
            var dateReceived = "";
            var totalPrice = "";
            var paymentCode = "";
            var userId = "";
            var tripId = "";
            var receiptId = "";
            var completed = "";

            Query.run(`SELECT * FROM \`Order\` WHERE id = ${orderId}`, function (result) {
                const response = result;
                response.forEach((row) => {
                   dateIssued = row["date_issued"];
                   dateReceived = row["date_received"];
                   totalPrice = row["total_price"];
                   paymentCode = row["payment_code"];
                   userId = row["user_id"];
                   tripId = row["trip_id"];
                   receiptId = row["receipt_id"];
                   completed = row["completed"];
                });
            });
            


             if (document.querySelector('[name="dateIssued"]').value.trim() != null){
                dateIssued = document.querySelector('[name="dateIssued"]').value.trim();
             }
             if (document.querySelector('[name="dateReceived"]').value.trim() != null){
                dateReceived = document.querySelector('[name="dateReceived"]').value.trim();
             }
             if (document.querySelector('[name="totalPrice"]').value.trim() != null){
                totalPrice = document.querySelector('[name="totalPrice"]').value.trim();
             }
             if (document.querySelector('[name="paymentCode"]').value.trim() != null){
                paymentCode = document.querySelector('[name="paymentCode"]').value.trim();
             }
             if (document.querySelector('[name="userId"]').value.trim() != null){
                userId = document.querySelector('[name="userId"]').value.trim();
             }
             if (document.querySelector('[name="tripId"]').value.trim() != null){
                tripId = document.querySelector('[name="tripId"]').value.trim();
             }
             if (document.querySelector('[name="receiptId"]').value.trim() != null){
                receiptId = document.querySelector('[name="receiptId"]').value.trim();
             }
             if (document.querySelector('[name="completed"]').value.trim() != null){
                completed = document.querySelector('[name="completed"]').value.trim();
             }
             
            Query.run(`UPDATE \`Order\` SET date_issued='${dateIssued}'
            , date_received='${dateReceived}' 
            , total_price='${totalPrice}'
            , payment_code='${paymentCode}'
            , user_id='${userId}'
            , trip_id='${tripId}'
            , completed='${completed}'
            , receipt_Id='${receiptId}' WHERE id='${orderId}'`, function (result) {
                const response = result;
                console.log(response);
            });
          
        }

        if(tablename.localeCompare("Item") == 0){

            const itemId = document.querySelector('[name="orderId"]').value.trim();
            var itemName = "";
            var itemPrice = "";
            var itemSource = "";
            var itemDepart = "";
            var itemUrl = "";
        
            Query.run(`SELECT * FROM ITEM WHERE id = ${itemId}`, function (result) {
                const response = result;
                response.forEach((row) => {
                    itemName = row["name"];
                    itemPrice = row["price"];
                    itemSource = row["source"];
                    itemDepart= row["department"];
                    itemUrl= row["image_url"];
                });
            });

            if (document.querySelector('[name="itemName"]').value.trim() != null){
                itemName = document.querySelector('[name="itemName"]').value.trim();
                }
            if (document.querySelector('[name="itemPrice"]').value.trim() != null){
                itemPRice = document.querySelector('[name="itemPrice"]').value.trim();
                }
            if (document.querySelector('[name="itemSource"]').value.trim() != null){
                itemPrice = document.querySelector('[name="itemSource"]').value.trim();
                }
            if (document.querySelector('[name="itemSource"]').value.trim() != null){
                    itemSource = document.querySelector('[name="itemSource"]').value.trim();
                }
            if (document.querySelector('[name="itemDest"]').value.trim() != null){
                itemDepart = document.querySelector('[name="itemDest"]').value.trim();
            }       
            if (document.querySelector('[name="itemUrl"]').value.trim() != null){
                itemUrl = document.querySelector('[name="itemUrl"]').value.trim();
            }      
        
           
            Query.run(`UPDATE ${tableName} SET name='${itemName}'
            , price='${itemPrice}' 
            , source='${itemSource}'
            , department='${itemDepart}'
            , image_url = '${itemUrl}'
            WHERE id='${itemId}'`, function (result) {
                const response = result;
                console.log(response);
            });
           
        }

        if(tablename.localeCompare("Truck") == 0){

            const truckId = document.querySelector('[name="mTruckId"]').value.trim();
            var truckCode = "";
            var truckAvail = "";

        
            Query.run(`SELECT * FROM TRUCK WHERE id = ${truckId}`, function (result) {
                const response = result;
                response.forEach((row) => {
                    truckCode = row["truck_code"];
                    truckAvail = row["availability_code"];
                });
            });
            
            if (document.querySelector('[name="truckCode"]').value.trim() != null){
                truckCode = document.querySelector('[name="truckCode"]').value.trim();
            }   
            if (document.querySelector('[name="availCode"]').value.trim() != null){
                truckAvail = document.querySelector('[name="availCode"]').value.trim();
            }   

            Query.run(`UPDATE ${tableName} SET truck_code='${truckCode}' , availability_code='${availCode}' WHERE id='${truckId}'`, function (result) {
                const response = result;
                console.log(response);
            });
            
        }

        if(tablename.localeCompare("User") == 0){

            const truckId = document.querySelector('[name="mTruckId"]').value.trim();
            loginId = "";
            userPass = "";
            userName = "";
            userEmail= "";
            userPhone = "";
            userAddress = "";
            userCC= "";
            balance= "";
            isAdmin="";

            Query.run(`SELECT * FROM USER WHERE id = ${truckId}`, function (result) {
                const response = result;
                response.forEach((row) => {
                    loginId = row["login_id"];
                    userPass = row["password"];
                    userName = row["name"];
                    userEmail= row["email"];
                    userPhone = row["phone"];
                    userAddress = row["address"];
                    userCC= row["city_code"];
                    balance= row["balance"];
                    isAdmin=row["is_admin"];
                });
            });

            if (document.querySelector('[name="loginId"]').value.trim() != null){
                loginId = document.querySelector('[name="loginId"]').value.trim();
            }               
            if (document.querySelector('[name="userPass"]').value.trim() != null){
                userPass = document.querySelector('[name="userPass"]').value.trim();
            }   
            if (document.querySelector('[name="userName"]').value.trim() != null){
                userName = document.querySelector('[name="userName"]').value.trim();
            }
            if (document.querySelector('[name="userEmail"]').value.trim() != null){
                userEmail = document.querySelector('[name="userEmail"]').value.trim();
            }   
            if (document.querySelector('[name="userPhone"]').value.trim() != null){
                userPhone = document.querySelector('[name="userPhone"]').value.trim();
            }   
            if (document.querySelector('[name="userAddress"]').value.trim() != null){
                userAddress = document.querySelector('[name="userAddress"]').value.trim();
            } 
            if (document.querySelector('[name="userCC"]').value.trim() != null){
                userCC = document.querySelector('[name="userAddress"]').value.trim();
            }   
            if (document.querySelector('[name="userBalance"]').value.trim() != null){
                userBalance = document.querySelector('[name="userBalance"]').value.trim();
            }    
            if (document.querySelector('[name="userIsAdmin"]').value.trim() != null){
                isAdmin = document.querySelector('[name="userIsAdmin"]').value.trim();
            }     
        
            Query.run(`UPDATE \`USER\` SET login_id='${loginId}'
            , password='${userPass}' 
            , name='${userName}'
            , email='${userEmail}'
            , phone='${userPhone}' 
            , address='${userAddress}'
            , city_code='${userCC}'
            , balance='${balance}'
            , is_admin='${isAdmin}'
            WHERE id='${userid}'`, function (result) {
                const response = result;
                console.log(response);
            });
        
        }

        if(tablename.localeCompare("Shopping") == 0){


            const shoppingId = document.querySelector('[name="mTruckId"]').value.trim();
            var storeCode = "";
            var shoppingPrice = "";

            Query.run(`SELECT * FROM Shopping WHERE id='${shoppingId}'`, function (result) {
                const response = result;
                response.forEach((row) => {
                    storeCode = row["store_code"];
                    shoppingPrice = row["total_price"];
                });
            });

            if (document.querySelector('[name="storeCode"]').value.trim() != null){
                storeCode = document.querySelector('[name="storeCode"]').value.trim();
            } 
            if (document.querySelector('[name="shoppingPrice"]').value.trim() != null){
                shoppingPrice = document.querySelector('[name="shoppingPrice"]').value.trim();
            } 

            Query.run(`UPDATE ${tableName} SET store_code='${storeCode}'
            , total_price='${shoppingPrice}' 
            WHERE id='${shoppingId}'`, function (result) {
                const response = result;
                console.log(response);
            });
           
        }

        if(tablename.localeCompare("Trip") == 0){


            var srcCode = "";
            var destCode = "";
            var tripDist = "";
            var tripTruckId = "";
            var tripPrice = "";

            Query.run(`SELECT * FROM Shopping WHERE id='${shoppingId}'`, function (result) {
                const response = result;
                response.forEach((row) => {
                    srcCode = row["source_code"];
                    destCode = row["destination_code"];
                    tripDist = row["distance"];
                    tripTruckId = row["truck_id"];
                    tripPrice = row["price"];
                });
            });

            if (document.querySelector('[name="srcCode"]').value.trim() != null){
                srcCode= document.querySelector('[name="srcCode"]').value.trim();
            } 
            if (document.querySelector('[name="destCode"]').value.trim() != null){
                destCode = document.querySelector('[name="destCode"]').value.trim();
            }            
            if (document.querySelector('[name="tripDist"]').value.trim() != null){
                tripDist= document.querySelector('[name="tripDist"]').value.trim();
            } 
            if (document.querySelector('[name="tripTruckId"]').value.trim() != null){
                tripTruckId = document.querySelector('[name="tripTruckId"]').value.trim();
            } 
            if (document.querySelector('[name="tripPrice"]').value.trim() != null){
                tripPrice= document.querySelector('[name="tripPrice"]').value.trim();
            } 
           

            Query.run(`UPDATE ${tableName} SET source_code='${srcCode}'
            , destination_code='${destCode}' 
            , distance='${tripDist}'
            , truck_id='${tripTruckId}'
            , price='${tripPrice}' 
            WHERE id='${tripId}'`, function (result) {
                const response = result;
                console.log(response);
            });
           
        }
       
    });
}

async function runPageScriptSearch() {
    const form = document.querySelector('form');
    const resultDiv = document.querySelector('#result');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        const orderID = parseInt(document.querySelector('[name="inputBox"]').value);
        Query.run(`SELECT * FROM \`Order\` WHERE id = ${orderID}`, function (result) {
            const response = result;
            response.forEach((row) => {
                if (row && typeof row.completed !== 'undefined') {
                    if (row.completed == 1) {
                        resultDiv.textContent = `Order ${orderID} is completed`;
                    } else if (row.completed == 0) {
                        resultDiv.textContent = `Order ${orderID} is not completed`;
                    }
                } else {
                    resultDiv.textContent = `Order ${orderID} does not exist`;
                }
            });
        });
    });
}

// validates user account creation and inserts new user data into db
async function runSignUpValidation() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        const username = document.querySelector('[name="username"]').value.trim();
        const email = document.querySelector('[name="email"]').value.trim();
        const fname = document.querySelector('[name="fname"]').value.trim();
        const lname = document.querySelector('[name="lname"]').value.trim();
        const name = fname.concat(" ", lname);
        const password = document.querySelector('[name="password"]').value;
        const address = document.querySelector('[name="address"]').value.trim();
        const phone = document.querySelector('[name="phone"]').value.trim();
        const cityCode = phone.substring(0, 3);

        const admin = document.querySelector('[name="is_admin"]');
        if (admin != null ) {
            var isAdmin = 1;
        }else{
            var isAdmin = 0;
        }
        //console.log(isAdmin);

        Query.run(`SELECT COUNT(*) AS matches FROM \`User\` WHERE login_id = '${username}' OR email = '${email}'`, function (result) {
            const response = result;
            if (response[0]["matches"] > 0) {
                alert("This identifier or email has already been taken");
            }
            else {
                HTTPRequest.post("./api/auth.php", {
                    function: "sign_up",
                    arguments: [username, password, name, email, address, phone, cityCode, isAdmin],
                    callback: function () {
                        window.location.replace("#!/sign-in");
                    }
                });
            }
        });
    });
}

// validates sign in
async function signInValidation() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        const username = document.querySelector('[name="username"]').value.trim();
        const password = document.querySelector('[name="password"]').value;

        HTTPRequest.post("./api/auth.php", {
            function: "sign_in",
            arguments: [username, password],
            callback: function (result) {
                if (result["success_flag"]) {
                    const headerControllerNode = document.getElementById("header-controller");
                    const scope = angular.element(headerControllerNode).scope();
                    scope.$apply(() => {
                        scope.updateHeaderDisplay(true);
                    });
                }
                else {
                    alert("Invalid identifier or password");
                }
            }
        });
    });
}



function shoppingCartDisplay(){
    let cart = JSON.parse(sessionStorage.getItem('cart'));
    for (const [key, value] of Object.entries(cart)) {
        console.log(key, value);
        Query.run(`SELECT * FROM \`Item\` WHERE id = ${key}`, function (result) {
            const response = result;
            response.forEach((row) => {
                document.getElementById("resultCart").insertAdjacentHTML('beforeend',`<div class="cart-item">
                <img src="${row.image_url}" alt="${row.name}" class="no-user-select" width="40" height="40">
                <div class="cart-item-description">
                    <span><b>${row.name}</b></span>
                    <br>
                    <span>${row.price} x ${value}</span>
                </div>
            </div>
            <br>`);
            });
        })
      }
}

async function confirmPurchase() {

    const date = sessionStorage.getItem("datetime");
    const branch = sessionStorage.getItem("branch");
    const address = sessionStorage.getItem("address");
    const distance = sessionStorage.getItem("distance");
    const distance_fee =  sessionStorage.getItem("distance_fee");
    const orderDate = new Date();
    let orderD = orderDate.toString();
    const order_total = sessionStorage.getItem("invoice_total");
    const subtotal = parseInt(sessionStorage.getItem("subtotal"));
    const { result: auth_result } = await HTTPRequest.post("./api/auth.php", {
        function: "get_session_user",
    });
    const user_id = auth_result["id"];

    // There were no instructions on what the truck_code and availability_code should actually be, so this has been set with arbitrary parameters
    Query.run(`INSERT INTO Truck(truck_code, availability_code) VALUES ('123', '456')`,
        function (result, err) {
            if (err) {
                console.error(err);
            }
            else {
                console.log(result);
            }
        }
    );

    // Trip query
    Query.run(`
        INSERT INTO Trip(source_code, destination_code, distance, truck_id, price) 
        VALUES ('${branch}','${address}', '${distance}', 1, '${distance_fee}')`,
        function (result, err) {
            if (err) {
                console.error(err);
            }
            else {
                console.log(result);
            }
        }
    );

    // Shopping query
    Query.run(`INSERT INTO Shopping(store_code, total_price) VALUES ('${branch}', '${subtotal}')`,
        function (result, err) {
            if (err) {
                console.error(err);
            }
            else {
                console.log(result);
            }
        }
    );

    // Order query with arbitrary foreign IDs
    Query.run(`
        INSERT INTO \`Order\`(date_issued, date_received, total_price, payment_code, user_id, trip_id, receipt_id, completed) 
        VALUES ('${orderD}', '${date}', '${order_total}', '200', ${user_id}, 1, 1, 0)`,
        function (result, err) {
            if (err) {
                console.error(err);
            }
            else {
                console.log(result);
            }
        }
    );

    // Confirmation and consumption of stored items
    sessionStorage.clear();
    window.location.replace("#!/confirm-purchase");
}

