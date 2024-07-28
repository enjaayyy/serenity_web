<!DOCTYPE html>
<html>
<head>
    <title>Test Firebase Add Node</title>
</head>
<body>
    <form action="/add-node" method="GET">
        @csrf
        <label for="name">Name:</label>
        <input type="text" id="name" name="name"><br><br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>