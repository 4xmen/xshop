<?php @require_once __DIR__ . '/sections/header.php'; ?>
<?php

function curlGet($url) {
    $curl = curl_init();

    // Set the cURL options
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 5); //timeout in seconds
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    // Execute the cURL request
    $result = curl_exec($curl);

    // Close cURL session
    curl_close($curl);

    if(curl_error($curl)) {
        echo 'Curl error: ' . curl_error($curl);
    }


    return $result;
}

function parseEnv($file){
    // parse env file
    $envData = file_get_contents($file);
    $envData = explode(PHP_EOL, $envData);
    $envVars = [];
    foreach ($envData as $line) {
        $l = explode('=', $line);
        if (count($l) > 1 && $line[0] != '#') {
            $envVars[trim($l[0])] = trim($l[1], '" ');
        }
    }

    return $envVars;
}

function makeEnv($file,$data)
{
    $env = '';
    $lkey = 'A';
    foreach ($data as $k => $item){
        if ($k[0] !== $lkey){
            $env.= PHP_EOL.PHP_EOL;
            $lkey = $k[0];
        }
        $env .=  $k .'="'.$item.'"'.PHP_EOL;
    }
    return file_put_contents($file,$env);
}
$hasPackage = is_dir(__DIR__ . '/../vendor') && is_dir(__DIR__ . '/../vendor/xmen/starter-kit/');
if (isset($_GET['download']) && !$hasPackage) {
    /**
     * Initialize the cURL session
     */
    $ch = curl_init();
    /**
     * Set the URL of the page or file to download.
     */
    curl_setopt($ch, CURLOPT_URL,
        'https://github.com/A1Gard/xshop-installer-assets/raw/master/vendor.zip');
    /**
     * Create a new file
     */
    $fp = fopen(__DIR__ . '/../file.zip', 'w');
    /**
     * Ask cURL to write the contents to a file
     */
    curl_setopt($ch, CURLOPT_FILE, $fp);
    /**
     * Execute the cURL session
     */
    curl_exec($ch);
    /**
     * Close cURL session and file
     */
    curl_close($ch);
    fclose($fp);

    $zip = new ZipArchive;
    $res = $zip->open(__DIR__ . '/../file.zip');
    if ($res === TRUE) {
        $zip->extractTo(__DIR__ . '/..');
        $zip->close();
        $hasPackage = true;
    } else {
        die('unzip error!');
    }

    unlink(__DIR__ . '/../file.zip');
}

if (isset($_POST['dbname'])){
    $env = parseEnv(__DIR__ . '/../.env.example');
    $env['DB_HOST'] = $_POST['host'];
    $env['DB_DATABASE'] = $_POST['dbname'];
    $env['DB_USERNAME'] = $_POST['user'];
    $env['DB_PASSWORD'] = $_POST['passwd'];

    makeEnv(__DIR__ . '/../.env',$env);

}
?>
    <h2>
        Requrirment check
    </h2>
<?php if (PHP_MAJOR_VERSION >= 8 && PHP_MINOR_VERSION > 0): ?>
    <div class="msg success">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z"></path>
        </svg>
        <span>
                        PHP Version check <b>8.1 or Above</b>
                </span>
    </div>
<?php else: ?>
    <div class="msg error">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z"></path>
        </svg>
        <span>
                        PHP version check <b>8.1 or Above</b>
                        <br>
                        Your php version is <b><?php echo PHP_VERSION; ?></b>
                </span>
    </div>
<?php endif; ?>

<?php
$exts = get_loaded_extensions();
$ourRequriedExts = ['pdo_mysql', 'sqlite3', 'soap', 'zip', 'gd', 'mbstring', 'xml', 'curl', 'json', 'fileinfo', 'bcmath'];

//        print_r($exts);
$have = [];
$haveNot = [];

foreach ($ourRequriedExts as $ext) {
    if (in_array($ext, $exts)) {
        $have[] = $ext;
    } else {
        $haveNot[] = $ext;
    }
}
?>

<?php if (count($have) > 0): ?>
    <div class="msg success">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z"></path>
        </svg>
        <span>
                        PHP extentions not installed:
                        <b>
                            <?php foreach ($have as $item) {
                                echo $item . ', ';
                            } ?>
                        </b>
                </span>
    </div>
<?php endif; ?>
<?php if (count($haveNot) > 0): ?>
    <div class="msg error">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z"></path>
        </svg>
        <span>
                        PHP extentions not installed:
                        <b>
                            <?php foreach ($haveNot as $item) {
                                echo $item . ', ';
                            } ?>
                        </b>
                </span>
    </div>
<?php endif; ?>
<?php
const TMPDIR = __DIR__ . '/../tempCheck';
echo is_dir(TMPDIR) ? rmdir(TMPDIR) : '';
$writeAcess = mkdir(TMPDIR);
rmdir(TMPDIR);

if ($writeAcess):
    ?>
    <div class="msg success">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z"></path>
        </svg>
        <span>
                        Write permission!
                </span>
    </div>
<?php else: ?>
    <div class="msg error">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z"></path>
        </svg>
        <span>
                         Write permission problem:
                        <b>
                            <?php echo substr(__DIR__, 0, -10); ?>
                        </b>
                </span>
    </div>
<?php endif; ?>
<?php if ($hasPackage): ?>
    <div class="msg success">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z"></path>
        </svg>
        <span>
                        Packages already installed
        </span>
    </div>
    <script>
        window.addEventListener('load', function () {
            let p = 25;
            document.querySelector('#percent').innerText = p;
            document.querySelector('#bar').style.width = p + '%';
        });
    </script>
<?php else: ?>
    <a class="btn btn-next" href="?download">
        install packages
    </a>
<?php endif; ?>
<?php
$envInvalid = false;
if (file_exists(__DIR__ . '/../.env')) {


    $envVars = parseEnv(__DIR__ . '/../.env');

    try {
        //...
        $dbh = new PDO('mysql:host=' . $envVars['DB_HOST'] . ';dbname=' . $envVars['DB_DATABASE'], $envVars['DB_USERNAME'],
            $envVars['DB_PASSWORD']);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        var_dump($dbh);
    } catch (PDOException $e) {
        // Display a message and log the exception.
//        exit();
        $envInvalid = true;
    }
}else{
    $envVars = parseEnv(__DIR__ . '/../.env.example');
    $envInvalid = true;
}

if($envInvalid):
?>
    <div class="msg error">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z"></path>
        </svg>
        <span>
                 You need modify database connection
        </span>
    </div>

    <form action="" method="post">
        <label>
            Host:
            <br>
            <input type="text" name="host" value="<?php  echo $envVars['DB_HOST']; ?>" >
        </label>
        <label>
            Database name:
            <br>
            <input type="text" name="dbname" value="<?php  echo $envVars['DB_DATABASE']; ?>" >
        </label>
        <label>
            Database user:
            <br>
            <input type="text" name="user" value="<?php  echo $envVars['DB_USERNAME']; ?>" >
        </label>
        <label>
            Database password:
            <br>
            <input type="password" name="passwd" value="<?php  echo $envVars['DB_PASSWORD']; ?>" >
        </label>
        <button class="btn">
            Save
        </button>
    </form>
<?php else: ?>
    <div class="msg success">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z"></path>
        </svg>
        <span>
                       Database connection is OK!
        </span>
    </div>
    <script>
        window.addEventListener('load', function () {
            let p = 37;
            document.querySelector('#percent').innerText = p;
            document.querySelector('#bar').style.width = p + '%';
        });
    </script>
<!--<pre>-->
    <?php
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $url = "https://";
    } else {
        $url = "http://";
    }
    $url .=  $_SERVER['HTTP_HOST']. substr($_SERVER['REQUEST_URI'],0,-13).'work';
//    echo $url;
//    $response = curlGet( $url );
//    print_r($_SERVER);
//    echo  $response;
     ?>
    <input type="hidden" id="url" value="<?php echo  $url;?>">
    <div id="config">
        <div class="msg error">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                    d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z"></path>
            </svg>
            <span>
                 Rewrite error:
        </span>
        </div>

        Your server is : <?php echo $_SERVER['SERVER_SOFTWARE']; ?>

        <ul>
            <li>
                If you use `PHP`, restart laravel
            </li>
            <li>
                If you use `Apache`, your public_html has problem
            </li>
            <li>
                If you use `NGINX`, active this rewrite on domain config, then restart server:
                <code>
                    rewrite ^/(.*)$ /index.php/$1 last;
                </code>
            </li>
        </ul>

        <a href="?" class="btn" >
            Re-check
        </a>

    </div>
    <a href="<?php echo  substr($url,0,-7);?>" class="btn" id="continue">
        Continue
    </a>
    <script>
        url = document.querySelector('#url').value;
        async function getURL(url) {
            try {
                const response = await fetch(url);

                if(!response.ok) {
                    throw new Error(response.statusText);
                }

                return response.text();
            } catch(error) {
                throw error;
            }
        }

        // Usage:
        getURL(url)
            .then(response => {
                // Do something with response
               if (response.trim() === 'work!'){
                   document.querySelector('#config').remove();
                   window.addEventListener('load', function () {
                       let p = 50;
                       document.querySelector('#percent').innerText = p;
                       document.querySelector('#bar').style.width = p + '%';
                   });
               }else{
                   document.querySelector('#continue').remove();
               }
            })
            .catch(error => {
                console.error(error);
                document.querySelector('#continue').remove();
            });
    </script>
<?php endif; ?>
<!--</pre>-->
<?php @require_once __DIR__ . '/sections/footer.php'; ?>
