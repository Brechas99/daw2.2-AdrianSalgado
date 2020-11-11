<html>
<head>
    <title></title>
</head>
<body>

<p>Calculadora</p>
<form action="4b-operacionesCalculadora.php" method="post">
    <p>Introduce el operando1</p>
    <input type="number" name="operando1">
    <select name="operacion">
        <option value="sum">Suma</option>
        <option value="res">Resta</option>
        <option value="mul">Multiplicacion</option>
        <option  value="div">Division</option>
    </select>
    <p>Introduce el operando2</p>
    <input type="number" name="operando2">
    <input type="submit" value="Calcular">
</form>
</body>
</html>
