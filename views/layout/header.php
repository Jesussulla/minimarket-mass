<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Minimarket Mass</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar { background: #0066B3; color: #fff; padding: 14px 24px; }
        .main-wrapper { display: flex; flex: 1; }
        .sidebar { width: 200px; background: #1a2332; padding: 20px 12px; overflow-y: auto; }
        main { flex: 1; padding: 40px; }
        footer { background: #1f1e2c; color: #fff; text-align: center; padding: 20px; }
        
        h1 {
            color: #0066B3;
            border-bottom: 3px solid #FFB81C;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th {
            background: #0066B3;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background: #f9f9f9;
        }
        .precio {
            font-weight: bold;
            color: #0066B3;
        }
        .sin-stock {
            color: #c33;
        }
        p { margin-bottom: 16px; }
    </style>
</head>
<body>