<?php include('core/init.core.php');

    //Initialize the errors array:
    $errors = array();

    //If user is already logged in, then it redirects to dashboard:
    if(isset($_SESSION['account'])){
        header('Location: dashboard.php');
        die();
    }

    //Check if the email and password fields were submitted:
    if(isset($_POST['email'], $_POST['password'], $_POST['first-name'],$_POST['surname'])){
        //Check if the email is empty:
        if(empty($_POST['email'])){
            $errors[] = 'The email cannot be empty.';
        }

        //Check if the password is empty:
        if(empty($_POST['password'])){
            $errors[] = 'The password cannot be empty.';
        }

        //Check if the first name is empty:
        if(empty($_POST['first-name'])){
            $errors[] = 'The first name cannot be empty.';
        }

                //Check if the surname is empty:
        if(empty($_POST['surname'])){
            $errors[] = 'The surname cannot be empty.';
        }

        if(!(isset($_POST['agreement']))){
            $errors[] = 'You need to agree to the terms and conditions.';
        }


        if( count($errors)==0){
            //Api URL:
            $url = APIURL."/users";

            //Header of the API:
            $headers = array('Content-Type: application/json',"Authorization: ".API_APP_KEY);
            
            //Data array of the API:
            $dataArray = array(
                            'firstName'=> htmlentities($_POST['first-name']),
                            'surname' => htmlentities($_POST['surname']),
                            'email'    => htmlentities($_POST['email']),
                            'password' => htmlentities($_POST['password']),
                            'userRole' => 'User'
                            );
            
            //Encode the data array into JSON:
            $data = json_encode($dataArray);

            //Get a response from the API:
            $response = rest_post($url, $data, $headers);

            //Get the user object:
            $userobj = json_decode($response);
        }
       // var_dump($userobj);
        //die();
        //Get the status of the user (active/innactive):
        $status = $userobj->{'statusCode'};

        //Check if the registration was successful:
        if($status==409){
                $errors[] = $userobj->{'errors'}[0];
                $errors[] = $userobj->{'moreInfo'};
            }else if( count($errors)==0){ 
                     $_POST='';
                    //print_r($_SESSION['account']);
                    //Redirect to the dashboard: 
                }
        }
    
?>
<?php include('header.php');?>
<br/>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="register-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">TMI Registration</h3>
                    </div>
                    <div class="panel-body">

                <?php  if(count($errors)==0 && $_SERVER['REQUEST_METHOD'] == 'POST') echo'<div class="alert alert-success" role="alert">Registration was successful. A system administrator will activate your account.</div>';?>


                <div>
                    <?php if(count($errors)>0){ ?>
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
                                    <input class="form-control" placeholder="First name" name="first-name" type="text" autofocus required value="<?php if (isset($_POST['first-name']))echo $_POST['first-name']; else echo "";?>" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Surname" name="surname" type="text" autofocus required value="<?php if (isset($_POST['surname']))echo $_POST['surname']; else echo "";?>" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus required value="<?php if (isset($_POST['email']))echo $_POST['email']; else echo "";?>" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="agreement" type="checkbox" value="Agreement">I agree to the TMI terms and conditions.
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <div class="col-md-12 col-sm-8">
                                    <button class="btn btn-lg btn-success btn-block" type="submit">Register</button><br/>
                                                                </p>Already have an account?</p>
                            <div class="form-group col-lg-6 col-md-6 col-sm-3 col-xs-3">
                                <a class="btn btn-xs btn-primary btn-block" href="login.php" style="margin-left:-10px;">Login Here!</a><br/>
                            </div>

                                </div>



                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php');?>
