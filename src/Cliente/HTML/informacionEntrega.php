<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Entrega</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../EstilosMenus/EstilosMenu.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js" />
</head>
<style>

#chatbot-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
}
    .centrar {
        padding-bottom: 35px;
    }

    .navbar-custom {
        background: #FFC1C1;
    }

    body {
        background: #FF9999;
    }

    footer {
        background: #990000;
    }

    .container-delivery {
        display: flex;
        justify-content: center;
        gap: 40px;
        margin-top: 50px;
        flex-wrap: wrap;
    }

    .delivery-box {
        width: 200px;
        height: 200px;
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: all 0.3s ease-in-out;
        overflow: hidden;
        text-decoration: none;
    }

    .delivery-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .delivery-content {
        text-align: center;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: transparent;
        z-index: 1;
    }
</style>

<body>
    <?php include_once "navbar.php"; ?>
    <div class="container text-center mt-5">
        <h5>INFORMACIÓN DE ENTREGA</h5>
        <div class="container-delivery">
            <a href="https://rastrea.shalom.pe/" target="_blank" class="delivery-box shalom-box">
                <img src="../ImagenMenu/shalom.png" alt="Shalom logo">
                <div class="delivery-content">
                </div>
            </a>
            <a href="https://tracking.olvaexpress.pe/" target="_blank" class="delivery-box olva-box">
                <img src="../ImagenMenu/olva.png" alt="Olva Courier logo">
                <div class="delivery-content">
                </div>
            </a>
        </div>
    </div>
    <BR></BR>
<?php include_once "footer.php"; ?>

    <script>
        function toggleBlur(boxId) {
            var box = document.getElementById(boxId);
            box.classList.toggle('clicked');
        }
    </script>
    

</body>

</html>