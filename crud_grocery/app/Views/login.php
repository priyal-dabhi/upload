<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .login-form {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form-box {
            background-color: #fff;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
            padding: 10px 30px 30px 30px;
            width: 600px;
            border-radius:
                5px;
        }

        .login-form-header {
            margin-bottom: 40px;
        }

        .login-form-header h2 {
            font-size: 26px;
            font-weight: 700;
            font-family: Arial, Helvetica, sans-serif;
        }

        .login-form-header p {
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 0;
        }

        .login-form-header p a {
            text-decoration: none;
            color: #0e74bd;
        }

        .input-item {
            margin-bottom: 20px;
        }

        .input-item input {
            width: calc(100% - 30px);
            padding: 16px;
            border-radius: 5px;
            border: 1px solid #787878;
        }

        button {
            margin-top: 5px;
            background-color: #0e74bd;
            border: none;
            color: #fff;
            padding: 12px 40px;
            font-size: 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* custom Checkbox */
        .remember-pass {
            display: block;
            margin-bottom: 15px;
        }

        .remember-pass input {
            padding: 0;
            height: initial;
            width: initial;
            margin-bottom: 0;
            display: none;
            cursor: pointer;
        }

        .remember-pass label {
            position: relative;
            cursor: pointer;
        }

        .remember-pass label:before {
            content: '';
            background-color: transparent;
            border: 2px solid #0e74bd;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
            padding: 10px;
            display: inline-block;
            position: relative;
            vertical-align: middle;
            cursor: pointer;
            margin-right: 10px;
        }

        .remember-pass label {
            font-family: Arial, Helvetica, sans-serif;
        }

        .remember-pass input:checked+label:after {
            content: '';
            display: block;
            position: absolute;
            top: 1px;
            left: 8px;
            width: 6px;
            height: 12px;
            border: solid #0e74bd;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
</head>

<body>
    <div class="login-form">
        <div class="login-form-box">
            <div class="login-form-header">
                <h2 class="title">Sign In</h2>
                <p id="subtitle">Don't have an account? <a class='link'> Sign Up </a></p>
            </div>
            <form action="">
                <div class="input-item"><input type="text" placeholder="Enter Name" name="name"></div>
                <div class=" input-item"><input type="text" placeholder="Enter Password" name="pass"></div>
                <div class="input-item">
                    <label>Language</label>
                    <select id="lang">
                        <option value="english">EN</option>
                        <option value="hindi">HI</option>
                    </select>
                </div>
                <button id="subbtn">Submit</button>
            </form>
            <img src="/assets/images/qrcode.png" width="100" height="100">
        </div>


    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        const lang = document.querySelector('#lang');
        lang.addEventListener('change', () => {
            var langval = document.getElementById('lang').value;
            const title = document.querySelector('.title');
            const subtitle = document.querySelector('#subtitle');
            var btn = document.querySelector('#subbtn');

            title.textContent = data[langval].title;
            subtitle.innerHTML = data[langval].subtitle;
            btn.textContent = data[langval].btn;
            document.getElementsByName('name')[0].placeholder = data[langval].name;
            document.getElementsByName('pass')[0].placeholder = data[langval].pass;

        });
        var data = {
            "english": {
                "title": "Login page",
                "subtitle": "Don't have an account? <a  class='link'> Sign Up </a>",
                "btn": "Submit",
                "name": "Enter Name",
                "pass": "Enter Password"

            },
            "hindi": {
                "title": "दाखिल करना",
                "subtitle": "खाता नहीं है ? <a class='link'> साइन अप करें </a>",
                "btn": "जमा करना",
                "name": "नाम दर्ज करें ",
                "pass": "पास वर्ड दर्ज करें"
            }
        }
    </script>
</body>

</html>