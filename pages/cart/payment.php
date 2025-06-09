<?php
session_start();

require_once __DIR__ . '/../../php/db.php';

$user = null;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    $stmt = $db_o->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}

if (!$user) {
    header("Location: ../home/index.php");
    exit();
}

$stmt = $db_o->prepare('SELECT * FROM carts WHERE user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$cart = $stmt->get_result()->fetch_assoc();

if (!$cart) {
    header("Location: ../home/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_method'])) {
    $payment_method = $_POST['payment_method'];
    
    if ($payment_method == 'card') {
        $card_number = $_POST['card_number'];
        $card_exp = $_POST['card_exp'];
        $card_cvv = $_POST['card_cvv'];
        
        if (isset($card_number) && strlen($card_number) === 19 && isset($card_exp) && strlen($card_exp) === 5 && isset($card_cvv) && strlen($card_cvv) === 3) {
            $payment_status = 'success';
        } else {
            $payment_status = 'failed';
        }
    } elseif ($payment_method == 'bank') {
        $bank_number = $_POST['bank_number'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        
        
        if (isset($bank_number) && strlen($bank_number) === 32 && isset($name) && isset($surname)) {
            $payment_status = 'success';
        } else {
            $payment_status = 'failed';
        }
    } else {
        $payment_status = 'failed';
    }
    
    if ($payment_status == 'success') {
        $stmt = $db_o->prepare('INSERT INTO orders VALUES(NULL, ?, 1, 0, curdate(), NULL)');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    
        $stmt = $db_o->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY order_id DESC LIMIT 1');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_row();
    
        $stmt = $db_o->prepare('INSERT INTO order_items (order_id, product_id, quantity)SELECT ?, product_id, quantity FROM cart_items WHERE cart_id = ?');
        $stmt->bind_param('ii', $order[0], $cart['cart_id']);
        $stmt->execute();

        $stmt = $db_o->prepare('DELETE FROM cart_items WHERE cart_id = ?');
        $stmt->bind_param('i', $cart['cart_id']);
        $stmt->execute();

        $stmt = $db_o->prepare('DELETE FROM carts WHERE cart_id = ?');
        $stmt->bind_param('i', $cart['cart_id']);
        $stmt->execute();
        
        header("Location: ../home/index.php");
    } else {
        header("Location: ../home/index.php?message=Payment-failed");
    }
    
    exit();

}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment | GrowZone</title>
  <link rel="stylesheet" href="./styles.css" />
  <link rel="shortcut icon" href="../../public/images/icon.png" />
  <style>
    body {
    margin: 0;
    padding: 0;
    background-color: #1a1c2c;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    }

    .payment-box {
    background-color: #2b2d42;
    border-radius: 10px;
    width: 320px;
    padding: 20px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
    color: white;
    }

    .payment-option {
    background-color: #f1f1f1;
    color: black;
    border-radius: 6px;
    margin-bottom: 10px;
    padding: 12px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    }

    .payment-option:hover {
    background-color: #e2e2e2;
    }

    .details {
    display: none;
    flex-direction: column;
    margin-bottom: 10px;
    }

    .details input {
    margin-top: 5px;
    padding: 8px;
    border-radius: 4px;
    border: none;
    font-size: 14px;
    }

    .icon {
    width: 24px;
    height: auto;
    vertical-align: middle;
    margin-right: 5px;
    }

    .pay-button {
    width: 100%;
    background-color: #007bff;
    color: white;
    font-size: 16px;
    padding: 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s;
    }

    .pay-button:disabled {
    background-color: #666;
    cursor: not-allowed;
    }
  </style>
</head>
<body>
    <form action="" method="post" id="payment-form">
        <input type="hidden" name="payment_method" id="payment-method">
        <div class="payment-box">
            <div class="payment-option" data-method="card">
                <div>
                💳 <span>Karta</span>
                </div>
            </div>
            <div class="details" id="card-details">
                <input type="text" placeholder="Card number" maxlength="19" id="card-number" name="card_number">
                <input type="text" placeholder="Expire date (MM/RR)" maxlength="5" id="card-exp" name="card_exp">
                <input type="text" placeholder="CVV" maxlength="3" id="card-cvv" name="card_cvv">
            </div>
        
            <div class="payment-option" data-method="bank">
                <div>
                🏦
                <span>Przelew bankowy</span>
                </div>
            </div>
            <div class="details" id="bank-details">
                <input type="text" placeholder="Account number" maxlength="32" id="bank-number" name="bank_number">
                <input type="text" placeholder="Name" id="name" name="name">
                <input type="text" placeholder="Surname" id="surname" name="surname">
            </div>
        
            <button class="pay-button" disabled id="pay-btn">Pay €<?php 
            if (isset($cart['cart_id'])) {
            $cart_id = $cart['cart_id'];
            $stmt = $db_o->prepare('SELECT SUM(ci.quantity * p.price) AS wartosc FROM carts c JOIN cart_items ci ON c.cart_id = ci.cart_id JOIN  products p ON ci.product_id = p.product_id WHERE c.cart_id = ?');
            $stmt->bind_param('i', $cart_id);
            $stmt->execute();
            $cart_value = $stmt->get_result()->fetch_assoc()['wartosc'];
            echo htmlspecialchars(number_format($cart_value, 2));
            } else {
                echo htmlspecialchars(number_format(0, 2));
            }
            ?> now</button>
        </div>
    </form>

  <script>
    const options = document.querySelectorAll(".payment-option");
    const payBtn = document.getElementById("pay-btn");

    let currentMethod = null;

    options.forEach(option => {
        option.addEventListener("click", () => {
            const method = option.getAttribute("data-method");

            document.querySelectorAll(".details").forEach(d => d.style.display = "none");

            const details = document.getElementById(`${method}-details`);
            if (currentMethod === method) {
            details.style.display = "none";
            currentMethod = null;
            document.getElementById("payment-method").value = "";
            } else {
            details.style.display = "flex";
            currentMethod = method;
            document.getElementById("payment-method").value = method;
            }

            validateForm();
        });
    });

    document.getElementById("bank-number").addEventListener("input", function (e) {
        let value = e.target.value.replace(/\D/g, "");
        value = value.substring(0, 28);

        let formatted = "";

        if (value.length > 0) {
            formatted += value.substring(0, 2);
        }
        if (value.length > 2) {
            formatted += " " + value.substring(2, 6);
        }
        if (value.length > 6) {
            formatted += " " + value.substring(6, 10);
        }
        if (value.length > 10) {
            formatted += " " + value.substring(10, 14);
        }
        if (value.length > 14) {
            formatted += " " + value.substring(14, 18);
        }
        if (value.length > 18) {
            formatted += " " + value.substring(18, 22);
        }
        if (value.length > 22) {
            formatted += " " + value.substring(22, 26);
        }
        if (value.length > 26) {
            formatted += " " + value.substring(26, 28);
        }

        e.target.value = formatted.trim();
        validateForm();
    });

    document.getElementById("card-exp").addEventListener("input", function (e) {
        let value = e.target.value.replace(/\D/g, "");
        value = value.substring(0, 4);

        let formatted = "";

        if (value.length > 0) {
            formatted += value.substring(0, 2);
        }
        if (value.length > 2) {
            formatted += "/" + value.substring(2, 4);
        }

        e.target.value = formatted.trim();
        validateForm();
    });

    document.getElementById("card-cvv").addEventListener("input", function (e) {
        let value = e.target.value.replace(/\D/g, "");

        e.target.value = value.trim();
        validateForm();
    });

    document.getElementById("card-number").addEventListener("input", function (e) {
        let value = e.target.value.replace(/\D/g, "");
        value = value.substring(0, 16);

        let formatted = value.match(/.{1,4}/g);
        if (formatted) {
            e.target.value = formatted.join("-");
        } else {
            e.target.value = "";
        }

        validateForm();
    });

    function validateForm() {
    let valid = false;

    if (currentMethod === "card") {
        let number = document.getElementById("card-number").value.trim();
        let exp = document.getElementById("card-exp").value.trim();
        let cvv = document.getElementById("card-cvv").value.trim();

        if (number) {
            if (number.length == 19) {
                
            } else {
                number = null;
            }
        } else {
            number = null;
        }

        if (exp) {
            if (exp.length == 5) {
                
            } else {
                exp = null;
            }
        } else {
            exp = null;
        }

        if (cvv) {
            if (cvv.length == 3) {
                
            } else {
                cvv = null;
            }
        } else {
            cvv = null;
        }

        if(number && exp && cvv){
            valid = true;
        } else {
            valid = false;
        }
    } else if (currentMethod === "bank") {
        let bankNumber = document.getElementById("bank-number").value.trim();
        const name = document.getElementById("name").value.trim();
        const surname = document.getElementById("surname").value.trim();

        if (bankNumber) {
            if (bankNumber.length == 32) {
                
            } else {
                bankNumber = null;
            }
        } else {
            bankNumber = null;
        }

        if(bankNumber && name && surname){
            valid = true;
        } else {
            valid = false;
        }
    } else {
        valid = false;
    }

    payBtn.disabled = !valid;
    }

    document.querySelectorAll("input").forEach(input => {
    input.addEventListener("input", validateForm);
    });
    </script>
</body>
</html>