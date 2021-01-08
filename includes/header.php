
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">

<div class="container">

<a class="navbar-brand" href="/purje/index.php">
<img style="height: 50px; width: 70px; " src="/purje/images/logo1.png" alt=""> Drive Your Dreams</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse navitems" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/purje/user.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/purje/aboutus.php">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/purje/contact.php">Contact us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/purje/carvarieties.php">Explore cars</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="/purje/images/profile.png" width="30" height="30" class="rounded-circle">
                        <?php  echo $_SESSION["username"]; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/purje/profile.php">Profile Settings</a>
                        <a class="dropdown-item" href="/purje/updpwd.php">Update Password </a>
                        <a class="dropdown-item" href="/purje/mybookings.php">My Bookings</a>
                        <a class="dropdown-item" href="/purje/post_testimonal.php">Post Testimonal</a>
                        <a class="dropdown-item" href="/purje/query.php">Ask Queries</a>
                        <a class="dropdown-item" href="/purje/logout.php?logout-submit=logout">Logout</a>
                    </div>
                </li>
            </ul>
</nav>