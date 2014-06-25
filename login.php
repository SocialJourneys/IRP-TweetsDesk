<?php include('core/init.core.php');

    //Initialize the errors array:
    $errors = array();

    //If user is already logged in, then it redirects to dashboard:
    if(isset($_SESSION['account'])){
        header('Location: dashboard.php');
        die();
    }

    //Check if the email and password fields were submitted:
    if(isset($_POST['email'], $_POST['password'])){
        //Check if the email is empty:
        if(empty($_POST['email'])){
            $errors[] = 'The email cannot be empty.';
        }

        //Check if the password is empty:
        if(empty($_POST['password'])){
            $errors[] = 'The password cannot be empty.';
        }

        //Api URL:
        $url = APIURL."/auth";

        //Header of the API:
        $headers = array('Content-Type: application/json');
        
        //Data array of the API:
        $dataArray = array(
                        'email'    => htmlentities($_POST['email']),
                        'password' => htmlentities($_POST['password'])
                        );
        
        //Encode the data array into JSON:
        $data = json_encode($dataArray);

        //Get a response from the API:
        $response = rest_post($url, $data, $headers);

        //Get the user object:
        $userobj = json_decode($response);
        
        //Get the status of the user (active/innactive):
        $status = $userobj->{'statusCode'};

        //Check if the login was successful:
        if($status!=200){
            $errors[] = $userobj->{'errors'}[0];
            $errors[] = $userobj->{'moreInfo'};
        }else if($status==200){
            //Create the session:
            if(empty($errors)){
                //Get the size of the businessApiKeys array:
                //Store the variables in a session:
                $_SESSION['account'] = array('email'  => $userobj->{'email'},
                                             'apiKey' => $userobj->{'userApiKey'},
                                             'name'   => $userobj->{'userFullName'},
                                             'accountType' => $userobj->{'accountType'});
                



                //print_r($_SESSION['account']);
                //Redirect to the dashboard: 
                header('Location: dashboard.php');

                die();   
            }
            else
                echo "error";
        }
        else
            echo 'nothing to see here';
    }
?>
<?php include('header.php');?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">

                                        <div>
                    <?php if(empty($errors)===false){ ?>
                        <ul class="fedback-error-signin">
                            <?php foreach ($errors as $error) {
                                echo "<li><p><span class=\"glyphicon glyphicon-remove form-control-feedback\"></span>&nbsp;&nbsp;".$error."</p></li>";
                            } ?>
                        </ul>
                    <?php } ?>
                </div>

                        <form role="form" method="post" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                            <button class="btn btn-lg btn-success btn-block" type="submit">Login</button><br/>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php');?>
