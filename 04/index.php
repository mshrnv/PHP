<?php
  require "calculate.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calculator</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <div>
                <select name='base' class="form-select" aria-label="Default select ">
                    <?php echo printSelects($basesArr, $base); ?>
                  </select>
            </div>
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">1</span>
                <input name="number1" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">2</span>
                <input name="number2" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
              <div class="row">
                <div class="col-md-3"><input type="submit" name="operation" value="+"></div>
                <div class="col-md-3"><input type="submit" name="operation" value="-"></div>
                <div class="col-md-3"><input type="submit" name="operation" value="*"></div>
                <div class="col-md-3"><input type="submit" name="operation" value="/"></div>
              </div>
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Результат</span>
                <input value = "<?php echo $data['result']; ?>" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" disabled readonly>
                
              </div>
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Сообщение об ошибке</span>
                <input value = "<?php echo $data['error']; ?>" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" disabled readonly>
              </div>
        </form>
    </div>
</body>
</html>