
function allowDrop(event) {
    event.preventDefault();
}

function dragProduct(event) {
    const draggedProductId = event.target.querySelector("object").getAttribute("data");
    event.dataTransfer.setData("productId", draggedProductId);
}

function dropProduct(event) {
    event.preventDefault();
    const productId = event.dataTransfer.getData("productId");

    $.ajax({
        type: "POST",
        url: "api/cart.php",
        dataType: "json",
        data: {
            fn: "add_item",
            args: [productId]
        },
        success: (res) => {
            location.reload();
            console.log(res);
        }
    });
}