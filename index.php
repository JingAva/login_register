<?php
require_once 'core/init.php';

//render the header and navigation
$title='Index';
include ('./render/resume-header.php');

if(Session::exists('home')){
    echo '<br><p class="alert alert-success">'.Session::flash('home').'</p>';
}

$user=new User();
if($user->isLoggedIn()){
?>

<main>

<div class="card card-body  justify-content-center">

    <div class="col-sm-6">
    <div class="card">
        <div class="card-body">

            <p>Hello <a class="badge badge-primary" href="profile.php?user=<?php echo escape($user->data()->username);?>"><?php echo escape($user->data()->username);?></a>!</p>

            <ul>
                <li><a class="badge badge-primary" href="logout.php">Log out</a></li>
                <li><a class="badge badge-primary" href="update.php">Update details</a></li>
                <li><a class="badge badge-primary" href="changepassword.php">Change password</a></li>
            </ul>

<?php
    if($user->hasPermission('admin')){
        echo '<p>You are an admin</p>';
    }

}else{
    echo "<p class='alert alert-danger'>You need to <a href='login.php'>log in</a> or <a href='register.php'>register</a></p>";
}
?>

        </div>
    <div>
    </div>

</div>
</main>

<?php
//render the footer
include ('./render/resume-footer.php');
?>