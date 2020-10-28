<?php

    function lang( $phrase ){
        static $lang = array(
            //dashboard page
            'Home'          => 'Home',
            'Categories'    => 'Categories',
            'Account'       => 'Account',
            'Settings'      => 'Settings',
            'Logout'        => 'Logout',
            'Edit Profile'  => 'Edit Profile',
            'Items'         => 'Items',
            'Members'       => 'Members',    
            'Statistics'    => 'Statistics',        
            'Logs'          => 'Logs',
            ''              => '',   
            ''              => '',   
            ''              => ''   
            
        );
        return $lang[$phrase];
    }

 