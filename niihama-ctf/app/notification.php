<?php
function notification($message){
    return '
        <div class="notification-container">
            <div class="notification">
                <p>' . $message . '</p>
            </div>
        </div>
        '; 
}