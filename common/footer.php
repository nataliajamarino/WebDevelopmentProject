
  <!-- login modal -->
    <div class="modal" id="loginModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Please login to finish purchase</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="login" method="POST" action="login.php">
                    <div class="form-group">
                        <label for="inputEmail">Email address</label>
                        <input type="email" name="email" id="email" required class="form-control" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" id="password" name="password" required class="form-control" id="inputPassword" placeholder="Password">
                    </div>
                    <button type="submit" id="submit-form" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal" id="purchaseModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Finish Purchase</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
            </div>
        </div>
    </div> 

    <!-- Bootstrap core JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        function decreaseProduct(id) {
            products[id].qty -= 1;
            products[id].price -= products[id].original_price;
            const cart = document.querySelector('#cart');
            const items = cart.innerHTML;
            cart.innerHTML = Number(items) === 1 ? 0 : Number(items) - 1;
            if (products[id].qty === 0) {
                delete products[id];
            }
            showPurchases(user, products);
        }

        function showPurchases(user, products) {
            // User logged in shows purchase modal
            if (Object.keys(products).length > 0) {
                const totalPrice = Object.keys(products).map(v => products[v].price).reduce((acc, curr) => acc + curr).toFixed(2);
                const modalContent = document.querySelector("#purchaseModal .modal-body");
                let rows = '';
                Object.keys(products).forEach((v, i) => {
                    rows += `
                        <tr>
                            <th scope="row">${i+1}</th>
                            <td>${products[v].name}</td>
                            <td>${products[v].qty}</td>
                            <td>${products[v].price.toFixed(2)}</td>
                            <td><i onclick="decreaseProduct(${v})" class="far fa-minus-square clickable"></i></td>
                        </tr>
                    `;
                });
                modalContent.innerHTML = `
                    <h3>Hello, ${user.name}</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Price</th>
                                <th scope="col">Decrease Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${rows}
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total: ${totalPrice}</td>
                            </tr>
                        </tbody>
                    </table>
                `;
            } else {
                document.querySelector("#purchaseModal .modal-body").innerHTML = `Hello, ${user.name}, your cart is empty.`;
            }
        }
        (function() {
            const submit = function (event) {
                event.preventDefault();
                document.querySelector('#submit-form').disabled = true;
                $.ajax({
                    type: "POST",
                    url: "/login.php",
                    data: "email=" + document.querySelector('#email').value + '&password=' + document.querySelector("#password").value,
                    dataType: "json",
                    success: function(data) {
                        if (data.error) {
                            alert('User not found.');
                            document.querySelector('#submit-form').disabled = false;
                        } else {
                            user = data;
                            document.querySelector('#submit-form').disabled = false;
                            // User logged in shows purchase modal
                            $('#loginModal').modal('toggle');
                            $('#purchaseModal').modal('toggle');
                            showPurchases(user, products);
                        }
                    },
                });
            }
            const form = document.querySelector('#login');
            form.addEventListener("submit", submit, true);

            document.querySelector("#purchase").addEventListener("click", function () {
                if (Object.keys(products).length === 0) {
                    alert("Cart is empty");
                } else if (!user) {
                    $('#loginModal').modal('toggle');
                } else {
                    $('#purchaseModal').modal('toggle');
                    showPurchases(user, products);
                }
            });
        })()
    </script>
</body>
</html>