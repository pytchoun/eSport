<!-- Sidebar  -->
<nav id="sidebar">

  <!-- Sidebar Content -->
  <div id="sidebar-content">

    <ul class="list-unstyled components mb-0">
      <li>
        <a href="/">
          <i class="fas fa-home"></i>
          <span>Home</span>
        </a>
      </li>

      <li>
        <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
          <i class="fas fa-user"></i>
          <span>Account</span>
        </a>

        <div class="collapse" id="collapseExample">
          <ul class="list-unstyled components mb-0 px-0">
            <?php
            // Create userManager
            $userManager = new UserManager();
            $userIsConnected = $userManager->userIsConnected();
            if (!$userIsConnected) { ?>
              <li>
                <a href="/login">
                  <i class="fas fa-sign-in-alt"></i>
                  <span>Login</span>
                </a>
              </li>

              <li>
                <a href="/register">
                  <i class="fas fa-user-plus"></i>
                  <span>Register</span>
                </a>
              </li>
            <?php } else { ?>
              <li>
                <a href="/profile/<?php echo $_SESSION['account']['user_username']; ?>">
                  <i class="fas fa-user"></i>
                  <span>Profile</span>
                </a>
              </li>

              <li>
                <a href="/profile-settings">
                  <i class="fas fa-user-cog"></i>
                  <span>Profile Settings</span>
                </a>
              </li>

              <hr class="bg-info">

              <li>
                <a href="/notifications-center">
                  <i class="fas fa-bell"></i>
                  <span>Notifications Center</span>
                </a>
              </li>

              <hr class="bg-info">

              <li>
                <a href="/logout">
                  <i class="fas fa-sign-out-alt"></i>
                  <span>Logout</span>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>

      </li>

    </ul>
  </div>
  <!-- Sidebar Content -->

  <!-- Sidebar Spacer -->
  <div class="sidebar-spacer"></div>
  <!-- Sidebar Spacer -->

  <!-- Sidebar Footer -->
  <div id="sidebar-footer">

    <!-- Paladins Challenge socials networks -->
    <div class="text-center pb-3">
      <ul class="list-inline mb-0">

        <li class="list-inline-item mr-0 mt-3">
          <div class="social-icon-effect aeneas-effect">
            <a href="#" class="facebook" title="Join us on Facebook">
              <i class="fab fa-facebook-f" aria-hidden="true"></i>
            </a>
          </div>
        </li>

        <li class="list-inline-item mr-0 mt-2">
          <div class="social-icon-effect aeneas-effect">
            <a href="#" class="twitter" title="Follow us on Twitter">
              <i class="fab fa-twitter" aria-hidden="true"></i>
            </a>
          </div>
        </li>

        <li class="list-inline-item mr-0 mt-2">
          <div class="social-icon-effect aeneas-effect">
            <a href="#" class="discord" title="Join us on Discord">
              <i class="fab fa-discord" aria-hidden="true"></i>
            </a>
          </div>
        </li>

        <li class="list-inline-item mr-0 mt-2">
          <div class="social-icon-effect aeneas-effect">
            <a href="#" class="twitch" title="Follow us on Twitch">
              <i class="fab fa-twitch" aria-hidden="true"></i>
            </a>
          </div>
        </li>

        <li class="list-inline-item mr-0 mt-2">
          <div class="social-icon-effect aeneas-effect">
            <a href="#" class="email" title="Contact us by Email">
              <i class="fas fa-envelope" aria-hidden="true"></i>
            </a>
          </div>
        </li>

      </ul>
    </div>
    <!-- Paladins Challenge socials networks -->

    <!-- Donation Button -->
    <!-- <a class="btn btn-primary btn-block btn-donation" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8LGRNQXLY634Q" target="_blank" rel="noopener noreferrer nofollow">
      <i class="fas fa-donate"></i>
      <span>Donation</span>
    </a> -->
    <!-- Donation Button -->

  </div>
  <!-- Sidebar Footer -->

</nav>
<!-- Sidebar  -->
