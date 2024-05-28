<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recetas de Comidas</title>
        <!-- Enlace a Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Examen UT7</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
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
            <h1 class="mb-4">Recetas de Comidas</h1>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="selectMeal">Selecciona una comida:</label>
                        <form method="POST">
                            <select class="form-control" id="selectMeal" name="mealId">
                                <option value="">Seleccione una comida</option>
                                <?php
                                $selected_comida = isset($_POST['mealId']) ? $_POST['mealId'] : '';

                                $api_url = "https://www.themealdb.com/api/json/v1/1/search.php?s=";
                                $response = file_get_contents($api_url);
                                $data = json_decode($response, true);

                                if ($data && isset($data['meals'])) {
                                    $comidas = $data['meals'];

                                    foreach ($comidas as $comida) {
                                        $selected = ($selected_comida == $comida['strMeal']) ? 'selected' : '';
                                        echo '<option value="' . $comida['strMeal'] . '"' . $selected . '>' . $comida['strMeal'] . '</option>';
                                    }
                                } else {

                                    echo 'No se pueden cargar las comidas';
                                }
                                ?>
                            </select>
                            <button type="submit" class="btn btn-primary mt-2" name="cargar">Ver detalles</button>
                        </form>

                        <?php
                        if (isset($_POST['cargar'])) {
                            $selected_comida = $_POST['mealId'];

                            $api_url = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . $selected_comida;
                            $response = file_get_contents($api_url);
                            $data = json_decode($response, true);

                            if ($data) {
                                echo "<h2>" . $selected_comida . "</h2>";

                                if (isset($data['meals'][0])) {
                                    $comida = $data['meals'][0];
                                    echo "<h4>Ingredientes</h4>";
                                    echo "<ul>";
                                    echo "<li>" . $comida['strIngredient1'] . "</li>";
                                    echo "<li>" . $comida['strIngredient2'] . "</li>";
                                    echo "<li>" . $comida['strIngredient3'] . "</li>";
                                    echo "<li>" . $comida['strIngredient4'] . "</li>";
                                    echo "<li>" . $comida['strIngredient5'] . "</li>";
                                    echo "<li>" . $comida['strIngredient6'] . "</li>";
                                    echo "<li>" . $comida['strIngredient7'] . "</li>";
                                    echo "</ul>";

                                    echo "<h4>Intrucctiones</h4>";
                                    echo "<p>" . $comida['strInstructions'] . "</p>";

                                    echo "<img src='" . $comida['strMealThumb'] . "'>";
                                }
                            } else {
                                echo "No hay datos";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-light text-center text-lg-start mt-5">
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                Examen UT7 - Ribera del Tajo "DWES"
            </div>
        </footer>
    </body>
</html>







