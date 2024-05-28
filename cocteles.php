<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examen UT7 - Cocteles (servicio externo)</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            .select-container, .card-container {
                max-width: 50%;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.php">Examen UT7</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="comida.php">Recetas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cocteles.php">Cócteles</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <h1 class="text-center">Aprende a hacer cócteles</h1>
            <form method="POST" class="select-container">
                <select name="cocktailName" class="form-control form-control-sm d-block mx-auto my-3">
                    <option value="">Selecciona un cóctel</option>
                    <?php
                    $selected_cocktel = isset($_POST['cocktailName']) ? $_POST['cocktailName'] : '';

                    $api_url = "https://www.thecocktaildb.com/api/json/v1/1/search.php?s=";
                    $response = file_get_contents($api_url);
                    $data = json_decode($response, true);

                    if ($data && isset($data['drinks'])) {
                        $cocktels = $data['drinks'];

                        foreach ($cocktels as $cocktel) {
                            $selected = ($selected_cocktel == $cocktel['strDrink']) ? 'selected' : '';
                            echo '<option value="' . $cocktel['strDrink'] . '"' . $selected . '>' . $cocktel['strDrink'] . '</option>';
                        }
                    } else {

                        echo 'No se pueden cargar los cocktels';
                    }
                    ?>
                </select>
                <button type="submit" class="btn btn-primary" name="cargar">Buscar Ingredientes</button>
            </form>

            <?php
            if (isset($_POST['cargar'])) {
                $selected_cocktel = $_POST['cocktailName'];

                $api_url = "https://www.thecocktaildb.com/api/json/v1/1/search.php?s=" . $selected_cocktel;
                $response = file_get_contents($api_url);
                $data = json_decode($response, true);

                if ($data) {
                    echo "<h2>" . $selected_cocktel . "</h2>";

                    if (isset($data['drinks'][0])) {
                        $cocktel = $data['drinks'][0];
                        echo "<h4>Ingredientes</h4>";
                        echo "<ul>";
                        echo "<li>" . $cocktel['strIngredient1'] . "</li>";
                        echo "<li>" . $cocktel['strIngredient2'] . "</li>";
                        echo "<li>" . $cocktel['strIngredient3'] . "</li>";
                        echo "</ul>";

                        echo "<h4>Intrucctiones</h4>";
                        echo "<p>" . $cocktel['strInstructions'] . "</p>";

                        echo "<img src='" . $cocktel['strDrinkThumb'] . "'>";
                    }
                } else {
                    echo "No hay datos";
                }
            }
            ?>

        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
</html>




