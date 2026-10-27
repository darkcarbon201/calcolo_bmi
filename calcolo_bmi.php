<?php

if($_SERVER["REQUEST_METHOD"] != "POST"){
  header("location: index.html");
}


$nome = isset($_POST['nome']) ? $_POST['nome'] : 'NOT_VALID';
$peso = isset($_POST['peso']) ? $_POST['peso'] : 'NOT_VALID';
$altezza_cm = isset($_POST['altezza']) ? $_POST['altezza'] : 'NOT_VALID';



$bmi = 0;
$classe_card = 'normopeso';
$fascia = 'NORMOPESO';

if ($altezza_cm > 0 && $peso > 0) {
    $altezza_m = $altezza_cm / 100;
    $bmi = $peso / ($altezza_m * $altezza_m);
    
    
    if ($bmi < 18.5) {
        $classe_card = 'sottopeso';
        $fascia = 'SOTTOPESO';
    } else if ($bmi <= 24.9) {
        $classe_card = 'normopeso';
        $fascia = 'NORMOPESO';
    } else if ($bmi <= 29.9) {
        $classe_card = 'sovrappeso';
        $fascia = 'SOVRAPPESO';
    } else {
        $classe_card = 'obesita';
        $fascia = 'OBESITÀ';
    }
}


$data = date("d/m/o, H/i/s");

$ip = $_SERVER["SERVER_ADDR"];

if($nome == "NOT_VALID" || $peso == "NOT_VALID" || $altezza_cm == "NOT_VALID"){
  $fascia = "NOT_VALID";
  $record = implode("," ,[$ip, $data, $nome, $peso, $altezza_cm, $fascia]);  
}



$record = implode("," ,[$ip, $data, $nome, $peso, $altezza_cm, $fascia]). PHP_EOL;

$nomeFile = "log.csv";

$file = fopen($nomeFile,"a");

fwrite($file, $record);

fclose($file);  

?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Il tuo BMI</title>
  <link rel="stylesheet" href="stile.css">
</head>
<body>
  <div class="app-container">
    <h1 class="main-title">Il tuo BMI</h1>
    <main class="bmi-card">
      <div class="card <?php echo $classe_card; ?>">
        <div class="result-name"><?php echo $nome; ?></div>
        <div class="result-details">Peso <?php echo $peso; ?> kg · Altezza <?php echo $altezza_cm; ?> cm</div>
        <div class="result-value"><?php echo number_format($bmi, 2); ?></div>
        <div class="result-category"><?php echo $fascia; ?></div>
      </div>
    </main>
    <a href="index.html" class="recalculate-link">Calcola di nuovo</a>
  </div>
</body>
</html>