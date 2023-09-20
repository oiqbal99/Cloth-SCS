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

    // Updates cart representation in `sessionStorage`
    Cart.add_item(productId);

    // Call `updateCart` to dynamically update state using content of the `sessionStorage` cart
    const homeControllerNode = document.getElementById("home-controller");
    const scope = angular.element(homeControllerNode).scope();
    scope.$apply(() => {
        scope.updateCart();
    });
}