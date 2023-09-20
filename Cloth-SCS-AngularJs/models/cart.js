class Cart {
    static initialize() {
        if (!sessionStorage.getItem('cart')) {
            sessionStorage.setItem('cart', JSON.stringify({}));
        }
    }

    static add_item(product_id) {
        const cart = JSON.parse(sessionStorage.getItem('cart'));
        if (cart[product_id]) {
            cart[product_id]++;
        } else {
            cart[product_id] = 1;
        }
        sessionStorage.setItem('cart', JSON.stringify(cart));
    }

    static remove_item(product_id) {
        const cart = JSON.parse(sessionStorage.getItem('cart'));
        if (cart[product_id]) {
            cart[product_id]--;
            if (cart[product_id] <= 0) {
                delete cart[product_id];
            }
        }
        sessionStorage.setItem('cart', JSON.stringify(cart));
    }


    static async get_cost() {
        let total = 0;
        const cart = JSON.parse(sessionStorage.getItem('cart'));
        for (const [product_id, item_count] of Object.entries(cart)) {
            const product = await new Promise((resolve, reject) => {
                Query.run(`SELECT * FROM Item WHERE Id= ${product_id}`, function(response) {
                    resolve(response[0]["price"]);
                });
            });
            total += product * item_count;
        }
        console.log("total" + total);
        return total;
    }

/*
    static async get_cost() {
        let total = 0;
        const cart = JSON.parse(sessionStorage.getItem('cart'));
        for (const [product_id, item_count] of Object.entries(cart)) {
            let product;
            Query.run(`SELECT * FROM Item WHERE Id= ${product_id}`, function(response) {
                // This function will be called with the query response
                product = response[0]["price"];
              });
            total += product * item_count;
        }
        console.log("total" + total);
        return total;
    }
*/
  
    static get_size() {
        let count = 0;
        const cart = JSON.parse(sessionStorage.getItem('cart'));
        for (const item_count of Object.values(cart)) {
            count += item_count;
        }
        return count;
    }

    static as_dict() {
        return JSON.parse(sessionStorage.getItem('cart'));
    }
}
