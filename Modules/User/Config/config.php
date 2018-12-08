<?php

return [
    'name' => 'User',

    # allow user registration, if "false", users cannot register
    'allow_user_registration' => true,
    # if "true", each registered user needs to verify account first
    'user_verify_required' => true,
    # if "false", users cannot reset their passwords
    'enable_password_reset' => true,
    # whether user should automatically be activated after registration
    'activate_user_on_registration' => true,
    # show/hide remember me checkbox on login page
    'remember_me_checkbox' => true,
    # login user after registration
    'login_user_after_registration' => false,
    # route to redirect to after login
    'redirect_route_after_login' => '/home',
    # route to redirect to after registration
    'redirect_route_after_register' => '/home',
    # route to redirect to after logout
    'redirect_route_after_logout' => 'user/login',
];
