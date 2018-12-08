<?php

// only allows admins to subscribe to app events
Broadcast::channel('app.events', function ($user) {
    return $user->isSuperAdmin();
});
