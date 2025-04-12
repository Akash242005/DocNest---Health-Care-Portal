<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #6e8efb, #5348e4);
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }
        .login-container h2 {
            margin-bottom: 1rem;
            color: #333;
        }
        .input-group {
            margin-bottom: 1rem;
            text-align: left;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        .login-btn {
            width: 100%;
            padding: 10px;
            background: #6e8efb;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }
        .login-btn:hover {
            background: #4c6ef5;
        }
        .forgot-pass {
            display: block;
            margin-top: 10px;
            color: #6e8efb;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .forgot-pass:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>DOCNEST</h2>
        <form>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
            <a href="#" class="forgot-pass">Forgot Password?</a>
        </form>
    </div>
</body>
</html>