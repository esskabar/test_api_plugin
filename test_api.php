<?php

/*
Plugin Name: API for test
Plugin URI: http://test_api.localhost/
Description: API to mentioned requirements
Author: Maxim Gavryushenko
Version: 1.0
Author URI: http://test_api.localhost/


Annotation :

write shortcode "use" on some place in page after udate page ,
you  can watch users table with data
thank you.

*/


class Test_API
{


    public function __construct()
    {
        add_action('wp_ajax_nopriv_get_coordinate', array($this, 'get_coordinate'));
        add_action('wp_enqueue_scripts', array($this, 'users_style_method'));
        add_shortcode('use', array(&$this, 'get_coordinate'));
    }

    function users_style_method()
    {
        wp_register_style('users-css', plugins_url() . '/test_api/style.css');
        wp_enqueue_style('users-css');
    }

    public function get_coordinate()
    {

        if ($ch = curl_init()) {
            curl_setopt($ch, CURLOPT_URL, 'http://api.micronetonline.com/v1/associations(1896)/members');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'User-Agent: Fiddler',
                'X-ApiKey: 8a783d25-cd2f-4abd-9116-18912ae62263',
                'Host: api.micronetonline.com'
            ));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            $output = curl_exec($ch);


        } else {
            echo 'cURL disabled';
        }
        ?>
        <div id="users_table">
            <center><h2>users table</h2></center>
            <table border="1" cellspacing="0">
                <tr>
                    <th>Users ID</th>
                    <th>Users name</th>
                    <th>Users email</th>
                    <th>Users LogoUrl</th>
                    <th>Users SearchLogoUrl</th>
                    <th>Users Status</th>
                    <th>Users StatusText</th>
                    <th>Users Latitude</th>
                    <th>Users Longitude</th>
                    <th>Users Level</th>
                    <th>Users WebParticipationLevel</th>
                    <th>Users MembershipEstablished</th>
                    <th>Users Slug</th>
                    <th>Users DisplayName</th>
                    <th>Users DropDate</th>
                </tr>
                <?php
                $users = json_decode($output);

                foreach ($users as $user) :
                    //     var_dump($user);
                    ?>
                    <tr data-id="<?php echo $user->ID ?>">
                        <td data-name="id"><?php echo $user->Id ?></td>
                        <td data-name="name"><?php echo $user->Name ?></td>
                        <td data-name="email"><?php echo $user->Email ?></td>
                        <td data-name="LogoUrl" class="user_password"><?php echo $user->LogoUrl ?></td>
                        <td data-name="SearchLogoUrl"><?php echo $user->SearchLogoUrl ?></td>
                        <td data-name="Status"><?php echo $user->Status ?></td>
                        <td data-name="StatusText"><?php echo $user->StatusText ?></td>
                        <td data-name="Latitude"><?php echo $user->Latitude ?></td>
                        <td data-name="Longitude"><?php echo $user->Longitude ?></td>
                        <td data-name="Level"><?php echo $user->Level ?></td>
                        <td data-name="WebParticipationLevel"><?php echo $user->WebParticipationLevel ?></td>
                        <td data-name="MembershipEstablished"><?php echo $user->MembershipEstablished ?></td>
                        <td data-name="Slug"><?php echo $user->Slug ?></td>
                        <td data-name="DisplayName"><?php echo $user->DisplayName ?></td>
                        <td data-name="DropDate"><?php echo $user->DropDate ?></td>
                        </td>
                    </tr>
                <?php
                endforeach; ?>
            </table>
        </div>
    <?php
    }
}

$test = new Test_API();