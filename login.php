    <?php
    session_start();
    require "userDb.php" ;
    
    // auto login 
    if ( validSession()) {
        header("Location: userPage.php") ;
        exit ;
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <meta name="robots" content="noindex, follow">
    <script nonce="e785aceb-27b0-4af7-be6f-e4539996ad29">(function(w,d){!function(Y,Z,_,ba){Y[_]=Y[_]||{};Y[_].executed=[];Y.zaraz={deferred:[],listeners:[]};Y.zaraz.q=[];Y.zaraz._f=function(bb){return function(){var bc=Array.prototype.slice.call(arguments);Y.zaraz.q.push({m:bb,a:bc})}};for(const bd of["track","set","debug"])Y.zaraz[bd]=Y.zaraz._f(bd);Y.zaraz.init=()=>{var be=Z.getElementsByTagName(ba)[0],bf=Z.createElement(ba),bg=Z.getElementsByTagName("title")[0];bg&&(Y[_].t=Z.getElementsByTagName("title")[0].text);Y[_].x=Math.random();Y[_].w=Y.screen.width;Y[_].h=Y.screen.height;Y[_].j=Y.innerHeight;Y[_].e=Y.innerWidth;Y[_].l=Y.location.href;Y[_].r=Z.referrer;Y[_].k=Y.screen.colorDepth;Y[_].n=Z.characterSet;Y[_].o=(new Date).getTimezoneOffset();if(Y.dataLayer)for(const bk of Object.entries(Object.entries(dataLayer).reduce(((bl,bm)=>({...bl[1],...bm[1]})),{})))zaraz.set(bk[0],bk[1],{scope:"page"});Y[_].q=[];for(;Y.zaraz.q.length;){const bn=Y.zaraz.q.shift();Y[_].q.push(bn)}bf.defer=!0;for(const bo of[localStorage,sessionStorage])Object.keys(bo||{}).filter((bq=>bq.startsWith("_zaraz_"))).forEach((bp=>{try{Y[_]["z_"+bp.slice(7)]=JSON.parse(bo.getItem(bp))}catch{Y[_]["z_"+bp.slice(7)]=bo.getItem(bp)}}));bf.referrerPolicy="origin";bf.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(Y[_])));be.parentNode.insertBefore(bf,be)};["complete","interactive"].includes(Z.readyState)?zaraz.init():Y.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script>
    </head>
    <body>


    <?php
        // Authentication
        if ( !empty($_POST)) {
            extract($_POST) ;
            if ( checkUser($email, $pass) ) {
                // the user is authenticated
                // Store data to use in other php files. 
                $_SESSION["user"] = getUser($email) ;
                header("Location: userPage.php") ; // redirect to main page
                exit ;
            }
            $authError = true ;
        }
    ?>


    <div class="limiter">
    <div class="container-login100">
    <div class="wrap-login100 p-t-50 p-b-90">
    <form action="?" method="post">
    <span class="login100-form-title p-b-51">
    Login
    </span>


    <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
    <input class="input100" type="text" name="email" placeholder="Email" value="<?= $email ?? '' ?>">
    </div>
    <div class="wrap-input100 validate-input m-b-16" data-validate="Password is required">
    <input class="input100" type="password" name="pass" placeholder="Password">
    <span class="focus-input100"></span>
    </div>
    <div class="flex-sb-m w-full p-t-3 p-b-24">
    <div class="contact100-form-checkbox">
    <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
    </div>
    </div>
    <div class="container-login100-form-btn m-t-17">
    <button class="login100-form-btn">
    Login
    </button>
    <?php   
        // Authentication Error Message
        if( isset($authError)) {
            echo "<p class='error' style='margin-top:20px;'>Wrong email or password</p>" ;
        }

        // Direct access to main page error message
        if ( isset($_GET["error"])) {
            echo "<p class='error'>You tried to access main.php directly</p>" ;
        }

    ?>

    </div>
    </form>
    </div>
    </div>
    </div>

    <script src="js/main.js"></script>

    <button class="btn-shine" style="position: fixed; bottom: 0; right: 0; padding:15px; margin:10px;">
    <span><a style="text-decoration:none; color:inherit;" href="mainPage.php">Main Page</a></span>
    </button>

    </body>
    </html>
